<?php

namespace App\Controllers;

use App\Models\TeacherModel;
use App\Models\BranchModel;
use CodeIgniter\RESTful\ResourceController;

class TeacherController extends ResourceController
{
    protected $teacherModel;
    protected $branchModel;
    protected $session;

    public function __construct()
    {
        $this->teacherModel = new TeacherModel();
        $this->branchModel = new BranchModel();
        $this->session = session();
    }

    /**
     * Display teacher index page
     */
    public function index()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data['session'] = $this->session->get('isLoggedIn') ? true : false;
        $data['pageName'] = lang('Nav.teacher');
        $data['branches'] = $this->teacherModel->getBranches();
        $data['kindergardens'] = $this->teacherModel->getKindergarden();

        echo view('template/start');
        echo view('template/header');
        echo view('teacher/index', $data);
        echo view('template/footer');
        echo view('template/end', $data);
    }

    /**
     * Get teachers list with pagination (AJAX)
     */
    public function teacherListWithPagination()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'code' => 69,
                'message' => 'Session expired'
            ]);
        }

        try {
            $input = json_decode($this->request->getBody(), true);
            
            $params = [
                'pageindex' => $input['pageindex'] ?? 1,
                'rowperpage' => $input['rowperpage'] ?? 20,
                'teacherName' => $input['teacherName'] ?? '',
                'status' => $input['status'] ?? 'all',
                'qualification' => $input['qualification'] ?? '',
                'branch_id' => $input['branch_id'] ?? ''
            ];

            $result = $this->teacherModel->getTeachersWithPagination($params);

            // Format data for DataTables
            $formattedData = [];
            foreach ($result['data'] as $row) {
                $kapBadge = $row['kap_certificate'] === '1' 
                    ? '<span class="badge bg-primary">Yes</span>'
                    : '<span class="badge bg-secondary">No</span>';

                $actions = '
                    <button class="btn btn-sm btn-primary" onclick="viewTeacher(' . $row['teacher_id'] . ')">
                        <i class="ph-bold ph-eye me-1"></i>
                    </button>';

                switch ($row['status']) {
                    case '1': // Active
                        $statusButtons = '
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-sm btn-success me-1" 
                                    title="Set Inactive" 
                                    onclick="changeTeacherStatus(' . $row['teacher_id'] . ', \'2\')">
                                    <i class="ph-bold ph-check"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" 
                                    title="Terminate" 
                                    onclick="changeTeacherStatus(' . $row['teacher_id'] . ', \'3\')">
                                    <i class="ph-bold ph-x"></i>
                                </button>
                            </div>';
                        break;

                    case '2': // Inactive
                        $statusButtons = '
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-sm btn-warning me-1" 
                                    title="Set Active" 
                                    onclick="changeTeacherStatus(' . $row['teacher_id'] . ', \'1\')">
                                    <i class="ph-bold ph-pause"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" 
                                    title="Terminate" 
                                    onclick="changeTeacherStatus(' . $row['teacher_id'] . ', \'3\')">
                                    <i class="ph-bold ph-x"></i>
                                </button>
                            </div>';
                        break;

                    case '3': // Terminated
                    default:
                        $statusButtons = '<span class="badge bg-danger">Terminated</span>';
                        break;
                }

                $formattedData[] = [
                    $row['teacher_name'],
                    $row['age'],
                    $row['highest_qualification'],
                    $kapBadge,
                    date('M d, Y', strtotime($row['hired_date'])),
                    $row['phone_number'],
                    $row['branch_name'] ?? 'N/A',
                    $statusButtons,
                    $actions
                ];
            }

            return $this->response->setJSON([
                'code' => 1,
                'message' => 'Success',
                'data' => $formattedData,
                'totalRecord' => $result['totalRecord']
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Add new teacher
     */
    public function addNewTeacher()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'code' => 69,
                'message' => 'Session expired'
            ]);
        }

        try {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'teacher_name' => 'required|min_length[2]|max_length[100]',
                'age' => 'required|integer|greater_than[17]|less_than[100]',
                'highest_qualification' => 'required|max_length[200]',
                'hired_date' => 'required|valid_date[Y-m-d]',
                'id_number' => 'required|max_length[50]',
                'phone_number' => 'required|max_length[20]',
                'address' => 'required',
                'branch_id' => 'required|integer',
                'kdgn_id' => 'required|integer',
                'kdmgm_id' => 'required|integer'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'Validation failed',
                    'errors' => $validation->getErrors()
                ]);
            }

            // Check if ID number already exists
            if ($this->teacherModel->isIdNumberExists($this->request->getPost('id_number'))) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'ID Number already exists'
                ]);
            }

            $teacherData = [
                'teacher_name' => $this->request->getPost('teacher_name'),
                'age' => $this->request->getPost('age'),
                'highest_qualification' => $this->request->getPost('highest_qualification'),
                'kap_certificate' => $this->request->getPost('kap_certificate') ?: '2',
                'hired_date' => $this->request->getPost('hired_date'),
                'id_number' => $this->request->getPost('id_number'),
                'phone_number' => $this->request->getPost('phone_number'),
                'address' => $this->request->getPost('address'),
                'branch_id' => $this->request->getPost('branch_id'),
                'kdgn_id' => $this->request->getPost('kdgn_id'),
                'kdmgm_id' => $this->request->getPost('kdmgm_id'),
                'status' => '1'
            ];

            $loginData = null;
            if ($this->request->getPost('create_login') === '1') {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                if (empty($username) || empty($password)) {
                    return $this->response->setJSON([
                        'code' => 0,
                        'message' => 'Username and password are required for login account'
                    ]);
                }

                if ($this->teacherModel->isUsernameExists($username)) {
                    return $this->response->setJSON([
                        'code' => 0,
                        'message' => 'Username already exists'
                    ]);
                }

                $loginData = [
                    'kdgn_id' => $teacherData['kdgn_id'],
                    'kdmgm_id' => $teacherData['kdmgm_id'],
                    'branch_username' => $username,
                    'branch_password' => password_hash($password, PASSWORD_DEFAULT),
                    'branch_role' => '2',
                    'branch_childcare' => $this->request->getPost('branch_childcare') ?: '2',
                    'branch_name' => $teacherData['teacher_name'],
                    'branch_status' => '1'
                ];
            }

            $teacherId = $this->teacherModel->createTeacherWithAccount($teacherData, $loginData);

            return $this->response->setJSON([
                'code' => 1,
                'message' => 'Teacher added successfully',
                'teacher_id' => $teacherId
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get teacher details for editing
     */
    public function getTeacherDetails($teacherId)
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'code' => 69,
                'message' => 'Session expired'
            ]);
        }

        try {
            $teacher = $this->teacherModel->getTeacherDetails($teacherId);
            
            if (!$teacher) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'Teacher not found'
                ]);
            }

            return $this->response->setJSON([
                'code' => 1,
                'message' => 'Success',
                'data' => $teacher
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update teacher
     */
    public function updateTeacher()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'code' => 69,
                'message' => 'Session expired'
            ]);
        }

        try {
            $teacherId = $this->request->getPost('teacher_id');
            
            $validation = \Config\Services::validation();
            $validation->setRules([
                'teacher_id' => 'required|integer',
                'teacher_name' => 'required|min_length[2]|max_length[100]',
                'age' => 'required|integer|greater_than[17]|less_than[100]',
                'highest_qualification' => 'required|max_length[200]',
                'hired_date' => 'required|valid_date[Y-m-d]',
                'id_number' => 'required|max_length[50]',
                'phone_number' => 'required|max_length[20]',
                'address' => 'required'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'Validation failed',
                    'errors' => $validation->getErrors()
                ]);
            }

            // Check if ID number already exists (exclude current teacher)
            if ($this->teacherModel->isIdNumberExists($this->request->getPost('id_number'), $teacherId)) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'ID Number already exists'
                ]);
            }

            $teacherData = [
                'teacher_name' => $this->request->getPost('teacher_name'),
                'age' => $this->request->getPost('age'),
                'highest_qualification' => $this->request->getPost('highest_qualification'),
                'kap_certificate' => $this->request->getPost('kap_certificate') ?: '2',
                'hired_date' => $this->request->getPost('hired_date'),
                'id_number' => $this->request->getPost('id_number'),
                'phone_number' => $this->request->getPost('phone_number'),
                'address' => $this->request->getPost('address'),
                'status' => $this->request->getPost('status') ?: '1'
            ];

            $loginData = null;
            if ($this->request->getPost('update_login') === '1') {
                $username = $this->request->getPost('username');
                
                if (empty($username)) {
                    return $this->response->setJSON([
                        'code' => 0,
                        'message' => 'Username is required for login account'
                    ]);
                }

                if ($this->teacherModel->isUsernameExists($username, $teacherId)) {
                    return $this->response->setJSON([
                        'code' => 0,
                        'message' => 'Username already exists'
                    ]);
                }

                $loginData = [
                    'branch_username' => $username,
                    'branch_childcare' => $this->request->getPost('branch_childcare') ?: '2',
                    'branch_name' => $teacherData['teacher_name'],
                    'branch_status' => $this->request->getPost('login_status') ?: '1'
                ];

                // Add password if provided
                $password = $this->request->getPost('password');
                if (!empty($password)) {
                    $loginData['branch_password'] = password_hash($password, PASSWORD_DEFAULT);
                }
            }

            $this->teacherModel->updateTeacherWithAccount($teacherId, $teacherData, $loginData);

            return $this->response->setJSON([
                'code' => 1,
                'message' => 'Teacher updated successfully'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete teacher
     */
    public function deleteTeacher()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'code' => 69,
                'message' => 'Session expired'
            ]);
        }

        try {
            $teacherId = $this->request->getPost('teacher_id');
            
            if (empty($teacherId)) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'Teacher ID is required'
                ]);
            }

            // Check if teacher exists
            $teacher = $this->teacherModel->find($teacherId);
            if (!$teacher) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'Teacher not found'
                ]);
            }

            // Delete teacher (will cascade delete login account due to foreign key)
            $this->teacherModel->delete($teacherId);

            return $this->response->setJSON([
                'code' => 1,
                'message' => 'Teacher deleted successfully'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Change teacher status
     */
    public function changeStatus()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'code' => 69,
                'message' => 'Session expired'
            ]);
        }

        try {
            $teacherId = $this->request->getPost('teacher_id');
            $newStatus = $this->request->getPost('status');
            
            if (empty($teacherId) || empty($newStatus)) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'Teacher ID and status are required'
                ]);
            }

            // Validate status value
            if (!in_array($newStatus, ['1', '2', '3'])) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'Invalid status value'
                ]);
            }

            // Check if teacher exists
            $teacher = $this->teacherModel->find($teacherId);
            if (!$teacher) {
                return $this->response->setJSON([
                    'code' => 0,
                    'message' => 'Teacher not found'
                ]);
            }

            // Update teacher status
            $this->teacherModel->update($teacherId, ['status' => $newStatus]);

            $statusText = match($newStatus) {
                '1' => 'Active',
                '2' => 'Inactive',
                '3' => 'Terminated',
                default => 'Unknown'
            };

            return $this->response->setJSON([
                'code' => 1,
                'message' => "Teacher status changed to {$statusText} successfully"
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * View teacher details page
     */
    public function view($teacherId)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $teacher = $this->teacherModel->getTeacherDetails($teacherId);
        
        if (!$teacher) {
            return redirect()->to('/teachers')->with('error', 'Teacher not found');
        }

        $data['session'] = $this->session->get('isLoggedIn') ? true : false;
        $data['pageName'] = 'Teacher Details - ' . $teacher['teacher_name'];
        $data['teacher'] = $teacher;

        echo view('template/start');
        echo view('template/header');
        echo view('teacher/view', $data);
        echo view('template/footer');
        echo view('template/end', $data);
    }
}