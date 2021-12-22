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

if (!empty($manag)) {

    switch ($act) {

        default:
            echo '<div class="menu"> 
       <a href="inf.php?act=my">База клуба</a><br/>
       <a href="inf.php?act=new">Создать базу клуба</a><br/> 
	
	   </div>';
            break;

        case 'my':
            /* Мои постройки */
            $k_post = mysql_result(mysql_query("SELECT count(*) FROM `invent_2` WHERE  `uid`='" .
                $fid . "'"), 0);
            if ($k_post == 0) {
                echo display_error('У вас нет базы клуба');
                require_once ("incfiles/end.php");
                exit;
            }
            ;
            $x = mysql_query("SELECT * FROM `invent_2` WHERE  `uid`='" . $fid . "'");

            while ($ros = mysql_fetch_assoc($x)) {
                $xx = mysql_query("SELECT * FROM `dom_2`  where `name` = '" . $ros['name'] .
                    "' ORDER BY `price`");
                while ($row = mysql_fetch_assoc($xx)) {
                    echo '<div class="gmenu"><img src="dom/' . $row['path'] .
                        ' " width="150" height="112"  alt="' . $row['name'] . '"/><br/>';
                    echo 'Название: <b>' . $row['name'] . ' </b><br/>';
                    echo 'Описание: <b>' . $row['ops'] . ' </b><br/>';
                    echo 'Цена: <u>' . $row['price'] . '</u><br/>';
                    echo 'Прибыль: <u>' . $row['prib'] . '</u><br/>';
                    echo '<img src="img/magazin.gif" alt=""/><a href="inf.php?act=prod&amp;id=' . $ros['id'] .
                        '">Продать базу</a><br/>';
                    echo '</div>';
                    $postrouka = $postrouka + $row['prib'];
                }
            }
            echo '<div class="gmenu">Доход от постройки: <u>' . $postrouka . '</u></div>';
            echo ' <br/>[<a href="inf.php">Назад</a>]<br/>';
            break;

        case 'new':

            $x = mysql_query("SELECT * FROM `dom_2` ORDER BY `price`");

            if (!mysql_num_rows($x)) {
                echo display_error('Нет  Базы клуба');
                require_once ("incfiles/end.php");
                exit;
            } else {
                while ($row = mysql_fetch_assoc($x)) {
                    echo '<div class="gmenu"><img src="dom/' . $row['path'] .
                        '" width="150" height="112"  alt="' . $row['name'] . '"/><br/>';
                    echo 'Название: <b>' . $row['name'] . ' </b><br/>';
                    echo 'Описание: <b>' . $row['ops'] . ' </b><br/>';
                    echo 'Цена: <u>' . $row['price'] . '</u><br/>';
                    echo 'Прибыль: <u>' . $row['prib'] . '</u><br/>';
                    echo '<img src="img/magazin.gif" alt=""/><a href="inf.php?act=buy&amp;id=' . $row['id'] .
                        '">Купить Базу клуба</a><br/>';
                    echo '</div>';
                }
                ;
            }
            ;
            break;

        case 'prod';
            if (!$id) {
                echo display_error('Пустые параметры');
                require_once ("incfiles/end.php");
                exit;
            }
            if (isset($_POST['submit'])) {

                $x = mysql_query("SELECT * FROM `invent_2` WHERE `id`='$id'");

                if (!mysql_num_rows($x)) {
                    echo display_error('Такой посторойки не существует!');
                    require_once ("incfiles/end.php");
                    exit;
                }
                ;
                $x = mysql_fetch_assoc($x);
                mysql_query("UPDATE `team_2` SET `money`=`money`+'" . $x['price'] .
                    "' WHERE `id`='" . $fid . "'");
                mysql_query("DELETE FROM `invent_2` WHERE   `id`='" . $id . "' AND `uid` = '" .
                    $fid . "';");
                header('location: inf.php?id=' . $fid . '');
            } else {
                echo '<div class="rmenu"><p>Внимание!<br/>Вы действительно хотите удалить Базу клуба ?';
                echo '</p><p><form action="inf.php?act=prod&amp;id=' . $id .
                    '" method="post"><input type="submit" name="submit" value="Удалить" /></form>';
                echo '</p></div>';
            }
            break;

        case 'buy':
            if (!$id) {
                echo display_error('Пустые параметры');
                require_once ("incfiles/end.php");
                exit;
            }

            if (isset($_POST['submit'])) {
                $x = mysql_query("SELECT * FROM `dom_2` WHERE `id`='$id'");

                if (!mysql_num_rows($x)) {
                    echo display_error('Такой посторойки не существует!');
                    require_once ("incfiles/end.php");
                    exit;
                }
                $x = mysql_fetch_assoc($x);
                $isdom = mysql_query("SELECT * FROM `invent_2` WHERE `name`='" . $x['name'] .
                    "' AND `uid`='" . $fid . "'");
                if (mysql_num_rows($isdom) > 0) {
                    echo display_error('У тебя уже есть єта посторойка! Сначала продай старую!');
                    require_once ("incfiles/end.php");
                    exit;
                }

                if ($money < $x['price']) {
                    echo '' . $datauser['name'] .
                        ', y тeбя нeт денег, чтoбы кyпить эту посторойку. Пpиxoди, кoгдa paзбoгaтeeшь.<br/>';
                } else {
                    mysql_query("UPDATE `team_2` SET `money`=`money`-'" . $x['price'] .
                        "' WHERE `id`='" . $fid . "'");
                    mysql_query("INSERT INTO `invent_2` (`uid`,`name`,`type`,`price`)VALUES('" . $fid .
                        "','" . $x['name'] . "','dom','" . $x['price'] . "')");

                }
                header('location: inf.php?id=' . $fid . '');
            } else {
                echo '<div class="rmenu"><p>Внимание!<br/>Вы действительно хотите купить постройку ?';
                echo '</p><p><form action="inf.php?act=buy&amp;id=' . $id .
                    '" method="post"><input type="submit" name="submit" value="Купить" /></form>';
                echo '</p></div>';
            }
            break;


        case 'buy':
            /* Продажа постройки */

            $id = (int)$_GET['id'];
            if (!$id) {
                echo 'Пустые параметры!';
                require_once ("incfiles/end.php");
                exit;
            }
            ;
            $x = mysql_query("SELECT * FROM `invent_2` WHERE `id`='$id'");

            if (!mysql_num_rows($x)) {
                echo 'Такой посторойки не существует!';
                require_once ("incfiles/end.php");
                exit;
            }
            ;
            $x = mysql_fetch_assoc($x);
            mysql_query("UPDATE `team_2` SET `money`=`money`+'" . $x['price'] .
                "' WHERE `id`='" . $fid . "'");
            mysql_query("DELETE FROM `invent_2` WHERE   `id`='" . $id . "' AND `uid` = '" .
                $fid . "';");
            echo 'Продано! <br/>';
            break;

        case 'mnogo':
            echo 'У Вас макс. к-во построек!<br/>[<a href="inf.php">Назад</a>]<br/>';
            break;
    }
} else {
    echo 'Доступ закрыт<br/>';
}

require_once ("incfiles/end.php");
?>
