<?php
define('_IN_JOHNCMS', 1);
$headmod = 'fegokreohie4lkn';
$textl = 'Стена союза';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");

$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../incfiles/end.php");
exit;
}

if ($rights >= 6 || $datauser[id] == $arr['id_prez']){
if(empty($_GET['send'])){
echo 'Вы действительно желаете очистить стену?<br/>';
echo '<a href="cleanwall.php?id='.$arr['id'].'&send=yes">Да</a> / <a href="wall.php?id='.$arr['id'].'">Нет</a>';
} else {
mysql_query("delete from `stena` where `idgrupa`='".$id."';");
header("location: wall.php?id=".$id); die(); }
} else { header("location: wall.php?id=".$id); die(); }

require_once ("../incfiles/end.php");
?>
