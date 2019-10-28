<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.10.2019
 * Time: 12:08
 */
include('domain/RecordService.php');

use domain\RecordService;

(new RecordService())->InsertOrUpdate();
$name = strpos($_SERVER['HTTP_REFERER'], 'index1.html') !== false ? './images/1.jpg' : './images/2.jpg';
readfile($name);