<?php
define('_IN_JOHNCMS', 1);
$headmod = 'manager';
$textl = 'Админка';
$rootpath = '../../';
require_once ("../../incfiles/core.php");
require_once ("../../incfiles/head.php");
require_once ('../../incfiles/class_upload.php');

if (!$id){
echo '<div class="rmenu">Союза не существует</div>';
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
exit;
}
$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arq = mysql_fetch_array($q);


if ($user_id  == $arq['id_prez'] || $rights>=9)
{

$array = array (
    'addcup',
    'deltur',
    
    
    'priz',
    'kalend',
    'rozp',
    'lc',
    'liga',
    'upl',
    'team',
    'addmoney',
    'delmoney',
    'divizion',
    'zav',
    'addteam',
    'addplay',
    'delman',
    'zay',
    'dom',
    'deldom',
    'bazar',
    'delbazar',
    'clean',
    'sponsor',
    'addsponsor',
    'delsponsor',
    'files',
    'filter',
    'restore'
);
if (in_array($act, $array) && file_exists($act . '.php')) {
    require_once($act . '.php');
} else {
    require_once('../../incfiles/head.php');


				echo '<div class="phdr"><b>Админ-панель</b></div><p><ul>';
                echo '<li><a href="admin.php?act=addcup&amp;id='.$id.'">Управление кубками</a></li>';
                echo '</ul></p>';




}
echo'<a href="group.php?id='.$id.'">Вернуться в союз</a>';
}else{
echo '<div class="rmenu">Вы не являетесь президентом союза.</div>';
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
exit;
}
require_once ("../../incfiles/end.php");
?>