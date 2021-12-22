<?php
# Script for public by MyZik
# ICQ: 419173
# Site: xLoF.Ru
# Tweet: aka_myzik
# Kopeyka.biZ: MyZik

defined('_IN_JOHNADM') or die('Error: restricted access');

$error = false;
    $req = mysql_query("SELECT * FROM `quotes` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $quote = mysql_fetch_assoc($req);
    }
# Проверяем на ошибки
    else {
        $error = 'Цитаты за данным ID не существует';
    }
/*else {
    $error = 'Не указан ID цитаты';
}*/
# Если все клево
if (!$error) {
    echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | Удаление цитаты</div>';
    echo '<div class="rmenu"><p>Удаление текста из БД:<hr/>' . $quote['quote'] . '<hr/>Подтвердите операцию</p></div>';
    switch ($mod) {
        case 'del' :
            // Удаляем цитату
            mysql_query("DELETE FROM `quotes` WHERE `id` = '" . $id . "' LIMIT 1");
            echo '<div class="rmenu"><p><h3>Цитата успешно удалена</h3></p></div>';
            break;

        default :
            # форма :)
            echo '<form action="index.php?act=quote_del&amp;mod=del&amp;id=' . $id . '" method="post"><div class="menu"><p><h3>Удаление цитаты</h3>';
            echo '</p></div><div class="rmenu"><p>Вы действительно хотите удалить данную цитату?';
            echo '</p><p><input type="submit" value="Удалить" name="submit" />';
            echo '</p></div></form>';
    }
}
else {
# Выводим ошибки если имеются
    echo display_error($error);
}
# Навигация
echo '<div class="phdr"><p><a href="index.php?act=quotes">Цитаты</a><br /><a href="index.php">Админ панель</a></p></div>';
# Прошу не удалять копирайт...
echo "<div class='phdr'><a href='http://xlof.ru' title='Mod by MyZik'>Made by &copy; MyZik</a></div>";
?>