<?php namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'db_teacher';

    protected function initialize()
    {
        $this->allowedFields[] = ['teacher_id','branch_id','kdgn_id','kdmgm_id','teacher_name','age','highest_qualification','kap_certificate','hired_date','id_number','phone_number','address','status','created_date','modified_date'];
    }

    /*
    * Protected
    */

    /*
    * End Protected
    */

    /*
    * Public
    */

    public function updateTeacherStatus($where)
    {
        $params = [
            'status' => $where['status'],
            'modified_date' => $where['modified_date'],
        ];

        $builder = $this->db->table($this->table);
        $query = $builder->set($params)
            ->where('teacher_id', $where['teacher_id'])
            ->update();

        if( $query ):
            $response = [
                'code' => 1,
                'message' => 'Teacher status updated successfully'
            ];
        else:
            $response = $this->db->error();
        endif;

        return $response;
    }

    public function insertNewTeacher($where, $loginData = null)
	{
        $this->db->transStart();

        // Insert teacher
        $builder = $this->db->table($this->table);
        $query = $builder->ignore(true)
            ->set($where)
            ->insert();

        if( $query ):
            $teacherId = $this->db->insertID();
            
            // Create login account if provided
            if( $loginData ):
                $loginData['teacher_ref_id'] = $teacherId;
                $loginBuilder = $this->db->table('db_kinder_branch');
                $loginQuery = $loginBuilder->ignore(true)
                    ->set($loginData)
                    ->insert();
                
                if( !$loginQuery ):
                    $this->db->transRollback();
                    return $this->db->error();
                endif;
            endif;

            $this->db->transComplete();

            if( $this->db->transStatus() === false ):
                $response = [
                    'code' => 0,
                    'message' => 'Failed to create teacher'
                ];
            else:
                $response = [
                    'code' => 1,
                    'message' => lang('Label.teacher_added_successfully'),
                    'teacher_id' => $teacherId
                ];
            endif;
        else:
            $response = $this->db->error();
        endif;

        return $response;
	}

        public function selectAllTeachersWithPagination($where)
	{
        $indexing = ($where['pageindex'] - 1) * $where['rowperpage'];

        $builder = $this->db->table($this->table . ' t');
        $builder->select('t.*, 
                         br.branch_name,
                         k.kindergarden_name,
                         m.mgm_full_name as manager_name')
                ->join('db_kinder_branch br', 'br.branch_id = t.branch_id', 'left')
                ->join('db_kindergarden k', 'k.kdgn_id = t.kdgn_id', 'left')
                ->join('db_kinder_management m', 'm.kdmgm_id = t.kdmgm_id', 'left');

        // Apply filters
        if( !empty($where['status']) && $where['status'] !== 'all' ):
            $builder->where('t.status', $where['status']);
        endif;
        
        if( !empty($where['teacherName']) ):
            $builder->like('t.teacher_name', $where['teacherName'], 'both');
        endif;
        
        if( !empty($where['qualification']) ):
            $builder->like('t.highest_qualification', $where['qualification'], 'both');
        endif;
        
        if( !empty($where['branchId']) ):
            $builder->where('t.branch_id', $where['branchId']);
        endif;

        // Get total count before applying limit
        $countBuilder = clone $builder;
        $totalRecord = $countBuilder->countAllResults(false);

        // Apply pagination
        $query = $builder->orderBy('t.teacher_id', 'DESC')
                       ->limit($where['rowperpage'], $indexing)
                       ->get()
                       ->getResultArray();

        $getTotalPage = ceil($totalRecord / $where['rowperpage']);
        $totalPage = $getTotalPage < 1 ? 1 : $getTotalPage;

        if( $query !== false ):
            $response = [
                'code' => 1,
                'message' => 'Success',
                'data' => $query,
                'pageIndex' => $where['pageindex'],
                'rowPerPage' => $where['rowperpage'],
                'totalPage' => (int)$totalPage,
                'totalRecord' => (int)$totalRecord
            ];
        else:
            $response = [
                'code' => 0,
                'message' => 'No data found',
                'data' => [],
                'pageIndex' => $where['pageindex'],
                'rowPerPage' => $where['rowperpage'],
                'totalPage' => 1,
                'totalRecord' => 0
            ];
        endif;

        return $response;
    }

    public function selectTeacherDetails($where)
    {
        $builder = $this->db->table($this->table . ' t');
        $query = $builder->select('t.*, 
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
                        ->where('t.teacher_id', $where['teacher_id'])
                        ->get()->getRowArray();

        if( $query ):
            $response = [
                'code' => 1,
                'message' => 'Success',
                'data' => $query
            ];
        else:
            $response = [
                'code' => 0,
                'message' => 'Teacher not found'
            ];
        endif;

        return $response;
    }

    public function updateTeacherWithAccount($where, $loginData = null)
    {
        $this->db->transStart();

        // Update teacher
        $params = [
            'teacher_name' => $where['teacher_name'],
            'age' => $where['age'],
            'highest_qualification' => $where['highest_qualification'],
            'kap_certificate' => $where['kap_certificate'],
            'hired_date' => $where['hired_date'],
            'id_number' => $where['id_number'],
            'phone_number' => $where['phone_number'],
            'address' => $where['address'],
            'status' => $where['status'],
            'modified_date' => $where['modified_date'],
        ];

        $builder = $this->db->table($this->table);
        $query = $builder->set($params)
            ->where('teacher_id', $where['teacher_id'])
            ->update();

        if( $query ):
            // Update login account if provided
            if( $loginData ):
                $existingLogin = $this->db->table('db_kinder_branch')
                                         ->where('teacher_ref_id', $where['teacher_id'])
                                         ->get()
                                         ->getRowArray();

                if( $existingLogin ):
                    $loginBuilder = $this->db->table('db_kinder_branch');
                    $loginParams = [
                        'branch_username' => $loginData['branch_username'],
                        'branch_childcare' => $loginData['branch_childcare'],
                        'branch_name' => $loginData['branch_name'],
                        'branch_status' => $loginData['branch_status'],
                        'modified_date' => $loginData['modified_date']
                    ];
                    
                    // Only update password if provided
                    if( !empty($loginData['branch_password']) ):
                        $loginParams['branch_password'] = $loginData['branch_password'];
                    endif;
                    
                    $loginQuery = $loginBuilder->set($loginParams)
                        ->where('teacher_ref_id', $where['teacher_id'])
                        ->update();
                    
                    if( !$loginQuery ):
                        $this->db->transRollback();
                        return [
                            'code' => 0,
                            'message' => 'Failed to update login account'
                        ];
                    endif;
                else:
                    // Create new login account if it doesn't exist
                    $loginData['teacher_ref_id'] = $where['teacher_id'];
                    $loginBuilder = $this->db->table('db_kinder_branch');
                    $loginQuery = $loginBuilder->insert($loginData);
                    
                    if( !$loginQuery ):
                        $this->db->transRollback();
                        return [
                            'code' => 0,
                            'message' => 'Failed to create login account'
                        ];
                    endif;
                endif;
            endif;

            $this->db->transComplete();

            if( $this->db->transStatus() === false ):
                $response = [
                    'code' => 0,
                    'message' => 'Failed to update teacher'
                ];
            else:
                $response = [
                    'code' => 1,
                    'message' => lang('Label.teacher_updated_successfully')
                ];
            endif;
        else:
            $response = [
                'code' => 0,
                'message' => 'Failed to update teacher record'
            ];
        endif;

        return $response;
    }

    public function checkIdNumberExists($where)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id_number', $where['id_number']);
        
        if( isset($where['exclude_teacher_id']) ):
            $builder->where('teacher_id !=', $where['exclude_teacher_id']);
        endif;
        
        $count = $builder->countAllResults();
        
        $response = [
            'code' => 1,
            'exists' => $count > 0
        ];

        return $response;
    }

    public function checkUsernameExists($where)
    {
        $builder = $this->db->table('db_kinder_branch');
        $builder->where('branch_username', $where['username']);
        
        if( isset($where['exclude_teacher_id']) ):
            $builder->where('teacher_ref_id !=', $where['exclude_teacher_id']);
        endif;
        
        $count = $builder->countAllResults();
        
        $response = [
            'code' => 1,
            'exists' => $count > 0
        ];

        return $response;
    }

    public function selectBranches()
    {
        $builder = $this->db->table('db_kinder_branch');
        $query = $builder->select('branch_id, branch_name')
                       ->where('branch_role', '1') // Only admin branches
                       ->where('branch_status', '1')
                       ->get()->getResultArray();

        $response = [
            'code' => 1,
            'message' => 'Success',
            'data' => $query ?: []
        ];

        return $response;
    }

    public function selectKindergartens()
    {
        $builder = $this->db->table('db_kindergarden');
        $query = $builder->select('kdgn_id, kindergarden_name')
                       ->where('kindergarden_status', '1')
                       ->get()->getResultArray();

        $response = [
            'code' => 1,
            'message' => 'Success',
            'data' => $query ?: []
        ];

        return $response;
    }

    public function selectTeacherStats()
    {
        $stats = [];
        
        // Total teachers
        $totalBuilder = $this->db->table($this->table);
        $stats['total'] = $totalBuilder->countAllResults();
        
        // By status
        $activeBuilder = $this->db->table($this->table);
        $stats['active'] = $activeBuilder->where('status', '1')->countAllResults();
        
        $inactiveBuilder = $this->db->table($this->table);
        $stats['inactive'] = $inactiveBuilder->where('status', '2')->countAllResults();
        
        $terminatedBuilder = $this->db->table($this->table);
        $stats['terminated'] = $terminatedBuilder->where('status', '3')->countAllResults();
        
        // With KAP certificate
        $kapBuilder = $this->db->table($this->table);
        $stats['with_kap'] = $kapBuilder->where('kap_certificate', '1')->countAllResults();
        
        // Recent hires (last 30 days)
        $recentBuilder = $this->db->table($this->table);
        $stats['recent_hires'] = $recentBuilder->where('hired_date >=', date('Y-m-d', strtotime('-30 days')))
                                              ->countAllResults();

        $response = [
            'code' => 1,
            'message' => 'Success',
            'data' => $stats
        ];

        return $response;
    }

    /*
    * End Public
    */

}