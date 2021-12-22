<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="login.php">авторизованным</a> посетителям';
if ($error) {
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
	require_once ("incfiles/end.php");
    exit;
}
if (mysql_num_rows($manager) == 0)
{
echo "Команды не существует<br/>";
require_once ("incfiles/end.php");
exit;
}
echo '<div class="phdr2"><b>Рейтинг</b></div>';
echo '<div class="c"><img src="img/reting/cups.png" alt=""/> <a href="rating.php?act=cup">По кубкам</a></div>';
echo '<div class="c"><img src="img/rating.png" alt=""/> <a href="rating.php">По опыту</a></div>';
echo '<div class="c"><img src="img/rating.png" alt=""/> <a href="rating.php?act=fans">По фанатам</a></div>';
echo '<div class="c"><img src="img/rating.png" alt=""/> <a href="rating.php?act=slava">По славе</a></div>';
echo '<div class="c"><img src="img/reting/stad.jpg" alt=""/> <a href="rating.php?act=stadium">По стадионам</a></div>';
echo '<div class="c"><img src="img/rating.png" alt=""/> <a href="bomb.php?act=all">Бомбардиры</a></div>';


echo'<br/><a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
