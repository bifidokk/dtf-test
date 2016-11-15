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
use TJ\Exception\UploadException;
use TJ\File\AmazonFile;

class AmazonUploader
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

    public function setUploadedFile($file)
    {
        if(!is_array($file) || !isset($file['name'])) {
            throw new \Exception('Bad filedata');
        }

        if ($file['error'] != 0) {
            throw new UploadException($file['error']);
        }

        $this->filename = $file['name'];
        $this->fileLocalPath = $file['tmp_name'];
    }

    /**
     * @param $url
     * @throws \Exception
     */
    public function setFileFromUrl($url)
    {
        $name = array_pop(explode(DIRECTORY_SEPARATOR, $url));

        try {
            file_put_contents($this->parameters['tmp_dir'] . '/' . $name, file_get_contents($url));
        } catch (\Exception $e) {
            throw $e;
        }

        $this->filename = $name;
        $this->fileLocalPath = $this->parameters['tmp_dir'] . '/' . $name;
    }

    /**
     * @return AmazonFile
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

            $uploadedFile = new AmazonFile();
            $uploadedFile->setFileUri($this->parameters['s3_container_url'] . '/' . $this->filename);

            return $uploadedFile;

        } catch (S3Exception $e) {
            echo $e->getMessage();
        }
    }
}