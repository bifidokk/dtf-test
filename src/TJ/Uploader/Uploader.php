<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 10.11.16
 * Time: 12:54
 */

namespace TJ\Uploader;

use TJ\Exception\UploadException;
use TJ\File\FileInterface;
use TJ\Service\Downloader;

class Uploader implements UploaderInterface
{
    /**
     * @var
     */
    private $uploader;

    /**
     * @var array
     */
    private $parameters;

    function __construct($storage, $storageParameters)
    {
        $this->parameters = $storageParameters;

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
        $this->checkUploadFile($file);

        $this->uploader->setFileLocalPath($file['tmp_name']);
        $this->uploader->setFilename($file['name']);
        $this->uploader->uploadFile();
    }

    /**
     * Загрузка картинки в хранилище по ссылке
     * @param  string $url Ссылка
     * @return FileInterface
     */
    public function uploadFromUrl($url)
    {
        $downloader = new Downloader($url, $this->parameters['tmp_dir']);
        $result = $downloader->copyFile();

        $this->uploader->setFileLocalPath($result['path']);
        $this->uploader->setFilename($result['name']);
        $this->uploader->uploadFile();
    }

    /**
     * @param $file array
     * @return bool
     * @throws UploadException
     * @throws \Exception
     */
    private function checkUploadFile($file)
    {
        if(!is_array($file) || !isset($file['name'])) {
            throw new \Exception('Bad filedata');
        }

        if ($file['error'] != 0) {
            throw new UploadException($file['error']);
        }

        return true;
    }
}