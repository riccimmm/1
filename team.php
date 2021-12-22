<?php
define('_IN_JOHNCMS', 1);
$textl = 'Команда - FUTMEN.NET';
$rootpath = '';
require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
$k = mysql_query("select * from `team_2` where id='" . $id . "';");
$kom = mysql_fetch_array($k);
$textl = $kom['name'];

if (isset ($ban)){
    echo'<div class="rmenu"><b>Доступ закрыт!</b></div>';
	require_once ('incfiles/end.php');
	exit;
	}
       if (!$user_id) {
            echo display_error('Команда только для зарегистрированных');
            require_once ('incfiles/end.php');
            exit;
        }

		

$time = $realtime - 1800;

// ВОСТАНОВЛЕНИЕ
if ($kom['time'] < ($realtime - 300)) {
    $req = mysql_query("SELECT * FROM `player_2` where `kom`='" . $kom['id'] . "';");

    while ($arr = mysql_fetch_array($req)) {
        if ($arr[fiz] <= 100 || $arr['mor'] != '0') {
            $mast = $arr['otbor'] + $arr['opeka'] + $arr['drib'] + $arr['priem'] + $arr['vonos'] +
                $arr['pas'] + $arr['sila'] + $arr['tocnost'];
            $rrr = ceil(($realtime - $kom['time']) / 300);
            $fiza = $arr[fiz] + $rrr;
            if ($fiza > 100) {
                $fiza = 100;
            }

            $rmm = ceil($mast / 100 * $fiza);
            if ($rmm < 0) {
                $rmm = 0;
            }
            mysql_query("update `player_2` set `fiz`='" . $fiza . "',  `rm`='" . $rmm .
                "' where id='" . $arr[id] . "' LIMIT 1;");
        }

        if (($realtime - $arr[time]) > 24 * 1800 * 10) {
            $voz = $arr[voz] + 1;
            mysql_query("update `player_2` set `time`='" . $realtime . "', `voz`='" . $voz .
                "' where id='" . $arr[id] . "' LIMIT 1;");
        }

    }
    mysql_query("update `team_2` set `time`='" . $realtime . "' where id='" . $id .
        "' LIMIT 1;");
}
		

echo '<center><div class="phdr"><b>' . $kom['name'] . '</b></center>';
if ($rights >= 9)
echo '<div class="rmenu"><a href="team.php?act=delete&amp;id=' . $kom['id'] . '" class="redbutton">Удалить команду</a></div>';
echo '<div class="list2">';

if (empty($kom[logo])) {
    echo '<center><img src="logo/bignologo.jpg" alt=""/></center>';
	//echo '<p align="center"><a href="team/logo.php">Выгрузить лого</a></p>';
} else {
    echo '<center><img src="logo/big' . $kom[logo] . '" alt=""/></center>';
    
}

if ($kom[id]==$datauser[manager2])
echo '</div>';
echo '<div class="list1">';
if (!empty($kom[forma])) {
echo '<center><img src="team/thumb.php?file=' . $kom[forma] . '" alt=""/></center>';
}else{echo'<p align="center">Форма комманды стандартная</p>';}
if ($kom[id]==$datauser[manager2])
//echo '<p align="center"><a href="team/forma.php">Выбрать форму</a></p>';

echo '</div>';
echo '<div class="list2">';
echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">

<tr bgcolor="40B832" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Игрок</b></td>
<td><b>Фото</b></td>
<td><b>Гр</b></td>
<td><b>Где</b></td>
<td><b>Поз</b></td>
<td><b>Воз</b></td>
<td><b>Тал</b></td>
<td><b>Мас</b></td>
<td><b>Ф/г</b></td>


<td><b>Р/м</b></td>
</tr>
';

$req = mysql_query("SELECT * FROM `player_2` where `kom`='" . $kom['id'] .
    "' order by nomer asc;");
