<?php



defined('_IN_JOHNCMS') or die('Error: restricted access');

$textl = 'Кто в менеджере?';
$headmod = 'manager2';
require_once ("incfiles/head.php");
$onltime = $realtime - 300;

if (!$user_id) {
    header('Location: index.php');
    exit;
}


$do= isset ($_GET['do']) ? $_GET['do'] : '';


    ////////////////////////////////////////////////////////////
    // Показываем общий список тех, кто в менеджере              //
    ////////////////////////////////////////////////////////////
    echo '<div class="phdr"><b>Кто в менеджере</b></div>';
    echo '<div class="bmenu">Список ' . ($do
        == 'guest' ? 'гостей' : 'авторизованных' ) . '</div>';
    $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `" . ($do
        == 'guest' ? "cms_guests" : "users" ) . "` WHERE `lastdate` > $onltime AND `place` LIKE 'manager%'" ), 0 );
    if ($total) {
        $req = mysql_query("SELECT * FROM `" . ($do
            == 'guest' ? "cms_guests" : "users" ) . "` WHERE `lastdate` > $onltime AND `place` LIKE 'manager%' ORDER BY " . ($do
                == 'guest' ? "`movings` DESC" : "`name` ASC" ) . " LIMIT $start, $kmess" );
        while ($res = mysql_fetch_assoc($req)) {
            echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';

            $set_user['avatar'] = 0;
            echo show_user($res, 0, ($act == 'guest' || ($rights >= 1 && $rights >= $res['rights']) ? 1 : 0), '' . $place);
            echo '</div>';
            ++$i;
        }
    }
    else {
        echo '<div class="menu"><p>Никого нет</p></div>';
    }
    echo '<div class="phdr">Всего: ' . $total . '</div>';
    if ($total > 10) {
        echo '<p>' . pagenav('index.php?act=who&amp;' . ($do
            == 'guest' ? 'do=guest&amp;' : '' ), $start, $total, $kmess ) . '</p>';
        echo '<p><form action="index.php?act=who' . ($do
            == 'guest' ? '&amp;do=guest' : '' ) . '" method="post"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
    }
    echo '<p><a href="index.php?act=who' . ($do
        == 'guest' ? '">Показать авторизованных' : '&amp;do=guest">Показать гостей' ) . '</a>
		<br /><a href="index.php">В менеджер</a></p>';


require_once ("incfiles/end.php");

?>