<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 10.11.16
 * Time: 12:53
 */

namespace TJ\File;


interface FileInterface
{
    public function __construct();

    /**
     * @return string
     */
    public function getFileUri();

    /**
     * @param $url
     */
    public function setFileUri($url);
}