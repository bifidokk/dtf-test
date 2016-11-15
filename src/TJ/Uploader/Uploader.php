<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 10.11.16
 * Time: 12:54
 */

namespace TJ\Uploader;

use TJ\File\FileInterface;

class Uploader implements UploaderInterface
{
    private $uploader;

    function __construct($storage, $storageParameters)
    {
        switch ($storage) {
            case SelectelUploader::SELECTEL_TYPE:
                $this->uploader = new SelectelUploader($storageParameters);
                break;
            case AmazonUploader::AMAZON_TYPE:
                $this->uploader = new AmazonUploader($storageParameters);
                break;
        }
    }

    /**
     * Загрузка картинки в хранилище из формы
     * @param  array $file Загруженный с помощью формы файл из $_FILES
     * @return FileInterface
     */
    public function uploadFromFile($file)
    {
        $this->uploader->setUploadedFile($file);
        $this->uploader->uploadFile();
    }

    /**
     * Загрузка картинки в хранилище по ссылке
     * @param  string $url Ссылка
     * @return FileInterface
     */
    public function uploadFromUrl($url)
    {
        $this->uploader->setFileFromUrl($url);
        $this->uploader->uploadFile();
    }
}