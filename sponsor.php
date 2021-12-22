<?php

define('_IN_JOHNCMS', 1);

$textl = 'Спонсор';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ('incfiles/class_upload.php');
require_once ("incfiles/manag2.php");

require_once ("incfiles/manager_func.php");
// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="../login.php">авторизованным</a> посетителям';
if ($error) {
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
    require_once ("incfiles/end.php");
    exit;
}
echo '<div class="phdr"><b>Спонсоры</b></div>';
switch ($act) {
    default:
        $x = mysql_query("SELECT * FROM `m_sponsor` ORDER BY `id`");
        if (!mysql_num_rows($x)) {
            echo 'Нет Спонсоров';
        } else {
            $x22 = mysql_query("SELECT `name` FROM `m_sponsor` where id='" . $sponsor .
                "'");
            if (mysql_num_rows($x22) != 0) {
                $arr = mysql_fetch_array($x22);
                echo '<div class="menu"><center><b>Ваш спонсор ' . $arr['name'] .
                    '</b></center></div>';
            }
            while ($row = mysql_fetch_assoc($x)) {
                echo '<div class="gmenu"><img src="../img/' . $row['logo'] .
                    '"  width="150" height="90" alt="' . $row['name'] . '"/><br/>';
                echo 'Название: <b>' . $row['name'] . ' </b><br/>';
                echo 'Стоимость контракта: <b>' . $row['mon'] . ' </b><br/>';
                echo 'Деньги за матч: <b>' . $row['money'] . ' </b><br/>';
                if ($sponsor == '0') {
                    echo '<img src="img/magazin.gif" alt=""/><a href="sponsor.php?act=buy&amp;id=' .
                        $row['id'] . '">Подписать контракт</a><br/>';
                }
                if ($sponsor != '0' && $sponsor == $row['id']) {
                    echo '<img src="img/magazin.gif" alt=""/><a href="sponsor.php?act=del&amp;id=' .
                        $row['id'] . '">Розорвать контракт</a><br/>';
                }
                echo '</div>';
            }
            ;
        }
        ;
        break;

    case 'buy':
        $id = $_GET['id'];
        if (isset($_GET['yes'])) {
            $x22 = mysql_query("SELECT `name`, `mon` FROM `m_sponsor` where id='" . $id .
                "'");
            $arr = mysql_fetch_array($x22);
            if ($money < $arr['mon']) {
                echo '<div class="rmenu">У вас не достаточно денег</div>  <br/><a href="sponsor.php" class="button">Назад</a> <br/> <br/>';
                require_once ("incfiles/end.php");
                exit;
            }
            if ($sponsor != '0') {
                echo '<div class="menu"><center><b>У вас уже есть спонсор. Ваш спонсор ' . $arr['name'] .
                    '</b></center></div>';
                require_once ("incfiles/end.php");
                exit;
            }
            mysql_query("update `team_2` set `money`=`money`-'" . $arr['mon'] .
                "', `sponsor` = '" . $id . "' WHERE `id` = '" . $fid . "' LIMIT 1");
            header("Location: sponsor.php");
        } else {
            require_once ("incfiles/head.php");
            echo '<div class="rmenu">Вы действительно хотите подписать контракт с данным спонсором?<br/><br/><a href="sponsor.php?act=buy&amp;yes&amp;id=' .
                $id . '" class="button">Да</a>  <a class="redbutton" href="sponsor.php">Нет</a></div>';
            require_once ("incfiles/end.php");
            exit;
        }
        break;

    case 'del':
        $id = $_GET['id'];
        if (isset($_GET['yes'])) {
            mysql_query("update `team_2` set  `sponsor` = '0' WHERE `id` = '" . $fid .
                "' LIMIT 1");
            header("Location: sponsor.php");
        } else {
            require_once ("incfiles/head.php");
            echo '<p>Вы действительно хотите розорвать єтот контракт?<br/><a href="sponsor.php?act=del&amp;yes&amp;id=' .
                $id . '">Да</a> | <a href="sponsor.php">Нет</a></p>';
            require_once ("incfiles/end.php");
            exit;
        }
        break;
}
require_once ("incfiles/end.php");
?>