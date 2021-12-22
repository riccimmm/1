<?php
define('_IN_JOHNCMS', 1);
$headmod = 'manager';
$rootpath = '../../';
$textl = 'Кубки союза';
require_once ("../../incfiles/core.php");
require_once ("../../incfiles/head.php");

 echo '<style>
.close
{
background: #ff0000;
font-size:x-small;
color:white;
padding-left:2px;
padding-right:2px;
}

.open
{
background: #00ff00;
font-size:x-small;
color:white;
padding-left:2px;
padding-right:2px;
}
</style>';

// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="../login.php">авторизованным</a> посетителям';
if ($error) {
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
    require_once ("../../incfiles/end.php");
    exit;
}
/*
if (!empty($datauser['manager'])) {
    if (mysql_num_rows($manager) == 0) {
        echo "Команды не существует<br/>";
        require_once ("../incfiles/end.php");
        exit;
    }
*/

$reqq = mysql_query("SELECT * FROM `team_2` where `id`='" . $datauser[manager2] ."' AND `union`='$id' LIMIT 1;");
$uch = mysql_num_rows($reqq);

if ($rights <7){
if ($uch == 0) {
require_once ("../../incfiles/head.php");
    echo '<div class="rmenu">';
    echo "Вы не учасник союза и не можете просматривать кубки!</div>";
    require_once ("../../incfiles/end.php");
    exit;
}}


if (!$id){
echo '<div class="rmenu">Союза не существует</div>';
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
exit;
}

$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arq = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="rmenu">Союза не существует</div>';
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
exit;
}

echo '<div class="phdr"><a href="group.php?id='.$id.'">Союз: '.$arq[name].'</a> | Кубки</div>';


$total_tourn = mysql_result(mysql_query("SELECT COUNT(*) FROM `union_cup` WHERE `union`='" . $id . "' "), 0);

if ($total_tourn>0)
{
    $req = mysql_query("SELECT * FROM `union_cup` WHERE `union`='" . $id . "' order by `status`, `id` asc;");
    while ($arr = mysql_fetch_array($req)) {
        $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `` WHERE `chemp`='$arr[id]' "), 0);
        echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '' : '';



if ($arr[status]==0){$finish = ' <span class="open">ON</span>';}else{$finish = ' <span class="close">OFF</span>';}

echo '
<table id="example">
<tr class="oddrows">
<td align="center"><img src="img/' . $arr['img'] . '_small.jpg"  alt="' .$arr['name'] . ' " /></td>
<td width="100%"><a href="cup.php?cup=' . $arr['id'] . '&amp;id='.$id.'">' . $arr['name'] . '</a> (' . $arr['priz'] . ' €)&nbsp;'.$finish .'<div class="sub">
Начало: [' . date("d.m.y / H:i", $arr['time']) . ']<br/>';
if ($arr[status]==1)
$total = 16;
echo 'Участников: ' . $total . '  из 16</div>';


echo '</td></tr></table><hr/>';
		++$i;
    }
    
    echo '<div class="phdr">';
   echo "Всего кубков: $total_tourn";    
    echo '</div>';  


    }else
    {
    echo '<div class="rmenu">';
   echo "В этом союзе нет турниров!";    
    echo '</div>';
    }
    
if ($user_id == $arq[id_prez] || $rights>7) {
    echo '<div class="func">';
       echo "<b><a href='admin.php?act=addcup&amp;id=$id'>Добавить кубок</a></b>";
echo '</div>';    }
    

echo '</div>';


    echo '<a href="group.php?id='.$id.'">Вернуться</a><br/>';


require_once ("../../incfiles/end.php");
?>