<?php
define('_IN_JOHNCMS', 1);

$headmod = 'union';
$textl = 'Союзы';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");
require_once ("../incfiles/manag2.php");

echo '<div class="c"><b>Союзы</b></div>';


if ($rights == 9)
  echo '<div class="menu"><a href="adm_msg.php">Рассылка всем кто есть в союзах</a></div>';

$q1 = mysql_query("SELECT * FROM `union` ORDER BY `players` DESC;");

$mesto = $start + 1;

echo '<table id="example">';
while ($res = mysql_fetch_array($q1))
{


if (!empty($_SESSION['uid']) && $res[id] == $datauser[union])
{
echo '<tr class="redrows">';
}
else
{
echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="oddrows">';
}

echo '<td width="5%" align="center">'.$mesto.'</td>';
echo '<td><img src="/union/logo/small'.$res[unionlogo].'" alt=""/> <a href="/union/group.php?id='.$res[id].'">'.$res[name].'</a></td>
<td width="10%" align="center"><font color="green"><b>'.$res[players].'</b></font></td>';	
echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';


require_once ("../incfiles/end.php");
?>