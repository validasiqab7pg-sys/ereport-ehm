<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Models\BaseModel;

// use Modules\Authentication\Models\UserAuthModel;

class UserModel extends BaseModel
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = ['id','username','password','email','jabatan','department','status'	
    ];
    protected function initialize()
    {
        $this->allowedFields[] = 'middlename';
    }



}