<?php
define('_IN_JOHNCMS', 1);
$textl = 'Игровая валюта - Буцер';
// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';
require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
echo '<div class="gmenu"><b>Игровая валюта - Буцер</b></div>';
echo '<div class="menu">';
echo 'На сайте <b>'.$namesite.'</b> имеется игровая валюта - буцеры. <br/>';
echo 'Зарабатывая или покупая буцеры, Вы получаете дополнительные возможности на сайте!<br/>';
echo '<br/>';
echo '</div>';
echo '<div class="menu">
<b>С помощью буцеров Вы можете:</b><br/>
- Мгновенно восстановить физготовность игроков на 100%, вылечить травмы и повысить мораль.<br/>
- <a href="butcer.php?act=obmen">Обменять на деньги. 1 Буцер = 1000 €</a><br/>
- Прокачать любого игрока на 1000 опыта.<br/>
- <a href="team/shop.php">Купить реальные игроки.</a><br/>
- Сменить свой ник за 10 буцеров.<br/>';
echo '</div>';

echo '<div class="gmenu"><b>Как получить буцеры?</b></div>';
echo '<div class="menu">';
echo 'Получить буцеры можно 2 способами - заработать или купить. По ссылкам ниже вы можете ознакомится с этими способами подробнее:<br/>';
echo '<a href="pay.php"><b>Купить буцеры</b></a>';
echo '<br/>
<a href="pays.php"><b>Заработать буцеры</b></<br/>';
echo '</div>';
require_once ("incfiles/end.php");
?>
