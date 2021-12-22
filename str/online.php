<?php

define('_IN_JOHNCMS', 1);
$headmod = 'online';
$textl = 'Онлайн';
require_once('../incfiles/core.php');
require_once('../incfiles/head.php');	
echo '<div class="gmenu">Список ' . ($act == 'guest' ? 'гостей' : 'онлайнеров') . '</div>';
$onltime = $realtime - 300;
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `" . ($act == 'guest' ? 'cms_guests' : 'users') . "` WHERE `lastdate` > '$onltime'"), 0);
if ($total) {
    $req = mysql_query("SELECT * FROM `" . ($act == 'guest' ? 'cms_guests' : 'users') . "` WHERE `lastdate` > '$onltime' ORDER BY " . ($act == 'guest' ? "`movings` DESC" : "`name` ASC") . " LIMIT $start,$kmess");
    while ($res = mysql_fetch_assoc($req)) {
        echo ($i % 2) ? '<a class="at">' : '<a class="at">';
		
		
		
		
		if ($user_id) {
            // Вычисляем местоположение
            $where = explode(",", $res['place']);
            switch ($where[0]) {
                case 'forumfiles':
                    $place = '<a href="../forum/index.php?act=files">Файлы форума</a>';
                    break;

                case 'forumwho':
                    $place = '<a href="../forum/index.php?act=who">Смотрит кто в форуме?</a>';
                    break;

                case 'anketa':
                    $place = '<a href="anketa.php">Анкета</a>';
                    break;

                case 'settings':
                    $place = '<a href="usset.php">Настройки</a>';
                    break;

                case 'users':
                    $place = '<a href="users.php">Список пользователей</a>';
                    break;
					
				case 'exit':
                    $place = '<a href="'.$home.'/exit.php">Ушел с сайта</a>';
                    break;

                case 'online':
                    $place = 'Тут, в списке';
                    break;

                case 'privat':
                case 'pradd':
                    $place = '<a href="../index.php?act=cab">Приват</a>';
                    break;

                case 'birth':
                    $place = '<a href="brd.php">Список именинников</a>';
                    break;

                case 'read':
                    $place = '<a href="../read.php">Читает FAQ</a>';
                    break;

                case 'load':
                    $place = '<a href="../download/index.php">Загрузки</a>';
                    break;

                case 'gallery':
                    $place = '<a href="../gallery/index.php">Галерея</a>';
                    break;

                case 'forum':
                case 'forums':
                    $place = '<a href="../forum/index.php">Форум</a>&nbsp;/&nbsp;<a href="../forum/index.php?act=who">&gt;&gt;</a>';
                    break;

                case 'chat':
                    $place = '<a href="../chat/index.php">Чат</a>';
                    break;

                case 'guest':
                    $place = '<a href="guest.php">Гостевая</a>';
                    break;

                case 'lib':
                    $place = '<a href="../library/index.php">Библиотека</a>';
                    break;

                case 'mainpage':
                default:
                    $place = '<a href="../index.php">Главная</a>';
                    break;
            }
        }
		
		
		
		
        
        echo show_user($res, 0, ($act == 'guest' || ($rights >= 1) ? ($rights >= 1 ? 2 : 1) : 0), ' <br /><img src="../images/info.png" width="16" height="16" align="middle" />&nbsp;' . $place);
        echo '</a>';
        ++$i;
    }
} else {
    echo '<div class="gmenu"><p>Никого нет</p></div>';
}
if ($total > 10) {
    echo '<p>' . pagenav('online.php?' . ($act == 'guest' ? 'act=guest&amp;' : ''), $start, $total, $kmess) . '</p>';
    echo '<p><form action="online.php" method="get"><input type="text" name="page" size="2"/>' . ($act == 'guest' ? '<input type="hidden" value="guest" name="act" />' : '') .
        '<input type="submit" value="К странице &gt;&gt;"/></form></p>';
}
if ($user_id)
    echo '<a class="at" href="online.php' . ($act == 'guest' ? '">Показать авторизованных' : '?act=guest">Показать гостей') . '</a>';
require_once('../incfiles/end.php');

?>