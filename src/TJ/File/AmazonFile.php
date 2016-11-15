<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 15.11.16
 * Time: 12:47
 */

namespace TJ\File;


class AmazonFile implements FileInterface
{
    /**
     * @var string
     */
    protected $fileUri;

    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getFileUri()
    {
        return $this->fileUri;
    }

    /**
     * @param $url
     */
    public function setFileUri($url)
    {
        $this->fileUri = $url;
    }
}