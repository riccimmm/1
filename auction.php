<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');



        $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `team_2` where `id_admin`='0' and `strana`!='liga';"), 0);
$req = mysql_query("SELECT `id`, `name`, `logo`, `strana`, `divizion` FROM `team_2` where `id_admin`='0' and `strana`!='liga' order by `id` asc LIMIT $start, $kmess;");
if ($total != '0') {
    echo '<div class="gmenu"><b>Аукцион</b></div>';
    echo '<div class="c">';
    while ($arr = mysql_fetch_array($req)) {
        echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
        echo 'Клуб: <img src="logo/small' . $arr['logo'] .
            '" alt=""/> <a href="team.php?id=' . $arr['id'] . '">' . $arr['name'] .
            '</a><br/>';
        echo 'Чемпионат: <a href="chemp.php?act=' . $arr['strana'] . '">' . $arr['divizion'] .
            '</a><br/>';
        echo '[<a href="buyteam.php?id=' . $arr['id'] . '">Заявки</a>]<br/>';
        echo '</div>';
        ++$i;
    }
	        if ($total > $kmess) {
            echo '<p>' . pagenav('auction.php?&amp;', $start, $total, $kmess) .
                '</p>';
            echo '<p><form action="auction.php?&amp;" method="post"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        }


    echo '<div class="c">Всего: ' . $total . '</div><br/></div>';
}
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
