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
    $send = $adminController->signin(payLoadExtractor());
    print_r($send);
});

$klein->respond('POST', '/admin/signin', function($request, $response) {
    $adminController = new AdminController();
    $admins = $adminController->signin(payLoadExtractor());
    $response->body($admins); 
});

$klein->post('/qrcode', function () {
    $qrController = new QRCodeController();
    $qrController->newQRCode(payLoadExtractor());
    return "QR Code created!";
});

$klein->get('/admin/images', function ($request, $response) {
    $adminController = new AdminController();
    $images = $adminController->listAllQRCodes((array) $request->headers());
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    //$response->body($request->headers()); 
    print_r($request->headers());
});

$klein->dispatch();