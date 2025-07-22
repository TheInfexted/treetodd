<?php namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'db_user';
    // protected $allowedFields = ['session_id','upline_role','upline_id','role','status','username','password','agent_code','email','mobile_no','firstname','lastname','remark','login_ip','lastlogin_date','created_date','updated_date'];

    public function __construct()
	{
		$this->db = db_connect();
	}

    /*
    * Protected
    */

    protected function findUserByEmail($where)
	{
        try {
            $builder = $this->db->table($this->table);
            $query = $builder->select('*')
                ->where('email', $where['email'])
                ->get()->getRowArray();

            if( $query ):
                $response = $query;
            else:
                $response = $this->db->error();
            endif;

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /*
    * End Protected
    */

    /*
    * Public
    */

    public function selectUserAfterLogin()
	{
        $conditions = "username='{$_SESSION['username']}' AND user_token='{$_SESSION['session']}'";

        try {
            $builder = $this->db->table($this->table);
            $query = $builder->select('*')
                // ->where('username', $_SESSION['username'])
                // ->where('user_token', $_SESSION['token'])
                ->where($conditions)
                ->get()->getRowArray();

            if( $query ):
                $response = [
                    'code' => 1,
                    'message' => lang('Response.success'),
                    'data' => $query
                ];
            else:
                $response = $this->db->error();
            endif;

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectUserBeforeLogin($where)
	{
        try {
            $builder = $this->db->table($this->table);
            $query = $builder->select('*')
                ->where('email', $where['email'])
                ->get()->getRowArray();

            if( $query ):
                $response = [
                    'code' => 1,
                    'message' => lang('Response.success'),
                    'data' => $query
                ];
            else:
                $response = $this->db->error();
            endif;

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateUserLogin($where)
	{
        try {
            $params = [
                'user_token' => $where['user_token'],
                'lastlogin_ip' => $where['lastlogin_ip'],
                'lastlogin_date' => $where['lastlogin_date'],
            ];

            $builder = $this->db->table($this->table);
            $query = $builder->ignore(true)
                ->set($params)
                ->where('email', $where['email'])
                ->update();

            if( $query ):
                // Find User
                $user = $this->findUserByEmail(['email'=>$where['email']]);
                // End Find User

                $response = [
                    'code' => 1,
                    'message' => lang('Response.success'),
                    'data' => $user
                ];
            else:
                $response = $this->db->error();
            endif;

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateUserLogOut()
    {
        try {
            $params = [
                'user_token' => '',
            ];

            $builder = $this->db->table($this->table);
            $query = $builder->ignore(true)
                ->set($params)
                ->where('username', $_SESSION['username'])
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

    /*
    * End Public
    */
}