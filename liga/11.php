<?php
/*
//////////////////////////////////////////////////////////////////////////////////////////////////////
// mod manager by 1_Kl@S Syava Andrusiv                                    //
// Официальный сайт сайт Менеджера: http://megasport.name       //
// СДЕСЬ НИЧЕГО НЕ МЕНЯТЬ!!!!!!!!!!!!!!!                                        //
/////////////////////////////////////////////////////////////////////////////////////////////////////
// JohnCMS core team:                                                                  //
// Евгений Рябинин aka john77          john77@johncms.com            //
// Олег Касьянов aka AlkatraZ          alkatraz@johncms.com           //
//                                                                                                  //
// Информацию о версиях смотрите в прилагаемом файле version.txt//
//////////////////////////////////////////////////////////////////////////////////////////////////////
*/

define('_IN_JOHNCMS', 1);
$headmod = 'liga';
$textl = 'Лига Чемпионов';
$rootpath = '../';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");
require_once ("../incfiles/manag2.php");
// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="../login.php">авторизованным</a> посетителям';
if ($error)
{
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
    require_once ("../incfiles/end.php");
    exit;
}

if (mysql_num_rows($manager) == 0)
{
    echo "Команды не существует</div>";
    require_once ("../incfiles/end.php");
 exit;
}

// ИГРАЕМ МАТЧ
if ($act == "play")
{
$q = mysql_query("select * from `liga_game_2` where id='" . $id . "';");
$arr = mysql_fetch_array($q);
$totalz = mysql_num_rows($q);

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
echo '<div class="c">Игра уже состоялась</div>';
require_once ("../incfiles/end.php");
exit;
}

if ($totalz != 1)
{
echo '<div class="c">Вашей заявки не найдено</div>';
require_once ("../incfiles/end.php");
exit;
}

if ($realtime < $arr[time])
{
echo '<div class="c">Еще не время</div>';
require_once ("../incfiles/end.php");
exit;
}


$q1 = mysql_query("select * from `tur_2` where chemp='liga' AND id_match='" . $arr[id] . "';");
$arr1 = mysql_fetch_array($q1);
$totalz1 = mysql_num_rows($q1);

if ($totalz1 == 0)
{

$q1 = mysql_query("select * from `team_2` where id='" . $arr[id_team1] . "' LIMIT 1;");
$arr1 = mysql_fetch_array($q1);

$q2 = mysql_query("select * from `team_2` where id='" . $arr[id_team2] . "' LIMIT 1;");
$arr2 = mysql_fetch_array($q2);



if (empty($arr1['id']) && empty($arr2['id']) && empty($arr1['name']) && empty($arr2['name']))
{
echo '<div class="c">Заявка не найдена</div>';
require_once ("../incfiles/end.php");
exit;
}

//$mtime = $realtime+450;

mysql_query("insert into `tur_2` set 
`chemp`='liga',
`id_match`='".$id."',
`time`='".$realtime."',
`id_team1`='".$arr1['id']."',
`id_team2`='".$arr2['id']."',
`name_team1`='".$arr1['name']."',
`name_team2`='".$arr2['name']."'
;");

$lastid = mysql_insert_id();
header('location: '.$home.'/manag2/trans.php?id='.$lastid);


}
else
{
header('Location: '.$home.'/manag2/trans.php?id='.$arr1[id]);
exit;
}


require_once ("../incfiles/end.php");
exit;
}















echo '<div class="gmenu"><b>Финал</b></div>';

// Выводим туры
$g = mysql_query("select * from `liga_game_2` where gr='1/1' LIMIT 1;");

echo '<div class="c">';
echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>Время</b></td>
<td><b>Команды</b></td>
<td><b>Счёт</b></td>
</tr>';
while ($arr = mysql_fetch_array($g))
{

                        echo ceil(ceil($i1 / 2) - ($i1 / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("d.m/H:i", $arr['time']) . '</td>';
                        echo '<td>';


                        echo '<a href="'.$home.'/manag2/team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b>';
                        } else {
                            echo '' . $arr[name_team1] . '';
                        }


                        echo '</a> ['.$arr[level_team1].'] - ';
                        echo '<a href="'.$home.'/manag2/team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b>';
                        } else {
                            echo '' . $arr[name_team2] . '';
                        }

                        echo '</a> ['.$arr[level_team1].']</td>';


                        echo '<td width="10%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{

echo ' <a href="'.$home.'/manag2/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
if ($arr[rez1] == $arr[rez2])
{
echo ' (п. '.$arr[pen1].':'.$arr[pen2].')';
}
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="11.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
++$i1;
}
echo '</table>';
echo '</div>';












echo'<br/><a href="'.$home.'/manag2/index.php">Вернуться</a><br/>';
require_once ("../incfiles/end.php");
?>