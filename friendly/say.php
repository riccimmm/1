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


$kk1 = @mysql_query("select * from `frend_2` where id_team1='".$kom[id]."';");
$kom1 = @mysql_fetch_array($kk1);
$totalkom1 = mysql_num_rows($kk1);

if ($totalkom1 != 0)
{
mysql_query("delete from `frend_2` where `id_team1`='" . $kom[id] . "';");
}

mysql_query("insert into `frend_2` set 
`time`='".$realtime."', 
`id_team1`='".$kom[id]."', 
`name_team1`='".$kom[name]."', 
`level_team1`='".$kom[level]."'
;");

header('location: /friendly/');
exit;

require_once ("../incfiles/end.php");
?>