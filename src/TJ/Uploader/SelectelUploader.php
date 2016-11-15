<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 10.11.16
 * Time: 14:50
 */

namespace TJ\Uploader;

use ForumHouse\SelectelStorageApi\Authentication\CredentialsAuthentication;
use ForumHouse\SelectelStorageApi\Container\Container;
use ForumHouse\SelectelStorageApi\File\File;
use ForumHouse\SelectelStorageApi\Service\StorageService;
use TJ\Exception\UploadException;
use TJ\File\SelectelFile;

/**
 * Class SelectelUploader
 * @package TJ\Uploader
 */
class SelectelUploader
{
    const SELECTEL_TYPE = 0;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var CredentialsAuthentication
     */
    private $auth;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var StorageService
     */
    private $service;

    /**
     * @var File
     */
    private $file;

    function __construct($storageParameters)
    {
        $this->parameters = $storageParameters;

        $this->auth = new CredentialsAuthentication(
            $this->parameters['auth_user'],
            $this->parameters['auth_key'],
            $this->parameters['auth_url']
        );

        $this->auth->authenticate();

        $this->container = new Container($this->parameters['auth_container']);
        $this->service = new StorageService($this->auth);
    }

    /**
     * @param $file
     * @throws UploadException
     * @throws \Exception
     */
    public function setUploadedFile($file)
    {
        if(!is_array($file) || !isset($file['name'])) {
            throw new \Exception('Bad filedata');
        }

        if ($file['error'] != 0) {
            throw new UploadException($file['error']);
        }

        $this->file = new File($file['name']);
        $this->file->setLocalName($file['tmp_name']);
        $this->file->setSize();
    }

    public function setFileFromUrl($url)
    {
        $name = array_pop(explode(DIRECTORY_SEPARATOR, $url));

        try {
            file_put_contents($this->parameters['tmp_dir'] . '/' . $name, file_get_contents($url));
        } catch (\Exception $e) {
            throw $e;
        }

        $this->file = new File($name);
        $this->file->setLocalName($this->parameters['tmp_dir'] . '/' . $name);
        $this->file->setSize();

    }

    /**
     * @return SelectelFile
     * @throws \Exception
     * @throws \ForumHouse\SelectelStorageApi\Exception\UnexpectedHttpStatusException
     * @throws \ForumHouse\SelectelStorageApi\File\Exception\CrcFailedException
     */
    public function uploadFile()
    {
        if($this->service->uploadFile($this->container, $this->file)) {
            $uploadedFile = new SelectelFile();
            $uploadedFile->setFileUri($this->parameters['container_url'] . '/' . $this->file->getServerName());

            return $uploadedFile;
        }
    }

}