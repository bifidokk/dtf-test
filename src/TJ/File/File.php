<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 14.11.16
 * Time: 21:33
 */

namespace TJ\File;


class File implements FileInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $size = null;

    public function __construct()
    {

    }

    /**
     * Данные о загруженной картинке
     * @return array
     */
    public function getData()
    {
        return [
            'url'   => $this->url,
            'size'  => $this->size
        ];
    }

    /**
     * Ссылка на картинку
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Размер картинки (в байтах, если можно узнать)
     * @return integer|null
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
}