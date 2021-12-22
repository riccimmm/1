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

 $id2 = check($_GET['id2']);
if (($rights != 2 && $rights < 6) || !$id) {
    header('Location: index.php');
    exit;
}
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `chat` WHERE `id` = '$id2' AND `type` = 'm'"), 0)) {
  $type = mysql_query("SELECT * FROM `chat` WHERE `id` = '" . $id2 . "' LIMIT 1");
  $type1 = mysql_fetch_array($type);
  $type2 = mysql_query("SELECT * FROM `users` WHERE `id` = '" . $type1['to'] . "' LIMIT 1");
  $type3 = mysql_fetch_array($type2);
    if (isset ($_GET['closed'])){
         mysql_query("UPDATE `chat` SET `nas` = '1' WHERE `id` = '$id2'");
         $fpst = $type3['postchat'] - 1;
         mysql_query("UPDATE `users` SET `postchat` = '" . $fpst . "' WHERE `id` = '" . $type1['to'] . "'");
        }
    else{
        mysql_query("UPDATE `chat` SET `nas` = '0' WHERE `id` = '$id2'");
        $fpst = $type3['postchat'] + 1;
         mysql_query("UPDATE `users` SET `postchat` = '" . $fpst . "' WHERE `id` = '" . $type1['to'] . "'");
        }
}

header("Location: index.php?id=$id");

?>