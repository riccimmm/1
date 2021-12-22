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

        ////////////////////////////////////////////////////////////
        // Сообщение об ошибке                                    //
        ////////////////////////////////////////////////////////////
        $idd = check($_GET['idd']);
        $id2 = check($_GET['id2']);
        if (empty ($idd)) {
            require_once ("../incfiles/head.php");
            echo "Ошибка!<br/><a href='?'>В чат</a><br/>";
            require_once ("../incfiles/end.php");
            exit;
        }
        /////////////// Проверка на спам/////////////////   
        $old = ($rights) ? 5 : 10;
        if ($datauser['lastpost'] > ($realtime - $old)) {
            require_once ("../incfiles/head.php");
            echo '<p><b>Антифлуд!</b><br />Вы не можете так часто писать<br/>Порог ' . $old . ' секунд<br/><br/><a href="index.php?id=' . $id . '">Назад</a></p>';
            require_once ("../incfiles/end.php");
            exit;
        }
        /////////////////////////////////////////////////
        $type = mysql_query("SELECT * FROM `chat` WHERE `id` = '" . $idd . "' LIMIT 1");
        $type1 = mysql_fetch_array($type);
        
                ////////////////////////////////////////////////////////////
                //
                ////////////////////////////////////////////////////////////
                $th = $type1['refid'];
                $th2 = mysql_query("select * from `chat` where id= '" . $th . "';");
                $th1 = mysql_fetch_array($th2);
                $idd = check($_GET['idd']);
                if (isset ($_POST['submit'])) {
                    
                    if (empty ($_POST['msg'])) {
                        require_once ("../incfiles/head.php");
                        echo "Вы не ввели сообщение!<br/><a href='otv.php?idd=" . $idd . "'>Повторить</a><br/>";
                        require_once ("../incfiles/end.php");
                        exit;
                    }     
                    
                    $msg = check(trim($_POST['msg'])); 
            if ($_POST['msgtrans'] == 1) {
                $msg = trans($msg);
            }
            $to = $type1['from'];
            if (!empty ($_POST['citata'])) {
                // Если была цитата, форматируем ее и обрабатываем
                $citata = trim($_POST['citata']);
                $citata = preg_replace('#\[c\](.*?)\[/c\]#si', '', $citata);
                $citata = mb_substr($citata, 0, 200);
                $citata = preg_replace('#&#si', '&amp;', $citata);
                $tp = date("d.m.Y/H:i", $type1['time']);
                $to = $type1['from'];
                $repl = '[c]' . $to . ' (' . $tp . ")\r\n<br />" . $citata . '[/c]';
            }
            elseif (isset ($_POST['txt'])) { 
                // Если был ответ, обрабатываем реплику
                $txt = intval($_POST['txt']);
                switch ($txt) {
                    case 2 :
                        $repl = $type1['from'] . ', с удовольствием тебе отвечу, ';
                        break;
                    case 3 :
                        $id2 = intval($_GET['id2']);
                        $tp = date("d.m.Y/H:i", $type1['time']);
                        $repl = $type1['from'] . ', на твой пост ([url=' . $home . '/chat/index.php?act=post&amp;id2=' . $id2 . '&amp;idd=' . $idd . ']' . $tp . '[/url]) отвечу, ';
                        break;
                    case 4 :
                        $repl = $type1['from'] . ', канай отсюда редиска! Маргалы выкалю, рога поотшибаю! ';
                        break;
                    default :
                        $repl = $type1['from'] . ', ';    
                }
                
            }    
                    
                    $priv = intval($_POST['priv']);
                    $msg = check(trim($_POST['msg']));
                    $msg = mb_substr($msg, 0, 500);
                    if ($_POST['msgtrans'] == 1) {
                        $msg = trans($msg);
                    }
                   mysql_query("insert into `chat` values(0,'" . $th . "','','m','" . $realtime . "','" . $login . "','" . $datauser['id'] . "','" . $priv . "','" . $repl.$msg . "','" . $ipp . "','" . mysql_real_escape_string($agn) . "','','');"
                    );
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
                   header("location: $home/chat/index.php?id=$th");
                }
                else {
                    require_once ("../incfiles/head.php");
                    $udat = mysql_fetch_array(mysql_query("select * from `users` where id='" . $type1['to'] . "';"));
                    $se = unserialize($udat['set_chat']);
                    $idd = intval($_GET['idd']);
                        if (isset ($_GET['cyt'])) {
                // Форма с цитатой
                echo '<div class="phdr">комната: <b>' . $th1['text'] . '</b></div><div class="menu"><b>Автор:</b> ' . $type1['from'] . '<br />Настроение: '. $se['mood'] . '<br /></div><form action="otv.php?idd=' . $idd . '" method="post">';
                echo '<div class="menu"><b>Цитата:</b><br/><textarea cols="' . $set_chat['carea_w'] . '" rows="' . $set_chat['carea_h'] . '" name="citata">' . $type1['text'] . '</textarea>';
                echo '<br /><small>Допустимо макс. 200 символов.<br />Весь лишний текст обрезается.</small></div>';
            }
            else {
                // Форма с репликой
                $tp = date("d.m.Y/H:i", $type1['time']);
                echo '<div class="phdr">комната: <b>' . $th1['text'] . '</b></div><div class="menu"><b>Кому:</b> ' . $type1['from'] . '<br />Настроение: '. $se['mood'] . '<br /></div><form action="otv.php?idd=' . $idd . '&amp;id2=' . $id2 . '" method="post">';
                echo '<div class="menu">Выберите вариант обращения:<br />';
                echo '<input type="radio" value="1" checked="checked" name="txt" />&nbsp;' . $type1['from'] . ',<br />';
                echo '<input type="radio" value="2" name="txt" />&nbsp;' . $type1['from'] . ', с удовольствием тебе отвечу,<br />';
                echo '<input type="radio" value="3" name="txt" />&nbsp;' . $type1['from'] . ', на твой пост (<a href="index.php?act=post&amp;idd=' . $idd . '&amp;id2=' . $id2 . '">' . $tp . '</a>) отвечу,<br />';
                echo '<input type="radio" value="4" name="txt" />&nbsp;' . $type1['from'] . ', канай отсюда редиска! Маргалы выкалю, рога поотшибаю!<br />';
                echo '<small>Выбранный текст будет вставлен перед Вашим текстом, который Вы напишите ниже.</small>';
                echo '</div>';
            }
                    echo '<div class="gmenu"><b>Сообщение</b> (max. 500):<br/>';
                    echo "<textarea cols='" . $set_chat['carea_w'] . "' rows='" . $set_chat['carea_h'] . "' title='Введите ответ' name='msg'></textarea><br/>";
                    if ($set_user['translit'])
                        echo '<input type="checkbox" name="msgtrans" value="1" /> Транслит сообщения<br/>';
                    echo '<select name="priv">';
                    echo '<option value="0">Всем</option>';
                    echo '<option value="' . $type1['to'] . '">Приватно</option>';
                    echo '</select><br/>';
                    echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/><br/></div></form>";
                    echo "<a href='index.php?act=trans'>Транслит</a><br/><a href='../str/smile.php'>Смайлы</a><br/>";
                    echo "<br/><a href='../str/pradd.php?act=write&amp;adr=" . $type1['to'] . "'>Написать в приват</a><br/>";
                      if (($rights == 2 || $rights >= 6)) {
                          echo "<a href='../str/users_ban.php?act=ban&amp;id=" . $type1['to'] . "'>Пнуть</a><br/>";
                       }
                    echo "<a href='index.php?id=" . $type1['refid'] . "'>Назад</a><br/>";
                    require_once ("../incfiles/end.php");
                }

?>