<?php
namespace API\Controllers;

use API\Models\Admin;
use Cake\Database\Query;
use Firebase\JWT\JWT;
use Valitron\Validator;
use Illuminate\Support\Facades\DB;


class AdminController
{

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

    public function create1(array $adminParams) 
    {
        $admin = new Admin();
        $admin->username = $adminParams['username'];
        $admin->password = $adminParams['password'];
        $admin->save();
    }
}