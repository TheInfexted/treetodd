<?php

namespace App\Models;

use CodeIgniter\Model;

class BranchModel extends Model
{
    protected $table = 'db_kinder_branch';
    protected $primaryKey = 'branch_id';
    protected $allowedFields = [
        'kdgn_id', 'kdmgm_id', 'branch_username', 'branch_password', 
        'branch_role', 'branch_childcare', 'branch_name', 'branch_status',
        'teacher_ref_id'
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
}