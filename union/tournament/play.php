<?php
define('_IN_JOHNCMS', 1);
$headmod = 'tournament435';
$textl = 'Игра';
$rootpath = '../../';
require_once ("../../incfiles/core.php");
require_once ("../../incfiles/head.php");

$q = @mysql_query("select * from `r_union_cupgame` where id='" . $id . "' LIMIT 1;");
$arr = @mysql_fetch_array($q);

if (empty($arr[id]))
{
    echo display_error('Игра не существует');
    require_once ('../../incfiles/end.php');
    exit;
}

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
    echo display_error('Игра уже состоялась');
    require_once ('../../incfiles/end.php');
    exit;
}

$req = @mysql_query("select * from `r_union_game` where chemp='cup' AND id_match='" . $arr[id] . "';");
$res = @mysql_fetch_array($req);
$total = mysql_num_rows($req);

if ($total == 0)
{

$q1 = @mysql_query("select * from `team_2` where id='" . $arr[id_team1] . "' LIMIT 1;");
$arr1 = @mysql_fetch_array($q1);

$q2 = @mysql_query("select * from `team_2` where id='" . $arr[id_team2] . "' LIMIT 1;");
$arr2 = @mysql_fetch_array($q2);



if (empty($arr1['id']) && empty($arr2['id']) && empty($arr1['name']) && empty($arr2['name']))
{
    echo display_error('Заявка не найдена');
    require_once ('../../incfiles/end.php');
    exit;
}

$mtime = $realtime+300;

//mysql_query("insert into `r_union_game` set 
//`chemp`='cup',
//`id_match`='".$id."',
//`time`='".$mtime."',

//`id_team1`='".$arr1['id']."',
//`id_team2`='".$arr2['id']."',
//`union_team1`='".$arr1['union']."',
//`union_team2`='".$arr2['union']."',
//`name_team1`='".$arr1['name']."',
//`name_team2`='".$arr2['name']."',
//`lvl_team1`='".$arr1['lvl']."',
//`lvl_team2`='".$arr2['lvl']."'
//;");

mysql_query("insert into `r_union_game` set
`chemp`='cup',
`rez1`='—',
`rez2`='—',
`id_match`='".$id."',
`time`='".$mtime."',
`id_team1`='".$arr['id_team1']."',
`id_team2`='".$arr['id_team2']."',
`union_team1`='".$arr['union_team1']."',
`union_team2`='".$arr['union_team2']."',
`name_team1`='".$arr['name_team1']."',
`name_team2`='".$arr['name_team2']."',
`lvl_team1`='".$arr['lvl_team1']."',
`lvl_team2`='".$arr['lvl_team2']."'
;") or die(mysql_error());

$lastid = mysql_insert_id();
header('location: /trans/union/'.$lastid);

}
else
{
header('Location: /trans/union/'.$res[id]);
exit;
}


require_once ("../../incfiles/end.php");
?>
