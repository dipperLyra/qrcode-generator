<?php

use \API\Controllers\AdminController;

function payLoad() {
    $json = file_get_contents("php://input");
    return json_decode($json, true);
}

$klein = new \Klein\Klein();

$klein->respond('POST','/admin', function () {
    $adminController = new AdminController();
    $adminController->create(payLoad());
    return "Admin created!";
});

$klein->post('/qr_code', function () {

});

$klein->dispatch();