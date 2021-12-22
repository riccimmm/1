<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

echo '<div class="gmenu"><b>Зал трофеев</b></div>';

// ЗАЛ ТРОФЕЕВ
$req = mysql_query("SELECT COUNT(*) FROM `priz_2` where win = '" . $id . "'");
$total = mysql_result($req, 0);

$req = mysql_query("SELECT * FROM `priz_2` where win = '" . $id . "' order by time desc LIMIT " . $start . ", 20;");


echo '<table id="example">';

while ($arr = mysql_fetch_array($req))
{

echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="evenrows">';
$req2 = mysql_query("SELECT * FROM `tournaments_2` where id = '" . $arr[id_cup] . "' LIMIT 1;");
$arr2 = mysql_fetch_array($req2);
echo '<td width="32px" align="center">';

echo '<img width="50" src="img/'.$arr2[path].'.jpg" alt=""/>';
echo '</td>';

echo '<td valign="top">
<a href="'.$arr[url].'"><b>'.$arr[name].'</b></a><br/>
Время: '.date("d.m.Y H:i", $arr['time']).'<br/>
Приз: '.$arr['priz'].' €
</td>';

	
echo '</tr>';
	
++$i;
}
echo '</table>';

echo '<div class="c"><p>Всего: '.$total.'';
if ($total > 20)
{echo '<div style="float: right;">' . pagenav('winner.php?id=' . $id . '&amp;', $start, $total, 20) . '</div>';}
echo '</p></div>';
echo'<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
