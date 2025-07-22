<?php namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'db_kinder_branch';
    // protected $allowedFields = ['session_id','upline_role','upline_id','role','status','username','password','agent_code','email','mobile_no','firstname','lastname','remark','login_ip','lastlogin_date','created_date','updated_date'];

    public function __construct()
	{
		$this->db = db_connect();
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

    /*
    * End Public
    */

}