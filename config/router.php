<?php

use \API\Controllers\AdminController;
use \API\Controllers\QRCodeController;
use API\Models\Admin;
use Valitron\Validator;



function payLoadExtractor() {
    $json = file_get_contents("php://input");
    return json_decode($json, true);
}

$klein = new \Klein\Klein();

$klein->post('/super-admin', function ($request, $response) {
    $adminController = new AdminController();
    $send = $adminController->superAdminToken(payLoadExtractor());
    print_r($send);
});

$klein->post('/admin', function ($request, $response) {
    $adminController = new AdminController();
    $send = $adminController->createAdmin(payLoadExtractor());
    print_r($send);
});

$klein->post('/admin/signin', function ($request, $response) {
    $adminController = new AdminController();
    $send = $adminController->adminSignIn(payLoadExtractor());
    print_r($send);
});

$klein->post('/qrcode', function () {
    $qrController = new QRCodeController();
    $qrController->newQRCode(payLoadExtractor());
    return "QR Code created!";
});

$klein->get('/admin/images', function ($request, $response) {
    $adminController = new AdminController();
    $send = $adminController->listAllQRCodes($request->headers());
    print_r($send);
});

$klein->dispatch();