<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class ClassroomControl extends BaseController
{
    /*
    * Protected
    */

    protected function sessionSchedule($sessionId,$startTime,$endTime)
    {
        switch( $sessionId ):
            case 1: $sessionRemark = 'Morning ('.date('H:i A',strtotime($startTime)).'-'.date('H:i A',strtotime($endTime)).')'; break;
            case 2: $sessionRemark = 'Afternoon ('.date('H:i A',strtotime($startTime)).'-'.date('H:i A',strtotime($endTime)).')'; break;
            case 3: $sessionRemark = 'Morning & Afternoon ('.date('H:i A',strtotime($startTime)).'-'.date('H:i A',strtotime($endTime)).')'; break;

            default:
                $sessionRemark = '---';
        endswitch;

        return $sessionRemark;
    }

    /*
    * End Protected
    */

    /*
    * Public
    */

    public function updateClassroomStatus()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $payload = [
                'classroom_id' => (int)$this->request->getpost('params')['classRoomId'],
                'status' => (int)$this->request->getpost('params')['status'],
                'modified_date' => date('Y-m-d H:i:s'),
            ];
            $res = $this->ClassroomModel->updateClassroomStatus($payload);
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    public function updateClassroom()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $startTime = Time::parse(date('H:i:s', strtotime($this->request->getpost('params')['sessionStartTime'])));
        $endTime = Time::parse(date('H:i:s', strtotime($this->request->getpost('params')['sessionEndTime'])));

        $sessionDefine = $this->sessionSchedule($this->request->getpost('params')['session'],$startTime,$endTime);

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $payload = [
                'classRoomId' => (int)$this->request->getpost('params')['classRoomId'],
                'classRoomName' => $this->request->getpost('params')['classRoomName'],
                'batchYear' => $this->request->getpost('params')['batchYear'],
                'session' => (int)$this->request->getpost('params')['session'],
                'sessionStart' => $startTime,
                'sessionEnd' => $endTime,
                'sessionRemark' => $sessionDefine,
                'totalChild' => (int)$this->request->getpost('params')['totalChild'],
                'totalTeacher' => (int)$this->request->getpost('params')['totalTeacher'],
            ];
            $res = $this->ClassroomModel->updateClassroom($payload);
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    public function addNewClassroom()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $startTime = Time::parse(date('H:i:s', strtotime($this->request->getpost('params')['sessionStartTime'])));
        $endTime = Time::parse(date('H:i:s', strtotime($this->request->getpost('params')['sessionEndTime'])));

        $sessionDefine = $this->sessionSchedule($this->request->getpost('params')['session'],$startTime,$endTime);

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $payload = [
                'classroom_name' => $this->request->getpost('params')['classRoomName'],
                'batch_year' => $this->request->getpost('params')['batchYear'],
                'session' => (int)$this->request->getpost('params')['session'],
                'sessionStart' => $startTime,
                'sessionEnd' => $endTime,
                'session_remark' => $sessionDefine,
            ];
            $res = $this->ClassroomModel->insertNewClassroom($payload);
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    public function getClassroom()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $payload = [
                'classRoomId' => (int)$this->request->getpost('params')['classRoomId'],
            ];
            $res = $this->ClassroomModel->selectClassroom($payload);
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 69,
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    public function classroomListWithPagination()
    {
        if( !session()->get('isLoggedIn') ): return false; endif;

        $raw = json_decode(file_get_contents('php://input'),1);

        $verifyLogged = $this->verifyLoggedUser();
        if( !$verifyLogged['timeout'] ):
            $payload = $this->ClassroomModel->selectAllClassroomsWithPagination([
                'pageindex' => $raw['pageindex'],
                'rowperpage' => $raw['rowperpage'],
                'classRoomName' => $raw['classRoomName'],
                'status' => (int)$raw['status'],
            ]);
            // echo json_encode($payload);

            if( $payload['code']==1 && $payload['data']!=[] ):
                $data = [];
                foreach( $payload['data'] as $i ):
                    $date = Time::parse(date('Y-m-d H:i:s', strtotime($i['created_date'])));
                    $createDate = $date->toDateTimeString();

                    $modifiedDate = '';
                    if( !empty($i['modified_date']) ):
                        $date2 = Time::parse(date('Y-m-d H:i:s', strtotime($i['modified_date'])));
                        $modifiedDate .= $date2->toDateTimeString();
                    else:
                        $modifiedDate .= '---';
                    endif;

                    if( $i['status']==1 ):
                        $status = '<a href="javascript:void(0);" class="btn btn-success btn-xs icon-btn" onclick="editClassroomStatus(\''.$i['classroom_id'].'\',\'2\');"><i class="ph-bold ph-check"></i></a>';
                    else:
                        $status = '<a href="javascript:void(0);" class="btn btn-danger btn-xs icon-btn" onclick="editClassroomStatus(\''.$i['classroom_id'].'\',\'1\');"><i class="ph-bold ph-x"></i></a>';
                    endif;

                    $action = '<div class="">';
                    $action .= '<a href="javascript:void(0);" class="btn btn-light-primary btn-xs icon-btn b-r-4 me-1" onclick="getClassroom(\''.$i['classroom_id'].'\');"><i class="ti ti-edit text-success"></i></a>';
                    $action .= $status;
                    $action .= '</div>';

                    $row = [];
                    // $row[] = $i['classroom_id'];
                    // $row[] = $i['branch_id'];
                    // $row[] = $i['kdgn_id'];
                    $row[] = $i['classroom_name'];
                    $row[] = $i['batch_year'];
                    $row[] = $i['session_remark'];
                    $row[] = $i['total_child'];
                    $row[] = $i['total_teachers'];
                    $row[] = $createDate;
                    $row[] = $modifiedDate;
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
                'message' => lang('Response.sessiontimeout')
            ]);
        endif;
    }

    /*
    * End Public
    */
}