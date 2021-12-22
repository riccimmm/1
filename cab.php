<?php
define('_IN_JOHNCMS', 1);
$textl = 'Кабинет';
// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';
require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
if (isset ($ban)){
    echo'<div class="rmenu"><b>Доступ закрыт!</b></div>';
	require_once ('incfiles/end.php');
	exit;
	}
       if (!$user_id) {
            echo display_error('Кабинет только для зарегистрированных');
            require_once ('incfiles/end.php');
            exit;
        }

		if ($id && $id != $user_id) {
    // Если был запрос на юзера, то получаем его данные
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        $textl = 'Анкета: ' . $user['name'];
    } else {
        require_once('incfiles/head.php');
        echo display_error('Такого пользователя не существует');
        require_once("/incfiles/end.php");
        exit;
    }
} else {
    $id = false;
    $textl = 'Личная анкета';
    $user = $datauser;
}
		
    echo '<div class="gmenu"><b>Мой кабинет</b><span style="float:right;">Привет ' . $user['name'] . '!</span></div>';

	
				echo '<div class="tmn">Мой профиль</div>';
				echo '<div class="menu"><a href="str/anketa.php">Моя страничка</a></div>';
				echo '<div class="menu"><a href="str/my_data.php?id=' . $user['id'] . '">Редактировать анкету</a></div>';
				
				
				
				echo '<div class="tmn">Моя активность</div>';
		        echo '<div class="menu"><a href="str/my_stat.php?act=forum">Последние записи</a></div>';
				echo '<div class="menu"><a href="str/my_stat.php">Моя Статистика</a></div>';
	
				echo '<div class="tmn">Моя почта</div>';
				$count_mail = mysql_result(mysql_query("SELECT COUNT(*) FROM `privat` WHERE `user` = '$login' AND `type` = 'in'"), 0);
				$count_newmail = mysql_result(mysql_query("SELECT COUNT(*) FROM `privat` WHERE `user` = '" . $login . "' AND `type` = 'in' AND `chit` = 'no'"), 0);
				echo '<div class="menu"><a href="str/pradd.php?act=in">Входящие</a>&nbsp;(' . $count_mail . ($count_newmail ? '&nbsp;/&nbsp;<span class="red"><a href="str/pradd.php?act=in&amp;new">+' . $count_newmail . '</a></span>' : '') . ')</div>';
				$count_sentmail = mysql_result(mysql_query("SELECT COUNT(*) FROM `privat` WHERE `author` = '$login' AND `type` = 'out'"), 0);
				$count_sentunread = mysql_result(mysql_query("SELECT COUNT(*) FROM `privat` WHERE `author` = '$login' AND `type` = 'out' AND `chit` = 'no'"), 0);
				echo '<div class="menu"><a href="str/pradd.php?act=out">Отправленные</a>&nbsp;(' . $count_sentmail . ($count_sentunread ? '&nbsp;/&nbsp;<span class="red">' . $count_sentunread . '</span>' : '') . ')</div>';
				echo '<div class="menu"><a href="str/pradd.php?act=write">Написать сообщения</a></div>';
				$count_contacts = mysql_result(mysql_query("SELECT COUNT(*) FROM `privat` WHERE `me` = '$login' AND `cont` != ''"), 0);
				echo '<div class="menu"><a href="str/cont.php">Контакты</a>&nbsp;(' . $count_contacts . ')</div>';
				$count_ignor = mysql_result(mysql_query("SELECT COUNT(*) FROM `privat` WHERE `me` = '$login' AND `ignor` != ''"), 0);
				echo '<div class="menu"><a href="str/ignor.php">Игнор</a>&nbsp;(' . $count_ignor . ')</div>';
					
				echo '<div class="tmn">Мои настройки</div>';
				echo '<div class="menu"><a href="str/my_pass.php">Сменить пароль</a></div>';
				echo '<div class="menu"><a href="str/my_set.php">Общие настройки</a></div>';
				echo '<div class="menu"><a href="str/my_set.php?act=forum">Форум</a></div>';
				
				if ($rights >= 1) {
				echo '<div class="tmn">Админ-Панель</div>';
				$guest = gbook(2);
				echo '<div class="menu"><a href="str/guest.php?act=ga&amp;do=set">Админ-Клуб</a>&nbsp;(<span class="red">' . $guest . '</span>)</div>';
				echo '<div class="menu"><a href="' . $admp . '/index.php">Админка сайта</a></div>';
				echo '<div class="menu"><a href="admin.php">Админка менеджера</a></div>';
				}
				echo '<div class="menu"><a href="exit.php">Выход из сайта</a></div>';
   

require_once ('incfiles/end.php');

?>