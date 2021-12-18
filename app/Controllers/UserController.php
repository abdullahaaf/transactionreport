<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class UserController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        //
        $users = new UserModel;
        return $this->respond(['users' => $users->findAll()], 200);
    }

    public function getUser()
    {
        $user = new UserModel();
        $data_user = $user->getLoggedUser($this->decoded_token['user_name']);
        return $this->respond(['users' => $data_user], 200);
    }
}
