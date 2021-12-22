<?php
define('_IN_JOHNCMS', 1);
$headmod = 'tournament';
$textl = 'Кубковые турниры';
$rootpath = '../../';
require_once ("../../incfiles/core.php");
require_once ("../../incfiles/head.php");

$id = abs(intval($_GET['id']));
$q = @mysql_query("select * from `r_union_cup` where id='" . $id . "' LIMIT 1;");
$cup = @mysql_fetch_assoc($q);
$union = $cup['id_union'];

if (empty($cup[id]))
{
    echo display_error('Кубка не существует');
    require_once ('../../incfiles/end.php');
    exit;
}

$q = mysql_query("select * from `union` where id='" . $union . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../../incfiles/end.php");
exit;
}


if ($arr['id_prez'] == $user_id or $rights == 9) {
mysql_query("DELETE FROM `r_union_cup` WHERE `id` = '".$id."' LIMIT 1");
echo '<div class="c">Удалено</div>';
} else { echo '<div class="c">WTF?!</div>'; }

require_once ("../../incfiles/end.php");
?>
