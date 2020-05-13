<?php
namespace API\Controllers;

use API\Models\Admin;

class AdminController
{
    public function create(array $adminParams) {
        $admin = new Admin();
        $admin->username = $adminParams['username'];
        $admin->password = $adminParams['password'];
        $admin->save();
    }

    public function create1(array $adminParams) {
        $admin = new Admin();
        $admin->username = $adminParams['username'];
        $admin->password = $adminParams['password'];
        $admin->save();
    }
}