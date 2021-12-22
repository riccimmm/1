<?php
define('_IN_JOHNCMS', 1);
$headmod = 'friendly';
$textl = 'Товарищеские матчи';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");

$q = @mysql_query("select * from `team_2` where id='" . $datauser[manager2] . "' LIMIT 1;");
$kom = @mysql_fetch_array($q);

if (empty($kom[id]))
{
echo display_error('У вас нет команды');
require_once ("../incfiles/end.php");
exit;
}


$frendtime  = $realtime - 3600;
$req = mysql_query("SELECT * FROM `frend_2` where time > '" . $frendtime . "' order by time desc;");
$total = mysql_num_rows($req);

echo '<div class="phdr"><b>Товарищеские матчи</b></div>';

echo '<div class="c"><p><a href="/friendly/say.php">Подать заявку</a> | <a href="/friendly/index.php?s='.rand(1000,9999).'">Обновить</a></p></div>';
echo '<div class="c">';

echo '<table id="example">';
echo '
<tr bgcolor="40B832" align="center" class="whiteheader">
<td><b>Время</b></td>
<td align="center"><b>Команды</b></td>
<td><b>Действие</b></td>
</tr>
';

while ($arr = mysql_fetch_array($req))
{
echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="evenrows">';

echo '<td width="10%" align="center">'.date("H:i", $arr['time']).'</td><td>';


// ПОДАВШАЯ
echo '<a href="http://m.futmen.net/team.php?id='.$arr[id_team1].'">'.$arr[name_team1].'</a> ['.$arr[level_team1].']';	

if (!empty($arr[id_team2]))
{

echo ' - ';

// ПРИНЯВШАЯ
echo '<a href="http://m.futmen.net/team.php?id='.$arr[id_team2].'">'.$arr[name_team2].'</a> ['.$arr[level_team2].']';	
}


echo '</td>';	


if ($arr[id_team1] == $datauser[manager2])
{

if (!empty($arr[id_team2]))
{
echo '<td width="20%" align="center"><a href="/friendly/play.php?id='.$arr[id].'">Сыграть</a></td>';	
}
else
{
echo '<td></td>';	
}


}
else
{

if ($arr[id_team2] == $datauser[manager2])
{
echo '<td width="20%" align="center"><a href="/friendly/no.php?id='.$arr[id].'">Отказаться</a></td>';	
}
else
{
echo '<td width="20%" align="center"><a href="/friendly/yes.php?id='.$arr[id].'">Принять</a></td>';	
}

}


		
echo '</tr>';
++$i;
}
echo '</table>';
echo '</div>';

echo '<div class="c"><p>Всего: '.$total.'</p></div>';

require_once ("../incfiles/end.php");
?>