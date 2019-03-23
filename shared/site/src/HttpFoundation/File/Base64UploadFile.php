<?php

namespace App\HttpFoundation\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

class Base64UploadFile extends UploadedFile
{
    private $mimeType;

    public function __construct($base64Content)
    {
        $filePath = tempnam(sys_get_temp_dir(), 'UploadedFile');

        list(, $data) = explode(',', $base64Content);
        $data = base64_decode($data);

        // Получаем mime type
        $f = finfo_open();
        $this->mimeType = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);


        file_put_contents($filePath, $data);

        $mimeType = null;
        $size = null;
        $error = null;

        $test = true;

        parent::__construct($filePath, 'fb_name', $mimeType, $size, $error, $test);
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        $guesser = ExtensionGuesser::getInstance();
        return $guesser->guess($this->mimeType);
    }
}