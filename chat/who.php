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

require_once ('../incfiles/core.php');
$headmod = $id ? 'chat,' . $id : 'chat';
$textl = 'Кто в чате';
require_once ("../incfiles/head.php");
if (!empty ($_SESSION['uid'])) {
    if (!empty ($_GET['id'])) {
        $id = check(intval($_GET['id']));
        $typ = mysql_query("select * from `chat` where id='" . $id . "';");
        $ms = mysql_fetch_array($typ);
        if ($ms['type'] != "r") {
            echo "Ошибка!<br/><a href='index.php'>В чат</a><br/>";
            require_once ("../incfiles/end.php");
            exit;
        }
 echo '<div class="phdr"><b>' . $ms['text'] . '</b></div>';
        $onltime = $realtime - 300;
        $q = mysql_query("select * from `users` where  lastdate>='" . intval($onltime) . "' AND `place` = 'chat," . $id . "'");
        while ($arr = mysql_fetch_array($q)) {
           
            $wh = $arr['name'];
            $wher = $wh2[0];
            $wh2 = array();
            if ($wher == $whr) {
              if ($ms['dpar'] != "in") {
                  echo is_integer($i / 2) ? '<div class="list1">' : '<div class="list2">';
                  echo show_user($arr, 1, (($rights >= 1 && $rights >= $arr['rights']) ? 1 : 0)) . '</div>';
                $i++;
              }
            }
            $z++;
        }
        echo "<div class='phdr'>В комнате $z человек</div>";
        echo "<p><a href='index.php?id=" . $id . "'>Назад</a></p>";
    }
    else {
        echo '<div class="phdr"><a href="index.php"><b>В прихожей</b></a>:</div>';
        ///////////////////////
        $onltime = $realtime - 300;
        $q1 = mysql_query("select * from `users` where  lastdate>='" . intval($onltime) . "' AND `place` = 'chat'");
        while ($arr1 = mysql_fetch_array($q1)) {
        echo is_integer($i / 2) ? '<div class="list1">' : '<div class="list2">';
         $wh2 = array();
         $uz[] = $arr['name'];
         echo show_user($arr1, 1, (($rights >= 1 && $rights >= $arr1['rights']) ? 1 : 0)) . '</div>';
         ++$i;
        }
        $c = count($uz);
            if ($c == 0) 
            {
              echo '<p><font color="#FF0000"><b>Никого</b></font></p>';
            }
            $uz = array();
        $kom = mysql_query("select * from `chat` where type='r' order by realid ;");
        while ($mass = mysql_fetch_array($kom)) {
            echo "<div class='phdr'><a href='index.php?id=" . $mass['id'] . "'><b>" . $mass['text'] . "</b></a>:</div>";
     $q =  mysql_query("select * from `users` where  lastdate>='" . intval($onltime) . "' AND `place` = 'chat," . $mass['id'] . "'");
            while ($arr = mysql_fetch_array($q)) {
             echo is_integer($i / 2) ? '<div class="list1">' : '<div class="list2">';
                $wh2 = array();
                $uz[] = $arr['name'];
                echo show_user($arr, 1, (($rights >= 1 && $rights >= $arr['rights']) ? 1 : 0)) . '</div>';
          ++$i;
        }
            $c = count($uz);
            if ($c == 0) 
            {
              echo '<p><font color="#FF0000"><b>Никого</b></font></p>';
            }
            $uz = array();
        }
    }
  echo "<p><a href='index.php'>В чат</a></p>";
}
else {
    echo "Вы не авторизованы!<br/>";
}
require_once ("../incfiles/end.php");

?>