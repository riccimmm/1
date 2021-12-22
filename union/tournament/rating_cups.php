<?php
define('_IN_JOHNCMS', 1);
$headmod = 'warhejske7rsey5e';
$textl = 'Рейтинг внутрисоюзных кубков';
$rootpath = '../../';
require_once ("../../incfiles/core.php");
require_once ("../../incfiles/head.php");

function mysort($a, $b) 
{
  if ($a['cups'] == $b['cups'])return 0;
  return ($a['cups'] < $b['cups']) ? 1 : -1;
}

$union = abs(intval($_GET['union']));


$q = mysql_query("select * from `union` where id='" . $union . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../../incfiles/end.php");
exit;
}

$kz = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$zq = @mysql_fetch_array($kz);

/* if($zq['union'] != $union){
echo '<div class="c">Только для участников союза.</div>';
require_once ("../../incfiles/end.php"); exit; } */


echo '<div class="gmenu"><b>Рейтинг</b></div>';

$club = array();
$qwer = mysql_query("SELECT * FROM `team_2` WHERE `union` = '".$union."';");
$cwer = mysql_num_rows($qwer);

if ($cwer > 0) // команды сушествуют
{
while ($mwer = mysql_fetch_assoc($qwer)) // создание массива
{
$ccup = mysql_num_rows(mysql_query("SELECT * FROM `priz_2` WHERE `id_union` = '".$union."' AND `win` = '" . $mwer['id'] . "'"));


$club[$mwer['id']] = array();
$club[$mwer['id']]['idclub'] = $mwer['id'];
$club[$mwer['id']]['lvl'] = $mwer['lvl'];
$club[$mwer['id']]['admin'] = $mwer['id_admin'];
$club[$mwer['id']]['name'] = $mwer['name'];
$club[$mwer['id']]['logo'] = $mwer['logo'];
$club[$mwer['id']]['cups'] = $ccup;
} // конец while


usort($club, "mysort");

echo '<table id="example">
     <tr bgcolor="40B832" align="center" class="whiteheader">
     <td><b>№</b></td>
     <td><b>Команда</b></td>
     <td><b>Кубки</b></td></tr>';

$i = 1;
while (list($key, $value) = each($club))
{
if (!empty($_SESSION['uid']) && $user_id == $value['id_admin'])echo '<tr class="redrows">';
else {echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="evenrows">';}

echo '<td width="5%" align="center">'.$i.'</td><td>';

if (!empty($value['logo']))echo '<img src="http://futteam.ru/manager/logo/small' . $value['logo'] . '" alt="" />';
else echo '<img src="http://futteam.ru/manager/logo/smallnologo.jpg" alt="" />';

echo ' <a href="/team/' . $value['idclub'] . '">'.$value['name'].'</a> ['.$value['lvl'].']</td>
<td width="10%" align="center"><font color="green"><b>'.$value['cups'].'</b></font></td>';	
echo '</tr>';

if ($i == 20)break;
$i++;
} // конец while


}
else echo '<tr><td>Нет команд</td></tr>';


echo '</table>';

echo '<div class="c">Всего: '.$cwer.'</div>';


require_once ("../../incfiles/end.php");
?>
