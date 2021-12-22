<?php
define('_IN_JOHNCMS', 1);
$textl = 'Полная информация';
require_once ('../incfiles/core.php');
require_once ('../incfiles/head.php');
if (isset ($ban)){
    echo'<div class="rmenu"><b>Доступ закрыт!</b></div>';
	require_once ('../incfiles/end.php');
	exit;
	}
       if (!$user_id) {
            echo display_error('Анкета только для зарегистрированных');
            require_once ('../incfiles/end.php');
            exit;
        }

		if ($id && $id != $user_id) {
    // Если был запрос на юзера, то получаем его данные
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        $textl = 'Информация: ' . $user['name'];
    } else {
        require_once('incfiles/head.php');
        echo display_error('Такого пользователя не существует');
        require_once("../incfiles/end.php");
        exit;
    }
} else {
    $id = false;
    $textl = 'Полная информация';
    $user = $datauser;
}

if(!$id || $id == $user_id)
echo '<a class="at" href="my_data.php?id='.$user['id'].'"><img src="../images/icons/edit.png" height="14" width="14" />&nbsp;<b>Редактировать анкету</b></a>';


echo '<div class="b">Общая информация</div>';
echo '<div class="c"><small>Имя:</small> '.$user['imname'].'</div>';
echo '<div class="c"><small>Фамилия:</small> '.$user['imfamilia'].'</div>';
echo '<div class="c"><small>День рождения:</small> ' . $user['dayb'] . '&nbsp;' . $mesyac[$user['monthb']] . '&nbsp;' . $user['yearofbirth'] . '</div>';
echo '<div class="c"><small>О себе:</small> ' . smileys(tags($user['about'])) . '</div>';


echo '<div class="b">Контактная информация</div>';
echo '<div class="c"><small>Город:</small> '.$user['live'].'</div>';
echo '<div class="c"><small>Моб. телефон:</small> '.$user['mibile'].'</div>';
echo '<div class="c"><small>Skype:</small> '.$user['skype'].'</div>';

	$out = '';
	$out .= '<div class="c"><small>E-mail:</small>
	
	' . $user['mail'];
    $out .= ($user['mailvis'] ? '' : '<small> [скрыт]</small>') . '</div>';
	echo $out;




require_once('../incfiles/end.php');

?>