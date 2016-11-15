<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 10.11.16
 * Time: 12:50
 */

namespace TJ\Uploader;

use TJ\File\FileInterface;

interface UploaderInterface
{
    /**
     * Конструктор, в котором мы выбираем хранилище
     * @param integer $storage               1 - Amazon, 2 — Selectel
     * @param array   $storageAuthParameters Данные для авторизации в хранилище
     */
    public function __construct($storage, $storageAuthParameters);
    /**
     * Загрузка картинки в хранилище из формы
     * @param  array         $file Загруженный с помощью формы файл из $_FILES
     * @return FileInterface
     */
    public function uploadFromFile($file);
    /**
     * Загрузка картинки в хранилище по ссылке
     * @param  string        $url Ссылка
     * @return FileInterface
     */
    public function uploadFromUrl($url);
}