<?php

define('_IN_JOHNCMS', 1);

$headmod = 'anketa';
$textl = 'Редактирование Анкеты';

require_once ('../incfiles/core.php');
require_once ('../incfiles/head.php');

if (!$user_id) {
    display_error('Только для зарегистрированных посетителей');
    require_once ('../incfiles/end.php');
    exit;
}

if ($id && $id != $user_id && $rights >= 7) {
    // Если был запрос на юзера, то получаем его данные
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        if ($user['rights'] > $datauser['rights']) {
            // Если не хватает прав, выводим ошибку
            echo display_error('Вы не можете редактировать анкету старшего Вас по должности');
            require_once ('../incfiles/end.php');
            exit;
        }
    }
    else {
        echo display_error('Такого пользователя не существует');
        require_once ('../incfiles/end.php');
        exit;
    }
}
else {
    $id = false;
    $user = $datauser;
}


//////////////////////////////////////////////////////////

if (isset($_POST['submit'])) {
    $error = array();
    // Данные юзера
    $user['imname'] = isset($_POST['imname']) ? check(mb_substr($_POST['imname'], 0, 25)) : '';
	$user['imfamilia'] = isset($_POST['imfamilia']) ? check(mb_substr($_POST['imfamilia'], 0, 25)) : '';
    $user['live'] = isset($_POST['live']) ? check(mb_substr($_POST['live'], 0, 50)) : '';
    $user['dayb'] = isset($_POST['dayb']) ? intval($_POST['dayb']) : 0;
    $user['monthb'] = isset($_POST['monthb']) ? intval($_POST['monthb']) : 0;
    $user['yearofbirth'] = isset($_POST['yearofbirth']) ? intval($_POST['yearofbirth']) : 0;
    $user['about'] = isset($_POST['about']) ? check(mb_substr($_POST['about'], 0, 500)) : '';
    $user['mail'] = isset($_POST['mail']) ? check(mb_substr($_POST['mail'], 0, 40)) : '';
	$user['mibile'] = isset($_POST['mibile']) ? check(mb_substr($_POST['mibile'], 0, 40)) : '';
	$user['skype'] = isset($_POST['skype']) ? check(mb_substr($_POST['skype'], 0, 40)) : '';
	$user['mailvis'] = isset($_POST['mailvis']) ? 1 : 0;
	$user['sex'] = isset($_POST['sex']) && $_POST['sex'] == 'm' ? 'm' : 'zh';
    // Проводим необходимые проверки
    if ($user['id'] == $user_id)
        $user['rights'] = $datauser['rights'];
    if ($rights >= 7) {
        if (mb_strlen($user['name']) < 2)
            $error[] = 'Минимальная длина Ника - 2 символа';
        $lat_nick = rus_lat(mb_strtolower($user['name']));
        if (preg_match("/[^1-9a-z\-\@\*\(\)\?\!\~\_\=\[\]]+/", $lat_nick))
            $error[] = 'Недопустимые символы в Нике<br/>';
    }
    if ($user['dayb'] || $user['monthb'] || $user['yearofbirth']) {
        if ($user['dayb'] < 1 || $user['dayb'] > 31 || $user['monthb'] < 1 || $user['monthb'] > 12)
            $error[] = 'Дата рождения указана неправильно';
    }
    if (!$error) {
        mysql_query("UPDATE `users` SET
        `imname` = '" . $user['imname'] . "',
		`imfamilia` = '" . $user['imfamilia'] . "',
        `live` = '" . $user['live'] . "',
        `dayb` = '" . $user['dayb'] . "',
        `monthb` = '" . $user['monthb'] . "',
        `yearofbirth` = '" . $user['yearofbirth'] . "',
		`sex` = '" . $user['sex'] . "',
        `about` = '" . $user['about'] . "',
		`mibile` = '" . $user['mibile'] . "',
		`skype` = '" . $user['skype'] . "',
		`mailvis` = '" . $user['mailvis'] . "',
        `mail` = '" . $user['mail'] . "'
        WHERE `id` = '" . $user['id'] . "' LIMIT 1");

        echo '<div class="gmenu">Данные сохранены</div>';
    }
    else {
        echo display_error($error);
    }
}

///////////////////////////////////////////////////////////////



echo '<form name="edit" action="my_data.php?id='.$user['id'].'" method="post">';
echo '<div class="b">Общая информация</div>';
echo '<div class="c">Имя:<br />	<input type="text" value="' . $user['imname'] . '" name="imname" /></div>';
echo '<div class="c">Фамилия:<br /><input type="text" value="' . $user['imfamilia'] . '" name="imfamilia" /></div>';
echo '<div class="c">Дата рождения (д.м.г)<br />';
echo '<input type="text" value="' . $user['dayb'] . '" size="2" maxlength="2" name="dayb" />.';
echo '<input type="text" value="' . $user['monthb'] . '" size="2" maxlength="2" name="monthb" />.';
echo '<input type="text" value="' . $user['yearofbirth'] . '" size="4" maxlength="4" name="yearofbirth" /></div>';
echo '<div class="c">Укажите пол:<br />';
echo '<input type="radio" value="m" name="sex" ' . ($user['sex'] == 'm' ? 'checked="checked"' : '') . '/>&nbsp;Мужской<br />';
echo '<input type="radio" value="zh" name="sex" ' . ($user['sex'] == 'zh' ? 'checked="checked"' : '') . '/>&nbsp;Женский</div>';
echo '<div class="c">О себе:<br /><textarea cols="20" rows="4" name="about">' . str_replace('<br />', "\r\n", $user['about']) . '</textarea></div>';






echo '<div class="b">Контактная информация</div>';
echo '<div class="c">Город:<br /><input type="text" value="' . $user['live'] . '" name="live" /></div>';
echo '<div class="c">Тел. номер:<br /><input type="text" value="' . $user['mibile'] . '" name="mibile" /></div>';
echo '<div class="c">Skype:<br /><input type="text" value="' . $user['skype'] . '" name="skype" /></div>';
echo '<div class="c">E-mail:<br />';
echo '<input type="text" value="' . $user['mail'] . '" name="mail" />';
echo '<input name="mailvis" type="checkbox" value="1" ' . ($user['mailvis'] ? 'checked="checked"' : '') . ' />&nbsp;Показывать в Анкете</div>';




echo '<input type="submit" value="Сохранить" name="submit" />';
echo '</form>';







require_once ('../incfiles/end.php');

?>