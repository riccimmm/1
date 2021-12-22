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

if (mysql_num_rows($manager2) == 0)
{
    echo "Команды не существует</div>";
    require_once ("../incfiles/end.php");
 exit;
}

// ИГРАЕМ МАТЧ
if ($act == "play")
{
$q = mysql_query("select * from `liga_game2` where id='" . $id . "';");
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















echo '<div class="gmenu"><b>1/8 финала</b></div>';

// Выводим туры


$g = mysql_query("select * from `liga_game_2` where gr='1/8' AND tur='1' order by id asc;");

$gd = mysql_query("select * from `liga_game_2` where gr='1/8' AND tur='1' order by id asc limit 1;");
$ard = mysql_fetch_array($gd);
echo '<div class="c">';
echo '<br/><b>Первые матчи состоятся ' . date("d.m", $ard['time']) . '</b><br/><br/>';
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
                        echo '<td width="15%" align="center">' . date("H:i", $arr['time']) . '</td>';
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
                            echo '<b>' . $arr[name_team2] . '</b> ';
                        } else {
                            echo '' . $arr[name_team2] . ' ';
                        }

                        echo '</a> ['.$arr[level_team2].']</td>';


                        echo '<td width="15%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{

echo ' <a href="'.$home.'/manag2/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="18.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
                $rez1[$i1] = $arr['rez1'];
                $rez2[$i1] = $arr['rez2'];						
						
++$i1;
}
echo '</table>';
echo '</div>';



// Выводим туры 2
$g = mysql_query("select * from `liga_game_2` where gr='1/8' AND tur='2' order by id asc;");

$gd = mysql_query("select * from `liga_game_2` where gr='1/8' AND tur='2' order by id asc limit 1;");
$ard = mysql_fetch_array($gd);

echo '<div class="c">';

echo '<br/><b>Ответные матчи состоятся ' . date("d.m", $ard['time']) . '</b><br/><br/>';

echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>Время</b></td>
<td><b>Команды</b></td>
<td><b>Счёт</b></td>
</tr>';



