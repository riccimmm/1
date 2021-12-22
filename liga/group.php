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
header('location: '.$home.'/manag/trans.php?id='.$lastid);


}
else
{
header('Location: '.$home.'/manag/trans.php?id='.$arr1[id]);
exit;
}


require_once ("../incfiles/end.php");
exit;
}






if ($id >= '1' && $id <= '8')
{


switch ($id)
{
case "1":$gr = 'A';break;
case "2":$gr = 'B';break;
case "3":$gr = 'C';break;
case "4":$gr = 'D';break;
case "5":$gr = 'E';break;
case "6":$gr = 'F';break;
case "7":$gr = 'G';break;
case "8":$gr = 'H';break;
}

echo '<div class="gmenu"><b>Группа '.$gr.'</b></div>';

echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Команда</b></td>
<td><b>И</b></td>
<td><b>В</b></td>
<td><b>Н</b></td>
<td><b>П</b></td>
<td><b>Голы</b></td>
<td><b>О</b></td>
</tr>
';

$req = mysql_query("SELECT * FROM `liga_group_2` where `group`='".$gr."' order by ochey DESC, `gz` DESC LIMIT 4;");
$mesto = 1;

while ($arr = mysql_fetch_array($req))
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';

echo '
<td width="5%" align="center">'.$mesto.'</td>
<td> <a href="'.$home.'/manag/team.php?id='.$arr[id_team].'">'.$arr[name_team].'</a> ['.$arr[level_team].']</td>
<td align="center">'.$arr[igr].'</td>
<td align="center">'.$arr[win].'</td>
<td align="center">'.$arr[nn].'</td>
<td align="center">'.$arr[los].'</td>
<td align="center">'.$arr[gz].'-'.$arr[gp].'</td>
<td align="center"><font color="green"><b>'.$arr[ochey].'</b></font></td>
';		
echo '</tr>';


++$mesto;
}
echo '</table>';


// Выводим туры 1
$gd = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='1';");
$ard = mysql_fetch_array($gd);
echo '<div class="example">';
echo '<div class="phdr">';
echo '1 Тур: ' . date("d.m", $ard['time']) . '';
echo '</div>';

echo '<table border="0" width="100%" id="example2" cellspacing="1" cellpadding="2">';

$g = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='1';");
while ($arr = mysql_fetch_array($g))
{

                        echo ceil(ceil($i1 / 2) - ($i1 / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("H:i", $arr['time']) . '</td>';
                        echo '<td align="center">';


                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b> ';
                        } else {
                            echo '' . $arr[name_team1] . ' ';
                        }


                        echo '</a> ['.$arr[level_team1].'] - ';
                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b> ';
                        } else {
                            echo '' . $arr[name_team2] . ' ';
                        }

                        echo '</a> ['.$arr[level_team2].']</td>';


                        echo '<td width="10%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
//$req = mysql_query("select * from `m2_tur` where id='" . $arr['id_report'] . "';");
//$art = mysql_fetch_assoc($req);
echo ' <a href="'.$home.'/manag/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="group.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
++$i1;
}

echo '</table>';
echo '</div>';


// Выводим туры 2
$gd = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='2';");
$ard = mysql_fetch_array($gd);
echo '<div class="example">';
echo '<div class="phdr">';
echo '2 Тур: ' . date("d.m", $ard['time']) . '';
echo '</div>';

echo '<table border="0" width="100%" id="example2" cellspacing="1" cellpadding="2">';

$g = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='2';");
while ($arr = mysql_fetch_array($g))
{

                        echo ceil(ceil($i1 / 2) - ($i1 / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("H:i", $arr['time']) . '</td>';
                        echo '<td align="center">';


                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b> ';
                        } else {
                            echo '' . $arr[name_team1] . ' ';
                        }


                        echo '</a> ['.$arr[level_team1].'] - ';
                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b> ';
                        } else {
                            echo '' . $arr[name_team2] . ' ';
                        }

                        echo '</a> ['.$arr[level_team2].']</td>';


                        echo '<td width="10%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
//$req = mysql_query("select * from `tur_2` where id='" . $arr['id_report'] . "';");
//$art = mysql_fetch_assoc($req);
echo ' <a href="'.$home.'/manag/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="group.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
++$i1;
}

echo '</table>';
echo '</div>';



// Выводим туры 3
$gd = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='3';");
$ard = mysql_fetch_array($gd);
echo '<div class="example">';
echo '<div class="phdr">';
echo '3 Тур: ' . date("d.m", $ard['time']) . '';
echo '</div>';

echo '<table border="0" width="100%" id="example2" cellspacing="1" cellpadding="2">';

