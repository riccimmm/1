<?php
define('_IN_JOHNCMS', 1);
$headmod = 'union';
$textl = 'Союз. зал славы!';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");


$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

// Выводим информацию
echo '<div class="bmenu"><b>Зал славы</b></div>';
$slava = htmlentities($arr['slava'], ENT_QUOTES, 'UTF-8');
$slava = checkout($arr['slava'], 1, 1);
$slava = str_replace("\r\n", "<br/>", $slava);

echo '<div class="c">';
echo '' . $slava . '';

if ($datauser[id] == $arr['id_prez'] || $rights >= 6)
{
echo '<br/><a href="slava.php?act=edit&amp;id='.$arr['id'].'">Редактировать</a>';
}

echo '</div>';

// Добавляем информацию
if ($act == "edit")
{
if ($datauser[id] == $arr['id_prez'] || $rights >= 6)
{
if (isset($_POST['submit']))
{
$slava = htmlspecialchars($_POST['slava'], ENT_QUOTES, 'UTF-8');
mysql_query("update `union` set `slava`='" . $slava . "' where `id`='" . $arr['id'] . "' LIMIT 1;");
header('location: slava.php?act=edit&id='.$arr['id'].'');
}
else
{
echo '<div class="bmenu"><b>Информация</b></div>';
echo '<div class="c">';
echo '<form action="slava.php?act=edit&amp;id='.$arr['id'].'" method="post" name="id">';
$slava = htmlentities($arr['slava'], ENT_QUOTES, 'UTF-8');
echo '<textarea cols="57" rows="20" name="slava">'.$slava.'</textarea><br/>';
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