<?php
/**
 * Created by PhpStorm.
 * User: danilka
 * Date: 10.11.16
 * Time: 16:28
 */
require_once "vendor/autoload.php";

$params = include(__DIR__.'/config/config.php');

$uploader = new \TJ\Uploader\Uploader(\TJ\Uploader\SelectelUploader::SELECTEL_TYPE, $params);
//$uploader->uploadFromFile($_FILES['upload_file']);
$uploader->uploadFromUrl('https://ps.vk.me/c836539/v836539466/d83c/Mca_p9dH0BM.jpg');