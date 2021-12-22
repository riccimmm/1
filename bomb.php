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


if (mysql_num_rows($manager) == 0)
{
echo "Команды не существует<br/>";
require_once ("incfiles/end.php");
exit;
}


if (!empty($fid))
{
    
 switch($act){
    default:
    echo '<div class="gmenu"><b>Выберите чемпионат</b></div>';



echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
';

 

 echo '<tr bgcolor="dddddd">';
 echo '<td width="32px" align="center"><img src="/images/cup/s_liga.jpg" alt=""/></td>';


 echo '<td><a href="bomb.php?act=all"> Все лиги</a></td></tr>';

echo '</table>';
    break;
    
    case 'liga':
    $do = array('rus', 'ua', 'en', 'sp', 'it', 'ge', 'fr', 'go', 'por', 'bel');
    if(in_array($_GET['strana'], $do)){
    echo '<div class="c">';
echo '
<table border="0" width="100%"  id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Страна</b></td>
<td><b>Игрок</b></td>
<td><b>Голов</b></td>
</tr>
';


$req = mysql_query("SELECT `player_2`.*, `player_2`.`name` AS `pname`, `team_2`.`name` FROM `player_2` LEFT JOIN `team_2` ON `player_2`.`kom`=`team_2`.`id` WHERE `player_2`.`goal` != '0' AND `team_2`.`strana`='".$_GET['strana']."'  ORDER BY `player_2`.`goal` DESC LIMIT 30 ");
$mesto =1;
while ($arr = mysql_fetch_array($req))
{

echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
echo '
<td><center>'.$mesto.'</center></td>
<td><center><img src="flag/'.$arr['strana'].'.png" alt=""/></center></td>
<td><a href="player.php?id='.$arr['id'].'">'.$arr['pname'].'</a> '.$arr['poz'].'<br/><small>'.$arr['name'].'</small></td>
<td align="center"><font color="green"><b>'.$arr['goal'].'</b></font></td>
';		
echo '</tr>';
	++$mesto;
    ++$i;
}

echo '</table><br/></div>';
if($i == 0){
    echo display_error('Извините, на даний момент в лиге нет бомбардиров!');
    require_once ("incfiles/end.php");
    exit;
}

}else{
        echo display_error('Лига не существует!');
    require_once (".incfiles/end.php");
    exit;
}
    break;
    
    case 'all' :
        echo '<div class="c">';
echo '
<table border="0" width="100%"  id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Страна</b></td>
<td><b>Игрок</b></td>
<td><b>Голов</b></td>
</tr>
';


$req = mysql_query("SELECT `player_2`.*, `player_2`.`name` AS `pname`, `team_2`.`name` FROM `player_2` LEFT JOIN `team_2` ON `player_2`.`kom`=`team_2`.`id` WHERE `player_2`.`goal` != '0' ORDER BY `player_2`.`goal` DESC LIMIT 30 ");


$mesto =1;
while ($arr = mysql_fetch_array($req))
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
echo '
<td><center>'.$mesto.'</center></td>
<td><center><img src="flag/'.$arr['strana'].'.png" alt=""/></center></td>
<td><a href="player.php?id='.$arr['id'].'">'.$arr['pname'].'</a> '.$arr['poz'].'<br/><small>'.$arr['name'].'</small></td>
<td align="center"><font color="green"><b>'.$arr['goal'].'</b></font></td>
';		
echo '</tr>';
	++$mesto;
    ++$i;
}
echo '</table><br/></div>';
    break;
    
    
 }   




}else {
echo'Доступ закрыт';
}

echo'<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>