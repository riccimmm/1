<?php
define('_IN_JOHNCMS', 1);
$headmod = 'w4oli5uht4whr';
$textl = 'Внутрисоюзные кубки';
$rootpath = '../../';
require_once ("../../incfiles/core.php");
require_once ("../../incfiles/head.php");

$union = abs(intval($_GET['union']));

$q = mysql_query("select * from `union` where id='" . $union . "' LIMIT 1;");
$arrz = mysql_fetch_assoc($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../../incfiles/end.php");
exit;
}


// КУБКОВЫЕ МАТЧИ
echo '<div class="bmenu"><b>Внутрисоюзные кубки</b></div>';

// Подсказка пользователю
if($user_id && ($datauser['hints'] == 1 || ($datauser['hints'] == 2 && $datauser['total_on_site'] < 84600))) {
	echo '<div class="help">Чтобы принять участие во внутрисоюзном кубке, необходимо вступить в союз, и подать заявку на участие в кубке. Кубок стартует когда набирается 8 или 16 команд, в зависимости от типа кубка. Если участников больше разрешенного лимита, то команды отбираются случайным образом.<br />' .
	'<a href="/str/my_set.php?submit=1&amp;act=helps&amp;hints=0">Отключить подсказки</a></div>';
}

$req = mysql_query("SELECT * FROM `r_union_cup` where `id_union` = '".$union."' order by time desc LIMIT 10;");
//$total = mysql_num_rows($req);

echo '<table id="example">';
	$n = 0;
		while ($arr = mysql_fetch_array($req)){ $n++;
echo '<tr class="oddrows">';
echo '<td width="';echo ($theme == "wap") ? '32' : '55';
echo 'px" align="center"><img width="48" height="48" src="/union/logo/';

if(file_exists('../logo/big'.$arr['id_union'].'.jpeg')){
echo ($theme == "wap") ? 'small' : 'big'; echo $arr['id_union'].'.jpeg" alt=""/></td>';
} else { echo 'empty.jpeg" alt=""/></td>'; }

echo '<td><a href="/union/tournament/cup.php?id='.$arr[id].'"><b>'.$arr['name'].'</b></a> '.date("H:i", $arr['time']).'<br/>';

$b = mysql_query("SELECT * FROM `r_union_bilet` where id_cup = '" . $arr[id] . "' order by time desc;");
$totalbilet = mysql_num_rows($b);

echo '
Приз: ' . $arr['priz'] . ' €<br/>
Участников: ' . $totalbilet . ' из '.(($arr['type'] == 1) ? 16 : 8).'<br/>
Уровень игрока: ';
if ($arr['ot'] == $arr['do'])
{echo ''.$arr['ot'] . '';}
else
{echo 'от '.$arr['ot'] . ' до '.$arr['do'] . '';}
if($arrz['id_prez'] == $user_id or $rights == 9) echo '<br/><a href="/union/tournament/delete.php?id='.$arr['id'].'">Удалить кубок</a>';
echo '</td></tr>';
}

if($n == 0) echo 'В данный момент нет кубков.';

echo '</table>';

echo '<div class="c">
Если кубок рассчитан на 16 команд, то победитель получает 1500 евро.<br/>
Если кубок рассчитан на 8 команд, то победитель получает 800 евро.<br/>
Победитель не получает дополнительные очки опыта, славы, фанатов.
</div>';

require_once ("../../incfiles/end.php");
?>
