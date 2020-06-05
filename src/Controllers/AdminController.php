<?php
namespace API\Controllers;

use API\Models\Admin;
use API\Models\SuperAdmin;
use Cake\Database\Query;
use Firebase\JWT\JWT;
use Valitron\Validator;
use Illuminate\Support\Facades\DB;


class AdminController
{

    public function createAdmin(array $adminParams) 
    {
        $v = new Validator($adminParams);
        $v->rule('required', ['username', 'password', 'admin_username', 'admin_password']);

        if ($v->validate()) {
        $superAdmin = SuperAdmin::where('username', $adminParams['username'])->first();

        if ($superAdmin->password === $adminParams['password']) {
            $admin = new Admin();
            $admin->username = $adminParams['admin_username'];
            $admin->password = password_hash($adminParams['password'], PASSWORD_DEFAULT);
            $admin->save();
        } else {
            return "incorrect password";
        }
        }
    }

    public function create(array $adminParams) 
    {
        $admin = new Admin();
        $admin->username = $adminParams['username'];
        $admin->password = password_hash($adminParams['password'], PASSWORD_DEFAULT);
        $admin->save();
    }

    public function signin(array $adminParams)
    {
        $v = new Validator($adminParams);
        $v->rule('required', ['username', 'password']);
        
        if($v->validate()) {
            $admin = Admin::where('username', $adminParams['username'])->first();
            
            if(password_verify($adminParams['password'], $admin->password)) {
                $adminParams['iat'] = time();
                $adminParams['exp'] = time() + (60 * 60);
                $jwt = JWT::encode($adminParams, getenv('ADMIN_SECRET_KEY'));
                return $jwt;
            } else {
                return "Wrong password";
            }   
        } 
        else {return $v->errors();}

    }


    function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }


    function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public function listAllQRCodes(array $headers)
    {
        return $headers;
        // $v = new Validator($headers);
        // $v->rule('required', ['authorization']);
        
        // if($v->validate()) {
        //     return $this->getBearerToken();
        //  } 
        //  else {return $v->errors();}
    }   
}