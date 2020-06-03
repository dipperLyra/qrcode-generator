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

$klein->respond('POST','/admin/signup', function () {
    $adminController = new AdminController();
    $adminController->create(payLoadExtractor());
    return "Admin created!";
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

$klein->get('/qrcode', function () {
    $qrController = new QRCodeController();
    return $qrController->getAllQRImages();
});

$klein->dispatch();