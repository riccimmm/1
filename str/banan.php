<?php

/*
////////////////////////////////////////////////////////////////////////////////
// JohnCMS                             Content Management System              //
// Официальный сайт сайт проекта:      http://johncms.com                     //
// Дополнительный сайт поддержки:      http://gazenwagen.com                  //
////////////////////////////////////////////////////////////////////////////////
// JohnCMS core team:                                                         //
// Евгений Рябинин aka john77          john77@gazenwagen.com                  //
// Олег Касьянов aka AlkatraZ          alkatraz@gazenwagen.com                //
//                                                                            //
// Информацию о версиях смотрите в прилагаемом файле version.txt              //
////////////////////////////////////////////////////////////////////////////////
*/
define('_IN_JOHNCMS', 1);
$headmod = 'userban';
require_once ('../incfiles/core.php');
if (!$user_id) {
echo "\n" . '<link rel="stylesheet" href="http://futmen.net/theme/default/style.css" type="text/css" />';
    display_error('Только для авторизованных посетителей');
echo'<div class="fmenu"><div style="text-align:center"><a href="' . $home2 . '/">FUTMEN.NET</a></div></div>';
    exit;
}
if ($id && $id != $user_id) {
    // Если был запрос на юзера, то получаем его данные
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        $textl = 'Список нарушений: ' . $user['name'];
    } else {
echo "\n" . '<link rel="stylesheet" href="http://futmen.net/theme/default/style.css" type="text/css" />';
        echo display_error('Такого пользователя не существует');
echo'<div class="fmenu"><div style="text-align:center"><a href="' . $home2 . '/">FUTMEN.NET</a></div></div>';
        exit;
    }
} else {
    $textl = 'Мои нарушения';
    $user = $datauser;
}
echo "\n" . '<link rel="stylesheet" href="http://futmen.net/theme/default/style.css" type="text/css" />';
require_once ('../incfiles/ban.php');
$ban = isset($_GET['ban']) ? intval($_GET['ban']) : 0;
switch ($act) {
    case 'ban':
        ////////////////////////////////////////////////////////////
        // Баним пользователя (добавляем Бан в базу)              //
        ////////////////////////////////////////////////////////////
        if ($rights < 1 || ($rights < 6 && $user['rights']) || ($rights <= $user['rights'])) {
            echo display_error('У Вас не хватает прав, чтоб банить данного пользователя');
        } elseif ($user['immunity']) {
            echo display_error('Данный пользователь имеет Иннунитет, его банить нельзя');
        } else {
            echo '<div class="phdr"><b>Баним пользователя</b></div>';
            echo '<div class="rmenu"><p>' . show_user($user, 0, 1) . '</p></div>';
            if (isset($_POST['submit'])) {
                $error = false;
                $term = isset($_POST['term']) ? intval($_POST['term']) : '';
                $timeval = isset($_POST['timeval']) ? intval($_POST['timeval']) : '';
                $time = isset($_POST['time']) ? intval($_POST['time']) : '';
                $reason = !empty($_POST['reason']) ? trim($_POST['reason']) : '';
                $banref = isset($_POST['banref']) ? intval($_POST['banref']) : '';
                if (isset($_POST['violation'])) {
                    mysql_query("INSERT INTO `violation` SET
                        `user_id` = '$id',
                        `time` = '$realtime',
                        `type` = '$term',
                        `login` = '$login',
                        `text` = '" . mysql_real_escape_string($reason) . "'
                    ");
                    echo '<div class="rmenu"><p><h3>Пользователь предупрежден</h3></p></div>';
                } else {
                    if (empty($reason) && empty($banref)) $reason = 'Причина не указана';
                    if (empty($term) || empty($timeval) || empty($time) || $timeval < 1) $error = 'Отсутствуют необходимые данные';
                    if ($rights == 1 && $term != 14 || $rights == 2 && $term != 12 || $rights == 3 && $term != 11 || $rights == 4 && $term != 16 || $rights == 5 && $term != 15) $error = 'Вы не имеете права банить не в своем разделе';
                    if (mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_ban_users` WHERE `user_id` = '$id' AND `ban_time` > '$realtime' AND `ban_type` = '$term'"), 0)) $error = 'Такой бан уже есть';
                    switch ($time) {
                        case 2:
                            // Часы
                            if ($timeval > 24) $timeval = 24;
                            $timeval = $timeval * 3600;
                            break;
                        case 3:
                            // Дни
                            if ($timeval > 30) $timeval = 30;
                            $timeval = $timeval * 86400;
                            break;
                        case 4:
                            // До отмены (на 10 лет)
                            $timeval = 315360000;
                            break;
                        default:
                            // Минуты
                            if ($timeval > 60) $timeval = 60;
                            $timeval = $timeval * 60;
                    }
                    if ($datauser['rights'] < 6 && $timeval > 86400) $timeval = 86400;
                    if ($datauser['rights'] < 7 && $timeval > 2592000) $timeval = 2592000;
                    if (!$error) {
                        // Заносим в базу
                        mysql_query("INSERT INTO `cms_ban_users` SET
                    `user_id` = '$id',
                    `ban_time` = '" . ($realtime + $timeval) . "',
                    `ban_while` = '$realtime',
                    `ban_type` = '$term',
                    `ban_who` = '$login',
                    `ban_reason` = '" . mysql_real_escape_string($reason) . "'") or die('error');
                        mysql_query("DELETE FROM `violation`
                            WHERE `type` = '$term'
                        ");
                        if ($set_karma['on']) {
                            $points = $set_karma['karma_points'] * 2;
                            mysql_query("INSERT INTO `karma_users` SET `user_id` = '0', `name` = 'Система', `karma_user` = '$id', `points` = '$points', `type` = '0', `time` = '$realtime', `text` = 'Бан ($ban_term[$term])'");
                            $plm = explode('|', $user['plus_minus']);
                            $karma = $user['karma'] - $points;
                            $plus_minus = $plm[0] . '|' . ($plm[1] + $points);
                            mysql_query("UPDATE `users` SET `karma`='$karma', `plus_minus`='$plus_minus' WHERE `id` = '$id' LIMIT 1");
                            $text = ' и получил <span class="red">-' . $points . ' очков</span> к карме';
                        }
                        echo '<div class="rmenu"><p><h3>Пользователь забанен ' . $text . '</h3></p></div>';
                    } else {
                        echo display_error($error);
                    }
                }
            } else {
                $reqViolation = mysql_query("SELECT * FROM `violation` WHERE `user_id` = '" . $user['id'] . "'");
                $arrayViolation = array(1 => 0, 3 => 0, 10 => 0, 13 => 0, 11 => 0, 14 => 0, 15 => 0, 12 => 0);
                while ($resViolation = mysql_fetch_assoc($reqViolation)) {
                    ++$arrayViolation[$resViolation['type']];
                }
                // Форма параметров бана
                echo '<form action="banan.php?act=ban&amp;id=' . $user['id'] . '" method="post"><div class="menu"><p><h3>Тип бана</h3>';
                echo '<select name="term" size="1">';
                if ($rights == 2 || $rights >= 6) echo '<option value="12">Чат (' . $arrayViolation[12] . ')</option>';
                if ($rights == 3 || $rights >= 6) echo '<option value="11">Форум (' . $arrayViolation[11] . ')</option>';
                if ($rights == 1 || $rights >= 6) echo '<option value="14">Галерея (' . $arrayViolation[14] . ')</option>';
                if ($rights == 5 || $rights >= 6) echo '<option value="15">Библиотека (' . $arrayViolation[15] . ')</option>';
                if ($rights >= 6) {
                    echo '<option value="13">Гостевая (' . $arrayViolation[13] . ')</option>';
                    echo '<option value="10">Коментарии (' . $arrayViolation[10] . ')</option>';
                    echo '<option value="3">Приват (' . $arrayViolation[3] . ')</option>';
                    echo '<option value="1" selected="selected">Блокировка (' . $arrayViolation[1] . ')</option>';
                }
                echo '</select><br />';
                echo '</p><p><h3>Срок бана</h3>';
                echo '<input name="violation" type="checkbox" />&#160;<b><span class="red">Предупредить</span></b><br /><small>Время выбирать не надо</small><br />';
                echo '&nbsp;<input type="text" name="timeval" size="2" maxlength="2" value="12"/>&nbsp;Время<br/>';
                echo '&nbsp;<input name="time" type="radio" value="1" />&nbsp;Минут (60 макс.)<br />';
                echo '&nbsp;<input name="time" type="radio" value="2" checked="checked" />&nbsp;Часов (24 макс.)<br />';
                if ($rights >= 6) echo '&nbsp;<input name="time" type="radio" value="3" />&nbsp;Дней (30 макс.)<br />';
                if ($rights >= 7) echo '&nbsp;<input name="time" type="radio" value="4" />&nbsp;<b>До отмены</b>';
                echo '</p><p><h3>Причина бана</h3>';
                if (isset($_GET['fid'])) {
                    // Если бан из форума, фиксируем ID поста
                    $fid = intval($_GET['fid']);
                    echo '&nbsp;Нарушение <a href="' . $home . '/forum/index.php?act=post&amp;id=' . $fid . '">на форуме</a><br />';
                    echo '<input type="hidden" value="' . $fid . '" name="banref" />';
                }
                echo '&nbsp;<textarea cols="20" rows="4" name="reason"></textarea>';
                echo '</p><p><input type="submit" value="Банить" name="submit" />';
                echo '</p></div></form>';
            }
            echo '<div class="phdr"><a href="anketa.php' . ($id ? '?id=' . $id : '') . '">В анкету</a></div>';
        }
        break;
    case 'razban':
        ////////////////////////////////////////////////////////////
        // Разбаниваем пользователя (с сохранением истории)       //
        ////////////////////////////////////////////////////////////
        if (!$ban || $user['id'] == $user_id || $rights < 7) echo display_error('Неверные данные');
        else {
            $req = mysql_query("SELECT * FROM `cms_ban_users` WHERE `id` = '$ban' AND `user_id` = '" . $user['id'] . "' LIMIT 1");
            if (mysql_num_rows($req)) {
                $res = mysql_fetch_assoc($req);
                $error = false;
                if ($res['ban_time'] < $realtime) $error = 'Бан уже не активен';
                if (!$error) {
                    echo '<div class="phdr"><b>Прекращение действия Бана</b></div>';
                    echo '<div class="gmenu"><p>' . show_user($user, 0, 1) . '</p></div>';
                    if (isset($_POST['submit'])) {
                        mysql_query("UPDATE `cms_ban_users` SET `ban_time` = '$realtime' WHERE `id` = '$ban' LIMIT 1");
                        echo '<div class="gmenu"><p><h3>Пользователь разбанен</h3></p></div>';
                    } else {
                        echo '<form action="banan.php?act=razban&amp;id=' . $user['id'] . '&amp;ban=' . $ban . '" method="POST">';
                        echo '<div class="menu"><p>Прекращается действие активного бана с сохранением записи в истории нарушений';
                        echo '</p><p><input type="submit" name="submit" value="Разбанить" />';
                        echo '</p></div></form>';
                        echo '<div class="phdr"><a href="banan.php?act=details&amp;id=' . $user['id'] . '&amp;ban=' . $ban . '">Назад</a></div>';
                    }
                } else {
                    echo display_error($error);
                }
            } else {
                echo display_error('Неверные данные');
            }
        }
        break;
    case 'delban':
        ////////////////////////////////////////////////////////////
        // Удаляем бан (с удалением записи из истории)            //
        ////////////////////////////////////////////////////////////
        if (!$ban || $rights < 9) echo display_error('Неверные данные');
        else {
            $req = mysql_query("SELECT * FROM `cms_ban_users` WHERE `id` = '$ban' AND `user_id` = '" . $user['id'] . "' LIMIT 1");
            if (mysql_num_rows($req)) {
                $res = mysql_fetch_assoc($req);
                echo '<div class="phdr"><b>Удаление Бана</b></div>';
                echo '<div class="gmenu"><p>' . show_user($user, 0, 1) . '</p></div>';
                if (isset($_POST['submit'])) {
                    mysql_query("DELETE FROM `karma_users` WHERE `karma_user` = '$id' AND `user_id` = '0' AND `time` = '" . $res['ban_while'] . "' LIMIT 1");
                    $points = $set_karma['karma_points'] * 2;
                    $plm = explode('|', $user['plus_minus']);
                    $karma = $user['karma'] + $points;
                    $plus_minus = $plm[0] . '|' . ($plm[1] - $points);
                    mysql_query("UPDATE `users` SET `karma`='$karma', `plus_minus`='$plus_minus' WHERE `id` = '$id' LIMIT 1");
                    mysql_query("DELETE FROM `cms_ban_users` WHERE `id` = '$ban' LIMIT 1");
                    echo '<div class="gmenu"><p><h3>Бан удален</h3></p></div>';
                } else {
                    echo '<form action="banan.php?act=delban&amp;id=' . $user['id'] . '&amp;ban=' . $ban . '" method="POST">';
                    echo '<div class="menu"><p>Удаляется бан вместе с записью в истории нарушений';
                    echo '</p><p><input type="submit" name="submit" value="Удалить" />';
                    echo '</p></div></form>';
                    echo '<div class="phdr"><a href="banan.php?act=details&amp;id=' . $user['id'] . '&amp;ban=' . $ban . '">Назад</a></div>';
                }
            } else {
                echo display_error('Неверные данные');
            }
        }
        break;
    case 'delhist':
        ////////////////////////////////////////////////////////////
        // Очищаем историю нарушений юзера                        //
        ////////////////////////////////////////////////////////////
        if ($rights == 9) {
            echo '<div class="phdr"><b>История нарушений</b></div>';
            echo '<div class="gmenu"><p>' . show_user($user, 0, 1) . '</p></div>';
            if (isset($_POST['submit'])) {
                mysql_query("DELETE FROM `cms_ban_users` WHERE `user_id` = '" . $user['id'] . "'");
                echo '<div class="gmenu"><h3>История нарушений очищена</h3></div>';
            } else {
                echo '<form action="banan.php?act=delhist&amp;id=' . $user['id'] . '" method="post"><div class="menu"><p>';
                echo 'Вы действительно хотите очистить всю историю нарушений данного пользователя?';
                echo '</p><p><input type="submit" value="Очистить" name="submit" />';
                echo '</p></div></form>';
            }
            $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_ban_users` WHERE `user_id` = '" . $user['id'] . "'"), 0);
            echo '<div class="phdr">Всего нарушений: ' . $total . '</div>';
            echo '<p>' . ($total ? '<a href="banan.php?id=' . $user['id'] . '">История нарушений</a><br />' : '') . '<a href="../' . $admp . '/index.php?act=usr_ban">Бан панель</a></p>';
        } else {
            echo display_error('Очищать историю нарушений могут только Супервайзоры');
        }
        break;
    case 'details':
        ////////////////////////////////////////////////////////////
        // Детали отдельного Бана                                 //
        ////////////////////////////////////////////////////////////
        $req = mysql_query("SELECT * FROM `cms_ban_users` WHERE `id` = '$ban' LIMIT 1");
        if (mysql_num_rows($req)) {
            $res = mysql_fetch_assoc($req);
            echo '<div class="phdr"><b>История нарушений</b></div>';
            if ($user['id'] != $user_id) echo '<div class="gmenu"><p>' . show_user($user, 0, ($rights >= 1 && $rights >= $user['rights'] ? 1 : 0)) . '</p></div>';
            echo '<div class="' . ($res['ban_time'] > $realtime ? 'rmenu' : 'menu') . '"><p><h3>Подробности Бана</h3><ul>';
            if ($rights >= 1) echo '<li><span class="gray">Забанил:</span> <b>' . $res['ban_who'] . '</b></li>';
            echo '<li><span class="gray">Когда:</span> ' . gmdate('d.m.Y, H:i:s', $res['ban_while']) . '</li>';
            echo '<li><span class="gray">Срок:</span> ' . timecount($res['ban_time'] - $res['ban_while']) . '</li>';
            echo '<li><span class="gray">Осталось:</span> ' . timecount($res['ban_time'] - $realtime) . '</li>';
            echo '</ul></p><p><h3>Причина Бана</h3><ul>' . smileys(checkout($res['ban_reason'], 1, 1), 1);
            echo '</ul></p></div>';
            $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_ban_users` WHERE `user_id` = '" . $user['id'] . "'"), 0);
            echo '<div class="phdr">Всего нарушений: ' . $total . '</div>';
            echo '<p>';
            if ($rights >= 7 && $res['ban_time'] > $realtime) echo '<a href="banan.php?act=razban&amp;id=' . $user['id'] . '&amp;ban=' . $ban . '">Разбанить</a><br />';
            if ($rights == 9) echo '<a href="banan.php?act=delban&amp;id=' . $user['id'] . '&amp;ban=' . $ban . '">Удалить бан</a><br />';
            echo '<a href="banan.php?id=' . $res['user_id'] . '">История нарушений</a></p>';
        } else {
            echo display_error('Неверные данные');
        }
        break;
    case 'delViolation':
        /*
        -----------------------------------------------------------------
        Удаляем предупреждение
        -----------------------------------------------------------------
        */
        if (!$ban || $rights < 7) echo 'ошибка доступа';
        else {
            $req = mysql_query("SELECT * FROM `violation` WHERE `id` = '$ban' AND `user_id` = '" . $id . "'");
            if (mysql_num_rows($req)) {
                $res = mysql_fetch_assoc($req);
                echo '<div class="phdr"><b>Удаление предупреждения</b></div>' . '<div class="gmenu"><p>' . show_user($user) . '</p></div>';
                if (isset($_POST['submit'])) {
                    mysql_query("DELETE FROM `violation` WHERE `id` = '$ban'");
                    echo '<div class="gmenu"><p><h3>Предупреждение удалено</h3>
                    <a href="banan.php?act=violation&amp;id=' . $id . '">Вернуться</a></p></div>';
                } else {
                    echo '<form action="banan.php?act=delViolation&amp;id=' . $id . '&amp;ban=' . $ban . '" method="POST">' . '<div class="menu"><p>Удалить предупреждение?</p>' . '<p><input type="submit" name="submit" value="Удалить" /></p>' . '</div></form>' . '<div class="phdr"><a href="banan.php?act=violation&amp;id=' . $id . '">Назад</a></div>';
                }
            } else {
                echo functions::display_error($lng['error_wrong_data']);
            }
        }
        break;
    case 'violation':
        /*
        -----------------------------------------------------------------
        История предупреждений
        -----------------------------------------------------------------
        */
        echo '<div class="phdr"><a href="anketa.php?id=' . $user['id'] . '"><b>Анкета</b></a> | История предупреждений</div>';
        echo '<div class="bmenu"><p>' . show_user($user) . '</p></div>';
        $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `violation` WHERE `user_id` = '" . $user['id'] . "'"), 0);
        if ($total) {
            $req = mysql_query("SELECT * FROM `violation` WHERE `user_id` = '" . $user['id'] . "' ORDER BY `time` DESC LIMIT $start, $kmess");
            $i = 0;
            while ($res = mysql_fetch_assoc($req)) {
                $remain = $res['ban_time'] - time();
                $period = $res['ban_time'] - $res['ban_while'];
                echo $i % 2 ? '<div class="list2">' : '<div class="list1">';
                echo '<b>' . $ban_term[$res['type']] . '</b> <span class="gray">(' . date("d.m.y / H:i", $res['time'] + $set_user['sdvig'] * 3600) . ')</span>' . '<br />' . checkout($res['text']) . '<div class="sub"><span class="gray">Предупредил:</span> ' . $res['login'] . '<br />';
                if ($rights >= 7) echo '<a href="banan.php?act=delViolation&amp;id=' . $user['id'] . '&amp;ban=' . $res['id'] . '">Удалить предупреждение</a>';
                echo '</div></div>';
                ++$i;
            }
        } else {
            echo '<div class="menu"><p>Пусто</p></div>';
        }
        echo '<div class="phdr">Всего: ' . $total . '</div>';
        if ($total > $kmess) {
            echo '<div class="bmenu">' . pagenav('banan.php?act=violation&amp;id=' . $id . '&amp;', $start, $total, $kmess) . '</div>' . '<p><form action="banan.php?act=violation&amp;id=' . $id . '&amp;" method="post">' . '<input type="text" name="page" size="2"/>' . '<input type="submit" value="' . $lng['to_page'] . ' &gt;&gt;"/></form></p>';
        }
        break;
    default:
        ////////////////////////////////////////////////////////////
        // История нарушений                                      //
        ////////////////////////////////////////////////////////////
        echo '<div class="phdr"><b>История нарушений</b></div>';
        if ($user['id'] != $user_id) echo '<div class="gmenu"><p>' . show_user($user, 0, ($rights >= 6 ? 1 : 0)) . '</p></div>';
        else  echo '<div class="gmenu"><p>Мои нарушения</p></div>';
        $req = mysql_query("SELECT * FROM `cms_ban_users` WHERE `user_id`='" . $user['id'] . "' ORDER BY `ban_time` DESC");
        $total = mysql_num_rows($req);
        if ($total) {
            while ($res = mysql_fetch_array($req)) {
                echo '<div class="' . ($res['ban_time'] > $realtime ? 'rmenu' : 'menu') . '">';
                echo '<a href="banan.php?act=details&amp;id=' . $user['id'] . '&amp;ban=' . $res['id'] . '">' . date("d.m.Y", $res['ban_while']) . '</a> <b>' . $ban_term[$res['ban_type']] . '</b>';
                echo '</div>';
            }
        } else {
            echo '<div class="menu"><p>Список пуст</p></div>';
        }
        echo '<div class="phdr">Всего нарушений: ' . $total . '</div>';
        echo '<p>' . ($rights == 9 && $total ? '<a href="banan.php?act=delhist&amp;id=' . $user['id'] . '">Очистить историю</a><br />' : '') . ($rights >= 6 ? '<a href="../' . $admp . '/index.php?act=usr_ban">Бан панель</a>' : '') . '</p>';
}
echo'<div class="fmenu"><div style="text-align:center"><a href="' . $home2 . '/">FUTMEN.NET</a></div></div>';

?>