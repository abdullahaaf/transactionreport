<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class LoginController extends ResourceController
{
    use ResponseTrait;

    public function login()
    {
        //
        $userModel = new UserModel();
  
        $user_name = $this->request->getVar('user_name');
        $password = $this->request->getVar('password');
          
        $user = $userModel->where('user_name', $user_name)->first();
  
        if(is_null($user)) {
            return $this->respond(['error' => 'No user.'], 401);
        }
  
        // $pwd_verify = password_verify($password, $user['password']);
        $pwd_verify = md5($password) === $user->password;
  
        if(!$pwd_verify) {
            return $this->respond(['error' => 'Invalid Password.'], 401);
        }
 
        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;
 
        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "user_name" => $user->user_name,
            "uid" => $user->id
        );
         
        $token = JWT::encode($payload, $key);
 
        $response = [
            'message' => 'Login Succesful',
            'token' => $token,
            'login_status' => 1,

        ];

        // session()->set('uid',$user->id);
        // session()->set('user_name',$user->user_name);
         
        return $this->respond($response, 200);
    }

    public function loginPage()
    {
        return view('login');
    }
}