$total = mysql_num_rows($req);
while ($arr = mysql_fetch_array($req)) {

    echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr class="list2">' :
        '<tr class="list1">';
		
    echo '
<td align="center">'.($arr['nomer']) .'</td>
<td><a href="player.php?id=' . $arr[id] . '">' . $arr[name] . '</a>';


    if ($arr[btime] != 0) {
        echo ' <img src="img/trav.gif" alt=""/>';
    }
    
    if ($arr[utime] != 0) {
        echo ' <img src="img/m_red.gif" alt=""/>';
    }

    if ($arr[yellow] != 0) {
        echo ' <img src="img/m_yellow.gif" alt=""/>';
    }

    if ($arr[t_money] != 0) {
        echo ' <a href="transfer.php?act=buy&amp;id=' . $arr[id] .
            '"><img src="img/buy.gif" alt=""/></a>';
    }
echo "</td>";

        if (file_exists(('foto/' . $arr['id'] . '_small.png'))) {
            echo '<td><center><img src="foto/' . $arr['id'] . '_small.png" alt="" /></center></td>';
}else{
            echo '<td><center><img src="foto/nofoto.jpeg" alt="" width="20" height="25"/></center></td>';
}






    echo '<td><center><img src="flag/' . $arr[strana] .
        '.png" alt=""/></center></td>';
    if ($arr['sostav'] == '0') {
        $sostav = 'Отд';
    } else {
        $sostav = '<u>Осн</u>';
    }
    $mast = $arr[otbor] + $arr[opeka] + $arr[drib] + $arr[priem] + $arr[vonos] + $arr[pas] +
        $arr[sila] + $arr[tocnost];
    echo '
<td><center>' . $sostav . '</center></td>';
    echo '<td><center>' . $arr[poz] . '</center></td>
<td><center>' . $arr[voz] . '</center></td>
<td><center>' . $arr[tal] . '</center></td>
<td><center>' . $mast . '</center></td>
<td><center>' . $arr[fiz] . '%</center></td>


<td><center><font color="green"><b>' . $arr[rm] . '</b></font></center></td>';
    echo '</tr>';

    $sila = $sila + $arr[rm];
    
    ++$i;
}
$srsila = $sila / $total;
echo '
<tr class="phdr">
    <td align="center"></td>
	<td>Всего ' . $total . ' игроков</td>
	<td align="center"></td>
	<td align="center"></td>
	<td align="center"></td>
	<td align="center"></td>
	<td align="center"></td>
	<td align="center"></td>
	<td align="center">' . round($srsila) . '</td>
	<td align="center"></td>
	<td align="center"><b></b></td>

</tr>

</table><br/></div>';

echo '<div class="c"><b>Профиль</b></div>';
echo '<div class="c">';

//КУБКИ
$w = mysql_query("select * from `priz_2` where `win` = '" . $id .
    "' GROUP BY `id_cup` order by `time` asc;");
$wintotal = mysql_num_rows($w);


if ($wintotal > 0) {
    while ($win = mysql_fetch_array($w))
    {
    $w2 = mysql_fetch_array(mysql_query("select `path` from `tournaments_2` where `id` = '" . $win[id_cup] ."' GROUP BY `time` order by `time` asc;"));
    echo '<img src="img/' . $w2[path] . '.jpg" width="48" alt=""/> ';
    }

    echo '<br/><a href="winner.php?id=' . $id . '">Зал трофеев</a><br/><br/>';
}



echo 'Опыт: <b>' . $kom[rate] . '</b><br/>';

echo 'Менеджер: <a href="str/anketa.php?id=' . $kom[id_admin] . '">' . $kom[name_admin] .
    '</a><br/>';

echo '</div>';



echo '<div class="gmenu"><b>Статистика</b></div>';
echo '<div class="c">Игроков: <b>' . $total . '</b><br/>';
$srsila = $sila / $total;
echo 'Ср. сила: <b>' . round($srsila) . '</b><br/>';
    $all = $kom[win] + $kom[nnn] + $kom[lost];
echo 'Матчей: <b>' . $all . '</b><br/>';
echo 'Побед: <b>' . $kom[win] . '</b><br/>';
echo 'Ничьих: <b>' . $kom[nnn] . '</b><br/>';
echo 'Поражений: <b>' . $kom[lost] . '</b><br/>';

echo '<a href="stadium.php?id=' . $id . '">Стадион [' . $kom['mest'] . ']</a>';

if ($kom['trener'] > 0) {
    echo ', <a href="trener.php?id=' . $id . '">Тренер [' . $kom['trener'] . ']</a>';
}
if ($kom['med'] > 0) {
    echo ', <a href="personal.php?act=med&amp;id=' . $id . '">Врач [' . $kom['med'] .
        ']</a>';

}


echo '</div>';

if ($kom['id_admin'] == $user_id)
{}
else{echo'<center><a href="friendly.php?act=pred&amp;id='.$id.'" class="button">Предложить сыграть матч</a></center>';}
require_once ("incfiles/end.php");
?>