$g = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='3';");
while ($arr = mysql_fetch_array($g))
{

                        echo ceil(ceil($i1 / 2) - ($i1 / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("H:i", $arr['time']) . '</td>';
                        echo '<td align="center">';


                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b> ';
                        } else {
                            echo '' . $arr[name_team1] . ' ';
                        }


                        echo '</a> ['.$arr[level_team1].'] - ';
                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b> ';
                        } else {
                            echo '' . $arr[name_team2] . ' ';
                        }

                        echo '</a> ['.$arr[level_team2].']</td>';


                        echo '<td width="10%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
//$req = mysql_query("select * from `m2_tur` where id='" . $arr['id_report'] . "';");
//$art = mysql_fetch_assoc($req);
echo ' <a href="'.$home.'/manag/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="group.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
++$i1;
}

echo '</table>';
echo '</div>';



// Выводим туры 4
$gd = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='4';");
$ard = mysql_fetch_array($gd);
echo '<div class="example">';
echo '<div class="phdr">';
echo '4 Тур: ' . date("d.m", $ard['time']) . '';
echo '</div>';

echo '<table border="0" width="100%" id="example2" cellspacing="1" cellpadding="2">';

$g = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='4';");
while ($arr = mysql_fetch_array($g))
{

                        echo ceil(ceil($i1 / 2) - ($i1 / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("H:i", $arr['time']) . '</td>';
                        echo '<td align="center">';


                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b> ';
                        } else {
                            echo '' . $arr[name_team1] . ' ';
                        }


                        echo '</a> ['.$arr[level_team1].'] - ';
                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b> ';
                        } else {
                            echo '' . $arr[name_team2] . ' ';
                        }

                        echo '</a> ['.$arr[level_team2].']</td>';


                        echo '<td width="10%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
//$req = mysql_query("select * from `tur_2` where id='" . $arr['id_report'] . "';");
//$art = mysql_fetch_assoc($req);
echo ' <a href="'.$home.'/manag/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="group.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
++$i1;
}

echo '</table>';
echo '</div>';


// Выводим туры 5
$gd = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='5';");
$ard = mysql_fetch_array($gd);
echo '<div class="example">';
echo '<div class="phdr">';
echo '5 Тур: ' . date("d.m", $ard['time']) . '';
echo '</div>';

echo '<table border="0" width="100%" id="example2" cellspacing="1" cellpadding="2">';

$g = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='5';");
while ($arr = mysql_fetch_array($g))
{

                        echo ceil(ceil($i1 / 2) - ($i1 / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("H:i", $arr['time']) . '</td>';
                        echo '<td align="center">';


                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b> ';
                        } else {
                            echo '' . $arr[name_team1] . ' ';
                        }


                        echo '</a> ['.$arr[level_team1].'] - ';
                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b> ';
                        } else {
                            echo '' . $arr[name_team2] . ' ';
                        }

                        echo '</a> ['.$arr[level_team2].']</td>';


                        echo '<td width="10%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
//$req = mysql_query("select * from `tur_2` where id='" . $arr['id_report'] . "';");
//$art = mysql_fetch_assoc($req);
echo ' <a href="'.$home.'/manag/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="group.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
++$i1;
}

echo '</table>';
echo '</div>';


// Выводим туры 6
$gd = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='6';");
$ard = mysql_fetch_array($gd);
echo '<div class="example">';
echo '<div class="phdr">';
echo '6 Тур: ' . date("d.m", $ard['time']) . '';
echo '</div>';

echo '<table border="0" width="100%" id="example2" cellspacing="1" cellpadding="2">
';

$g = mysql_query("select * from `liga_game_2` where gr='".$gr."' AND `tur`='6';");
while ($arr = mysql_fetch_array($g))
{

                        echo ceil(ceil($i1 / 2) - ($i1 / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("H:i", $arr['time']) . '</td>';
                        echo '<td align="center">';


                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b> ';
                        } else {
                            echo '' . $arr[name_team1] . ' ';
                        }


                        echo '</a> ['.$arr[level_team1].'] - ';
                        echo '<a href="'.$home.'/manag/team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b> ';
                        } else {
                            echo '' . $arr[name_team2] . ' ';
                        }

                        echo '</a> ['.$arr[level_team2].']</td>';


                        echo '<td width="10%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
//$req = mysql_query("select * from `tur_2` where id='" . $arr['id_report'] . "';");
//$art = mysql_fetch_assoc($req);
echo ' <a href="'.$home.'/manag/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="group.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
++$i1;
}

echo '</table>';
echo '</div>';





