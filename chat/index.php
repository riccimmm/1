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

$textl = 'Чат';

require_once ("../incfiles/core.php");

// Ограничиваем доступ к Чату
$error = '';
if (!$set['mod_chat'] && $rights < 7)
    $error = 'Чат закрыт';
elseif ($ban['1'] || $ban['12'])
    $error = 'Для Вас доступ в Чат закрыт';
elseif (!$user_id)
    $error = 'Доступ в Чат открыт только <a href="../in.php">авторизованным</a> посетителям';
if ($error) {
    require_once ("../incfiles/head.php");
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
    require_once ("../incfiles/end.php");
    exit;
}

////////////////////////////////////////////////////////////
// Настройки Чата                                         //
////////////////////////////////////////////////////////////
$set_chat = array();
$set_chat = unserialize($datauser['set_chat']);
if (empty ($set_chat)) {
    $set_chat['refresh'] = 20;
    $set_chat['chmes'] = 10;
    $set_chat['carea'] = 0;
    $set_chat['carea_w'] = 20;
    $set_chat['carea_h'] = 2;
    $set_chat['mood'] = 'нейтральное';
}

// Фиксируем местонахождение пользователя
$headmod = !empty ($id) ? 'chat,' . $id : 'chat';

switch ($act) {
    case "room2" :
        ////////////////////////////////////////////////////////////
        // Удаление поста                                         //
        ////////////////////////////////////////////////////////////
        if (($rights == 9) && $id) {
            $id2 = check($_GET['id2']);
            $typ = mysql_query("SELECT * FROM `chat` WHERE `id` = '" . $id2 . "' LIMIT 1");
            $ms = mysql_fetch_array($typ);
            $type2 = mysql_query("SELECT * FROM `users` WHERE `id` = '" . $ms['to'] . "' LIMIT 1");
            $type3 = mysql_fetch_array($type2);
            if ($ms['type'] == "r") {
                require_once ("../incfiles/head.php");
                echo "Ошибка!<br/><a href='index.php?'>В чат</a><br/>";
                require_once ("../incfiles/end.php");
                exit;
            }
            if (isset ($_GET['yes'])) {
                mysql_query("DELETE FROM `chat` WHERE `id` = '" . $id2 . "'");
              if ($ms['nas']!=1) {
                $fpst = $type3['postchat'] - 1;
         mysql_query("UPDATE `users` SET `postchat` = '" . $fpst . "' WHERE `id` = '" . $ms['to'] . "'");
              }   
            }
            else {
                require_once ("../incfiles/head.php");
                echo '<p>Вы действительно хотите удалить пост?<br/><a href="index.php?act=room2&amp;id=' . $id . '&amp;id2=' . $id2 . '&amp;yes">Да</a> | <a href="index.php?id=' . $id . '">Нет</a></p>';
            require_once ("../incfiles/end.php");
            exit;
            }
        }
        header("Location: $home/chat/index.php?id=$id");
        break;

    case "moders" :
        ////////////////////////////////////////////////////////////
        // Список модераторов чата                                //
        ////////////////////////////////////////////////////////////
        require_once ("../incfiles/head.php");
        echo "<div class='phdr'><b>Модераторы чата</b></div>";
        $mod = mysql_query("select * from `users` where rights='2';");
        $mod2 = mysql_num_rows($mod);
        if ($mod2 != 0) {
   while ($res = mysql_fetch_assoc($mod)) {
    echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
    echo show_user($res, 1, (($rights >= 1 && $rights >= $res['rights']) ? 1 : 0)) . '</div>';
    ++$i;
}
        }
        else {
            echo '<p><font color="#FF0000"><b>Не назначены</b></font></p>';
        }
        echo "<div class='phdr'><a href='index.php?id=" . $id . "'>Назад</a></div>";
        require_once ("../incfiles/end.php");
        break;

    case "trans" :
        ////////////////////////////////////////////////////////////
        //
        ////////////////////////////////////////////////////////////
        require_once ("../incfiles/head.php");
        include ("../pages/trans.$ras_pages");
        echo '<br/><br/><a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Назад</a><br/>';
        require_once ("../incfiles/end.php");
        break;

///////////////////////////

 case "post" :
        ////////////////////////////////////////////////////////////
        // Отдельный пост                                         //
        ////////////////////////////////////////////////////////////
        require_once ("../incfiles/head.php");
        $id2 = check(intval($_GET['id2'])); // Ид владельца сообщения
        $idd = check(intval($_GET['idd'])); // Ид сообщения
       if (empty ($id2)) {
    echo "Ошибка!<br/><a href='?'>В чат</a><br/>";
    require_once ("../incfiles/end.php");
    exit;
}
 if (empty ($idd)) {
    echo "Ошибка!<br/><a href='?'>В чат</a><br/>";
    require_once ("../incfiles/end.php");
    exit;
}
// Запрос сообщения
$mass = mysql_fetch_array(mysql_query("SELECT * FROM `chat` WHERE `id` = '" . $idd . "'"));
$mass1 = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '" . $id2 . "'"));
$text = tags($mass['text']); // Текст сообщения
$refid = $mass['refid']; // Ид темы
$nik = $mass1['name']; // Ник владельца сообщения
$t = mysql_fetch_array(mysql_query("SELECT * FROM `chat` WHERE `id` = '" . $refid . "'"));
$tema = $t['text']; // Название темы
// Запрос Комнаты
echo '<div class="phdr"><b>Комната:</b> ' . $tema . '</div><div class="menu">';
//Аватар:
if ($set_user['avatar']) {
  echo '<table cellpadding="0" cellspacing="0"><tr><td>';
  if (file_exists(('../files/avatar/' . $mass1['id'] . '.png')))
    echo '<img src="../files/avatar/' . $mass1['id'] . '.png" width="32" height="32" alt="" />&nbsp;';
 else
    echo '<img src="../images/empty.png" width="32" height="32" alt="' . $mass1['from'] . '" />&nbsp;';
  echo '</td><td>';
}
////////
// Значок пола
if ($mass1['sex'])
    echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($mass1['sex'] == 'm' ? 'm' : 'w') . '.png" alt=""  width="16" height="16"/>&nbsp;';
else
    echo '<img src="../images/del.png" width="12" height="12" />&nbsp;';
// Ник юзера и ссылка на его анкету
if ((!empty ($_SESSION['uid'])) && ($_SESSION['uid'] != $mass1['to'])) {
    echo '<a href="../str/anketa.php?id=' . $id2 . '"><b>' . $nik . '</b></a> ';
// Ссылки на ответ и цитирование
    echo '<a href="otv.php?idd=' . $idd . '&amp;id2=' . $id2 . '">[о]</a>&nbsp;<a href="otv.php?idd=' . $idd . '&amp;cyt">[ц]</a> ';
}
else {
    echo '<b>' . $nik . '</b>';
}
// Выводим метку должности
                   $user_rights = array(2 => ' (CMod)', 6 => ' (Smd)', 7 => ' (Adm)', 9 => ' (Adm)');
                    echo $user_rights[$mass1['rights']];
// Метка Онлайн / Офлайн
echo ($realtime > $mass1['lastdate'] + 300 ? '<span class="red"> [Off]</span> ' : '<span class="green"> [ON]</span> ');
// Время поста
$vrp = $mass['time'] + $set_user['sdvig'] * 3600;
$vr = date("d.m.Y/H:i", $vrp);                    // Время поста
echo ' <span class="gray">(' . $vr . ')</span><br/>';
if (!empty ($mass1['status']))
    echo '<div class="status"><img src="../theme/' . $set_user['skin'] . '/images/label.png" alt="" align="middle"/>&nbsp;' . $mass1['status'] . '</div>';
//--//Аватар:
 if ($set_user['avatar']) {
echo '</td></tr></table>';
}
//--//
// Статус юзера
if  ($set_user['smileys'])
    $text = smileys($text, ($mass1['rights'] >= 1) ? 1 : 0);
echo $text . '</div>';
echo '<div class="phdr"><a href="index.php?id=' . $refid . '">Вернуться в комнату</a></div>';
 echo '<p><a href="who.php">Кто в чате? (' . wch(0, 2) . ')</a></p>';
echo '<p><a href="index.php">В прихожую</a></p>';

        require_once ("../incfiles/end.php");
        break;

    case "say" :
        ////////////////////////////////////////////////////////////
        //
        ////////////////////////////////////////////////////////////
        if (empty ($id)) {
            require_once ("../incfiles/head.php");
            echo "Ошибка!<br/><a href='?'>В чат</a><br/>";
            require_once ("../incfiles/end.php");
            exit;
        }

        // Проверка на спам
        $old = ($rights) ? 5 : 10;
        if ($datauser['lastpost'] > ($realtime - $old)) {
            require_once ("../incfiles/head.php");
            echo '<p><b>Антифлуд!</b><br />Вы не можете так часто писать<br/>Порог ' . $old . ' секунд<br/><br/><a href="index.php?id=' . $id . '">Назад</a></p>';
            require_once ("../incfiles/end.php");
            exit;
        }
        $type = mysql_query("SELECT * FROM `chat` WHERE `id` = '" . $id . "' LIMIT 1");
        $type1 = mysql_fetch_array($type);
        $tip = $type1['type'];
        switch ($tip) {
            case "r" :
                if (isset ($_POST['submit'])) {
                    if (empty ($_POST['msg'])) {
                        require_once ("../incfiles/head.php");
                        echo "Вы не ввели сообщение!<br/><a href='index.php?act=say&amp;id=" . $id . "'>Повторить</a><br/>";
                        require_once ("../incfiles/end.php");
                        exit;
                    }
                    // Принимаем сообщение и записываем в базу
                    $msg = check(trim($_POST['msg']));
                    $msg = mb_substr($msg, 0, 500);
                    if ($_POST['msgtrans'] == 1) {
                        $msg = trans($msg);
                    }
                    $agn = strtok($agn, ' ');
                    mysql_query("insert into `chat` values(0,'" . $id . "','','m','" . $realtime . "','" . $login . "','" . $datauser['id'] . "','0','" . $msg . "','" . $ipp . "','" . mysql_real_escape_string($agn) . "','','');");
                    if (empty ($datauser['postchat'])) {
                        $fpst = 1;
                    }
                    else {
                        $fpst = $datauser['postchat'] + 1;
                    }
                    mysql_query("UPDATE `users` SET
						`postchat` = '" . $fpst . "',
						`lastpost` = '" . $realtime . "'
						WHERE `id` = '" . $user_id . "';");
                    if ($type1['dpar'] == "vik") {
                        $protv = mysql_query("select * from `chat` where dpar='vop' and type='m' order by time desc;");
                        while ($protv2 = mysql_fetch_array($protv)) {
                            $prr[] = $protv2['id'];
                        }
                        $pro = mysql_query("select * from `chat` where dpar='vop' and type='m' and id='" . $prr[0] . "';");
                        $protv1 = mysql_fetch_array($pro);
                        $prr = array();
                        $ans = $protv1['realid'];
                        $vopr = mysql_query("select * from `vik` where id='" . $ans . "';");
                        $vopr1 = mysql_fetch_array($vopr);
                        $answer = $vopr1['otvet'];
                        if (!empty ($msg) && !empty ($answer) && $protv1['otv'] != 1) {
                            if (preg_match("/$answer/i", "$msg")) {
                                $itg = $datauser['otvetov'] + 1;
                                switch ($protv1['otv']) {
                                    case "2" :
                                        $pods = ", не используя подсказок";
                                        $bls = 5;
                                        break;
                                    case "3" :
                                        $pods = ", используя одну подсказку";
                                        $bls = 3;
                                        break;
                                    case "4" :
                                        $pods = ", используя две подсказки";
                                        $bls = 2;
                                        break;
                                }
                                $balans = $datauser['balans'] + $bls;
                                $otvtime = $realtime - $protv1['time'];
                                if ($datauser['sex'] == "m") {
                                    $tx =
                                    "$login молодец! Ты угадал правильный ответ:  $answer за $otvtime секунд $pods ,и заработал $bls баллов. Всего правильных ответов:<b>$itg</b>, твой игровой баланс $balans баллов.";
                                }
                                else {
                                    $tx =
                                    "$login молодец! Ты угадала правильный ответ:  $answer за $otvtime секунд $pods ,и заработала $bls баллов. Всего правильных ответов:<b>$itg</b>, твой игровой баланс $balans баллов.";
                                }
                                $mtim = $realtime + 1;
                                mysql_query("INSERT INTO `chat` VALUES(
'0','" . $id . "','','m','" . $mtim . "','Умник','','', '" . $tx . "', '127.0.0.1', 'Nokia3310', '','');");
                                mysql_query("update `chat` set otv='1' where id='" . $protv1['id'] . "';");
                                mysql_query("update `users` set otvetov='" . $itg . "',balans='" . $balans . "' where id='" . intval($_SESSION['uid']) . "';");
                            }
                        }
                    }
                    header("location: $home/chat/index.php?id=$id");
                }
                else {
                    require_once ("../incfiles/head.php");
                    echo '<div class="phdr"><b>Комната: ' . $type1['text'] . '</b></div>';
                    echo '<div class="gmenu">Сообщение(max. 500):';
                    echo "<form action='index.php?act=say&amp;id=" . $id . "' method='post'><textarea cols='" . $set_chat['carea_w'] . "' rows='" . $set_chat['carea_h'] .
                    "' title='Введите текст сообщения' name='msg'></textarea><br/>";
                    if ($set_user['translit'])
                        echo "<input type='checkbox' name='msgtrans' value='1' /> Транслит сообщения<br/>";
                    echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/></form></div>";
                    echo "<p><a href='index.php?act=trans'>Транслит</a> | <a href='../str/smile.php'>Смайлы</a></p>";
                    echo "<p><a href='index.php?id=" . $id . "'>Назад</a></p>";
                    require_once ("../incfiles/end.php");
                }
                break;

            default :
                require_once ("../incfiles/head.php");
                echo "Ошибка!<br/>&#187;<a href='?'>В чат</a><br/>";
                require_once ("../incfiles/end.php");
                break;
        }
        require_once ("../incfiles/head.php");
        break;

    case "chpas" :
        ////////////////////////////////////////////////////////////
        //
        ////////////////////////////////////////////////////////////
        $_SESSION['intim'] = "";
        header("location: $home/chat/index.php?id=$id");
        break;

    case "pass" :
        ////////////////////////////////////////////////////////////
        //
        ////////////////////////////////////////////////////////////
        $parol = check($_POST['parol']);
        $_SESSION['intim'] = $parol;
        mysql_query("update `users` set alls='" . $parol . "' where id='" . intval($_SESSION['uid']) . "';");
        header("location: $home/chat/index.php?id=$id");
        break;

    default :
        ////////////////////////////////////////////////////////////
        //
        ////////////////////////////////////////////////////////////
        if ($id) {
            // Отображаем комнату Чата
            require_once ('room.php');
        }
        else {
            // Отображаем прихожую Чата
            require_once ('hall.php');
        }
}

?>