while ($arr = mysql_fetch_array($g))
{

                        echo ceil(ceil($i2 / 2) - ($i2 / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("H:i", $arr['time']) . '</td>';
                        echo '<td>';


                        echo '<a href="../team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b> ';
                        } else {
                            echo '' . $arr[name_team1] . ' ';
                        }


                        echo '</a> ['.$arr[level_team1].'] - ';
                        echo '<a href="..//team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b> ';
                        } else {
                            echo '' . $arr[name_team2] . ' ';
                        }

                        echo '</a> ['.$arr[level_team2].']</td>';


                        echo '<td width="15%" align="center">';

if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
{
echo ' <a href="/manag2/trans.php?id='.$arr['id_report'].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b></font></a>';
$rez3[$i2] = $arr['rez1'] + $rez2[$i2];
$rez4[$i2] = $arr['rez2'] + $rez1[$i2];
if ($rez4[$i2] == $rez3[$i2]) {
echo ' (п. '.$arr[pen1].':'.$arr[pen2].')';
}
}
else
{

if ($realtime > $arr[time])
{
echo ' <a href="18.php?act=play&amp;id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}


}
                        echo '</td></tr>';
++$i2;
}
echo '</table>';
echo '</div>';


$req = mysql_query("SELECT COUNT(*) FROM `liga_game_2` where `gr`='1/8' AND `rez1`!='' ;");
$total = mysql_result($req, 0);

if($total == 16){
$req = mysql_query("SELECT COUNT(*) FROM `liga_game` where `gr`='1/4' ;");
$total = mysql_result($req, 0);
if($total == 0){




$req = mysql_query("SELECT * FROM `liga_game_2` where `gr`='1/8' AND `tur`='1' order by id asc;");
            $i = 1;

            while ($arr = mysql_fetch_array($req)) {
                $rez1[$i] = $arr['rez1'];
                $rez2[$i] = $arr['rez2'];

                ++$i;
            }

            $req = mysql_query("SELECT * FROM `liga_game_2` where `gr`='1/8' AND `tur`='2' order by id asc;");
            $i = 1;

            while ($arr = mysql_fetch_array($req)) {

                $rez3[$i] = $arr['rez1'] + $rez2[$i];
                $pen3[$i] = $arr['pen1'];


                $rez4[$i] = $arr['rez2'] + $rez1[$i];
                $pen4[$i] = $arr['pen2'];

                if ($rez4[$i] > $rez3[$i]) {
                    $id4[$i] = $arr['id_team2'];
                    $union4[$i] = $arr['union_team2'];
                    $name4[$i] = $arr['name_team2'];
                    $level4[$i] = $arr['level_team2'];
                } elseif ($rez4[$i] == $rez3[$i]) {
                    $dop1 = $rez4[$i] + $pen4[$i];
                    $dop2 = $rez3[$i] + $pen3[$i];
                    if ($dop1 > $dop2) {
                        $id4[$i] = $arr['id_team2'];
                        $union4[$i] = $arr['union_team2'];
                        $name4[$i] = $arr['name_team2'];
                        $level4[$i] = $arr['level_team2'];
                    } else {
                        $id4[$i] = $arr['id_team1'];
                        $union4[$i] = $arr['union_team1'];
                        $name4[$i] = $arr['name_team1'];
                        $level4[$i] = $arr['level_team1'];
                    }
                } else {
                    $id4[$i] = $arr['id_team1'];
                    $union4[$i] = $arr['union_team1'];
                    $name4[$i] = $arr['name_team1'];
                    $level4[$i] = $arr['level_team1'];
                }
                ++$i;
            }

if($rights == 9){
echo 'Матчи 1/4 сгенерированы.<br/>';
            echo '' . $name4[1] . '-' . $name4[4] . '<br/>';
            echo '' . $name4[2] . '-' . $name4[8] . '<br/>';
            echo '' . $name4[3] . '-' . $name4[5] . '<br/>';
            echo '' . $name4[7] . '-' . $name4[6] . '<br/>';
}
            $id1_1 = $id4[1];
            $id2_2 = $id4[4];
            $id2_1 = $id4[2];
            $id1_2 = $id4[8];
            $id3_1 = $id4[3];
            $id4_2 = $id4[5];
            $id4_1 = $id4[7];
            $id3_2 = $id4[6];

            $union1_1 = $union4[1];
            $union2_2 = $union4[4];
            $union2_1 = $union4[2];
            $union1_2 = $union4[8];
            $union3_1 = $union4[3];
            $union4_2 = $union4[5];
            $union4_1 = $union4[7];
            $union3_2 = $union4[6];


            $name1_1 = $name4[1];
            $name2_2 = $name4[4];
            $name2_1 = $name4[2];
            $name1_2 = $name4[8];
            $name3_1 = $name4[3];
            $name4_2 = $name4[5];
            $name4_1 = $name4[7];
            $name3_2 = $name4[6];


            $level1_1 = $level4[1];
            $level2_2 = $level4[4];
            $level2_1 = $level4[2];
            $level1_2 = $level4[8];
            $level3_1 = $level4[3];
            $level4_2 = $level4[5];
            $level4_1 = $level4[7];
            $level3_2 = $level4[6];


            $turtime1 = $realtime;
            $turtime2 = $realtime + 86400;

            mysql_query("insert into `liga_game_2` set `gr`='1/4',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id1_1 . "',`id_team2`='" . $id2_2 . "',   `union_team1`='" .
                $union1_1 . "',`union_team2`='" . $union2_2 . "',    `name_team1`='" . $name1_1 .
                "',`name_team2`='" . $name2_2 . "',`level_team1`='" . $level1_1 .
                "',`level_team2`='" . $level2_2 . "';");
            mysql_query("insert into `liga_game_22` set `gr`='1/4',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id2_1 . "',`id_team2`='" . $id1_2 . "',   `union_team1`='" .
                $union2_1 . "',`union_team2`='" . $union1_2 . "',    `name_team1`='" . $name2_1 .
                "',`name_team2`='" . $name1_2 . "',`level_team1`='" . $level2_1 .
                "',`level_team2`='" . $level1_2 . "';");

            mysql_query("insert into `liga_game_2` set `gr`='1/4',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id3_1 . "',`id_team2`='" . $id4_2 . "',   `union_team1`='" .
                $union3_1 . "',`union_team2`='" . $union4_2 . "',    `name_team1`='" . $name3_1 .
                "',`name_team2`='" . $name4_2 . "',`level_team1`='" . $level3_1 .
                "',`level_team2`='" . $level4_2 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/4',`tur`='1',`time`='" . $turtime1 .
                "',`id_team1`='" . $id4_1 . "',`id_team2`='" . $id3_2 . "',   `union_team1`='" .
                $union4_1 . "',`union_team2`='" . $union3_2 . "',    `name_team1`='" . $name4_1 .
                "',`name_team2`='" . $name3_2 . "',`level_team1`='" . $level4_1 .
                "',`level_team2`='" . $level3_2 . "';");


            mysql_query("insert into `liga_game_2` set `gr`='1/4',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id2_2 . "',`id_team2`='" . $id1_1 . "',   `union_team1`='" .
                $union2_2 . "',`union_team2`='" . $union1_1 . "',    `name_team1`='" . $name2_2 .
                "',`name_team2`='" . $name1_1 . "',`level_team1`='" . $level2_2 .
                "',`level_team2`='" . $level1_1 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/4',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id1_2 . "',`id_team2`='" . $id2_1 . "',   `union_team1`='" .
                $union1_2 . "',`union_team2`='" . $union2_1 . "',    `name_team1`='" . $name1_2 .
                "',`name_team2`='" . $name2_1 . "',`level_team1`='" . $level1_2 .
                "',`level_team2`='" . $level2_1 . "';");

            mysql_query("insert into `liga_game_2` set `gr`='1/4',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id4_2 . "',`id_team2`='" . $id3_1 . "',   `union_team1`='" .
                $union4_2 . "',`union_team2`='" . $union3_1 . "',    `name_team1`='" . $name4_2 .
                "',`name_team2`='" . $name3_1 . "',`level_team1`='" . $level4_2 .
                "',`level_team2`='" . $level3_1 . "';");
            mysql_query("insert into `liga_game_2` set `gr`='1/4',`tur`='2',`time`='" . $turtime2 .
                "',`id_team1`='" . $id3_2 . "',`id_team2`='" . $id4_1 . "',   `union_team1`='" .
                $union3_2 . "',`union_team2`='" . $union4_1 . "',    `name_team1`='" . $name3_2 .
                "',`name_team2`='" . $name4_1 . "',`level_team1`='" . $level3_2 .
                "',`level_team2`='" . $level4_1 . "';");
}
}


echo'<br/><a href="../index.php">Вернутьсяя</a><br/>';

require_once ("../incfiles/end.php");
?>