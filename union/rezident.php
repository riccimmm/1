<?php
define('_IN_JOHNCMS', 1);

$headmod = 'union';
$textl = 'Резиденты';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");

echo '<div class="gmenu"><b>Резиденты</b></div>';


$req = mysql_query("SELECT COUNT(*) FROM `team_2` where `union`= '" . $id . "' and `union_mod` = 1;");
$colmes = mysql_result($req, 0);

$q = mysql_query("select * from `union` where id = '" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../incfiles/end.php");
exit;
}


if ($arr[players] != $colmes)
{
mysql_query("update `union` set `players`='" . $colmes . "' where id='" . $arr[id] . "';");
}



$q1 = mysql_query("SELECT * FROM `team_2`  where `union`='" . $id . "' and `union_mod` = 1 ORDER BY `rate` DESC LIMIT " . $start . ", 20;");

$mesto = $start + 1;

echo '<table id="example">';

echo '
<tr>
<td><b>№</b></td>
<td><b>Флаг</b></td>
<td><b>Команда</b></td>
<td><b>Опыт</b></td>
<td><b>Кредит</b></td>
</tr>
';

while ($res = mysql_fetch_array($q1))
{

if (!empty($_SESSION['uid']) && $user_id == $res[id_admin])
{
echo '<tr class="redrows">';
}
else
{
echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="evenrows">';
}

echo '<td>'.$mesto.'</td>';

echo '<td><img src="../flag/' . $res['strana'] . '.png" alt="" /></td><td>';

if (!empty($res[logo]))
{
echo '<img src="../manager/logo/small' . $res[logo] . '" alt=""/> ';
}
else
{
echo '<img src="../manager/logo/smallnologo.jpg" alt=""/> ';
}

echo '<a href="/team.php?id=' . $res['id'] . '">'.$res[name].'</a> ['.$res[lvl].']';

if ($arr['id_prez'] == $user_id)
  echo '&nbsp;<span class="red"><a href="del_rez.php?un=' . $id . '&amp;rez=' . $res['id'] . '" title="Нажмите для увольнения этой команды из союза">[уволить]</a></span>';

echo '</td>
<td><font color="green"><b>'.$res[rate].'</b></font></td>';

if (!empty($res[kred]))
{
echo '<td> Кредит ' . $res[kred] . ' €</td>';
}
	
echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';

if ($colmes > 20)
{
echo '<div class="c">' . pagenav('rezident.php?id='.$arr['id'].'&amp;', $start, $colmes, 20) . '</div>';
}

echo '<div class="c">Всего: '.$colmes.'</div>';

require_once ("../incfiles/end.php");
?>