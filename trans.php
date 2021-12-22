<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");


$q = mysql_query("select * from `tur_2` where id='" . $id . "';");

if (mysql_num_rows($q) == 0) {
    echo "Такого турнира не существует<br/>";
    echo '<a href="index.php">Вернуться</a><br/>';
    require_once ("incfiles/end.php");
    exit;
}
$art = mysql_fetch_assoc($q);



if ($act == "add")
{

if ($datauser[manager2] == $art[id_team1])
{
mysql_query("update `tur_2` set `gotov1`='1' where id='" . $id . "' LIMIT 1;");

}
elseif ($datauser[manager2] == $art[id_team2])
{
mysql_query("update `tur_2` set `gotov2`='1' where id='" . $id . "' LIMIT 1;");
}


header('location: trans.php?id='.$id);
exit;
}




// ЕСЛИ НЕТ ПОДТВЕРЖДЕНИЯ
if ($art[gotov1] == 0 || $art[gotov2] == 0){

$tt = ($art[time] + 300);
if ($tt > $realtime){

$ostime = $tt-$realtime;
echo '<div class="gmenu"><b>Таймаут: '.date("i:s", $ostime).'</b></div>';
echo '<div class="c">';
echo '<center>Ожидание заявки соперника<br/>Таймаут: '.date("i:s", $ostime).'</center>';
echo '<center><h2><a href="team.php?id='.$art[id_team1].'">'.$art[name_team1].'</a> vs. <a href="team.php?id='.$art[id_team2].'">'.$art[name_team2].'</a></h2></center>';


echo '<meta http-equiv="refresh" content="10;url=trans.php?id='.$id.'"/>';

if ($art[gotov1] != 1 && $datauser[manager2] == $art[id_team1])
{
echo '<center><a href="sostav.php?act=editsostav&amp;id='.$datauser[manager2].'">Изменить состав</a><br/>';
echo '<a href="sostav.php?act=tactics&amp;id='.$datauser[manager2].'">Изменить тактику</a></center><br/>';

echo '<center><a href="trans.php?act=add&amp;id='.$id.'"><font color="red"><b>Отправить</b></font></a></center><br/>';

}
elseif ($art[gotov2] != 1 && $datauser[manager2] == $art[id_team2])
{
echo '<center><a href="sostav.php?act=editsostav&amp;id='.$datauser[manager2].'">Изменить состав</a><br/>';
echo '<a href="sostav.php?act=tactics&amp;id='.$datauser[manager2].'">Изменить тактику</a></center><br/>';

echo '<center><a href="trans.php?act=add&amp;id='.$id.'"><font color="red"><b>Отправить</b></font></a></center><br/>';

}else{
echo '<center></center>';
}

echo '</div>';
require_once ("incfiles/end.php");
exit;
}


}






echo '<div class="gmenu"><b>' . $art['name_team1'] . '[1] - ' . $art['name_team2'] .
    '[2]</b></div>';
echo '<div class="c">';


$k1 = mysql_query("select * from `team_2` where id='" . $art['id_team1'] .
    "' LIMIT 1;");
$krr1 = mysql_fetch_array($k1);

$k2 = mysql_query("select * from `team_2` where id='" . $art['id_team2'] .
    "' LIMIT 1;");
$krr2 = mysql_fetch_array($k2);


echo '<center>' . date("d.m / H:i", $art['time']) . '</center>';

echo '
<center>
<img src="logo/small' . $krr1['logo'] . '" alt=""/> <a href="team.php?id=' . $krr1['id'] .
    '">' . $krr1['name'] . '</a>
-
<a href="team.php?id=' . $krr2['id'] . '">' . $krr2['name'] .
    '</a> <img src="logo/small' . $krr2['logo'] . '" alt=""/>
</center>
';

echo '</div>';

