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

require_once ("../incfiles/core.php");

if ($rights != 9){
header("location: $home");
}

        ////////////////////////////////////////////////////////////
        // Очищаем комнату                                        //
        ////////////////////////////////////////////////////////////
        
            $typ = mysql_query("SELECT * FROM `chat` WHERE `id` = '" . $id . "' LIMIT 1");
            $ms = mysql_fetch_array($typ);
            if ($ms['type'] != "r") {
                require_once ("../incfiles/head.php");
                echo "Ошибка!<br/><a href='index.php?'>В чат</a><br/>";
                require_once ("../incfiles/end.php");
                exit;
            }
            
            if (isset ($_GET['1n'])) {
            mysql_query("DELETE FROM `chat` WHERE `refid` = '" . $id . "' AND `time`<='" . ($realtime - $realtime - 604800) . "';");
            mysql_query("OPTIMIZE TABLE `chat`;");
            require_once ("../incfiles/head.php");
            echo 'Все сообщения, старше 1 недели удалены.<br /><a href="index.php?id='.$id.'">В комнату</a><br />';
            require_once ("../incfiles/end.php");
            exit;
            }
            
            elseif (isset ($_GET['yes'])) {
                mysql_query("DELETE FROM `chat` WHERE `refid` = '" . $id . "'");
                mysql_query("OPTIMIZE TABLE `chat`;");
               require_once ("../incfiles/head.php");
               echo 'Удалены все сообщения.<br /><a href="index.php?id='.$id.'">В комнату</a><br />';
               require_once ("../incfiles/end.php");
               exit;
            }
            
            elseif (isset ($_GET['1d'])) {
            mysql_query("DELETE FROM `chat` WHERE `refid` = '" . $id . "' AND `time`<='" . ($realtime - 86400) . "';");
            mysql_query("OPTIMIZE TABLE `chat`;");
            require_once ("../incfiles/head.php");
            echo 'Удалены все сообщения, старше 1 дня.<br /><a href="index.php?id='.$id.'">В комнату</a><br />';
            require_once ("../incfiles/end.php");
            exit;
            }
            
            else {
                require_once ("../incfiles/head.php");
                echo '<div class="phdr"><b>Очистить комнату:</b></div><p><a href="?yes&amp;id=' . $id . '">Все сообщения</a><br />
                <a href="?1d&amp;id=' . $id . '">Сообщения старше 1 дня</a><br />
                <a href="?1n&amp;id=' . $id . '">Сообщения старше 1 недели</a></p>';
                require_once ("../incfiles/end.php");
            }

?>