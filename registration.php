<?php

define('_IN_JOHNCMS', 1);

$textl = 'Регистрация '.$namesite.'';
$rootpath = '';
require_once('incfiles/core.php');
require_once('incfiles/head.php');

if ($regban || !$set['mod_reg']) {
    echo '<p>Регистрация Открита.</p>';
    require_once("incfiles/end.php");
    exit;
}

function regform() {
    echo '<form action="registration.php" method="post"><div class="gmenu">';
	echo '<p><b>Логин:</b><br/><input type="text" name="nick" maxlength="15" /><br/>';
    echo '</p>';
	echo '<p><b>Имя:</b><br/><input type="text" name="imname" maxlength="20" /><br/>';
    echo '</p>';
	echo '<p><b>Фамилия:</b><br/><input type="text" name="imfamilia" maxlength="20" /><br/>';
    echo '</p>';
    echo '<p><b>Пароль:</b><br/><input type="text" name="password" maxlength="20" /><br/>';
    echo '</p>';
    echo '<p><b>Пол:</b><br/><select name="sex"><option value="?">-?-</option><option value="m">Мужчина</option><option value="zh">Женщина</option></select></p></div>';

    echo '<div class="gmenu"><p>';
    echo '<img src="captcha.php?r=' . rand(1000, 9999) . '" alt="Проверочный код"/><br />';
    echo '<br/><input type="text" size="10" maxlength="5"  name="kod"/></p></div>';
    echo '<div class="bmenu"><input type="submit" name="submit" value="Регистрация"/></div></form>';
}

if (isset($_POST['submit'])) {
    // Принимаем переменные
    $reg_kod = isset($_POST['kod']) ? trim($_POST['kod']) : '';
    $reg_nick = isset($_POST['nick']) ? trim($_POST['nick']) : '';
    $lat_nick = rus_lat(mb_strtolower($reg_nick));
    $reg_pass = isset($_POST['password']) ? trim($_POST['password']) : '';
    $reg_name = isset($_POST['imname']) ? trim($_POST['imname']) : '';
    $reg_familia = isset($_POST['imfamilia']) ? trim($_POST['imfamilia']) : '';
    $reg_sex = isset($_POST['sex']) ? trim($_POST['sex']) : '';
    $error = false;
    // Проверка Логина
    if (empty($reg_nick))
        $error = $error . 'Не введён логин!<br/>';
    elseif (mb_strlen($reg_nick) < 2 || mb_strlen($reg_nick) > 15)
        $error = $error . 'Недопустимая длина Логина<br />';
    if (preg_match("/[^1-9a-z\-\@\*\(\)\?\!\~\_\=\[\]]+/", $lat_nick))
        $error = $error . 'Недопустимые символы в Логине!<br/>';
    // Проверка пароля
    if (empty($reg_pass))
        $error = $error . 'Не введён пароль!<br/>';
    elseif (mb_strlen($reg_pass) < 3 || mb_strlen($reg_pass) > 10)
        $error = $error . 'Недопустимая длина пароля<br />';
    if (preg_match("/[^\da-zA-Z_]+/", $reg_pass))
        $error = $error . 'Недопустимые символы в пароле!<br/>';
	// Проверка имени
    if (empty($reg_name))
        $error = $error . 'Не введён имя!<br/>';
    elseif (mb_strlen($reg_name) < 3 || mb_strlen($reg_pass) > 20)
        $error = $error . 'Недопустимая длина имени<br />';
	// Проверка Фамилии
    if (empty($reg_familia))
        $error = $error . 'Не введён фамилия!<br/>';
    elseif (mb_strlen($reg_name) < 3 || mb_strlen($reg_pass) > 20)
        $error = $error . 'Недопустимая длина фамилии<br />';
    // Проверка пола
    if ($reg_sex == 'm' || $reg_sex == 'zh') { }
    else
        $error = $error . 'Не указан пол!<br/>';
    // Проверка кода CAPTCHA
    if (empty($reg_kod) || mb_strlen($reg_kod) < 4)
        $error = $error . 'Не введён проверочный код!<br/>';
    elseif ($reg_kod != $_SESSION['code'])
        $error = $error . 'Проверочный код неверен!<br/>';
    unset($_SESSION['code']);
    // Проверка переменных
    if (empty($error)) {
        $pass = md5(md5($reg_pass));
        $reg_name = check(mb_substr($reg_name, 0, 20));
		$reg_familia = check(mb_substr($reg_familia, 0, 20));
        $reg_about = check(mb_substr($reg_about, 0, 500));
        $reg_sex = check(mb_substr($reg_sex, 0, 2));
        // Проверка, занят ли ник
        $req = mysql_query("select * from `users` where `name_lat`='" . mysql_real_escape_string($lat_nick) . "';");
        if (mysql_num_rows($req) != 0) {
            $error = 'Этот ник уже зарегистрирован!<br/>Выберите другой.<br/>';
        }
    }
    if (empty($error)) {
        $preg = $set['mod_reg'] > 1 ? 1 : 0;
        mysql_query("INSERT INTO `users` SET
        `name` = '" . mysql_real_escape_string($reg_nick) . "',
        `name_lat` = '" . mysql_real_escape_string($lat_nick) . "',
        `password` = '" . mysql_real_escape_string($pass) . "',
        `imname` = '$reg_name',
		`imfamilia` = '$reg_familia',
        `about` = '$reg_about',
        `sex` = '$reg_sex',
        `rights` = '0',
        `ip` = '$ipl',
        `browser` = '" . mysql_real_escape_string($agn) . "',
        `datereg` = '$realtime',
        `lastdate` = '$realtime',
        `preg` = '$preg'");
        $usid = mysql_insert_id();
        echo "<div class='rmenu'>Поздравляем! Вы успешно зарегистрированы!</div><br/>";
		echo '<div class="menu">';
        echo "Ваш id: " . $usid . "<br/>";
        echo "Ваш логин: " . $reg_nick . "<br/>";
        echo "Ваш Пароль: " . $reg_pass . "<br/>";
        echo "Ссылка для автовхода:<br/><input type='text' value='" . $home . "/login.php?id=" . $usid . "&amp;p=" . $reg_pass . "' /><br/>";
        if ($set['mod_reg'] == 1) {
            echo 'Пожалуйста,ожидайте подтверждения Вашей регистрации администратором<br/>';
        } else {
            echo "<br /><a href='login.php?id=" . $usid . "&amp;p=" . $reg_pass . "'>ВХОД</a><br/><br/>";
        }
		echo '</div>';
    } else {
        echo '<div class="rmenu"><p><b>ОШИБКА!</b><br />' . $error . '</p></div>';
        regform();
    }
}
// Форма регистрации
else {
    if ($set['mod_reg'] == 1) {
        echo '<div class="rmenu"><p>Вы сможете получить авторизованный доступ к разделам сайта после подтверждения Вашей регистрации.<br />Подтверждение проводится 1-2 раза в сутки.</p>';
        echo '<p>Просьба не регистрировать ники типа 111, ггг, uuuu и им подобные, они будут сразу же удалены.<br />Также будут удалены ВСЕ профили, которые регистрировались через Прокси серверы.</p></div>';
    }
    regform();
}

require_once('incfiles/end.php');

?>