<?php
define('_IN_JOHNCMS', 1);
$headmod = 'union';
$textl = 'Союз. Информация';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");


$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

// Выводим информацию
echo '<div class="bmenu"><b>Информация</b></div>';
$info = htmlentities($arr['info'], ENT_QUOTES, 'UTF-8');
$info = checkout($arr['info'], 1, 1);
$info = str_replace("\r\n", "<br/>", $info);

echo '<div class="c">';
echo '' . $info . '';

if ($datauser[id] == $arr['id_prez'] || $rights >= 6)
{
echo '<br/><a href="info.php?act=edit&amp;id='.$arr['id'].'">Редактировать</a>';
}

echo '</div>';

// Добавляем информацию
if ($act == "edit")
{
if ($datauser[id] == $arr['id_prez'] || $rights >= 6)
{
if (isset($_POST['submit']))
{
$info = htmlspecialchars($_POST['info'], ENT_QUOTES, 'UTF-8');
mysql_query("update `union` set `info`='" . $info . "' where `id`='" . $arr['id'] . "' LIMIT 1;");
header('location: info.php?act=edit&id='.$arr['id'].'');
}
else
{
echo '<div class="bmenu"><b>Информация</b></div>';
echo '<div class="c">';
echo '<form action="info.php?act=edit&amp;id='.$arr['id'].'" method="post" name="id">';
$info = htmlentities($arr['info'], ENT_QUOTES, 'UTF-8');
echo '<textarea cols="57" rows="20" name="info">'.$info.'</textarea><br/>';
echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Редактировать'/></form>";
echo '</div>';
}
echo '<div class="c"><a href="group.php?id='.$arr['id'].'">Вернутся</a></div>';
}
require_once ("../incfiles/end.php");
exit;
}

require_once ("../incfiles/end.php");
?>