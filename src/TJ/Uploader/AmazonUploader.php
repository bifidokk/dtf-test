<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 15.11.16
 * Time: 12:22
 */

namespace TJ\Uploader;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use TJ\File\File;
use TJ\File\FileInterface;

class AmazonUploader implements AbstractUploaderInterface
{
    const AMAZON_TYPE = 1;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var S3Client
     */
    private $client;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $fileLocalPath;

    function __construct($storageParameters)
    {
        $this->parameters = $storageParameters;

        $this->client = new S3Client([
            'version'       => $this->parameters['version'],
            'region'        => $this->parameters['region'],
            'credentials'   => [
                'key'    => $this->parameters['access_key_id'],
                'secret' => $this->parameters['secret_access_key']
            ],
        ]);
    }

    /**
     * @param string $path
     */
    public function setFileLocalPath($path)
    {
        $this->fileLocalPath = $path;
    }

    /**
     * @param string $name
     */
    public function setFilename($name)
    {
        $this->filename = $name;
    }

    /**
     * @return FileInterface
     */
    public function uploadFile()
    {
        try {
            $this->client->putObject([
                'Bucket' => $this->parameters['bucket'],
                'Key'    => $this->filename,
                'Body'   => fopen($this->fileLocalPath, 'r'),
                'ACL'    => 'public-read',
            ]);

            $uploadedFile = new File();
            $uploadedFile->setUrl($this->parameters['s3_container_url'] . '/' . $this->filename);
            $uploadedFile->setSize(filesize($this->fileLocalPath));

            return $uploadedFile;

        } catch (S3Exception $e) {
            echo $e->getMessage();
        }

        return null;
    }
}