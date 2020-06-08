<?php


namespace API\Controllers;


use API\Models\Image;
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
        return json_encode(['data' =>
            [
                'message' => 'QR Code created!',
            ]
        ]);
    }

    function saveFilePathAndText() {
        $file = new Image();
        $file->filepath = $this->filePath;
        $file->qr_code_text = $this->qrtext;
        $file->save();
    }

    function getAllQRImages()
    {
        return Image::all();
    }

    function deleteQRImages($id) {
        $file = Image::find($id);
        if($file) $file->forceDelete();
    }
}