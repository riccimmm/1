<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');



echo '<div class="phdr">Сервисы клуба</div>';
echo '<div class="phdr2">Логотип клуба</div>';

$q = mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "';");
$arr = mysql_fetch_array($q);

echo '<div class="list1">';
if($arr[logo])
echo '<img width="40" src="logo/big' . $arr[logo] . '" alt=""/>';
echo '<li><a href="team/logo.php">Изменить лого</a></li>';
echo '</div>';

echo '<div class="phdr2">Форма клуба</div>';





echo '<div class="list2">';
if($arr[forma])
echo '<img width="40" src="forma/' . $arr[forma] . '" alt=""/>';
echo '<li><a href="team/forma.php">Выбрать форму</a></li>';
echo '</div>';
echo '<div class="phdr2">Название клуба</div>';
echo '<div class="list1">';
if($arr[name])

echo 'Ваш клуб:';
echo '<b>'.$arr[name].'</b>';
echo '<li><a href="team/name.php">Переименовать команду</a> (5 буцеров)</li>';
echo '</div>';
echo '<div class="phdr2">Федерация клуба</div>';
echo '<div class="list1">';

if($arr[strana])

echo 'Ваша страна:';
echo '<img width="30" src="flag/' . $arr[strana] . '.png" alt=""/>';

if ($set_m[fed] == 1)
echo '<li><a href="team/country.php">Изменить федерацию</a> (5 буцеров)</li>';

echo '</div>';


require_once ("incfiles/end.php");
?>