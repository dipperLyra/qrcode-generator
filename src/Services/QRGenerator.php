<?php


namespace API\Services;


use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QRGenerator
{
    function createQRCode($qrtext) {
       $renderer = new ImageRenderer(
           new RendererStyle(400),
           new ImagickImageBackEnd()
       );
       $writer = new Writer($renderer);
       $randomWord = $this->getRandomWord('abcdefghijklmnopqrstuvwxyz', 0, 5);
       $writer->writeFile($qrtext, dirname(__DIR__) . '/files/' . $randomWord . '.png');
       return $randomWord;
    }

    function getRandomWord($characters, $start, $length)
    {
        return substr(str_shuffle($characters), $start, $length);
    }
}