if ($art['rez1'] != '—' || $art['rez2'] != '—') {
    header('location: report.php?id=' . $id);
    exit;
} elseif ($art['time'] < $realtime) {

//вставлям розщет
include ("game.php");
header('location: report.php?id=' . $id);

} else {
    echo "Предварительные настройки игры:<br/>";
    echo '<div class="gmenu"><b>' . $art['name_team1'] . '</b></div><div class="c">';
    $req1 = mysql_query("SELECT `id`,`name`,`nomer`,`line`,`rm` FROM `player_2` where `kom`='" .
        $art['id_team1'] . "' AND `sostav`='1';");
    while ($arr1 = mysql_fetch_array($req1)) {
        $sila1 = $sila1 + $arr1['rm'];
        $sostav1 = $sostav1 . '<b>' . $arr1['nomer'] . '</b> <a href="player.php?id=' .
            $arr1['id'] . '">' . $arr1['name'] . '</a><br/>';
    }
    echo $sostav1 . '<br/>';
    if ($krr1['shema'])
    echo 'Схема: <b>'.$krr1['shema'].'</b><br/>';

    switch ($krr1['pass']) {
        case "0":
            echo 'Пасы: <b>Смешанные</b><br/>';
            break;
        case "1":
            echo 'Пасы: <b>Дальние</b><br/>';
            break;
        case "2":
            echo 'Пасы: <b>Короткие</b><br/>';
            break;
    }


    switch ($krr1['strat']) {
        case "0":
            echo 'Стратегия: <b>Нормальная</b><br/>';
            break;
        case "1":
            echo 'Стратегия: <b>Дальние удары</b><br/>';
            break;
        case "2":
            echo 'Стратегия: <b>Техничная игра</b><br/>';
            break;
        case "3":
            echo 'Стратегия: <b>Игра в пас</b><br/>';
            break;
    }


    switch ($krr1['press']) {
        case "0":
            echo 'Прессинг: <b>Нет</b><br/>';
            break;
        case "1":
            echo 'Прессинг: <b>Да</b><br/>';
            break;
    }


    switch ($krr1['tactics']) {
        case "10":
            echo 'Тактика: <b>10 Суперзащитная</b><br/>';
            break;
        case "20":
            echo 'Тактика: <b>20 Суперзащитная</b><br/>';
            break;
        case "30":
            echo 'Тактика: <b>30 Защитная</b><br/>';
            break;
        case "40":
            echo 'Тактика: <b>40 Защитная</b><br/>';
            break;
        case "50":
            echo 'Тактика: <b>50 Нормальная</b><br/>';
            break;
        case "60":
            echo 'Тактика: <b>60 Нормальная</b><br/>';
            break;
        case "70":
            echo 'Тактика: <b>70 Атакующая</b><br/>';
            break;
        case "80":
            echo 'Тактика: <b>80 Атакующая</b><br/>';
            break;
        case "90":
            echo 'Тактика: <b>90 Суператакующая</b><br/>';
            break;
        case "100":
            echo 'Тактика: <b>100 Суператакующая</b><br/>';
            break;
    }

    echo 'Сила: <b>' . $sila1 . '</b><br/>';


    echo '</div><div class="gmenu"><b>' . $art['name_team2'] .
        '</b></div><div class="c">';
    $req2 = mysql_query("SELECT `id`,`name`,`nomer`,`line`,`rm` FROM `player_2` where `kom`='" .
        $art['id_team2'] . "' AND `sostav`='1';");
    while ($arr2 = mysql_fetch_array($req2)) {
        $sila2 = $sila2 + $arr2['rm'];
        $sostav2 = $sostav2 . '<b>' . $arr2['nomer'] . '</b> <a href="player.php?id=' .
            $arr2['id'] . '">' . $arr2['name'] . '</a><br/>';
    }
    echo $sostav2 . '<br/>';
    echo 'Схема: <b>'.$arr2['shema'].'</b><br/>';

    switch ($krr2['pass']) {
        case "0":
            echo 'Пасы: <b>Смешанные</b><br/>';
            break;
        case "1":
            echo 'Пасы: <b>Дальние</b><br/>';
            break;
        case "2":
            echo 'Пасы: <b>Короткие</b><br/>';
            break;
    }


    switch ($krr2['strat']) {
        case "0":
            echo 'Стратегия: <b>Нормальная</b><br/>';
            break;
        case "1":
            echo 'Стратегия: <b>Дальние удары</b><br/>';
            break;
        case "2":
            echo 'Стратегия: <b>Техничная игра</b><br/>';
            break;
        case "3":
            echo 'Стратегия: <b>Игра в пас</b><br/>';
            break;
    }


    switch ($krr2['press']) {
        case "0":
            echo 'Прессинг: <b>Нет</b><br/>';
            break;
        case "1":
            echo 'Прессинг: <b>Да</b><br/>';
            break;
    }


    switch ($krr2['tactics']) {
        case "10":
            echo 'Тактика: <b>10 Суперзащитная</b><br/>';
            break;
        case "20":
            echo 'Тактика: <b>20 Суперзащитная</b><br/>';
            break;
        case "30":
            echo 'Тактика: <b>30 Защитная</b><br/>';
            break;
        case "40":
            echo 'Тактика: <b>40 Защитная</b><br/>';
            break;
        case "50":
            echo 'Тактика: <b>50 Нормальная</b><br/>';
            break;
        case "60":
            echo 'Тактика: <b>60 Нормальная</b><br/>';
            break;
        case "70":
            echo 'Тактика: <b>70 Атакующая</b><br/>';
            break;
        case "80":
            echo 'Тактика: <b>80 Атакующая</b><br/>';
            break;
        case "90":
            echo 'Тактика: <b>90 Суператакующая</b><br/>';
            break;
        case "100":
            echo 'Тактика: <b>100 Суператакующая</b><br/>';
            break;
    }

    echo 'Сила: <b>' . $sila2 . '</b><br/>';


    echo '</div>';
}

echo "<a href='index.php'>Вернуться</a><br/>";
require_once ("incfiles/end.php");
?>