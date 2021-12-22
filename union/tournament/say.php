<?php 
define('_IN_JOHNCMS', 1);
$headmod = 'tournament';
$textl = 'Заявка';
$rootpath = '../../';
require_once ("../../incfiles/core.php");
require_once ("../../incfiles/head.php");


$kk = @mysql_query("select * from `team_2` where id='" . $datauser[manager2] . "' LIMIT 1;");
$kom = @mysql_fetch_array($kk);

if (empty($kom[id]))
{
    echo display_error('У Вас нет команды');
    require_once ('../../incfiles/end.php');
    exit;
}

$q = @mysql_query("select * from `r_union_cup` where id='" . $id . "' LIMIT 1;");
$cup = @mysql_fetch_array($q);
$union = $cup['id_union'];

if (empty($cup[id]))
{
    echo display_error('Кубка не существует');
    require_once ('../../incfiles/end.php');
    exit;
}


$q = mysql_query("select * from `union` where id='" . $union . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../../incfiles/end.php");
exit;
}

$qqz = mysql_query("select * from `union` where id_prez='" . $user_id . "' LIMIT 1;");
$sarr = mysql_fetch_array($qqz);

if (!empty($sarr['id_prez'])) {
    echo display_error('Вы являетесь создателем какого-либо союза и не можете принимать участие.');
    require_once ('../../incfiles/end.php');
    exit;
}

if ($kom[lvl] < $cup['ot'] || $kom[lvl] > $cup['do'])
{
    echo display_error('Вы не можете участвовать в этом турнире из-за ограничения по уровню');
    require_once ('../../incfiles/end.php');
    exit;
}

$kz = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$zq = @mysql_fetch_array($kz);

if($zq['union'] != $union or $zq['union_mod'] != 1){
echo '<div class="c">Только для участников союза.</div>';
echo '<div class="c"><a href="../group.php?id='.$union.'">В союз</a></div>';
require_once ("../../incfiles/end.php"); exit; }

if($arr['id_prez'] == $user_id){
echo '<div class="c">Президенты не имеют права играть в кубках.</div>';
echo '<div class="c"><a href="../group.php?id='.$union.'">В союз</a></div>';
require_once ("../../incfiles/end.php"); exit; 
}

$dostart = $cup['time'] - $realtime;
if ($dostart > 900 || $cup['status'] == 'yes')
{
    echo display_error('Приём заявок запрещен');
echo '<div class="c"><a href="../group.php?id='.$union.'">В союз</a></div>';
    require_once ('../../incfiles/end.php');
    exit;
}


$req = mysql_query("SELECT * FROM `r_union_bilet` where id_cup = '" . $id . "' and id_team = '" . $kom[id] . "' order by time desc;");
$total = mysql_num_rows($req);

if ($total != 0)
{
    echo display_error('Вы уже подали заявку');
echo '<div class="c"><a href="../group.php?id='.$union.'">В союз</a></div>';
    require_once ('../../incfiles/end.php');
    exit;
}


mysql_query("insert into `r_union_bilet` set 
`time`='".$realtime."', 
`id_cup`='".$id."', 
`id_team`='".$kom[id]."', 
`union_team`='".$kom[union]."', 
`name_team`='".$kom[name]."', 
`lvl_team`='".$kom[lvl]."'
;");

header('location: /union/tournament/cup/'.$id);
exit;


require_once ("../../incfiles/end.php");
?>
