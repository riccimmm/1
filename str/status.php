<?php
define('_IN_JOHNCMS', 1);
$textl = 'Мой статус';
require_once ('../incfiles/core.php');
require_once ('../incfiles/head.php');
if (isset ($ban)){
    echo'<div class="rmenu"><b>Доступ закрыт!</b></div>';
	require_once ('../incfiles/end.php');
	exit;
	}
if (!$user_id) {
            echo display_error('Только для зарегистрированных');
            require_once ('../incfiles/end.php');
            exit;
        }
if ($id && $id != $user_id) {
    // Если был запрос на юзера, то получаем его данные
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        $textl = 'Статус: ' . $user['name'];
    } else {
        require_once('incfiles/head.php');
        echo display_error('Такого пользователя не существует');
        require_once("../incfiles/end.php");
        exit;
    }
} else {
    $id = false;
    $textl = 'Мой статус';
    $user = $datauser;
}
if(!$id || $id == $user_id){
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
if (isset($_POST['submit'])) {
            mysql_query("UPDATE `users` SET
            `status` = '" . $status . "'
            WHERE `id` = '" . $user['id'] . "' LIMIT 1");
        echo '<div class="gmenu">Данные сохранены</div>';
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="sbeka" action="status.php?id='.$user['id'].'" method="post">';
echo '<div class="c">Статус: <input type="text" value="' . $_POST['status'] . '" name="status" style="width:98%;" /></div>';
echo '<div class="c"><input type="submit" value="Сохранить" name="submit" /></div>';
echo '</form>';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
echo '<div class="rmenu">ОШИБКА!</div>';
}













require_once('../incfiles/end.php');

?>