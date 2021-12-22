<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');


echo '<div class="red"><b>Справка по опыту</b></div>';
echo '<div class="gmenu">';

echo '100 очков опыта - 2 уровень. <br/>';
echo '400 очков опыта - 3 уровень.<br/>';
echo '800 очков опыта - 4 уровень.<br/>';
echo '1800 очков опыта - 5 уровень.<br/>';
echo '3800 очков опыта - 6 уровень.<br/>';
echo '8800 очков опыта - 7 уровень.<br/>';
echo '18800 очков опыта - 8 уровень.<br/>';






echo '</div>';




echo '<a href="index.php">Вернуться</a><br/>';

require_once ("incfiles/end.php");
?>
