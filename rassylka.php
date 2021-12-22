<?php
define('_IN_JOHNCMS', 1);
$rootpath = '';
$textl = "Рассылка сообщений юзерам";
require_once ("incfiles/core.php");
require_once ("incfiles/head.php");

//Проверка прав доступа.если меньше 6 то посылаем нафиг :)
if ($rights<7) {
echo '<div class="phdr" style="font-weight:bold;">Облом!</div>';
echo 'Доступ на данную страницу разрешен только Администрации сайта!';
require_once ("incfiles/end.php");
exit;
}

switch($_GET['act']) {

//Страница ввода текста сообщения.
default:
echo '<div class="phdr" style="font-weight:bold;">Рассылка сообщений</div>' . "\n";
echo '<div class="list1"><p><form action="rassylka.php?act=start" method="POST"><br />';
echo '<b>Кому отправляем</b><br />';
echo '<select name="sel"><option value="all">Всем</option><option value="adm">Админам + Всем модерам</option><option value="smdadm">Админам + Старшим модерам</option><option value="m">Всем парням</option><option value="zh">Всем девушкам</option></select><br />' . "\n";
echo '<br /><b>Текст сообщения: </b><br />';
echo '<textarea name="message" rows="5"></textarea><br />';
echo '<p>[<a href="' .$home. '/str/smile.php?">смайлы</a>] [<a href="' .$home. '/read.php?do=forumfaq">теги</a>]</p>';
echo '<input type="submit" value="Отправить!" />' . "\n";
echo '</form></p></div>';
echo '<div class="menu">&raquo; <a href="' .$home. '/index.php?act=cab">В кабинет</a><br />&raquo; <a href="' .$home.'/rassylka.php?act=stat">Статистика рассылок</a></div>';
break;

//Проверка,обработка и отправка сообщений
case 'start':

if (empty($_POST['message'])) {
echo '<b>Ошибка!</b>Вы не ввели текст сообщения!<br />&raquo; <a href="rassylka.php">Назад</a>';
require_once ("incfiles/end.php");
exit;
}
echo '<div class="phdr" style="font-weight:bold;">Результаты рассылки</div>' . "\n";
echo '<div class="b">';
$soob = check(trim($_POST['message']));

//Отправка всем пользователям
if ($_POST['sel'] == 'all') {
$colus = mysql_result(mysql_query("SELECT COUNT(*) FROM `users`;"), 0);
$asp = mysql_query("SELECT `name` FROM `users` ORDER BY `id` DESC LIMIT $colus;");
$wx = 0;
while ($res = mysql_fetch_assoc($asp)) {
$usname = $res['name'];
if ($usname == $login) { continue; } 
mysql_query("INSERT INTO `privat` VALUES(0,'" .$usname. "','" .$soob. "','" .$realtime. "','" .$login. "','in','no','Рассылка','0','','','','');");
$wx++;
}
echo '<b>Рассылка успешно выполнена!</b><br />
Отправлено <b>' .$wx. '</b> сообщений всем пользователям!';
$type_r = 1;
}

//Отправка сообщений всем модерам и админам

elseif ($_POST['sel'] == 'adm') {
$colad = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `rights`>= 1;"), 0);
$asp = mysql_query("SELECT `name` FROM `users` WHERE `rights`>=1 ORDER BY `id` DESC LIMIT $colad;");
$wx = 0;
while ($res = mysql_fetch_assoc($asp)) {
$usname = $res['name'];
if ($usname == $login) { continue; } 
mysql_query("INSERT INTO `privat` VALUES(0,'" .$usname. "','" .$soob. "','" .$realtime. "','" .$login. "','in','no','Рассылка','0','','','','');");
$wx++;
}
echo '<b>Рассылка успешно выполнена!</b><br />
Отправлено <b>' .$wx. '</b> сообщений всем Модерам и Админам!';
$type_r = 2;
}

//Отправка сообщений всем Старшим модерам и админам

elseif ($_POST['sel'] == 'smdadm') {
$coladm = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `rights`>=6;"), 0);
$asp = mysql_query("SELECT `name` FROM `users` WHERE `rights`>=6 ORDER BY `id` DESC LIMIT $coladm;");
$wx = 0;
while ($res = mysql_fetch_assoc($asp)) {
$usname = $res['name'];
if ($usname == $login) { continue; } 
mysql_query("INSERT INTO `privat` VALUES(0,'" .$usname. "','" .$soob. "','" .$realtime. "','" .$login. "','in','no','Рассылка','0','','','','');");
$wx++;
}
echo '<b>Рассылка успешно выполнена!</b><br />
Отправлено <b>' .$wx. '</b> сообщений всем Старшим модерам и Админам!';
$type_r = 3;
}

//Отправка сообщений всем парням
if ($_POST['sel'] == 'm') {
$colm = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `sex`='m';"), 0);
$asp = mysql_query("SELECT `name` FROM `users` WHERE `sex`='m' ORDER BY `id` DESC LIMIT $colm;");
$wx = 0;
while ($res = mysql_fetch_assoc($asp)) {
$usname = $res['name'];
if ($usname == $login) { continue; } 
mysql_query("INSERT INTO `privat` VALUES(0,'" .$usname. "','" .$soob. "','" .$realtime. "','" .$login. "','in','no','Рассылка','0','','','','');");
$wx++;
}
echo '<b>Рассылка успешно выполнена!</b><br />
Отправлено <b>' .$wx. '</b> сообщений всем Парням!'; 
$type_r = 4;
}

//Отправка сообщении всем девушкам на сайте :)
elseif ($_POST['sel'] == 'zh') {
$colzh = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `sex`='zh';"), 0);
$asp = mysql_query("SELECT `name` FROM `users` WHERE `sex`='zh' ORDER BY `id` DESC LIMIT $colzh;");
$wx = 0;
while ($res = mysql_fetch_assoc($asp)) {
$usname = $res['name'];
if ($usname == $login) { continue; } 
mysql_query("INSERT INTO `privat` VALUES(0,'" .$usname. "','" .$soob. "','" .$realtime. "','" .$login. "','in','no','Рассылка','0','','','','');");
$wx++;
}
echo '<b>Рассылка успешно выполнена!</b><br />
Отправлено <b>' .$wx. '</b> сообщений всем Девушкам!';
$type_r = 5;
}
echo '<br /></div><div class="menu">&raquo; <a href="rassylka.php">Назад</a><br />&raquo; <a href="rassylka.php?act=stat">Статистика рассылок</a></div>';
//Запись статистики
mysql_query("INSERT INTO `rass_stat` SET
`time`='" .$realtime. "',
`user_id`='" .$user_id. "',
`type`='" .$type_r."',
`mess`='" .$soob. "';");
break;

case 'stat':
$colmes = mysql_result(mysql_query("SELECT COUNT(*) FROM `rass_stat`;"), 0);
echo '<div class="phdr"><b>Статистика</b></div>';
echo '<div class="menu">Всего рассылок : (<span class="red" style="font-weight:bold;">' .$colmes. '</span>)</div>';
echo '<div class="rmenu">Последние рассылки</div>';
if ($colmes == 0) {
echo '<div class="c"><p>Сообщении нет!</p><br />&raquo; <a href="rassylka.php">Назад</a><br /></div>';
require_once ("incfiles/end.php");
exit;
}
$az = mysql_query("SELECT * FROM `rass_stat` ORDER BY `id` DESC LIMIT " .$start. ", " .$kmess. ";");
while ($ss = mysql_fetch_assoc($az)) {
echo ($i % 2) ? '<div class="c">' : '<div class="b">';
$idu = $ss['user_id'];
$ps = mysql_result(mysql_query("SELECT `name` FROM `users` WHERE `id`='" .$idu. "' LIMIT 1;"), 0);
echo 'Автор: <b><a href="' .$home. '/str/anketa.php?id=' .$idu. '">' .$ps. '</a></b> ';
$col_p = mysql_result(mysql_query("SELECT COUNT(*) FROM `rass_stat` WHERE `user_id`='" .$idu. "';"), 0);
echo '[' .$col_p. ']<br />';
echo 'Дата: <span class="green">' .date("d.m.y H:i", $ss['time']). '</span><br />';
echo 'Тип: <b>';
switch($ss['type']) {
case '1':
echo 'Всем';
break;
case '2':
echo 'Всем модерам и админам';
break;
case '3':
echo 'Старшим модерам и админам';
break;
case '4':
echo 'Всем парням';
break;
case '5':
echo 'Всем девушкам';
break;
}
echo '</b><br />';
echo "Сообщение: " .$ss['mess']. "<br /></div>";
$i++;
}
if ($colmes > $kmess) {
    echo '<div class="menu">'.pagenav('?act=stat&amp;', $start, $colmes, $kmess) . '</div>';
}
echo '<div class="phdr">&raquo; <a href="' .$home. '/index.php?act=cab">В кабинет</a></div>';
break;
}
require_once ("incfiles/end.php");
?>