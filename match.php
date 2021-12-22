<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="login.php">авторизованным</a> посетителям';
if ($error) {
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
    require_once ("incfiles/end.php");
    exit;
}


if (!empty($manag)) {

    $req1 = mysql_query("SELECT * FROM `tur_2` where `id_team1`='".$id."' OR `id_team2`='".$id."' order by time asc;");
    if (mysql_num_rows($req1) == 0)
{
    echo '<div class="gmenu">В ближайщее время игр нет </div>';
    require_once ("incfiles/end.php");
    exit;
}
    echo '<div class="gmenu"><b>Архив игр чемпионата</b></div>';
    echo '<div class="c">';
    echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">';


    while ($arr1 = mysql_fetch_array($req1)) {
        
        if($arr1['tur'] != 0){

$turtime = $realtime - $arr1['time'];

if ($turtime < 0 && $turtime > -24*3600)
{
echo '<tr bgcolor="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '<td width="15%" align="center">'.date("d.m/H:i", $arr1['time']).'</td>';
echo '<td width="10%" align="center">'.$arr1['tur'].' Тур</td>';

echo '<td>';



echo '<a href="team.php?id=' . $arr1['id_team1'] . '">';


if ($arr1[rez1] > $arr1[rez2])
{
echo '<b>'.$arr1[name_team1].'</b>';
}
else
{
echo ''.$arr1[name_team1].'';
}


echo '</a>  - ';
echo '<a href="team.php?id=' . $arr1['id_team2'] . '">';

if ($arr1[rez2] > $arr1[rez1])
{
echo '<b>'.$arr1[name_team2].'</b>';
}
else
{
echo ''.$arr1[name_team2].'';
}

echo '</a> </td>';
        

echo '<td width="10%" align="center">';

if($arr1['time']>$realtime){
$status='<a href="trans.php?id='.$arr1['id'].'"><b>Ожид</b></a>';}
elseif($arr1['time']<$realtime && $arr1['time']>($realtime-951))
{
$status='<a href="trans.php?id='.$arr1['id'].'"><b>?:?</b></a>';}
elseif($arr1[rez1] != '—' || $arr1[rez2] != '—'){
$status='<a href="trans.php?id='.$arr1['id'].'"><b>'.$arr1['rez1'].':'.$arr1['rez2'].'</b></a>';
}else{
$status='<center><a href="trans.php?id='.$arr1[id].'"><img src="img/report.gif" alt="vs"/></a></center>';}

echo '<center>'.$status.'</center>';



echo '</td></tr>';



++$i;     

    }
    }
    echo '</table>';
    echo '</div>';

} else {
    echo 'Доступ закрыт<br/>';
}

echo '<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
