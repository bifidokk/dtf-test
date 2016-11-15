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
    /**
     * Данные о загруженной картинке
     * @return array
     */
    public function getData();

    /**
     * Ссылка на картинку
     * @return string
     */
    public function getUrl();

    /**
     * Размер картинки (в байтах, если можно узнать)
     * @return integer|null
     */
    public function getSize();
}