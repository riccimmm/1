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
if ($error)
{
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

switch ($act)
{
case "ru":
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
default:
$name_liga = 'Чемпионаты';
break;
}

$textl = $name_liga;



// ТАБЛИЦА
$do = array('ru', 'ua', 'en', 'sp', 'it', 'ge', 'fr', 'go');
if ($act && in_array($act, $do))
{

echo '<div class="gmenu"><b>'.$name_liga.'</b></div>';
echo '<div class="c">
<center><img src="/images/cup/b_'.$act.'.jpg" alt=""/></center>';

echo '</div><div class="c">';

$q1 = mysql_query("SELECT * FROM `champ_table_2` where `champ`='".$act."' ORDER BY `ochey` DESC, `raz` DESC, `gz` DESC LIMIT 16;");

$mesto = 1;



echo '
<table border="0" width="100%"  cellspacing="1" cellpadding="4">
<tr bgcolor="40B832" align="center" class="whiteheader" >
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

while ($arr = mysql_fetch_array($q1))
{


// if ($mesto >= 1 && $mesto <= 5 && $dostadm == 1)
// {
//СОЗДАЁМ ЛЧ
// mysql_query("insert into `liga_group_2` set 
// `group`='', 
// `id_team`='".$arr[id_team]."', 
// `union_team`='".$arr[union_team]."',
// `name_team`='".$arr[name_team]."',
// `level_team`='".$arr[level_team]."'
// ;");
// }






// if ($mesto == 1 && $dostadm == 1)
// {
// $q1 = @mysql_query("select * from `r_team` where id='" . $arr[id_team] . "' LIMIT 1;");
// $winkom = @mysql_fetch_array($q1);

// $oput = $winkom[oput]+100;
// $money = $winkom[money]+10000;
// $slava = $winkom[slava]+100;
// $fans = $winkom[fans]+100;

// mysql_query("update `r_team` set `oput`='" . $oput . "', `money`='" . $money . "', `slava`='" . $slava . "', `fans`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
// }

// if ($mesto == 2 && $dostadm == 1)
// {
// $q1 = @mysql_query("select * from `r_team` where id='" . $arr[id_team] . "' LIMIT 1;");
// $winkom = @mysql_fetch_array($q1);

// $oput = $winkom[oput]+50;
// $money = $winkom[money]+5000;
// $slava = $winkom[slava]+50;
// $fans = $winkom[fans]+50;

// mysql_query("update `r_team` set `oput`='" . $oput . "', `money`='" . $money . "', `slava`='" . $slava . "', `fans`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
// }

// if ($mesto == 3 && $dostadm == 1)
// {
// $q1 = @mysql_query("select * from `r_team` where id='" . $arr[id_team] . "' LIMIT 1;");
// $winkom = @mysql_fetch_array($q1);

// $oput = $winkom[oput]+20;
// $money = $winkom[money]+2000;
// $slava = $winkom[slava]+20;
// $fans = $winkom[fans]+20;

// mysql_query("update `r_team` set `oput`='" . $oput . "', `money`='" . $money . "', `slava`='" . $slava . "', `fans`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
// }


if ($datauser['id'] && $datauser[manager2] == $arr[id_team])
{
echo '<tr class="redrows">';
}
else
{
echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="evenrows">';
}

echo '
<td width="5%" align="center">'.$mesto.'</td>
<td><a href="/manag/union/group.php?id=' . $arr[union_team] . '"><img src="/images/union/' . $arr[union_team] . '.jpg" alt=""/></a> 
<a href="/manag/champ/history.php?act='.$act.'&amp;id='.$arr[id_team].'">'.$arr[name_team].'</a> ['.$arr[level_team].']</td>
<td align="center">'.$arr[igr].'</td>
<td align="center">'.$arr[win].'</td>
<td align="center">'.$arr[nn].'</td>
<td align="center">'.$arr[los].'</td>
<td align="center">'.$arr[gz].'-'.$arr[gp].'</td>
<td align="center"><font color="green"><b>'.$arr[ochey].'</b></font></td>
';	

echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';
echo '</div><div class="c">';
echo '<p><a href="/manag/champ/calendar.php?act='.$act.'">Календарь</a></p>
</div>';

// if ($act == 'fr' && $dostadm == 1)
// {
// mysql_query("insert into `r_priz` set 
// `id_cup`='".$act."', 
// `time`='".$realtime."', 
// `name`='".$name_liga."',
// `priz`='10000',
// `win`='454'
// ;");
// }

require_once ("incfiles/end.php");
exit;
}

//echo '<div class="rmenu" style="text-align: center"><a href="nabor.php"><b><font color="red">Набор участников</font></b></a></div>';
echo '<div class="gmenu"><b>Чемпионаты</b></div>';

echo '<table id="example">';

echo '<tr class="oddrows">';
echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_ru.jpg" alt=""/></td>';
echo '<td><a href="/manag/champ/index.php?act=ru">Россия. Премьер Лига</a></td></tr>';

echo '<tr class="oddrows">';
echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_ua.jpg" alt=""/></td>';
echo '<td><a href="/manag/champ/index.php?act=ua">Украина. Премьер Лига</a></td></tr>';

echo '<tr class="oddrows">';
echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_en.jpg" alt=""/></td>';
echo '<td><a href="/manag/champ/index.php?act=en">Англия. Премьер Лига</a></td></tr>';

echo '<tr class="oddrows">';
echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_sp.jpg" alt=""/></td>';
echo '<td><a href="/manag/champ/index.php?act=sp">Испания. Примера</a></td></tr>';

echo '<tr class="oddrows">';
echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_it.jpg" alt=""/></td>';
echo '<td><a href="/manag/champ/index.php?act=it">Италия. Серия А</a></td></tr>';

// echo '<tr class="oddrows">';
// echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_ge.jpg" alt=""/></td>';
// echo '<td><a href="/champ/index.php?act=ge">Германия. Бундеслига</a></td></tr>';

// echo '<tr class="oddrows">';
// echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_fr.jpg" alt=""/></td>';
// echo '<td><a href="/champ/index.php?act=fr">Франция. Лига 1</a></td></tr>';

// echo '<tr class="oddrows">';
// echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_go.jpg" alt=""/></td>';
// echo '<td><a href="/champ/index.php?act=go">Голландия. Эредивизия</a></td></tr>';

// echo '<tr class="oddrows">';
// echo '<td width="';echo ($theme == "wap") ? '32' : '55';echo 'px" align="center"><img src="/images/cup/';echo ($theme == "wap") ? 's' : 'm';echo '_liga.jpg" alt=""/></td>';
// echo '<td><a href="/liga">Лига Чемпионов</a></td></tr>';

echo '</table>';

require_once ("incfiles/end.php");
?>