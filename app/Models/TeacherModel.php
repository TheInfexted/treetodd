<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'db_teacher';
    protected $primaryKey = 'teacher_id';
    protected $allowedFields = [
        'branch_id', 'kdgn_id', 'kdmgm_id', 'teacher_name', 'age', 
        'highest_qualification', 'kap_certificate', 'hired_date', 
        'id_number', 'phone_number', 'address', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'modified_date';
    protected $dateFormat = 'datetime';

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    /**
     * Get teachers with pagination and filters
     */
    public function getTeachersWithPagination($params = [])
    {
        $builder = $this->db->table('db_teacher t');
        $builder->select('
            t.teacher_id,
            t.teacher_name,
            t.age,
            t.highest_qualification,
            t.kap_certificate,
            t.hired_date,
            t.id_number,
            t.phone_number,
            t.status,
            t.created_date,
            b.branch_name,
            k.kindergarden_name,
            IF(kb.branch_id IS NOT NULL, "Yes", "No") as has_login_account
        ');
        $builder->join('db_kinder_branch b', 't.branch_id = b.branch_id', 'left');
        $builder->join('db_kindergarden k', 't.kdgn_id = k.kdgn_id', 'left');
        $builder->join('db_kinder_branch kb', 't.teacher_id = kb.teacher_ref_id AND kb.branch_role = "2"', 'left');

        // Apply filters
        if (!empty($params['teacherName'])) {
            $builder->like('t.teacher_name', $params['teacherName']);
        }
        
        if (!empty($params['status']) && $params['status'] !== 'all') {
            $builder->where('t.status', $params['status']);
        }

        if (!empty($params['qualification'])) {
            $builder->like('t.highest_qualification', $params['qualification']);
        }

        if (!empty($params['branch_id'])) {
            $builder->where('t.branch_id', $params['branch_id']);
        }

        // Get total count
        $totalQuery = clone $builder;
        $totalCount = $totalQuery->countAllResults(false);

        // Apply pagination
        $offset = ($params['pageindex'] - 1) * $params['rowperpage'];
        $builder->limit($params['rowperpage'], $offset);
        $builder->orderBy('t.teacher_name', 'ASC');

        $result = $builder->get()->getResultArray();

        return [
            'data' => $result,
            'totalRecord' => $totalCount
        ];
    }

    /**
     * Get teacher details with related data
     */
    public function getTeacherDetails($teacherId)
    {
        $builder = $this->db->table('db_teacher t');
        $builder->select('
            t.*,
            b.branch_name,
            k.kindergarden_name,
            m.mgm_full_name as manager_name,
            kb.branch_username,
            kb.branch_status as login_status
        ');
        $builder->join('db_kinder_branch b', 't.branch_id = b.branch_id', 'left');
        $builder->join('db_kindergarden k', 't.kdgn_id = k.kdgn_id', 'left');
        $builder->join('db_kinder_management m', 't.kdmgm_id = m.kdmgm_id', 'left');
        $builder->join('db_kinder_branch kb', 't.teacher_id = kb.teacher_ref_id AND kb.branch_role = "2"', 'left');
        $builder->where('t.teacher_id', $teacherId);

        return $builder->get()->getRowArray();
    }

    /**
     * Create teacher with login account
     */
    public function createTeacherWithAccount($teacherData, $loginData = null)
    {
        $this->db->transStart();

        try {
            // Insert teacher
            $teacherId = $this->insert($teacherData);

            // Create login account if provided
            if ($loginData && $teacherId) {
                $branchModel = new \App\Models\BranchModel();
                $loginData['teacher_ref_id'] = $teacherId;
                $loginData['branch_role'] = '2'; // Teacher role
                $branchModel->insert($loginData);
            }

            $this->db->transCommit();
            return $teacherId;
        } catch (\Exception $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * Update teacher and login account
     */
    public function updateTeacherWithAccount($teacherId, $teacherData, $loginData = null)
    {
        $this->db->transStart();

        try {
            // Update teacher
            $this->update($teacherId, $teacherData);

            // Update or create login account
            if ($loginData) {
                $branchModel = new \App\Models\BranchModel();
                $existingAccount = $branchModel->where('teacher_ref_id', $teacherId)
                    ->where('branch_role', '2')
                    ->first();

                if ($existingAccount) {
                    $branchModel->update($existingAccount['branch_id'], $loginData);
                } else {
                    $loginData['teacher_ref_id'] = $teacherId;
                    $loginData['branch_role'] = '2';
                    $branchModel->insert($loginData);
                }
            }

            $this->db->transCommit();
            return true;
        } catch (\Exception $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * Get branches for dropdown
     */
    public function getBranches()
    {
        return $this->db->table('db_kinder_branch')
            ->select('branch_id, branch_name')
            ->where('branch_role', '1') // Only admin branches
            ->where('branch_status', '1')
            ->get()
            ->getResultArray();
    }

    /**
     * Get kindergardens for dropdown
     */
    public function getKindergarden()
    {
        return $this->db->table('db_kindergarden')
            ->select('kdgn_id, kindergarden_name')
            ->where('kindergarden_status', '1')
            ->get()
            ->getResultArray();
    }

    /**
     * Check if ID number exists
     */
    public function isIdNumberExists($idNumber, $excludeTeacherId = null)
    {
        $builder = $this->db->table('db_teacher');
        $builder->where('id_number', $idNumber);
        
        if ($excludeTeacherId) {
            $builder->where('teacher_id !=', $excludeTeacherId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Check if username exists in branch table
     */
    public function isUsernameExists($username, $excludeTeacherId = null)
    {
        $builder = $this->db->table('db_kinder_branch');
        $builder->where('branch_username', $username);
        $builder->where('branch_role', '2');
        
        if ($excludeTeacherId) {
            $builder->where('teacher_ref_id !=', $excludeTeacherId);
        }
        
        return $builder->countAllResults() > 0;
    }
}