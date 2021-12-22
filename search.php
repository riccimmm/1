<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

/////////////////////////////////////////////////////////////////////////////////////////
// Принимаем данные, выводим форму поиска                 //
/////////////////////////////////////////////////////////////////////////////////////////
$search = isset ($_POST['search']) ? trim($_POST['search']) : '';
$search = $search ? $search : rawurldecode(trim($_GET['search']));

echo '<div class="phdr"><b>Поиск игрока</b></div>';
echo '<form action="search.php" method="post"><div class="gmenu"><p>';
echo '<input type="text" name="search" value="' . checkout($search) . '" />';
echo '<input type="submit" value="Поиск" name="submit" /><br />';
echo '</p></div></form>';

////////////////////////////////////////////////////////////
// Проверям на ошибки                                     //
////////////////////////////////////////////////////////////
$error = false;
if (!empty ($search) && (mb_strlen($search) < 2 || mb_strlen($search) > 20))
    $error = '<div>Недопустимая длина Ника. Разрешено минимум 2 и максимум 20 символов.</div>';


if ($search && !$error) {
    ////////////////////////////////////////////////////////////
    // Выводим результаты поиска                              //
    ////////////////////////////////////////////////////////////
    echo '<div class="phdr">Результаты запроса</div>';
    $search_db = mb_strtolower($search);
    $search_db = strtr($search_db, array('_' => '\\_', '%' => '\\%', '*' => '%'));
    $search_db = '%' . $search_db . '%';
	 
    $req = mysql_query("SELECT COUNT(*) FROM `player_2` WHERE `name` LIKE '" . mysql_real_escape_string($search_db) . "'");
    $total = mysql_result($req, 0);
    if ($total > 0) {
        $req = mysql_query("SELECT * FROM `player_2` WHERE `name` LIKE '" . mysql_real_escape_string($search_db) . "' ORDER BY `name` ASC LIMIT $start, $kmess");
        while ($res = mysql_fetch_array($req)) {
            echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
           echo' <a href="player.php?id='.$res[id].'">'.$res[name].'</a>';
            echo '</div>';
            ++$i;
        }
    }
    else {
        echo '<div class="menu"><p>По Вашему запросу ничего не найдено</p></div>';
    }
    echo '<div class="phdr">Всего найдено: ' . $total . '</div>';
    if ($total > $kmess) {
        // Навигация по страницам
        echo '<p>' . pagenav('search.php?' . ($search_t ? 't=1&amp;' : '') . 'search=' . rawurlencode($search) . '&amp;', $start, $total, $kmess) . '</p>';
        echo '<p><form action="search.php" method="post"><input type="hidden" name="search" value="' . checkout($search) .
        '" /><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
    }
    echo '<p><a href="search.php">Новый поиск</a></p>';
}
else {
    // Выводим сообщение об ошибке
    if ($error)
        echo '<div class="rmenu"><p>ОШИБКА!<br />' . $error . '</p></div>';
    // Инструкции для поиска
    echo '<div class="phdr"><small>';
    echo 'Поиск идет по имени игрока  и нечувствителен к регистру букв. То есть, <b>UsEr</b> и <b>user</b> для поиска равноценны.';
   
    echo '</small></div>';
}
require_once ("incfiles/end.php");

?>