$total0 = mysql_result(mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='A' AND `rez1`!='' ;"), 0);
$total1 = mysql_result(mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='B' AND `rez1`!='' ;"), 0);
$total2 = mysql_result(mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='C' AND `rez1`!='' ;"), 0);
$total3 = mysql_result(mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='D' AND `rez1`!='' ;"), 0);
$total4 = mysql_result(mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='E' AND `rez1`!='' ;"), 0);
$total5 = mysql_result(mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='F' AND `rez1`!='' ;"), 0);
$total6 = mysql_result(mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='G' AND `rez1`!='' ;"), 0);
$total7 = mysql_result(mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='H' AND `rez1`!='' ;"), 0);


$total = $total0+$total1+$total2+$total3+$total4+$total5+$total6+$total7;

if($total == 96){
$req = mysql_query("SELECT COUNT(*) FROM `liga_game_2` where `gr`='1/8' ;");
$total = mysql_result($req, 0);
if($total == 0){
 $req1 = mysql_query("SELECT * FROM `liga_group_2` where `group`='A' order by ochey desc LIMIT 2;");
            $mesto1 = 1;
            while ($arr1 = mysql_fetch_array($req1)) {
                switch ($mesto1) {
                    case "1":
                        $id1_1 = $arr1['id_team'];
                        $union1_1 = $arr1['union_team'];
                        $name1_1 = $arr1['name_team'];
                        $level1_1 = $arr1['level_team'];
                        break;
                    case "2":
                        $id1_2 = $arr1['id_team'];
                        $union1_2 = $arr1['union_team'];
                        $name1_2 = $arr1['name_team'];
                        $level1_2 = $arr1['level_team'];
                        break;
                }
                ++$mesto1;
            }


            $req2 = mysql_query("SELECT * FROM `liga_group_2` where `group`='B' order by ochey desc LIMIT 2;");
            $mesto2 = 1;
            while ($arr2 = mysql_fetch_array($req2)) {
                switch ($mesto2) {
                    case "1":
                        $id2_1 = $arr2['id_team'];
                        $union2_1 = $arr2['union_team'];
                        $name2_1 = $arr2['name_team'];
                        $level2_1 = $arr2['level_team'];
                        break;
                    case "2":
                        $id2_2 = $arr2['id_team'];
                        $union2_2 = $arr2['union_team'];
                        $name2_2 = $arr2['name_team'];
                        $level2_2 = $arr2['level_team'];
                        break;
                }
                ++$mesto2;
            }


            $req3 = mysql_query("SELECT * FROM `liga_group_2` where `group`='C' order by ochey desc LIMIT 2;");
            $mesto3 = 1;
            while ($arr3 = mysql_fetch_array($req3)) {
                switch ($mesto3) {
                    case "1":
                        $id3_1 = $arr3['id_team'];
                        $union3_1 = $arr3['union_team'];
                        $name3_1 = $arr3['name_team'];
                        $level3_1 = $arr3['level_team'];
                        break;
                    case "2":
                        $id3_2 = $arr3['id_team'];
                        $union3_2 = $arr3['union_team'];
                        $name3_2 = $arr3['name_team'];
                        $level3_2 = $arr3['level_team'];
                        break;
                }
                ++$mesto3;
            }


            $req4 = mysql_query("SELECT * FROM `liga_group_2` where `group`='D' order by ochey desc LIMIT 2;");
            $mesto4 = 1;
            while ($arr4 = mysql_fetch_array($req4)) {
                switch ($mesto4) {
                    case "1":
                        $id4_1 = $arr4['id_team'];
                        $union4_1 = $arr4['union_team'];
                        $name4_1 = $arr4['name_team'];
                        $level4_1 = $arr4['level_team'];
                        break;
                    case "2":
                        $id4_2 = $arr4['id_team'];
                        $union4_2 = $arr4['union_team'];
                        $name4_2 = $arr4['name_team'];
                        $level4_2 = $arr4['level_team'];
                        break;
                }
                ++$mesto4;
            }


            $req5 = mysql_query("SELECT * FROM `liga_group_2` where `group`='E' order by ochey desc LIMIT 2;");
            $mesto5 = 1;
            while ($arr5 = mysql_fetch_array($req5)) {
                switch ($mesto5) {
                    case "1":
                        $id5_1 = $arr5['id_team'];
                        $union5_1 = $arr5['union_team'];
                        $name5_1 = $arr5['name_team'];
                        $level5_1 = $arr5['level_team'];
                        break;
                    case "2":
                        $id5_2 = $arr5['id_team'];
                        $union5_2 = $arr5['union_team'];
                        $name5_2 = $arr5['name_team'];
                        $level5_2 = $arr5['level_team'];
                        break;
                }
                ++$mesto5;
            }


            $req6 = mysql_query("SELECT * FROM `liga_group_2` where `group`='F' order by ochey desc LIMIT 2;");
            $mesto6 = 1;
            while ($arr6 = mysql_fetch_array($req6)) {
                switch ($mesto6) {
                    case "1":
                        $id6_1 = $arr6['id_team'];
                        $union6_1 = $arr6['union_team'];
                        $name6_1 = $arr6['name_team'];
                        $level6_1 = $arr6['level_team'];
                        break;
                    case "2":
                        $id6_2 = $arr6['id_team'];
                        $union6_2 = $arr6['union_team'];
                        $name6_2 = $arr6['name_team'];
                        $level6_2 = $arr6['level_team'];
                        break;
                }
                ++$mesto6;
            }


            $req7 = mysql_query("SELECT * FROM `liga_group_2` where `group`='G' order by ochey desc LIMIT 2;");
            $mesto7 = 1;
            while ($arr7 = mysql_fetch_array($req7)) {
                switch ($mesto7) {
                    case "1":
                        $id7_1 = $arr7['id_team'];
                        $union7_1 = $arr7['union_team'];
                        $name7_1 = $arr7['name_team'];
                        $level7_1 = $arr7['level_team'];
                        break;
                    case "2":
                        $id7_2 = $arr7['id_team'];
                        $union7_2 = $arr7['union_team'];
                        $name7_2 = $arr7['name_team'];
                        $level7_2 = $arr7['level_team'];
                        break;
                }
                ++$mesto7;
            }


            $req8 = mysql_query("SELECT * FROM `liga_group_2` where `group`='H' order by ochey desc LIMIT 2;");
            $mesto8 = 1;
            while ($arr8 = mysql_fetch_array($req8)) {
                switch ($mesto8) {
                    case "1":
                        $id8_1 = $arr8['id_team'];
                        $union8_1 = $arr8['union_team'];
                        $name8_1 = $arr8['name_team'];
                        $level8_1 = $arr8['level_team'];
                        break;
                    case "2":
                        $id8_2 = $arr8['id_team'];
                        $union8_2 = $arr8['union_team'];
                        $name8_2 = $arr8['name_team'];
                        $level8_2 = $arr8['level_team'];
                        break;
                }
                ++$mesto8;
            }

if($rights == 9){
echo 'Матчи 1/8 сгенерированы.<br/>';
            echo '' . $name1_1 . ' - ' . $name2_2 . '<br/>';
            echo '' . $name2_1 . ' - ' . $name1_2 . '<br/>';

            echo '' . $name3_1 . ' - ' . $name4_2 . '<br/>';
            echo '' . $name4_1 . ' - ' . $name3_2 . '<br/>';

            echo '' . $name5_1 . ' - ' . $name6_2 . '<br/>';
            echo '' . $name6_1 . ' - ' . $name5_2 . '<br/>';

            echo '' . $name7_1 . ' - ' . $name8_2 . '<br/>';
            echo '' . $name8_1 . ' - ' . $name7_2 . '<br/>';
}

            $turtime1 = $realtime;
            $turtime2 = $realtime + 86400;

            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id1_1 . "',`id_team2`='" . $id2_2 . "',`union_team1`='" . $union1_1 .
                "',`union_team2`='" . $union2_2 . "',`name_team1`='" . $name1_1 .
                "',`name_team2`='" . $name2_2 . "',`level_team1`='" . $level1_1 .
                "',`level_team2`='" . $level2_2 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id2_1 . "',`id_team2`='" . $id1_2 . "',`union_team1`='" . $union2_1 .
                "',`union_team2`='" . $union1_2 . "',`name_team1`='" . $name2_1 .
                "',`name_team2`='" . $name1_2 . "',`level_team1`='" . $level2_1 .
                "',`level_team2`='" . $level1_2 . "';");

            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id3_1 . "',`id_team2`='" . $id4_2 . "',`union_team1`='" . $union3_1 .
                "',`union_team2`='" . $union4_2 . "',`name_team1`='" . $name3_1 .
                "',`name_team2`='" . $name4_2 . "',`level_team1`='" . $level3_1 .
                "',`level_team2`='" . $level4_2 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id4_1 . "',`id_team2`='" . $id3_2 . "',`union_team1`='" . $union4_1 .
                "',`union_team2`='" . $union3_2 . "',`name_team1`='" . $name4_1 .
                "',`name_team2`='" . $name3_2 . "',`level_team1`='" . $level4_1 .
                "',`level_team2`='" . $level3_2 . "';");


            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id5_1 . "',`id_team2`='" . $id6_2 . "',`union_team1`='" . $union5_1 .
                "',`union_team2`='" . $union6_2 . "',`name_team1`='" . $name5_1 .
                "',`name_team2`='" . $name6_2 . "',`level_team1`='" . $level5_1 .
                "',`level_team2`='" . $level6_2 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id6_1 . "',`id_team2`='" . $id5_2 . "',`union_team1`='" . $union6_1 .
                "',`union_team2`='" . $union5_2 . "',`name_team1`='" . $name6_1 .
                "',`name_team2`='" . $name5_2 . "',`level_team1`='" . $level6_1 .
                "',`level_team2`='" . $level5_2 . "';");

            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id7_1 . "',`id_team2`='" . $id8_2 . "',`union_team1`='" . $union7_1 .
                "',`union_team2`='" . $union8_2 . "',`name_team1`='" . $name7_1 .
                "',`name_team2`='" . $name8_2 . "',`level_team1`='" . $level7_1 .
                "',`level_team2`='" . $level8_2 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id8_1 . "',`id_team2`='" . $id7_2 . "',`union_team1`='" . $union8_1 .
                "',`union_team2`='" . $union8_1 . "',`name_team1`='" . $name8_1 .
                "',`name_team2`='" . $name7_2 . "',`level_team1`='" . $level8_1 .
                "',`level_team2`='" . $level7_2 . "';");


            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id2_2 . "',`id_team2`='" . $id1_1 . "',`union_team1`='" . $union2_2 .
                "',`union_team2`='" . $union1_1 . "',`name_team1`='" . $name2_2 .
                "',`name_team2`='" . $name1_1 . "',`level_team1`='" . $level2_2 .
                "',`level_team2`='" . $level1_1 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id1_2 . "',`id_team2`='" . $id2_1 . "',`union_team1`='" . $union1_2 .
                "',`union_team2`='" . $union2_1 . "',`name_team1`='" . $name1_2 .
                "',`name_team2`='" . $name2_1 . "',`level_team1`='" . $level1_2 .
                "',`level_team2`='" . $level2_1 . "';");

            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id4_2 . "',`id_team2`='" . $id3_1 . "',`union_team1`='" . $union4_2 .
                "',`union_team2`='" . $union3_1 . "',`name_team1`='" . $name4_2 .
                "',`name_team2`='" . $name3_1 . "',`level_team1`='" . $level4_2 .
                "',`level_team2`='" . $level3_1 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id3_2 . "',`id_team2`='" . $id4_1 . "',`union_team1`='" . $union3_2 .
                "',`union_team2`='" . $union4_1 . "',`name_team1`='" . $name3_2 .
                "',`name_team2`='" . $name4_1 . "',`level_team1`='" . $level3_2 .
                "',`level_team2`='" . $level4_1 . "';");


            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id6_2 . "',`id_team2`='" . $id5_1 . "',`union_team1`='" . $union6_2 .
                "',`union_team2`='" . $union5_1 . "',`name_team1`='" . $name6_2 .
                "',`name_team2`='" . $name5_1 . "',`level_team1`='" . $level6_2 .
                "',`level_team2`='" . $level5_1 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id5_2 . "',`id_team2`='" . $id6_1 . "',`union_team1`='" . $union5_2 .
                "',`union_team2`='" . $union6_1 . "',`name_team1`='" . $name5_2 .
                "',`name_team2`='" . $name6_1 . "',`level_team1`='" . $level5_2 .
                "',`level_team2`='" . $level6_1 . "';");

            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id8_2 . "',`id_team2`='" . $id7_1 . "',`union_team1`='" . $union8_2 .
                "',`union_team2`='" . $union7_1 . "',`name_team1`='" . $name8_2 .
                "',`name_team2`='" . $name7_1 . "',`level_team1`='" . $level8_2 .
                "',`level_team2`='" . $level7_1 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/8',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id7_2 . "',`id_team2`='" . $id8_1 . "',`union_team1`='" . $union7_2 .
                "',`union_team2`='" . $union8_1 . "',`name_team1`='" . $name7_2 .
                "',`name_team2`='" . $name8_1 . "',`level_team1`='" . $level7_2 .
                "',`level_team2`='" . $level8_1 . "';");

}
}




}
else
{
echo '<div class="c">Группа не существует</div>';
}
echo'<br/><a href="../manag2/index.php">Вернуться</a><br/>';
require_once ("../incfiles/end.php");
?>