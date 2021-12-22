<?php
define('_IN_JOHNCMS', 1);
$headmod = 'friendly';
$textl = 'Товарищеские матчи';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");

$q = @mysql_query("select * from `team_2` where id='" . $datauser[manager2] . "' LIMIT 1;");
$kom = @mysql_fetch_array($q);

if (empty($kom[id]))
{
echo display_error('У вас нет команды');
require_once ("../incfiles/end.php");
exit;
}


$result = @mysql_query ('SELECT SUM(fiz) FROM `player_2` WHERE `kom`="'.$datauser[manager2].'" AND `sostav`="1" LIMIT 11');
$myrow = mysql_fetch_row($result); 
$fizgotov = round($myrow[0]/11);

if ($fizgotov < 50)
{
echo '<div class="gmenu"><b>Товарищеские матчи</b></div>';
echo '<div class="c">Физготовность команды очень слабая (меньше 50%)<br/>';
echo 'Физготовность основного состава вашей команды: <font color="#FF0000">'.$fizgotov.'%</font></div>';
require_once ("../incfiles/end.php");
exit;
}


$q = @mysql_query("select * from `frend_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$totalz = mysql_num_rows($q);

if ($totalz != 1)
{
echo display_error('Соперник уже играет');
require_once ("../incfiles/end.php");
exit;
}


$ftime = $realtime - 600;
$s = @mysql_query("select * from `tur_2` where type='frend' AND id_team1='" . $arr[id_team1] . "' AND id_team2='" . $datauser[manager2] . "' AND time > '" . $ftime . "';");
$totals = mysql_num_rows($s);

if ($totals != 0)
{
echo display_error('Вы недавно уже играли с этим соперником');
require_once ("../incfiles/end.php");
exit;
}



$q1 = @mysql_query("select * from `team_2` where id='" . $arr[id_team] . "' LIMIT 1;");
$arr1 = @mysql_fetch_array($q1);

$q2 = @mysql_query("select * from `team_2` where id='" . $datauser[manager2] . "' LIMIT 1;");
$arr2 = @mysql_fetch_array($q2);

if ($arr1['id'] == $arr2['id'])
{
echo display_error('Вы не можете принять свою заявку');
require_once ("../incfiles/end.php");
exit;
}

mysql_query("update `frend_2` set `id_team2`='" . $arr2[id] . "',`name_team2`='" . $arr2[name] . "',`level_team2`='" . $arr2[level] . "' where id='" . $arr[id] . "' LIMIT 1;");

header('location: /friendly/');
exit;

require_once ("../incfiles/end.php");
?>