<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

switch ($act)
{
case "rus":
$name_liga = 'Россия. Премьер Лига';
break;
case "ua":
$name_liga = 'Украина. Премьер Лига';
break;
case "en":
$name_liga = 'Англия. Премьер Лига';
break;
case "sp":
$name_liga = 'Испания. Примера';
break;
case "it":
$name_liga = 'Италия. Серия А';
break;
case "ge":
$name_liga = 'Германия. Бундеслига';
break;
case "fr":
$name_liga = 'Франция. Лига 1';
break;
case "go":
$name_liga = 'Голландия. Эредивизия';
break;
case "por":
$name_liga = 'Португалия. Лига Сагрес';
break;
case "bel":
$name_liga = 'Бельгия. Юпилер Лига';
break;
default:
$name_liga = 'Чемпионаты';
break;
}
$textl = $name_liga;

require_once ("incfiles/head.php");
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



// ТАБЛИЦА
$do = array('rus', 'ua', 'en', 'sp', 'it', 'ge', 'fr', 'go', 'por', 'bel');
if ($act && in_array($act, $do))
{
echo '<div class="gmenu"><b>'.$name_liga.'</b></div>';






if (empty($_GET['tur']))
{
$matile = mysql_query("SELECT * from `tur_2` WHERE `chemp`='".$act."' and `tur`!='0' GROUP BY `tur` asc;");

echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">
';

while ($mat = mysql_fetch_array($matile))
{

$turtime = $realtime - $mat['time'];
if ($turtime < 0 && $turtime > -24*3600)
{
echo '<tr bgcolor="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '<td width="20%" align="center">'.date("d.m / H:i", $mat['time']).'</td>';
echo '<td align="center"><a href="calendar.php?act='.$act.'&amp;tur=' . $mat['tur'] . '">' . $mat['tur'] . ' Тур</a></td>';
echo '<td align="center"><a href="chemp.php?act='.$act.'">'.$name_liga.'</a></td>';
echo '</tr>';

++$i;
}
echo '</table>';

}
else
{
$tur = intval($_GET['tur']);
$req = mysql_query("SELECT * FROM `tur_2` where `chemp`='".$act."' and tur='" . $tur . "' order by time asc;");
$total = mysql_num_rows($req);

echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">
';

while ($arr = mysql_fetch_array($req))
{
if ($datauser['id'] && $datauser[manager2] == $arr[id_team1] || $datauser[manager2] == $arr[id_team2])
{
echo '<tr bgcolor="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '<td width="15%" align="center">'.date("d.m / H:i", $arr['time']).'</td>
<td width="10%" align="center">'.$arr[tur].' Тур</td>
<td>';

echo ' <a href="team.php?id='.$arr[id_team1].'">'.$arr[name_team1].'</a> ';

echo ' - <a href="team.php?id='.$arr[id_team2].'">'.$arr[name_team2].'</a> ';

echo '</td>';

echo '<td>';
if($arr['time']>$realtime){
$status='<a href="trans.php?id='.$arr['id'].'"><b>Ожид</b></a>';}
elseif($arr['time']<$realtime && $arr['time']>($realtime-951))
{
$status='<a href="trans.php?id='.$arr['id'].'"><b>Идёт</b></a>';}
elseif($arr[rez1] != '—' || $arr[rez2] != '—'){
$status='<a href="report.php?id='.$arr['id'].'"><b>'.$arr['rez1'].':'.$arr['rez2'].'</b></a>';
}else{
$status='<center><a href="trans.php?id='.$arr[id].'">?:?</a></center>';}

echo '<center>'.$status.'</center>';
echo '</td>';
echo '</tr>';

++$i;
}
echo '</table>';
}

echo '<br/><a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
exit;
}




require_once ("incfiles/end.php");
?>
