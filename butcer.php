<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

$kk = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "';");
$kom = @mysql_fetch_array($kk);
$totalkom = mysql_num_rows($kk);

if ($totalkom == 0)
{
header('Location: index.php');
exit;
}

echo '<div class="gmenu"><center>Магазин буцера</center></div>';
echo '<div class="menu"><a href="butc.php">Все о буцерах</a></div>';
echo '<div class="menu"><a href="butcer.php?act=vost">Востанавливаем команду за 3 буцер</a></div>';
echo '<div class="menu"><a href="butcer.php?act=obmen">Обменник буцера на 3000евро</a></div>';
echo '<div class="menu"><a href="butcer.php?act=oput">Прокачать игрока на 1000 опыта за 1 буцер</a></div>';
echo '<div class="menu"><a href="obmen.php">Обменник сообщений</a></div>';



// Востанавливаем
if ($act == "vost")
{
if ($kom[butcer] < 3)
{
echo '<div class="gmenu"><b>У Вас нет буцеров</b></div>';
echo '<div class="c">
У Вас нет буцеров и потому Вы не можете мгновенно восстановить физготовность игроков на 100%, вылечить травмы и повысить мораль.<br/>
<a href="pay.php">Где взять буцер?</a><br/>
</div>';
require_once ("incfiles/end.php");
exit;
}

$butcer = $kom[butcer] - 3;
mysql_query("update `team_2` set `time`='0', butcer='" . $butcer . "' where id='" . $kom[id] . "' LIMIT 1;");

header('location: team.php?id='.$kom[id]);
exit;
}


// Обмен
if ($act == "obmen")
{
if ($kom[butcer] < 1)
{
echo '<div class="gmenu"><b>У Вас нет буцеров</b></div>';
echo '<div class="c">
У Вас нет буцеров и потому Вы не можете обменять буцер на 3000 €<br/>
<a href="pay.php">Где взять буцер?</a><br/>
</div>';

require_once ("incfiles/end.php");
exit;
}

$butcer = $kom[butcer] - 1;
$money = $kom[money] + 3000;
mysql_query("update `team_2` set `money`='" . $money . "', butcer='" . $butcer . "' where id='" . $kom[id] . "' LIMIT 1;");

header('location: /index.php');
exit;
}


// Опыт игроку
if ($act == "oput")
{
if ($kom[butcer] < 1)
{
echo '<div class="gmenu"><b>У Вас нет буцеров</b></div>';
echo '<div class="c">
У Вас нет буцеров и потому Вы не можете прокачать игрока на 1000 опыта.<br/>
<a href="pay.php">Где взять буцер?</a><br/>
</div>';
require_once ("incfiles/end.php");
exit;
}


if (isset($_POST['submit']))
{
$player = trim($_POST['player']);

$q = @mysql_query("select * from `player_2` where id='" . $player . "' LIMIT 1;");
$play = @mysql_fetch_array($q);

if ($kom[id] == $play[kom])
{
$butcer = $kom[butcer] - 1;
mysql_query("update `team_2` set butcer='" . $butcer . "' where id='" . $kom[id] . "' LIMIT 1;");

$oput = $play[opit] + 1000;
mysql_query("update `player_2` set opit='" . $oput . "' where id='" . $play[id] . "' LIMIT 1;");
}

}
else
{
echo '<div class="gmenu"><b>Выбор игрока</b></div>';
echo '<div class="c">';

$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$kom[id]."' order by nomer asc;");

echo '<form action="butcer.php?act=oput" method="post">';
echo '<select name="player">';
while ($arr = mysql_fetch_array($req))
{
echo '<option value="'.$arr[id].'">'.$arr[nomer].' '.$arr[name].'</option>';
}
echo '</select>';
echo ' <input type="submit" name="submit" value="Прокачать" />';
echo '</form>';
echo '</div>';
require_once ("incfiles/end.php");
exit;
}

header('location: train.php');
exit;
}



require_once ("incfiles/end.php");
?>