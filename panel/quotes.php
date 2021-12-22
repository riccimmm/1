<?php

defined('_IN_JOHNADM') or die('Error: restricted access');

echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | Цитаты</div>';
# Ставим условие, если форма не пустая
if (isset($_POST['quote']) && $_POST['quote']!=NULL)
{
# Защищаемся
$quote = mysql_escape_string($_POST['quote']);
# Вставляем данные в таблицу
mysql_query("INSERT INTO `quotes` (`quote`) VALUES ('$quote')");
echo 'Цитата успешно добавлена';
}

# Главная
echo '<div class="bmenu">';
# Форма :)
echo '<form method="post" action="quotes.php?">Введите текст:<br/><textarea name="quote"></textarea><br/><input value="Добавить в базу" type="submit"/></form></div>';
# Вывод цитат v2
$req = mysql_query("SELECT COUNT(*) FROM `quotes`");
$total = mysql_result($req, 0);
$req = mysql_query("SELECT `id`, `quote` FROM `quotes` WHERE `id` >= 1 ORDER BY `id` ASC LIMIT $start, $kmess");
while ($res = mysql_fetch_assoc($req)) {
    echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
echo "".$res['quote']."<br/>[<a href='index.php?act=quote_del&amp;id=".$res['id']."'><font color='red'>Удалить</font></a>]</div>";
    ++$i;
}
# Общее количество цитат
echo '<div class="phdr">Всего цитат в базе: '.mysql_num_rows(mysql_query("SELECT `id` FROM `quotes`")).'</div>';
if ($total > $kmess) {
    echo '<p>' . pagenav('index.php?act=quotes&amp;', $start, $total, $kmess) . '</p>';
    echo '<p><form action="index.php?act=quotes" method="post"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
}

# Ссылка на админку
echo '<div class="phdr"><p><a href="index.php">Админ панель</a></p></div>';
?>