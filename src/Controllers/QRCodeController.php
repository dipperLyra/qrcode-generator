<?php


namespace API\Controllers;


use API\Models\Files;
use API\Services\QRGenerator;

class QRCodeController
{
    private $qrtext;
    private $filePath;
    private $fileName;

    function newQRCode(array $qrtext) {
        $qrGenerator = new QRGenerator();
        $this->fileName = $qrGenerator->createQRCode($qrtext['text']);
        $this->qrtext = $qrtext['text'];
        $this->filePath = dirname(__DIR__) . '/files/' . $this->fileName . '.png';
        $this->saveFilePathAndText();
    }

    function saveFilePathAndText() {
        $file = new Files();
        $file->filepath = $this->filePath;
        $file->qr_code_text = $this->qrtext;
        $file->save();
    }

    function getAllQRImages() {
        return Files::all();
    }

    function deleteQRImages($id) {
        $file = Files::find($id);
        if($file) $file->forceDelete();
    }
}