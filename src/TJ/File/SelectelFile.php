<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 14.11.16
 * Time: 21:33
 */

namespace TJ\File;


class SelectelFile implements FileInterface
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