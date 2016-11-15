<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 15.11.16
 * Time: 16:18
 */

namespace TJ\Uploader;

use TJ\File\FileInterface;

interface AbstractUploaderInterface
{
    /**
     * @param array $parameters Массив с параметрами из конфига
     */
    public function __construct($parameters);

    /**
     * @param string $path Путь до загружаемого файла
     */
    public function setFileLocalPath($path);

    /**
     * @param string $name Имя файла
     */
    public function setFilename($name);

    /**
     * @return FileInterface
     */
    public function uploadFile();
}