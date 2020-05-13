<?php

use \API\Controllers\AdminController;
use \API\Controllers\QRCodeController;

function payLoadExtractor() {
    $json = file_get_contents("php://input");
    return json_decode($json, true);
}

$klein = new \Klein\Klein();

$klein->respond('POST','/admin', function () {
    $adminController = new AdminController();
    $adminController->create(payLoadExtractor());
    return "Admin created!";
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