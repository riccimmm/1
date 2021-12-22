<?php

define('_IN_JOHNCMS', 1);

$headmod = 'union';
$textl = 'Увольнение Резидента';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");

echo '<div class="bmenu"><b>Увольнение Резидента</b></div>';

$uni = abs(intval($_GET['un']));
$rez = abs(intval($_GET['rez']));

$un = mysql_query("SELECT * FROM `union` WHERE `id` = '$uni';");
if (mysql_num_rows($un) == 0) {
    echo display_error('Такого союза не существует!');
    require('../incfiles/end.php');
    exit;
}
$un = mysql_fetch_array($un);

if ($un['id_prez'] != $user_id) {
    echo display_error('Вы не являетесь президентом данного союза!');
    require('../incfiles/end.php');
    exit;
}

$rz = mysql_query("SELECT `id`, `name` FROM `team_2` WHERE `id` = '$rez' AND `union` = '$uni' LIMIT 1;");
if (mysql_num_rows($rz) == 0) {
    echo display_error('Такой команды не существует, либо её нет в вашем союзе!');
    require('../incfiles/end.php');
    exit;
}
$rz = mysql_fetch_array($rz);


if (isset($_GET['yes'])) {
    mysql_query("UPDATE `team_2` SET `union` = '0' WHERE `id` = '$rez' LIMIT 1;");
    echo '<div class="list1"><p>Команда уволена из вашего союза!</p><p><a href="group.php?id=' . $uni . '">В союз</a></p></div>';
} else {
    echo '<div class="rmenu"><p>Вы действительно хотите уволить команду <b>' . $rz['name'] . '</b> из союза?</p><p><a href="del_rez.php?un=' . $uni . '&amp;rez=' . $rez . '&amp;yes">Уволить</a> | <a href="group.php?id=' . $uni . '">Отмена</a></p></div>';
}

require('../incfiles/end.php');
?>