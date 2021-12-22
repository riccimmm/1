<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

$q = mysql_query("select * from `tur_2` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

$textl = $arr[name_team1] . ' - ' . $arr[name_team2].' '.$arr[rez1].':'.$arr[rez2];
require_once ("incfiles/head.php");

$q = mysql_query("select * from `tur_2` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (empty($arr[id]) || empty($arr[text]))
{
echo display_error('Отчёт не найден');
require_once ("incfiles/end.php");
exit;
}


echo '<div class="gmenu"><b>' . $textl . '</b></div>';
echo '<div class="c"><p align="center">';

$k1 = mysql_query("select * from `team_2` where id='" . $arr[id_team1] . "' LIMIT 1;");
$kom1 = mysql_fetch_array($k1);

$k2 = mysql_query("select * from `team_2` where id='" . $arr[id_team2] . "' LIMIT 1;");
$kom2 = mysql_fetch_array($k2);

echo ''.date("d.m / H:i", $arr['time']).'<br/>';

echo '<a href="stadium.php?id=' . $kom1['id'] . '">' . $kom1['name'] . ' Arena</a><br/>';


if (!empty($kom1[logo]))
{
echo '<img src="logo/small' . $kom1[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/> ';
}


echo '<a href="team.php?id=' . $kom1['id'] . '">'.$kom1[name].'</a> - <a href="team.php?id=' . $kom2['id'] . '">'.$kom2[name].'</a> ';


if (!empty($kom2[logo]))
{
echo '<img src="logo/small' . $kom2[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/>';
}


echo '<br/>';


if ($arr[rez1] != '' || $arr[rez2] != '')
{
echo '<h2>';
echo ''.$arr[rez1].':'.$arr[rez2].'';

if ($arr[rez1] == $arr[rez2] && $arr[chemp] == 'cup')
{echo ' (п. '.$arr[pen1].':'.$arr[pen2].')';}

echo '</h2>';
}

echo '<a href="report.php?id=' . $id . '">[Посмотреть отчет]</a>';
echo '</p>';


$text = explode("\r\n",$arr[text]);
asort($text);
next($text);

while (list($key, $val) = each($text)) 
{
$menu = explode("|",$text[$key]);
echo '<img src="img/txt/s_' . $menu[1] . '.gif" alt=""/> <b>'.intval($menu[0]).'</b> ' . $menu[2] . '<br/>';
}





echo '</div>';

echo '<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
