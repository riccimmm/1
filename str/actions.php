<?php
  define('_IN_JOHNCMS', 1);
$headmod = 'anketa';
require_once('../incfiles/core.php');
if (!$user_id) {
    require_once('../incfiles/head.php');
    echo display_error('Только для зарегистрированных посетителей');
    require_once('../incfiles/end.php');
    exit;
}
if ($id && $id != $user_id) {
    // Если был запрос на юзера, то получаем его данные
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        $textl = 'Действия c пользователем ' . $user['name'];
    } else {
        require_once('../incfiles/head.php');
        echo display_error('Такого пользователя не существует');
        require_once("../incfiles/end.php");
        exit;
    }
} else {
    $textl = 'Действия';
    require_once('../incfiles/head.php');
    # Это если пользователь хочет посмотреть что ему ставили
    
    $actions_arr = array('','Вас обнял','Вам пожал(-а) руку','Вам подмигнул(-а)','Вам предложил(-а) выпить','Вас позвал(-а) на дискотеку','Вас пригласил(-а) на свидание','Вас поцеловал(-а)','Вам признался(-ась) в любви','Вас пнул(-а)','Вам дал(-а) щелбан','Вас послал(-а) в');
    echo '<div class="phdr">Просмотр действий</div>';
    
    $all = mysql_result(mysql_query("SELECT COUNT(*) FROM `action` WHERE `tuid` = '{$user_id}'"),0);
    
    echo '<div class="gmenu">';
    if ($all){
    $act = mysql_query("SELECT `uid`,`type`,`time` FROM `action` WHERE `tuid` = '{$user_id}' ORDER BY `time` DESC LIMIT {$start},{$kmess}");
    
    
    while ($a = mysql_fetch_assoc($act)){
        $user = mysql_fetch_assoc(mysql_query("SELECT `name` FROM `users` WHERE `id` = '{$a['uid']}'"));
        echo '<li>'. $actions_arr[$a['type']] .'&nbsp;'. $user['name'] .'('.date("d.m.y / H:i", $a['time'] + $set_user['sdvig'] * 3600) .')</li>';
        
    }
            if ($all > $kmess) {
                echo '<p>' . pagenav('actions.php?', $start, $all, $kmess) . '</p>';
                echo '<p><form action="actions.php" method="get"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
            }
    }
    else{
        echo 'Никаких действий не найдено!';
    }
    echo '</div>
    <div class="menu"><a href="anketa.php">Анкета</a></div>';
    
    
    require_once("../incfiles/end.php");
    exit;   
}

require_once('../incfiles/head.php');



$arr_actions_do = array('','обняли','пожали руку','подмигнули','предложили выпить','позвали на дискотеку','пригласили на свидание','поцеловали','признались в любви','пнули','дали щелбан','послали в');
$arr_actions = array('','Обнять','Пожать руку','Подмигнуть','Предложить выпить','Позвать на дискотеку','Пригласить на свидание','Поцеловать','Признаться в любви','Пнуть','Дать щелбан','Послать в');

echo '<div class="phdr">Действия с пользователем '.$user['name'].'</div>';
echo '<div class="gmenu">';

if (isset($_GET['act']) && $_GET['act'] == 'do'){
$type = isset($_GET['type']) ? intval($_GET['type']) : null;

$t = time() - 60; // время через которое можно делать другое действие к данному пользователю




$result = mysql_result(mysql_query("SELECT COUNT(*) FROM `action` WHERE `uid` = '{$user_id}' && `tuid` = '{$user['id']}' && `time` > '{$t}'"),0);



if (is_numeric($type) && $type > 0 && $type < count($arr_actions) && $result == 0){
    mysql_query("INSERT INTO `action`(`uid`,`tuid`,`type`,`time`,`watch`) VALUES('{$user_id}','{$user['id']}','{$type}','". time() ."','1')");
    echo 'Вы '. $arr_actions_do[$type] .' пользователю под ником '. $user['name'];
}
elseif ($result > 0){
    echo 'Вы уже делали недавно какое то действие с данным пользователем! Подождите немного!';
}
else{
    echo 'Неправильное действие выбрано вами!';
}
}
else{
$i = 1;
while ($arr_actions[$i]){
    $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `action` WHERE `type` = '{$i}' && `tuid` = '{$user['id']}'"),0);
    echo '<li><a href="actions.php?act=do&amp;type='. $i .'&amp;id='. $user['id'] .'">'. $arr_actions[$i] .'</a>('. $count .')</li>';
    $i++;
}
}
echo '</div>
<div class="menu"><a href="anketa.php?id='. $user['id'] .'">В анкету</a></div>';

require_once('../incfiles/end.php');
?>
