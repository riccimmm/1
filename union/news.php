<?php
define('_IN_JOHNCMS', 1);
$headmod = 'union';
$textl = 'Союз. Новости';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");


$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

// Выводим новости

echo '<div class="bmenu"><b>Новости</b></div>';
$news = htmlentities($arr['news'], ENT_QUOTES, 'UTF-8');
$news = checkout($arr['news'], 1, 1);
$news = str_replace("\r\n", "<br/>", $news);

echo '<div class="c">';
echo '' . $news . '';

if ($datauser[id] == $arr['id_prez'] || $rights >= 6)
{
echo '<br/><a href="news.php?act=edit&amp;id='.$arr['id'].'">Редактировать</a>';
}

echo '</div>';

// Добавляем новость

if ($act == "edit")
{
if ($datauser[id] == $arr['id_prez'] || $rights >= 6)
{
if (isset($_POST['submit']))
{
$news = htmlspecialchars($_POST['news'], ENT_QUOTES, 'UTF-8');
mysql_query("update `union` set `news`='" . $news . "' where `id`='" . $arr['id'] . "' LIMIT 1;");
header('location: news.php?act=edit&id='.$arr['id'].'');
}
else
{
echo '<div class="bmenu"><b>Редактор</b></div>';
echo '<div class="c">';
echo '<form action="news.php?act=edit&amp;id='.$arr['id'].'" method="post" name="id">';
$news = htmlentities($arr['news'], ENT_QUOTES, 'UTF-8');
echo '<textarea cols="57" rows="20" name="news">'.$news.'</textarea><br/>';
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