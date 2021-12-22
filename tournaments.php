<?php

define('_IN_JOHNCMS', 1);

$textl = 'Кубковые турниры - FUTMEN.NET';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
//require_once ("manag.php");


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

    if (mysql_num_rows($manager) == 0) {
        echo "Команды не существует<br/>";
        require_once ("incfiles/end.php");
        exit;
    }


    if ($id) {
        $sql = "WHERE `liga`='$id'";
    } else {
        $sql = "WHERE `liga`='1'";
        $id = 1;
    }
    echo '<div class="phdr">Кубковые турниры</div>';
    if ($rights == 9) {
        echo '<div class="menu">';
        echo "<br/><center><b><a class='redbutton' href='admin.php?act=tur&amp;id=$id'>Добавить турнир</a></b></center><br/>";
        echo '</div>';
    }

    $total_tourn = mysql_result(mysql_query("SELECT COUNT(*) FROM `tournaments_2` WHERE `liga`='" .$id . "' "), 0);

    if ($total_tourn > 0) {
        $req = mysql_query("SELECT * FROM `tournaments_2` $sql order by `status`, `id`, `time` asc;");
        while ($arr = mysql_fetch_array($req)) {
            $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `start_2` WHERE `chemp`='" .
                $arr['name'] . "' "), 0);
            echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '' : '';

            if ($arr[status] == 1)
                $finish = '<font color="red">[завершен]</font>';

            echo '
<table id="example">
<tr class="oddrows">
<td width="48px" align="center"><img src="img/' . $arr['path'] . '.jpg"  alt="' .
                $arr['name'] . ' " width="42" height="62"/></td>
<td width="100%"><a href="cup_' . $arr['id'] . '">' . $arr['name'] .
                '</a>&nbsp;' . $finish . '<br/>
Приз: ' . $arr['priz'] . ' €<br/>
Начало:[' . date("d.m.y / H:i", $arr['time']) . ']<br/>';
            if ($arr[status] == 1){
                $total = 16;
}
            echo 'Участников: ' . $total . '  из ' . $arr['komand'] . '<br/>

';
            $lvl = explode('|', $arr['max_lvl']);
            if ($lvl[0] != $lvl[1]) {
                echo 'Уровень участников: от  <b>' . $lvl[0] . '</b> до <b>' . $lvl[1] . '</b>';
            } else {
                echo 'Уровень участников:   <b>' . $lvl[0] . '</b> ';
            }
            echo '</td></tr></table><hr/>';
            ++$i;
        }

        echo '<div class="phdr">';
        echo "Всего турниров: $total_tourn";
        echo '</div>';


    } else {
        echo '<div class="rmenu">';
        echo "В этой лиге нет турниров!";
        echo '</div>';
    }

require_once ("incfiles/end.php");