<?php

define('_IN_JOHNCMS', 1);

$textl = 'Чемпионат';

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
case "por":
$name_liga = 'Португалия. Лига Сагрес';
break;
case "bel":
$name_liga = 'Бельгия. Юпитер Лига';
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
$do = array('rus', 'ua', 'en', 'sp', 'it', 'ge', 'fr', 'por', 'bel');
if ($act && in_array($act, $do))
{

echo '<div class="gmenu"><b>'.$name_liga.'</b></div>';
echo '<div class="c">
<center><img src="chemp/b_'.$act.'.jpg" alt=""/></center>';

echo '</div><div class="c">';

$q1 = mysql_query("SELECT * FROM `team_2` where `strana`='".$act."' ORDER BY `oo` DESC, `raz` DESC, `mz` DESC ;");

$mesto = 1;

echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">';

echo '
<tr bgcolor="dddddd" align="center" class="whiteheader" >
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
if ($datauser['id'] && $datauser[manager2] == $arr[id])
{
echo '<tr bgcolor="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '
<td width="5%" align="center">'.$mesto.'</td>
<td> 
<a href="match.php?id='.$arr[id].'">'.$arr[name].'</a> ['.$arr[lvl].']</td>
<td align="center">'.$arr[ii].'</td>
<td align="center">'.$arr[vv].'</td>
<td align="center">'.$arr[nn].'</td>
<td align="center">'.$arr[pp].'</td>
<td align="center">'.$arr[mz].'-'.$arr[mp].'</td>
<td align="center"><font color="green"><b>'.$arr[oo].'</b></font></td>
';	

echo '</tr>';

if ($mesto >= 1 && $mesto <= 5 )
{
//СОЗДАЁМ ЛЧ
mysql_query("insert into `liga_group_2` set 
`group`='', 
`id_team`='".$arr[id]."', 
`name_team`='".$arr[name]."',
`level_team`='".$arr[lvl]."'
;");
}

++$mesto;
++$i;
}

echo '</table>';
echo '</div><div class="c">';
echo '<p><a href="calendar.php?act='.$act.'">Календарь</a></p>
</div>';
require_once ("incfiles/end.php");
exit;
}
echo '<div class="gmenu"><b>Чемпионаты</b></div>';



echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
';

echo '<tr bgcolor="ffffff">';
echo '<td width="32px" align="center"><img width="40" src="chemp/s_rus.jpg" alt=""/></td>';
echo '<td><a href="chemp.php?act=rus">Россия. Премьер Лига</a></td></tr>';

echo '<tr bgcolor="ffffff">';
echo '<td width="32px" align="center"><img width="40" src="chemp/s_ua.jpg" alt=""/></td>';
echo '<td><a href="chemp.php?act=ua">Украина. Премьер Лига</a></td></tr>';

echo '<tr bgcolor="ffffff">';
echo '<td width="32px" align="center"><img width="40" src="chemp/s_en.jpg" alt=""/></td>';
echo '<td><a href="chemp.php?act=en">Англия. Премьер Лига</a></td></tr>';

echo '<tr bgcolor="ffffff">';
echo '<td width="32px" align="center"><img width="40" src="chemp/s_sp.jpg" alt=""/></td>';
echo '<td><a href="chemp.php?act=sp">Испания. Примера</a></td></tr>';

echo '<tr bgcolor="ffffff">';
echo '<td width="32px" align="center"><img width="40" src="chemp/s_it.jpg" alt=""/></td>';
echo '<td><a href="chemp.php?act=it">Италия. Серия А</a></td></tr>';

 echo '<tr bgcolor="ffffff">';
 echo '<td width="32px" align="center"><img width="40" src="chemp/s_ge.jpg" alt=""/></td>';
 echo '<td><a href="chemp.php?act=ge">Германия. Бундеслига</a></td></tr>';

 echo '<tr bgcolor="ffffff">';
 echo '<td width="32px" align="center"><img width="40" src="chemp/s_fr.jpg" alt=""/></td>';
echo '<td><a href="chemp.php?act=fr">Франция. Лига 1</a></td></tr>';
 
  echo '<tr bgcolor="ffffff">';
 echo '<td width="32px" align="center"><img width="40" src="chemp/s_bel.jpg" alt=""/></td>';
 echo '<td><a href="chemp.php?act=bel"> Бельгия. Юпитер Лига</a></td></tr>';
 
  echo '<tr bgcolor="ffffff">';
 echo '<td width="32px" align="center"><img width="40" src="chemp/s_por.jpg" alt=""/></td>';
 echo '<td><a href="chemp.php?act=por"> Португалия. Лига Сагреш</a></td></tr>';
 

echo '<tr bgcolor="ffffff">';
echo '<td width="32px" align="center"><img width="40" src="chemp/s_liga.jpg" alt=""/></td>';
echo '<td><a href="liga">Лига Чемпионов</a></td></tr>';

echo '</table>';


echo '<br/><a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
