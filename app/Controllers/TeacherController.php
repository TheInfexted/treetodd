<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class TeacherController extends BaseController
{
    /*
    * Protected
    */

    /*
    * End Protected
    */

    /*
    * Public
    */

    public function updateTeacherStatus()
    {
        // Set content type to JSON
        header('Content-Type: application/json');
        
        if( !session()->get('isLoggedIn') ):
            echo json_encode([
                'code' => 69,
                'message' => 'Not logged in'
            ]);
            return;
        endif;

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            try {
                $params = $this->request->getpost('params');
                
                if (!$params || !isset($params['teacherId']) || !isset($params['status'])) {
                    echo json_encode([
                        'code' => 0,
                        'message' => 'Missing required parameters'
                    ]);
                    return;
                }
                
                $payload = [
                    'teacher_id' => (int)$params['teacherId'],
                    'status' => (int)$params['status'],
                    'modified_date' => date('Y-m-d H:i:s'),
                ];
                
                $res = $this->TeacherModel->updateTeacherStatus($payload);
                
                // Make sure we have a valid response
                if (!is_array($res)) {
                    echo json_encode([
                        'code' => 0,
                        'message' => 'Invalid model response'
                    ]);
                    return;
                }
                
                echo json_encode($res);
                
            } catch (Exception $e) {
                echo json_encode([
                    'code' => 0,
                    'message' => 'Controller error: ' . $e->getMessage()
                ]);
            }
        else:
            echo json_encode([
                'code' => 69,
                'message' => 'Session timeout'
            ]);
        endif;
    }

    public function addNewTeacher()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            // Check for duplicate ID number
            $checkIdNumber = $this->TeacherModel->checkIdNumberExists([
                'id_number' => $this->request->getpost('params')['idNumber']
            ]);
            
            if( $checkIdNumber['exists'] ):
                echo json_encode([
                    'code' => 0,
                    'message' => 'ID Number already exists'
                ]);
                return;
            endif;

            $payload = [
                'teacher_name' => $this->request->getpost('params')['teacherName'],
                'age' => (int)$this->request->getpost('params')['age'],
                'highest_qualification' => $this->request->getpost('params')['qualification'],
                'kap_certificate' => $this->request->getpost('params')['kapCertificate'] ?: '2',
                'hired_date' => $this->request->getpost('params')['hiredDate'],
                'id_number' => $this->request->getpost('params')['idNumber'],
                'phone_number' => $this->request->getpost('params')['phoneNumber'],
                'address' => $this->request->getpost('params')['address'],
                'branch_id' => (int)$this->request->getpost('params')['branchId'],
                'kdgn_id' => (int)$this->request->getpost('params')['kdgnId'],
                'kdmgm_id' => (int)$this->request->getpost('params')['kdmgmId'],
                'status' => '1'
            ];

            // Handle login account creation if provided
            $loginPayload = null;
            if( !empty($this->request->getpost('params')['username']) ):
                $checkUsername = $this->TeacherModel->checkUsernameExists([
                    'username' => $this->request->getpost('params')['username']
                ]);
                
                if( $checkUsername['exists'] ):
                    echo json_encode([
                        'code' => 0,
                        'message' => 'Username already exists'
                    ]);
                    return;
                endif;

                $loginPayload = [
                    'kdgn_id' => $payload['kdgn_id'],
                    'kdmgm_id' => $payload['kdmgm_id'],
                    'branch_username' => $this->request->getpost('params')['username'],
                    'branch_password' => password_hash($this->request->getpost('params')['password'], PASSWORD_DEFAULT),
                    'branch_role' => '2',
                    'branch_childcare' => $this->request->getpost('params')['branchChildcare'] ?: '2',
                    'branch_name' => $payload['teacher_name'],
                    'branch_status' => '1'
                ];
            endif;

            $res = $this->TeacherModel->insertNewTeacher($payload, $loginPayload);
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    public function teacherListWithPagination()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $raw = json_decode(file_get_contents('php://input'),1);

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $payload = $this->TeacherModel->selectAllTeachersWithPagination([
                'pageindex' => $raw['pageindex'],
                'rowperpage' => $raw['rowperpage'],
                'teacherName' => $raw['teacherName'],
                'status' => (int)$raw['status'],
                'qualification' => $raw['qualification'],
                'branchId' => $raw['branchId'],
            ]);

            if( $payload['code']==1 && $payload['data']!=[] ):
                $data = [];
                foreach( $payload['data'] as $i ):
                    $date = Time::parse(date('Y-m-d H:i:s', strtotime($i['hired_date'])));
                    $hiredDate = $date->toDateTimeString();

                    $modifiedDate = '';
                    if( !empty($i['modified_date']) ):
                        $date2 = Time::parse(date('Y-m-d H:i:s', strtotime($i['modified_date'])));
                        $modifiedDate .= $date2->toDateTimeString();
                    else:
                        $modifiedDate .= '---';
                    endif;

                    $kapBadge = $i['kap_certificate'] === '1' 
                        ? '<span class="badge bg-primary">Yes</span>'
                        : '<span class="badge bg-secondary">No</span>';

                    // Fix the status buttons to match the JavaScript function name
                    if( $i['status']=='1' ):
                        $status = '<a href="javascript:void(0);" class="btn btn-success btn-xs icon-btn me-1" onclick="editTeacherStatus(\''.$i['teacher_id'].'\',\'2\');" title="Set Inactive"><i class="ph-bold ph-check"></i></a>';
                        $status .= '<a href="javascript:void(0);" class="btn btn-danger btn-xs icon-btn" onclick="editTeacherStatus(\''.$i['teacher_id'].'\',\'3\');" title="Terminate"><i class="ph-bold ph-x"></i></a>';
                    elseif( $i['status']=='2' ):
                        $status = '<a href="javascript:void(0);" class="btn btn-warning btn-xs icon-btn me-1" onclick="editTeacherStatus(\''.$i['teacher_id'].'\',\'1\');" title="Set Active"><i class="ph-bold ph-pause"></i></a>';
                        $status .= '<a href="javascript:void(0);" class="btn btn-danger btn-xs icon-btn" onclick="editTeacherStatus(\''.$i['teacher_id'].'\',\'3\');" title="Terminate"><i class="ph-bold ph-x"></i></a>';
                    else:
                        $status = '<span class="badge bg-danger fs-8 px-2 py-2">Terminated</span>';
                    endif;

                    $action = '<div class="">';
                    $action .= '<a href="javascript:void(0);" class="btn btn-light-primary btn-xs icon-btn b-r-4 me-1" onclick="getTeacher(\''.$i['teacher_id'].'\');"><i class="ph-bold ph-eye text-success"></i></a>';
                    $action .= '</div>';

                    $row = [];
                    $row[] = $i['teacher_name'];
                    $row[] = $i['age'];
                    $row[] = $i['highest_qualification'];
                    $row[] = $kapBadge;
                    $row[] = $hiredDate;
                    $row[] = $i['phone_number'];
                    $row[] = $i['branch_name'] ?? 'N/A';
                    $row[] = $status;
                    $row[] = $action;
                    $data[] = $row;
                endforeach;
                echo json_encode([
                    'data'=>$data, 
                    'code'=>1, 
                    'pageIndex'=>$payload['pageIndex'], 
                    'rowPerPage'=>$payload['rowPerPage'], 
                    'totalPage'=>$payload['totalPage'], 
                    'totalRecord'=>$payload['totalRecord']
                ]);
            else:
                echo json_encode(['no data']);
            endif;
        else:
            echo json_encode([
                'code' => 69,
                'message' => 'Session timeout'
            ]);
        endif;
    }

    public function getTeacherDetails()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $teacherId = (int)$this->request->getpost('params')['teacherId'];
            $res = $this->TeacherModel->selectTeacherDetails(['teacher_id' => $teacherId]);
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    public function updateTeacher()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $teacherId = (int)$this->request->getpost('params')['teacherId'];
            
            // Check for duplicate ID number (excluding current teacher)
            $checkIdNumber = $this->TeacherModel->checkIdNumberExists([
                'id_number' => $this->request->getpost('params')['idNumber'],
                'exclude_teacher_id' => $teacherId
            ]);
            
            if( $checkIdNumber['exists'] ):
                echo json_encode([
                    'code' => 0,
                    'message' => 'ID Number already exists'
                ]);
                return;
            endif;

            $payload = [
                'teacher_id' => $teacherId,
                'teacher_name' => $this->request->getpost('params')['teacherName'],
                'age' => (int)$this->request->getpost('params')['age'],
                'highest_qualification' => $this->request->getpost('params')['qualification'],
                'kap_certificate' => $this->request->getpost('params')['kapCertificate'] ?: '2',
                'hired_date' => $this->request->getpost('params')['hiredDate'],
                'id_number' => $this->request->getpost('params')['idNumber'],
                'phone_number' => $this->request->getpost('params')['phoneNumber'],
                'address' => $this->request->getpost('params')['address'],
                'status' => $this->request->getpost('params')['status'] ?: '1',
                'modified_date' => date('Y-m-d H:i:s'),
            ];

            // Handle login account update if provided
            $loginPayload = null;
            if( !empty($this->request->getpost('params')['username']) ):
                $checkUsername = $this->TeacherModel->checkUsernameExists([
                    'username' => $this->request->getpost('params')['username'],
                    'exclude_teacher_id' => $teacherId
                ]);
                
                if( $checkUsername['exists'] ):
                    echo json_encode([
                        'code' => 0,
                        'message' => 'Username already exists'
                    ]);
                    return;
                endif;

                $loginPayload = [
                    'teacher_id' => $teacherId,
                    'branch_username' => $this->request->getpost('params')['username'],
                    'branch_childcare' => $this->request->getpost('params')['branchChildcare'] ?: '2',
                    'branch_name' => $payload['teacher_name'],
                    'branch_status' => $this->request->getpost('params')['loginStatus'] ?: '1',
                    'modified_date' => date('Y-m-d H:i:s')
                ];

                if( !empty($this->request->getpost('params')['password']) ):
                    $loginPayload['branch_password'] = password_hash($this->request->getpost('params')['password'], PASSWORD_DEFAULT);
                endif;
            endif;

            $res = $this->TeacherModel->updateTeacherWithAccount($payload, $loginPayload);
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    public function getTeacherStats()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $res = $this->TeacherModel->selectTeacherStats();
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    public function getBranchesAndKindergartens()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $branches = $this->TeacherModel->selectBranches();
            $kindergartens = $this->TeacherModel->selectKindergartens();
            
            echo json_encode([
                'code' => 1,
                'message' => 'Success',
                'branches' => $branches['data'],
                'kindergartens' => $kindergartens['data']
            ]);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    /*
    * End Public
    */
}