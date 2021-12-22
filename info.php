<?php
define('_IN_JOHNCMS', 1);
$textl = 'Помощь';
// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';
require_once ('incfiles/core.php');
require_once ('incfiles/head.php');







echo '<div class="gmenu">Что такое '.$namesite.'</div>';
echo '<div class="c">';
echo '<a href = "'.$home.'"><b>'.$namesite.'</b></a> - это мобильный проект общения и знакомств.
Сразу после несложной <a href = "registration.php"><b>регистрации</b></a>, Вам будут доступны следующие возможности:';
echo '</div>';
echo '<div class="tmn"><b>Личная страничка</b></div>';
echo '<div class="c">';
echo 'Ваша личная страничка с анкетой, заполняй свою анкету, просматривай анкеты других пользователей!';
echo '</div>';
echo '<div class="tmn"><b>Переписка</b></div>';
echo '<div class="c">';
echo 'Общайся по личной почте!';
echo '</div>';
echo '<div class="tmn"><b>Друзья</b></div>';
echo '<div class="c">';
echo 'Дружи, добавляй в друзья!';
echo '</div>';
echo '<div class="tmn"><b>Фотографии, фотоальбомы</b></div>';
echo '<div class="c">';
echo 'Загружай фотографии, создавай фотоальбомы!';
echo '</div>';
echo '<div class="tmn"><b>Личные гостевые</b></div>';
echo '<div class="c">';
echo 'Общайся в гостевых пользователей!';
echo '</div>';
echo '<div class="tmn"><b>Подарки</b></div>';
echo '<div class="c">';
echo 'Дари, получай подарки!';
echo '</div>';
echo '<div class="tmn"><b>Поиск</b></div>';
echo '<div class="c">';
echo 'Ищи странички пользователей, знакомся!';
echo '</div>';
echo '<div class="tmn"><b>Чат</b></div>';
echo '<div class="c">';
echo 'Общайся в чатах!';
echo '</div>';
echo '<div class="tmn"><b>Поддержка</b></div>';
echo '<div class="c">';
echo 'Список Администраторов, к которым Вы можете обращаться с возникшими у Вас вопросами!';
echo '</div>';
echo '<div class="tmn"><b>А также многое другое... Со временем :)</b></div>';
echo '<div class="c">';
echo 'Каждый день ведутся работы над улучшением и созданием новых сервисов на сайте! Наша цель — сделать идеально удобный проект для всех! Присоединяйтесь к нам и Вы не пожалеете!<br/>';
echo '</div>';
echo '<div class="c">';
echo '<b>'.$namesite.'</b> - Мир безграничного общения и знакомств!';
echo '</div>';












require_once ('incfiles/end.php');

?>