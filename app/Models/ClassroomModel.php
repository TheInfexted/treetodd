<?php namespace App\Models;

use CodeIgniter\Model;

class ClassroomModel extends Model
{
    protected $table = 'db_classroom';

    public function __construct()
	{
		$this->db = db_connect();
	}

    protected function initialize()
    {
        $this->allowedFields[] = ['classroom_id','classroom_name','batch_year','session','total_child','total_teachers','status','created_date','modified_date'];
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

    public function updateClassroomStatus($where)
    {
        try {
            $params = [
                'status' => $where['status'],
                'modified_date' => $where['modified_date'],
            ];

            $builder = $this->db->table($this->table);
            $query = $builder->ignore(true)
                ->set($params)
                ->where('classroom_id', $where['classroom_id'])
                ->update();

            if( $query ):
                $response = [
                    'code' => 1,
                    'message' => lang('Response.success')
                ];
            else:
                $response = $this->db->error();
            endif;

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertNewClassroom($where)
	{
        try {
            $builder = $this->db->table($this->table);
            $query = $builder->ignore(true)
                ->set($where)
                ->insert();

            if( $query ):
                $response = [
                    'code' => 1,
                    'message' => lang('Response.success')
                ];
            else:
                $response = $this->db->error();
            endif;

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
	}

    public function selectAllClassroomsWithPagination($where)
	{
        $indexing = $where['pageindex'] - 1;

        try {
            $builder = $this->db->table($this->table);

            if( !empty($where['status']) && empty($where['classroomName']) ):
                $query = $builder->select('*')
                    ->set($where)
                    ->where('status', $where['status'])
                    ->limit($where['rowperpage'], $indexing)
                    ->orderBy('classroom_id DESC')
                    ->get()->getResultArray();

                // All
                $allRows = $builder->select('*')
                    ->where('status', $where['status'])
                    ->countAllResults();
                // End All
            elseif( empty($where['status']) && !empty($where['classroomName']) ):
                $query = $builder->select('*')
                    ->set($where)
                    ->like('classroom_name', $where['classroomName'], 'both')
                    ->limit($where['rowperpage'], $indexing)
                    ->orderBy('classroom_id DESC')
                    ->get()->getResultArray();

                // All
                $allRows = $builder->select('*')
                    ->like('classroom_name', $where['classroomName'], 'both')
                    ->countAllResults();
                // End All
            else:
                $query = $builder->select('*')
                    ->set($where)
                    ->limit($where['rowperpage'], $indexing)
                    ->orderBy('classroom_id DESC')
                    ->get()->getResultArray();

                // All
                $allRows = $builder->countAll();
                // End All
            endif;

            $totalRecord = $allRows;
            $getTotalPage = $totalRecord / $where['rowperpage'];
            $totalPage = $getTotalPage<1 ? 1 : $getTotalPage;

            if( $query ):
                $response = [
                    'code' => 1,
                    'message' => lang('Response.success'),
                    'data' => $query,
                    'pageIndex' => $where['pageindex'],
                    'rowPerPage' => $where['rowperpage'],
                    'totalPage' => (int)$totalPage,
                    'totalRecord' => (int)$totalRecord
                ];
            else:
                $response = $this->db->error();
            endif;

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /*
    * End Public
    */

}