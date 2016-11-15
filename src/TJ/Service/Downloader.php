<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 15.11.16
 * Time: 16:05
 */

namespace TJ\Service;

class Downloader
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string;
     */
    private $destinantionPath;

    /**
     * @param $url
     * @param $destinationPath
     */
    function __construct($url, $destinationPath)
    {
        $this->url = $url;
        $this->destinantionPath = $destinationPath;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function copyFile()
    {
        $name = array_pop(explode(DIRECTORY_SEPARATOR, $this->url));

        try {
            file_put_contents($this->destinantionPath . '/' . $name, file_get_contents($this->url));
        } catch (\Exception $e) {
            throw $e;
        }

        return array(
            'path' => $this->destinantionPath . '/' . $name,
            'name' => $name
        );
    }
}