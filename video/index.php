<?php
define('_IN_JOHNCMS', 1);
$headmod ="football";
$textl = 'Видео';
$rootpath = '../';
require_once ($rootpath ."incfiles/core.php");
require_once ($rootpath ."incfiles/head.php");
header("Content-type:text/html; charset=utf-8");

$file = file_get_contents("http://gegas.ru/video/?".$_SERVER['QUERY_STRING']);

$file = preg_replace('/<?xml(.*?)Клипы<\/a>/si', '', $file);
$file = preg_replace('/<!DOCTYPE(.*?)<div class="hov">/si', '', $file);
$file = preg_replace('/<div class="tab">Реклама(.*?)<\/html>/si', '', $file);

$file = str_replace('<img src="/images/video.gif" alt="." />','<img src="/video.ico" alt="." /> ',$file);
$file = str_replace('<hr />','',$file);
$file = str_replace('<img src="files/','<img src="http://gegas.ru/video/files/',$file);

$file = str_replace('<a href="files/','<a href="http://gegas.ru/video/files/',$file);

$file = str_replace('index.php?cat=','/video/cat/',$file);
$file = str_replace('index.php?id=','/video/id/',$file);

echo $file;

require_once ($rootpath ."incfiles/end.php");
?>

