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

    /**
     * @param array $superAdmin
     * @return array|bool|false|string
     * Super admin needs to obtain a token in order to create an admin.
     */
    public function superAdminToken(array $superAdmin) {
        $v = new Validator($superAdmin);
        $v->rule('required', ['username', 'password']);

        if (!$v->validate()) return $v->errors();

        $superAdminObject =
            SuperAdmin::where('username', $superAdmin['username'])->first() ?
            SuperAdmin::where('username', $superAdmin['username'])->first() :
            "";

        if ($superAdminObject->password === $superAdmin['password']) {
            $key = getenv('ADMIN_SECRET_KEY');
            $payload = array(
                "iss" => "system_droid",
                "iat" => time(),
                "exp" => time() + (60 * 60),
                "name" => $superAdmin['username']
            );

            $jwt = JWT::encode($payload, $key, 'HS256');

            return json_encode(['data' =>
                [
                    'message' => 'super admin token created',
                    'token' => $jwt
                ]
            ]);
        } else {
            return json_encode(['data' =>
                [
                    'error' => 'incorrect password',
                ]
            ]);
        }
    }

    /**
     * @param array $newAdmin
     * @return array|bool|false|string|null
     * Super admin uses the token generated to create an admin
     */
    public function createAdmin(array $newAdmin)
    {
        $v = new Validator($newAdmin);
        $v->rule('required', ['username', 'password', 'token']);

        if (!$v->validate()) return $v->errors();

        preg_match('/Bearer\s(\S+)/', $newAdmin['token'], $matches);

        if ($matches[1]) {
            $key = getenv('ADMIN_SECRET_KEY');
            $jwtDecode = JWT::decode($matches[1], $key, array('HS256'));

            if ($jwtDecode) {
                $admin = new Admin();
                $admin->username = $newAdmin['username'];
                $admin->password = password_hash($newAdmin['password'], PASSWORD_DEFAULT);
                if ($admin->save()) {
                    return json_encode(['data' =>
                        [
                            'message' => 'new admin created',
                        ]
                    ]);
                } else {
                    return json_encode(['data' =>
                        [
                            'error' => 'error creating new admin',
                        ]
                    ]);
                }
            }
        } else {
            return json_encode(['data' =>
                [
                    'error' => 'no token found',
                ]
            ]);
        }
        return null;
    }


    public function adminSignIn(array $adminParams)
    {
        $v = new Validator($adminParams);
        $v->rule('required', ['username', 'password']);

        if (!$v->validate()) return $v->errors();

        $admin = Admin::where('username', $adminParams['username'])->first() ?
            Admin::where('username', $adminParams['username'])->first() :
            "";

        if (password_verify($adminParams['password'], $admin->password)) {
            $key = getenv('QUASI_ADMIN_SECRET_KEY');
            $payload = array(
                "iss" => "system_droid",
                "iat" => time(),
                "exp" => time() + (60 * 60),
                "name" => $adminParams['username']
            );

            $jwt = JWT::encode($payload, $key, 'HS256');

            return json_encode(['data' =>
                [
                    'message' => 'admin sign in successful',
                    'token' => $jwt,
                ]
            ]);
        } else {
            return json_encode(['data' =>
                [
                    'message' => 'admin sign in failed',
                    'error' => 'incorrect password',
                ]
            ]);
        }
    }

    public function listAllQRCodes($headers)
    {
        preg_match('/Bearer\s(\S+)/', $headers['Token'], $matches);

        if ($matches[1]) {
            $key = getenv('QUASI_ADMIN_SECRET_KEY');
            $jwtDecode = JWT::decode($matches[1], $key, array('HS256'));

            if ($jwtDecode) {
                $qrCodeController = new QRCodeController();
                $images = $qrCodeController->getAllQRImages();
                return json_encode(['data' =>
                    [
                        'message' => 'All images retrieved!',
                        'images' => $images,
                    ]
                ]);
            }
        } else {
            return json_encode(['data' =>
                [
                    'message' => 'failed to retrieve images',
                    'error' => 'no token attached',
                ]
            ]);
        }
    }

}