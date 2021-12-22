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
if (!empty($datauser['manager2']))
{
$s = 'База клуба';
$isdom=mysql_query("SELECT * FROM `invent_2` WHERE `name`='".$s."' AND `uid`='".$fid."'");
if(mysql_num_rows($isdom)==0){
            echo display_error('Для найма специалистов, постройте Базу клуба!');
            echo '<br/>[<a href="index.php">В панель управления</a>]<br/>';
require_once ("incfiles/end.php");
exit;
}


switch ($act) {

case 'prezident' :

echo '<div class="gmenu"><b>Президент</b></div>';
echo '<div class="c">';
echo '<p align="center"><img src="img/personal/prezident.jpg" alt=""/></p>';
echo '</div>';
echo '<div class="menu">';
echo '
Владеет <b>51%</b> (контрольный пакет) акций клуба <a href="team.php?id=' . $fid . '">' . $names . '</a>.<br/>
Ставит перед менеджером <a href="str/anketa.php?id=' . $id_admin . '">' . $name_admin . '</a> задачу на сезон.<br/>
Оплачивает заработную плату игрокам команды и персонала клуба.<br/>
Доход имеет от спонсоров, рекламы и прав на TV трансляцию.<br/>
Уважаемый человек в клубе.<br/>
';
echo '</div>';
break;
case 'finansist' :

echo '<div class="gmenu"><b>Финансист</b></div>';
echo '<div class="c">';
echo '<p align="center"><img src="img/personal/finansist.jpg" alt=""/></p>';
echo '</div>';
echo '<div class="c">';
echo '
Занимается бухгалтерией клуба <a href="team.php?id=' . $fid . '">' . $names . '</a>.<br/>
Начисляет зароботную плату персоналу клуба, а также по рекомендациях менеджера <a href="str/anketa.php?id=' . $id_admin . '">' . $name_admin . '</a> игрокам команды.<br/>
Ведёт переговоры со спонсорами.<br/>
Советник президента клуба.<br/>
';
echo '</div>';
break;


case 'med' :
echo '<div class="gmenu"><b>Врач</b></div>';


$k = mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$kom = mysql_fetch_array($k);

$q = mysql_query("select * from `infra_2` where type='med' and team='" . $datauser['manager2'] . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if ($arr[id])
{

switch ($arr[level])
{
case "1":$koftrener = 1.5;
break;
case "2":$koftrener = 2;
break;
case "3":$koftrener = 3;
break;
}

echo '<div class="c"><p align="center"><img src="img/personal/'.$arr[level].'_doktor.jpg" alt=""/></p></div>';


echo '<div class="menu"><p>';
echo '<b>' . $arr[name] . ' [' . $arr[level] . ']</b><br/>';
echo 'Врач ' . $arr[level] . '-го розряда уменьшает цену за лечение в ' . $koftrener . ' раза.<br/><br/>';

echo '<table border="0">';
echo '<tr><td width="120px">Розряд:</td><td align="right">'.$arr['level'].'-й</td></tr>';
echo '<tr><td width="120px">Нанят:</td><td align="right">'.date("d.m.y в H:i", $arr['time']).'</td></tr>';
echo '<tr><td width="120px">Контракт до:</td><td align="right">'.date("d.m.y в H:i", ($arr['time']+3600*24*90)).'</td></tr>';
echo '<tr><td>Страна:</td><td align="right"><img src="flag/'.$kom[strana].'.png" alt=""/></td></tr>';
echo '<tr><td>Команда:</td><td align="right"><a href="team.php?id=' . $kom['id'] . '">'.$kom[name].'</a> ['.$kom[lvl].']</td></tr>';
echo '<tr><td>Менеджер:</td><td align="right"><a href="str/anketa.php?user='.$kom['id_admin'].'">'.$kom['name_admin'].'</a></td></tr>';

echo '<tr><td><br/><a href="med.php">В больницу</a></td></tr>';

echo '</table>';

echo '</p></div>';
}
else
{


echo '<div class="list1"><p>';
echo '<table><tr><td><img src="img/personal/1_doktor_s.jpg" alt="" /></td><td valign="top"><b>Врач [1  розряд]</b><br/>';
echo 'Контракт на 3 месяца<br/>';
echo 'Цена: <b>10 000 €</b>';
echo '</td></tr></table>';
echo 'Врач 1-го розряда уменьшает цену за лечение в 1.5 раза.<br/>'; 
echo '<a href="personal.php?act=buy&amp;lvl=1"><font color="red"><b>Нанять врача</b></font></a><br/>';
echo '</p></div>';


echo '<div class="list2"><p>';
echo '<table><tr><td><img src="img/personal/2_doktor_s.jpg" alt="" /></td><td valign="top"><b>Врач [2  розряд]</b><br/>';
echo 'Контракт на 3 месяца<br/>';
echo 'Цена: <b>15 000 €</b>';
echo '</td></tr></table>';
echo 'Врач 2-го розряда уменьшает цену за лечение в 2 раза.<br/>';
echo '<a href="personal.php?act=buy&amp;lvl=2"><font color="red"><b>Нанять врача</b></font></a><br/>';
echo '</p></div>';



echo '<div class="list1"><p>';

echo '<table><tr><td><img src="img/personal/3_doktor_s.jpg" alt="" /></td><td valign="top"><b>Врач [3  розряд]</b><br/>';
echo 'Контракт на 3 месяца<br/>';
echo 'Цена: <b>20 000 €</b>';
echo '</td></tr></table>';

echo 'Врач 3-го розряда уменьшает цену за лечение в 3 раза.<br/>';

echo '<a href="personal.php?act=buy&amp;lvl=3"><font color="red"><b>Нанять врача</b></font></a><br/>';
echo '</p></div>';
}




break;

 case "buy" :
$k = mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$kom = mysql_fetch_array($k);

$b = mysql_query("select * from `infra_2` where type='med' and team='" . $datauser[manager2] . "' LIMIT 1;");
$buy = mysql_fetch_array($b);

if (empty($buy[id]))
{
switch ($_GET['lvl'])
{
case "1":
$level = 1;
$moneykup = 10000;
break;
case "2":
$level = 2;
$moneykup = 15000;
break;
case "3":
$level = 3;
$moneykup = 20000;
break;
}

}
elseif ($buy[level] != 0)
{
echo display_error('У вас уже нанят врач');
require_once ("incfiles/end.php");
exit;
}


$moneykom = $kom[money] - $moneykup;

if ($kom[money] >= $moneykup)
{
$i1 = rand(0,14087);
$i2 = rand(0,1241);

$fn="base/surname.txt"; 
$fp = @fopen ($fn,"r"); 
$str1=fread($fp,filesize($fn)); 
fclose($fp); 
$str1=explode("\n",$str1); 

$fn="base/rus_name.txt"; 
$fp = @fopen ($fn,"r"); 
$str2=fread($fp,filesize($fn)); 
fclose($fp); 
$str2=explode("\n",$str2); 

mysql_query("update `team_2` set `money`='" . $moneykom . "', `med`='".$level."' where id = '" . $kom[id] . " LIMIT 1';");

mysql_query("insert into `infra_2` set 
`type`='med', 
`team`='".$kom[id]."', 
`time`='".$realtime."', 
`name`='".$str1[$i1]." ".$str2[$i2]."', 
`level`='".$level."'
;");

header('location: personal.php?act=med');
exit;
}
else
{
echo display_error('У вас недостаточно денег');
require_once ("incfiles/end.php");
exit;
}
        break;

default :


echo '<div class="gmenu"><b>Персонал комманды "' . $names . '"</b></div>';
echo '<div class="c">';
echo '<a href="personal.php?act=prezident&amp;id=' . $fid . '">Президент</a><br/>';
echo '<a href="personal.php?act=finansist&amp;id=' . $fid . '">Финансист</a><br/>';
echo '<a href="trener.php">Тренер</a><br/>';
echo '<a href="personal.php?act=med&amp;id=' . $fid . '">Врач</a><br/>';
echo '</div>';

}

}
echo'<br/><a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
