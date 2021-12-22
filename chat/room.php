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

defined('_IN_JOHNCMS') or die('Error:restricted access');

////////////////////////////////////////////////////////////
// Комнаты Чата                                           //
////////////////////////////////////////////////////////////
$type = mysql_query("SELECT * FROM `chat` WHERE `id`= '$id' LIMIT 1");
$type1 = mysql_fetch_array($type);
$tip = $type1['type'];
switch ($tip) {
    case "r" :
        if ($type1['dpar'] != "in") {
            $_SESSION['intim'] = "";
        }
        if ($type1['dpar'] == "in") {
            if (empty ($_SESSION['intim'])) {
                require_once ("../incfiles/head.php");
                echo '<div class="phdr"><b>Интим</b></div>';
                echo '<div class="gmenu">';
                echo "<form action='index.php?act=pass&amp;id=" . $id .
                "' method='post'>Пароль (max. 10):<br/><input type='text' name='parol' size='10' maxlength='10'/><input type='submit' name='submit' value='Ok!'/></form></div><p><a href='index.php'>Прихожая</a></p>";
                require_once ("../incfiles/end.php");
                exit;
            }
        }
        if ($type1['dpar'] == "vik") {
            $prvik = mysql_query("select * from `chat` where dpar='vop' and type='m';");
            $prvik1 = mysql_num_rows($prvik);
            if ($prvik1 == "0") {
                mysql_query("INSERT INTO `chat` VALUES(
'0', '" . $id . "','', 'm', '" . $realtime . "','Умник','','vop','Начинаем Викторину', '127.0.0.1', 'Nokia3310','','5');");
            }
            $protv = mysql_query("select * from `chat` where dpar='vop' and type='m' order by time desc;");
            while ($protv1 = mysql_fetch_array($protv)) {
                $prr[] = $protv1['id'];
            }
            $pro = mysql_query("select * from `chat` where dpar='vop' and type='m' and id='" . $prr[0] . "';");
            $prov = mysql_fetch_array($pro);
            $prr = array();

            ////////////////////////////////////////////////////////////
            // Первая подсказка Умника                                //
            ////////////////////////////////////////////////////////////
            if ($prov['otv'] == "2" && $prov['time'] < intval($realtime - 50))                // Время ожидания от начала до первой подсказки
                {
                $vopr = mysql_query("select * from `vik` where id='" . $prov['realid'] . "';");
                $vopr1 = mysql_fetch_array($vopr);
                $ans = $vopr1['otvet'];
                $b = mb_strlen($ans);
                if ($b < 4) {
                    $e = 4;
                }
                else {
                    $e = 3;
                }
                $d = round($b / 4);
                $c = mb_substr($ans, 0, $d);
                for ($i = $d; $i < $b;++$i) {
                    $c = "$c*";
                }
                mysql_query("INSERT INTO `chat` VALUES(
'0', '" . $id . "','', 'm','" . $realtime . "','Умник','','', 'Подсказка " . $c . "', '127.0.0.1', 'Nokia3310', '', '');");
                mysql_query("update `chat` set otv='" . $e . "' where id='" . $prov['id'] . "';");
            }

            ////////////////////////////////////////////////////////////
            // Вторая подсказка Умника                                //
            ////////////////////////////////////////////////////////////
            if ($prov['otv'] == "3" && $prov['time'] < intval($realtime - 100))                // Время ожидания от начала до второй подсказки
                {
                $vopr = mysql_query("select * from `vik` where id='" . $prov['realid'] . "';");
                $vopr1 = mysql_fetch_array($vopr);
                $ans = $vopr1['otvet'];
                $b = mb_strlen($ans);
                $d = (round($b / 3)) + 1;
                //if ($d == 1)
                //    $d = 2;
                $c = mb_substr($ans, 0, $d);
                for ($i = $d; $i < $b;++$i) {
                    $c = "$c*";
                }
                mysql_query("INSERT INTO `chat` VALUES(
'0', '" . $id . "','', 'm','" . $realtime . "','Умник','','', 'Вторая подсказка " . $c . "', '127.0.0.1', 'Nokia3310', '', '');");
                mysql_query("update `chat` set otv='4' where id='" . $prov['id'] . "';");
            }
             if ($prov['otv'] == "5" && $prov[time] < intval($realtime - 15))                // Пауза перед новым вопросом
                {
                $v = mysql_query("select * from `vik` ;");
                $c = mysql_num_rows($v);
                $num = rand(1, $c);
                $vik = mysql_query("select * from `vik` where id='" . $num . "';");
                $vik1 = mysql_fetch_array($vik);
                $vopros = $vik1['vopros'];
                $len = mb_strlen($vik1['otvet']);
                mysql_query("INSERT INTO `chat` VALUES(
'0', '" . $id . "','" . $num . "', 'm','" . $realtime . "','Умник','','vop', '<b>Вопрос: " . $vopros . " (" . $len . " букв)</b>', '127.0.0.1', 'Nokia3310', '', '2');");
            }

            ////////////////////////////////////////////////////////////
            // Диалог Умника в викторине                              //
            ////////////////////////////////////////////////////////////
            if (!empty ($prov['time']) && $prov['time'] < ($realtime - 150))                // Общее время ожидания ответа на вопрос

                {
                // Задаем вопрос в викторине
                if ($prov['otv'] == "1") {
                    $v = mysql_query("select * from `vik` ;");
                    $c = mysql_num_rows($v);
                    $num = rand(1, $c);
                    $vik = mysql_query("select * from `vik` where id='" . $num . "';");
                    $vik1 = mysql_fetch_array($vik);
                    $vopros = $vik1['vopros'];
                    $len = mb_strlen($vik1['otvet']);
                    mysql_query("INSERT INTO `chat` VALUES(
'0', '" . $id . "','" . $num . "', 'm','" . $realtime . "','Умник','','vop', '<b>Вопрос: " . $vopros . " (" . $len .
                    " букв)</b>', '127.0.0.1', 'Nokia3310', '', '2');");
                }
                // Если не было правильного ответа, то выводим сообшение
                if ($prov['otv'] == "4") {
                    mysql_query("INSERT INTO `chat` VALUES(
'0', '" . $id . "','', 'm','" . $realtime . "','Умник','','', 'Время истекло! Вопрос не был угадан!','127.0.0.1', 'Nokia3310', '', '1');");
                    mysql_query("update `chat` set otv='1' where id='" . $prov['id'] . "';");
                }
            }
        }
        $refr = rand(0, 999);
         $arefresh = true;
        require_once ("head.php");
        echo '<div class="phdr"><b>' . $type1['text'] . '</b></div>';
        if ($set_chat['carea']) {
            echo '<div class="gmenu">';
            echo "<form action='index.php?act=say&amp;id=" . $id . "' method='post'><textarea cols='" . $set_chat['carea_w'] . "' rows='" . $set_chat['carea_h'] .
            "' title='Введите текст сообщения' name='msg'></textarea><br/>";
            if ($set_user['translit'])
                echo "<input type='checkbox' name='msgtrans' value='1' /> Транслит сообщения<br/>";
            echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Сказать'/><br/></form>";
        echo '</div><p>';
        }
        else {
              echo '<p><a href="index.php?act=say&amp;id=' . $id . '">Сказать</a><br />';
        }
        echo '<a href="index.php?id=' . $id . '&amp;refr=' . $refr . '">Обновить</a></p>';
        $req = mysql_query("SELECT COUNT(*) FROM `chat` WHERE `refid` = '" . $id . "' AND `type` = 'm'");
        $colmes = mysql_result($req, 0);
        $req = mysql_query("SELECT * FROM `chat` WHERE `refid` = '" . $id . "' AND `type` = 'm' ORDER BY `time` DESC LIMIT $start," . $set_chat['chmes']);
        $i = 0;
        while ($mass = mysql_fetch_array($req)) {
            $ign = mysql_query("SELECT COUNT(*) FROM `privat` WHERE `me` = '" . $login . "' AND `ignor` = '" . $mass['from'] . "'");
            $ign1 = mysql_result($ign, 0);
            $als = mysql_query("select * from `users` where name='" . $mass['from'] . "';");
            $als1 = mysql_fetch_array($als);
            $psw = $als1['alls'];
                if ($rights >= 7 || $mass['nas'] == 0) {
                if (empty($mass['dpar']) || $mass['dpar'] == $datauser['id'] || $mass['to'] == $datauser['id'] ||$rights == 0 || $rights >= 6) {
                    if ($type1['dpar'] != 'in' || $psw == $datauser['alls']) {
                    if ($mass['from'] != "Умник") {
                        $uz = @ mysql_query("select * from `users` where name='" . $mass['from'] . "';");
                        $mass1 = @ mysql_fetch_array($uz);
                    }
                     echo is_integer($i / 2) ? '<div class="list1">' : '<div class="list2">';
                    if ($mass['from'] != "Умник") {
                    //--//Аватар:
                      if ($set_user['avatar']) {
                         echo '<table cellpadding="0" cellspacing="0"><tr><td>';
                        if (file_exists(('../files/avatar/' . $als1['id'] . '.png')))
                            echo '<img src="../files/avatar/' . $als1['id'] . '.png" width="32" height="32" alt="" />&nbsp;';
                        else
                            echo '<img src="../images/empty.png" width="32" height="32" alt="" />&nbsp;';
                        echo '</td><td>';
                    }
                    //--//
                echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($als1['sex'] == 'm' ? 'm' : 'w') . ($als1['datereg'] > $realtime - 86400 ? '_new' : '') . '.png" width="16" height="16" align="middle" />&nbsp;';
                       if ((!empty ($_SESSION['uid'])) && ($_SESSION['uid'] != $mass['to'])) {
                            echo "<a href='../str/anketa.php?id=" . $mass1['id'] . "'><b>" .$mass['from'] . "</b></a> ";
                         // Ссылки на ответ и цитирование
                           echo '<a href="otv.php?idd=' . $mass['id'] . '&amp;id2=' . $mass1['id'] . '">[о]</a>&nbsp;<a href="otv.php?idd=' . $mass['id'] . '&amp;cyt">[ц]</a> ';
                        }
                        else {
                            echo "<b>" .$mass['from'] . "</b>";
                     }
                       }
                      else {
                    //--//Аватар:
                       if ($set_user['avatar']) {
                        echo '<table cellpadding="0" cellspacing="0"><tr><td>';
                        if (file_exists(('../files/avatar/' . $mass['to'] . '.png')))
                            echo '<img src="../files/avatar/' . $mass['to'] . '.png" width="32" height="32" alt="" />&nbsp;';
                        else
                            echo '<img src="../images/empty.png" width="32" height="32" alt="" />&nbsp;';
                        echo '</td><td>';
                    }
                    //--//
                        echo "<b>" .$mass['from'] . "</b>";
                    }
                    $vrp = $mass['time'] + $set_user['sdvig'] * 3600;
                    $vr = date("d.m.Y/H:i", $vrp);                    // Время поста
                    if ($mass['from'] != "Умник") {
                        // Выводим метку должности
                    $user_rights = array(2 => ' (CMod)', 6 => ' (Smd)', 7 => ' (Adm)', 9 => ' (Adm)');
                    echo $user_rights[$mass1['rights']];
                    // Метка Онлайн / Офлайн
                    echo ($realtime > $mass1['lastdate'] + 300 ? '<span class="red"> [Off]</span> ' : '<span class="green"> [ON]</span> ');
                    }
                    echo ' <span class="gray">(' . $vr . ')</span><br />';
                    if (!empty ($mass1['status']))
                        echo '<div class="status"><img src="../theme/' . $set_user['skin'] . '/images/label.png" alt="" align="middle"/>&nbsp;' . $mass1['status'] . '</div>';
                    if ($mass['dpar'] == $datauser['id'] || $mass['to'] == $datauser['id'] && !empty($mass['dpar'])) {
                        echo "<span class='red'>[П!]</span>";
                    }
                    //--//Аватар:
                     if ($set_user['avatar']) {
                       if ($rights >= 7 || $mass['nas'] == 0) {
                    echo '</td></tr></table>';
                    }
                    }
                    //--//
                    $text = tags($mass['text']);
                    if ($set_user['smileys'])
                        $text = smileys($text, ($mass1['rights'] >= 1) ? 1 : 0);
                    if ($rights >= 7 && $mass['nas']) {
                        echo '<span class="red">Пост удалён!</span><br/>';
                    }
                   echo'' . $text .  '<br/>';
                    //Ссылка скрыть/восстановить, удалить сообщение:
                    if ($rights == 2 || $rights >= 6){
                    echo '<div class="sub">';
                    if ($rights == 9) {
                    echo '<a href="index.php?act=room2&amp;id=' . $id . '&amp;id2=' . $mass['id'] . '">Удалить</a>';
                    if ($mass['nas'] == 1) 
                          echo ' | <a href="close.php?id=' . $id . '&amp;id2=' . $mass['id'] . '">Восстановить</a>';
                    if ($mass['nas'] == 0) 
                          echo ' | <a href="close.php?id=' . $id . '&amp;id2=' . $mass['id'] . '&amp;closed">Скрыть</a>';
                    }
                    if ($rights == 2 && $mass['nas'] == 0|| $rights == 6){
                          echo '<a href="close.php?id=' . $id . '&amp;id2=' . $mass['id'] . '&amp;closed">Удалить</a>';
                          }
                     if ($rights == 7){
                     if ($mass['nas'] == 1) 
                          echo ' | <a href="close.php?id=' . $id . '&amp;id2=' . $mass['id'] . '">Восстановить</a>';
                    if ($mass['nas'] == 0) 
                          echo ' | <a href="close.php?id=' . $id . '&amp;id2=' . $mass['id'] . '&amp;closed">Удалить</a>';
                     }
                     echo '<br /><span class="gray">' . $mass['ip'] . ' - ' . $mass['soft'] . '</span>';
                      echo "</div>";
                     }
                   echo "</div>";
                    ++$lr;
                }
                }
                }
            
             if ($rights >= 7 || $mass['nas'] == 0) {
               if (empty($mass['dpar']) || $mass['dpar'] == $datauser['id'] || $mass['to'] == $datauser['id']) {
               if ($type1['dpar'] != "in" || $psw == $datauser['alls']) {
                    ++$i;
                    }
                }
            }
        }
        echo '<div class="title2"><a href="who.php?id=' . $id . '">Кто здесь(' . wch($id) . ')</a></div>';
        echo '<a href="who.php">Кто в чате? (' . wch(0, 2) . ')</a><br/>';
        if ($colmes > $set_chat['chmes']) {
            echo '<p>' . pagenav('?id=' . $id . '&amp;', $start, $colmes, $set_chat['chmes']) . '</p>';
            echo '<p><form action="index.php" method="get">
			<input type="hidden" name="id" value="' . $id . '"/>
			<input type="text" name="page" size="2"/>
			<input type="submit" value="К странице &gt;&gt;"/></form></p>';
        }
        echo '<a href="index.php?">Прихожая</a><br/>';
        if ($type1['dpar'] == "in") {
            echo '<a href="index.php?act=chpas&amp;id=' . $id . '">Сменить пароль</a><br/>';
        }
        if ($rights == 9) {
            echo '<a href="dell.php?id=' . $id . '">Очистить комнату</a><br/>';
        }
        require_once ("end.php");
        break;

    default :
        require_once ("../incfiles/head.php");
        echo "Ошибка!<br/>&#187;<a href='index.php?'>В чат</a><br/>";
        require_once ("../incfiles/end.php");
}

?>