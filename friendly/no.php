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

$q = @mysql_query("select * from `frend_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$totalz = mysql_num_rows($q);

if ($totalz != 1)
{
echo display_error('Соперник уже играет');
require_once ("../incfiles/end.php");
exit;
}

if ($arr['id_team2'] == $datauser['manager2'])
{
mysql_query("update `frend_2` set `id_team2`='',`name_team2`='',`level_team2`='' where id='" . $arr[id] . "' LIMIT 1;");
}

header('location: /friendly/');
exit;

require_once ("../incfiles/end.php");
?>