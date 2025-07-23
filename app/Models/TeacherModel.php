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
        'id_number', 'phone_number', 'address', 'status', 'modified_date'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'modified_date';

    public function __construct()
    {
        $this->db = db_connect();
        parent::__construct();
    }

    /**
     * Get teachers with pagination and filters
     */
    public function getTeachersWithPagination($params)
    {
        $offset = ($params['pageindex'] - 1) * $params['rowperpage'];
        
        $builder = $this->db->table($this->table . ' t');
        $builder->select('t.*, 
                         br.branch_name,
                         k.kindergarden_name,
                         m.mgm_full_name as manager_name')
                ->join('db_kinder_branch br', 'br.branch_id = t.branch_id', 'left')
                ->join('db_kindergarden k', 'k.kdgn_id = t.kdgn_id', 'left')
                ->join('db_kinder_management m', 'm.kdmgm_id = t.kdmgm_id', 'left');

        // Apply filters
        if (!empty($params['teacherName'])) {
            $builder->like('t.teacher_name', $params['teacherName']);
        }
        
        if (!empty($params['qualification'])) {
            $builder->like('t.highest_qualification', $params['qualification']);
        }
        
        if (!empty($params['branch_id'])) {
            $builder->where('t.branch_id', $params['branch_id']);
        }
        
        if ($params['status'] !== 'all' && !empty($params['status'])) {
            $builder->where('t.status', $params['status']);
        }

        // Get total count
        $totalBuilder = clone $builder;
        $totalRecord = $totalBuilder->countAllResults();

        // Get paginated data
        $data = $builder->orderBy('t.teacher_id', 'DESC')
                       ->limit($params['rowperpage'], $offset)
                       ->get()
                       ->getResultArray();

        return [
            'code' => 1,
            'data' => $data,
            'totalRecord' => $totalRecord,
            'pageIndex' => $params['pageindex'],
            'rowPerPage' => $params['rowperpage']
        ];
    }

    /**
     * Get teacher details with login info
     */
    public function getTeacherDetails($teacherId)
    {
        $builder = $this->db->table($this->table . ' t');
        $teacher = $builder->select('t.*, 
                                   b.branch_username, 
                                   b.branch_childcare, 
                                   b.branch_status as login_status,
                                   br.branch_name,
                                   k.kindergarden_name,
                                   m.mgm_full_name as manager_name')
                          ->join('db_kinder_branch b', 'b.teacher_ref_id = t.teacher_id', 'left')
                          ->join('db_kinder_branch br', 'br.branch_id = t.branch_id', 'left')
                          ->join('db_kindergarden k', 'k.kdgn_id = t.kdgn_id', 'left')
                          ->join('db_kinder_management m', 'm.kdmgm_id = t.kdmgm_id', 'left')
                          ->where('t.teacher_id', $teacherId)
                          ->get()
                          ->getRowArray();

        return $teacher;
    }

    /**
     * Create teacher with optional login account
     */
    public function createTeacherWithAccount($teacherData, $loginData = null)
    {
        $this->db->transStart();

        try {
            // Insert teacher
            $this->insert($teacherData);
            $teacherId = $this->getInsertID();

            // Create login account if provided
            if ($loginData) {
                $loginData['teacher_ref_id'] = $teacherId;
                $this->db->table('db_kinder_branch')->insert($loginData);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Failed to create teacher');
            }

            return $teacherId;

        } catch (\Exception $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * Update teacher with optional login account
     */
    public function updateTeacherWithAccount($teacherId, $teacherData, $loginData = null)
    {
        $this->db->transStart();

        try {
            // Update teacher
            $this->update($teacherId, $teacherData);

            // Update login account if provided
            if ($loginData) {
                $existingLogin = $this->db->table('db_kinder_branch')
                                         ->where('teacher_ref_id', $teacherId)
                                         ->get()
                                         ->getRowArray();

                if ($existingLogin) {
                    $this->db->table('db_kinder_branch')
                            ->where('teacher_ref_id', $teacherId)
                            ->update($loginData);
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Failed to update teacher');
            }

            return true;

        } catch (\Exception $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * Check if ID number exists
     */
    public function isIdNumberExists($idNumber, $excludeTeacherId = null)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id_number', $idNumber);
        
        if ($excludeTeacherId) {
            $builder->where('teacher_id !=', $excludeTeacherId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Check if username exists
     */
    public function isUsernameExists($username, $excludeTeacherId = null)
    {
        $builder = $this->db->table('db_kinder_branch');
        $builder->where('branch_username', $username);
        
        if ($excludeTeacherId) {
            $builder->where('teacher_ref_id !=', $excludeTeacherId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Get branches for dropdown
     */
    public function getBranches()
    {
        return $this->db->table('db_kinder_branch')
                       ->select('branch_id, branch_name')
                       ->where('branch_role', '1') // Only admin branches
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get kindergartens for dropdown
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
     * Get teacher statistics
     */
    public function getTeacherStats()
    {
        $stats = [];
        
        // Total teachers
        $stats['total'] = $this->countAll();
        
        // By status
        $stats['active'] = $this->where('status', '1')->countAllResults(false);
        $stats['inactive'] = $this->where('status', '2')->countAllResults(false);
        $stats['terminated'] = $this->where('status', '3')->countAllResults(false);
        
        // With KAP certificate
        $stats['with_kap'] = $this->where('kap_certificate', '1')->countAllResults(false);
        
        // Recent hires (last 30 days)
        $stats['recent_hires'] = $this->where('hired_date >=', date('Y-m-d', strtotime('-30 days')))
                                     ->countAllResults(false);

        return $stats;
    }
}