<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

$adres = trim($_POST['adres']);
switch ($adres) {
    case 'chat':
        header("location: $home/chat/index.php");
        break;

    case 'forum':
        header("location: $home/forum/index.php");
        break;

    case 'soc':
        header("location: http://futmen.net");
        break;

case 'blog':
header("location: blogs"); 
break;

    case 'privat':
        header("location: $home/index.php?act=cab");
        break;

    case 'prof':
        header("location: $home/str/anketa.php");
        break;

    case 'lib':
        header("location: $home/library/index.php");
        break;

    case 'down':
        header("location: $home/download/index.php");
        break;

    case 'gallery':
        header("location: $home/gallery/index.php");
        break;

    case 'news':
        header("location: $home/str/news.php");
        break;

    case 'guest':
        header("location: $home/str/guest.php");
        break;

    default :
        header("location: http://futmen.net");
        break;
}

?>