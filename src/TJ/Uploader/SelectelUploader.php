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
use TJ\File\File as UploadedFile;
use TJ\File\FileInterface;

/**
 * Class SelectelUploader
 * @package TJ\Uploader
 */
class SelectelUploader implements AbstractUploaderInterface
{
    const SELECTEL_TYPE = 0;
    const DEFAULT_FILENAME = 'test';

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
        $this->file = new File(self::DEFAULT_FILENAME);
    }

    /**
     * @param string $path
     */
    public function setFileLocalPath($path)
    {
        $this->file->setLocalName($path);
        $this->file->setSize();
    }

    /**
     * @param string $name
     */
    public function setFilename($name)
    {
        $this->file->setServerName($name);
    }

    /**
     * @return FileInterface
     * @throws \Exception
     * @throws \ForumHouse\SelectelStorageApi\Exception\UnexpectedHttpStatusException
     * @throws \ForumHouse\SelectelStorageApi\File\Exception\CrcFailedException
     */
    public function uploadFile()
    {
        if($this->service->uploadFile($this->container, $this->file)) {
            $uploadedFile = new UploadedFile();
            $uploadedFile->setUrl($this->parameters['container_url'] . '/' . $this->file->getServerName());
            $uploadedFile->setSize($this->file->getSize());

            return $uploadedFile;
        }

        return null;
    }

}