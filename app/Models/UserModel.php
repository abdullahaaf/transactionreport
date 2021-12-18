<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "users";
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ["id","name","username","password"];

    public function getLoggedUser($user_name)
    {
        return $this->table('users')
                    ->where('users.user_name', $user_name)
                    ->get()
                    ->getRowArray();
    }
}
