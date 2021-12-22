<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

if ($act == "buy")
{

$k = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$kom = @mysql_fetch_array($k);

$b = @mysql_query("select * from `infra_2` where type='trener' and team='" . $datauser[manager2] . "' LIMIT 1;");
$buy = @mysql_fetch_array($b);

if (empty($buy[id]))
{
switch ($_GET['lvl'])
{
case "1":
$level = 1;
$moneykup = 10000;
break;
case "2":
$level = 2;
$moneykup = 25000;
break;
case "3":
$level = 3;
$moneykup = 50000;
break;
}

}
elseif ($buy[level] != 0)
{
echo display_error('У вас уже нанят тренер');
require_once ("incfiles/end.php");
exit;
}


$moneykom = $kom[money] - $moneykup;

if ($kom[money] >= $moneykup)
{
$i1 = rand(0,14087);
$i2 = rand(0,1241);

$fn="base/surname.txt"; 
$fp = @fopen ($fn,"r"); 
$str1=fread($fp,filesize($fn)); 
fclose($fp); 
$str1=explode("\n",$str1); 

$fn="base/name.txt"; 
$fp = @fopen ($fn,"r"); 
$str2=fread($fp,filesize($fn)); 
fclose($fp); 
$str2=explode("\n",$str2); 

mysql_query("update `team_2` set `money`='" . $moneykom . "', `trener`='".$level."' where id = '" . $kom[id] . " LIMIT 1';");

mysql_query("insert into `infra_2` set 
`type`='trener', 
`team`='".$kom[id]."', 
`time`='".$realtime."', 
`name`='".$str1[$i1]." ".$str2[$i2]."', 
`level`='".$level."'
;");

header('location: trener.php');
exit;
}
else
{
echo display_error('У вас недостаточно денег');
require_once ("incfiles/end.php");
exit;
}

}







echo '<div class="gmenu"><b>' . $textl . '</b></div>';
echo '<div class="c"><p align="center"><img src="img/personal/trener.jpg" alt=""/></p></div>';


if ($id)
{
$k = @mysql_query("select * from `team_2` where id='" . $id . "' LIMIT 1;");
$kom = @mysql_fetch_array($k);

$q = @mysql_query("select * from `infra_2` where type='trener' and team='" . $id . "' LIMIT 1;");
$arr = @mysql_fetch_array($q);

switch ($arr[level])
{
case "1":$koftrener = 1.5;break;
case "2":$koftrener = 2;break;
case "3":$koftrener = 3;break;
}

echo '<div class="c"><p>';
echo '<b>' . $arr[name] . ' [' . $arr[level] . ']</b><br/>';
echo 'Тренер ' . $arr[level] . '-го розряда повышает опыт полевых игроков на тренировках в ' . $koftrener . ' раза.<br/><br/>';

echo '<table border="0">';
echo '<tr><td width="70px"><div class="grey">Розряд</div></td><td>'.$arr['level'].'-й</td></tr>';
echo '<tr><td width="70px"><div class="grey">Нанят</div></td><td>'.date("d.m в H:i", $arr['time']).'</td></tr>';
echo '<tr><td width="70px"><div class="grey">Контракт до</div></td><td>'.date("d.m.y в H:i", ($arr['time']+3600*24*90)).'</td></tr>';

echo '<tr><td><div class="grey">Страна:</div></td><td><img src="flag/'.$kom[strana].'.png" alt=""/></td></tr>';
echo '<tr><td><div class="grey">Команда:</div></td><td><a href="team.php?id=' . $kom['id'] . '">'.$kom[name].'</a> ['.$kom[lvl].']</td></tr>';
echo '<tr><td><div class="grey">Менеджер:</div></td><td><a href="users/profile.php?user='.$kom['id_admin'].'">'.$kom['name_admin'].'</a></td></tr>';
echo '</table>';

echo '</p></div>';

}
else
{
$k = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$kom = @mysql_fetch_array($k);

$q = @mysql_query("select * from `infra_2` where type='trener' and team='" . $datauser['manager2'] . "' LIMIT 1;");
$arr = @mysql_fetch_array($q);

if ($arr[id])
{

switch ($arr[level])
{
case "1":$koftrener = 1.5;break;
case "2":$koftrener = 2;break;
case "3":$koftrener = 3;break;
}

echo '<div class="c><p>';
echo '<b>' . $arr[name] . ' [' . $arr[level] . ']</b><br/>';
echo 'Тренер ' . $arr[level] . '-го розряда повышает опыт полевых игроков на тренировках в ' . $koftrener . ' раза.<br/><br/>';

echo '<table border="0">';
echo '<tr><td width="70px"><div class="grey">Розряд</div></td><td>'.$arr['level'].'-й</td></tr>';
echo '<tr><td width="70px"><div class="grey">Нанят</div></td><td>'.date("d.m.y в H:i", $arr['time']).'</td></tr>';
echo '<tr><td width="70px"><div class="grey">Контракт до</div></td><td>'.date("d.m.y в H:i", ($arr['time']+3600*24*90)).'</td></tr>';
echo '<tr><td><div class="grey">Страна:</div></td><td><img src="flag/'.$kom[strana].'.png" alt=""/></td></tr>';
echo '<tr><td><div class="grey">Команда:</div></td><td><a href="team.php?id=' . $kom['id'] . '">'.$kom[name].'</a> ['.$kom[lvl].']</td></tr>';
echo '<tr><td><div class="grey">Менеджер:</div></td><td><a href="users/profile.php?user='.$kom['id_admin'].'">'.$kom['name_admin'].'</a></td></tr>';
echo '</table>';

echo '</p></div>';
}
else
{

echo '<div class="list1"><p>';
echo '<b>Тренер [1]</b><br/>';
echo 'Тренер 1-го розряда повышает опыт полевых игроков на тренировках в 1.5 раза.<br/><br/>';
echo 'Цена: 10000 € (Контракт 3 месяца)<br/><br/>';
echo '<a href="trener.php?act=buy&amp;lvl=1"><font color="red"><b>Нанять тренера</b></font></a><br/>';
echo '</p></div>';

echo '<div class="list2"><p>';
echo '<b>Тренер [2]</b><br/>';
echo 'Тренер 2-го розряда повышает опыт полевых игроков на тренировках в 2 раза.<br/><br/>';
echo 'Цена: 25000 € (Контракт 3 месяца)<br/><br/>';
echo '<a href="trener.php?act=buy&amp;lvl=2"><font color="red"><b>Нанять тренера</b></font></a><br/>';
echo '</p></div>';

echo '<div class="list1"><p>';
echo '<b>Тренер [3]</b><br/>';
echo 'Тренер 3-го розряда повышает опыт полевых игроков на тренировках в 3 раза.<br/><br/>';
echo 'Цена: 50000 € (Контракт 3 месяца)<br/><br/>';
echo '<a href="trener.php?act=buy&amp;lvl=3"><font color="red"><b>Нанять тренера</b></font></a><br/>';
echo '</p></div>';


}


}


echo'<br/><a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
