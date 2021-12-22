<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/usersystem.php");
require_once ('incfiles/class_mainpage.php');


$array = array('new', 'who');
if (in_array($act, $array) && file_exists($act . '.php')) {
    require_once ($act . '.php');
}

else {
switch ($act)
{


default :
    require_once ('incfiles/head.php');
    require_once ("incfiles/manag2.php");
    

if (!empty($manag))
{
//////////////////////////////////////////////////////////////////////////////////////////
if (!$user_id) {
    require_once('../incfiles/head.php');
    echo display_error('Только для зарегистрированных посетителей');
    require_once('../incfiles/end.php');
    exit;
}
if ($id && $id != $user_id) {
    // Если был запрос на юзера, то получаем его данные
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        $textl = 'Анкета: ' . $user['name'];
    } else {
        require_once('../incfiles/head.php');
        echo display_error('Такого пользователя не существует');
        require_once("../incfiles/end.php");
        exit;
    }
} else {
    $id = false;
    $textl = 'Личная анкета';
    $user = $datauser;
}
///////////////////////////////////////////////////////////////////////////////////



$q = mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "';");
$arr = mysql_fetch_array($q);

echo '<div class="gmenu"><b>' . $user['imname'] . ' ' . $user['imfamilia'] . '  ' . $user['name'] . '</b> ' . date("H:i", $realtime + $set_user['sdvig'] * 3600) . '</div>';

$lv=$lvl+1;
$req = mysql_query("SELECT `exp` FROM `lvl_2` WHERE `id`='" . $lv . "' LIMIT 1;");
if (mysql_num_rows($req) != '0') {
  $res = mysql_fetch_array($req);
if($rates >= $res['exp']){
mysql_query("UPDATE `team_2` set `lvl`=`lvl`+1 where `id`='".$fid."' LIMIT 1;");
echo 'Ваш уровень клуба увеличен!';
} 
}

echo '<div class="c">
<div class="blok">Клуб: <b>'.$names.'</b> ['.$lvl.']</div>
<div class="blok">Деньги: <b>'.$money.' &euro;</b></div>
<div class="blok">Опыт: <b>'.$rates.'</b>'.$res['exp'].'</div>
<div class="blok">Слава: <b>'.$slava.'</b></div>
<div class="blok">Фаны: <b>'.$fan.'</b></div>
<div class="blok">Буцеры: <b>'.$butcer.'</b> шт. [<a href="butc.php" style=""><span style="padding:4px">?</span></a>]</div><br/>';

echo '<img src="/images/icons/team.jpg" alt=""/> <b>Игроки</b><br/>';
echo '<div class="blok"><a href="team.php?id=' . $kom['id'] .'">Команда</a></div>
<div class="blok"><a href="sostav.php?id=' . $kom['id'] .'">Состав</a></div>
<div class="blok"><a href="train.php">Тренировка</a></div>
<div class="blok"><a href="transfer.php">Трансферы</a></div>
<div class="blok"><a href="agent2.php">Агенты</a></div>
<div class="blok"><a href="team/shop.php">Реальные игроки</a></div>';

echo '<img src="/images/icons/game.jpg" alt=""/> <b>Матчи</b><br/>';
echo '
<div class="blok"><a href="friendly.php">Товарищеские матчи</a></div>
<div class="blok"><a href="tournaments.php?id=1">Кубковые турниры</a></div>
<div class="blok"><a href="chemp.php">Чемпионаты</a></div>
<div class="blok"><a href="/cups.php?nation">Кубки стран</a></div>
<div class="blok"><a href="/euro">Еврокубки</a></div>
<div class="blok"><a href="friendly.php?act=my_calendar">Архив матчей</a></div>';


echo '<img src="images/icons/talk.jpg" alt=""/> <b>Общение</b>

<div class="blok"><a href="./union/">Союзы</a></div>
<div class="blok"><a href="forum">Форум</a> (' . wfrm() . ') <a href="forum/index.php?act=new">&#187;&#187;</a></div>
<div class="blok"><a href="'.$home.'/str/qchat.php">Чат</a></div>';


echo '<img src="/images/icons/office.jpg" alt=""/> <b>Офис</b><br/>';


echo '<div class="blok"><a href="butcer.php"><b>Магазин буцеров</b></a></div>';
echo '<div class="blok"><a href="personal.php?id=' . $fid . '">Персонал</a></div>';
echo '<div class="blok"><a href="inf.php?id=' . $fid . '">Постройки</a></div>';
echo '<div class="blok"><a href="stadium.php?id=' . $fid . '">Стадион</a></div>';
echo '<div class="blok"><a href="servise.php">Клубные цвета</a></div>';
echo '<div class="blok"><a href="rate.php">Рейтинг</a></div>';
echo '<div class="blok"><a href="search.php">Поиск игрока</a></div>';
echo '<div class="blok"><a href="search_t.php">Поиск клуба</a></div>';
$mp = new mainpage();
echo $mp->news;
}
if($fid == 0 ){
echo '<div><center><img src="' . $home . '/theme/' . $set_user['skin'] . '/images/logo.jpg" height=350 width=350  alt=""/></center></div>';
echo '</div>';

if ($rights >= !$user_id)
{
echo '<div class="phdr"><b>Создаем футбольный клуб...</b></div>';  
 
   echo '<form action="team/add.php" method="post">';
   echo '<div class="menu">Выберите уникальное название Вашей команды</div>
   <div class="menu"><b>Название команды:</b> <span style="color:red; font-size:14px; font-weight: bold">*</span></div>
   <div class="menu"><input type="text" name="name" maxlength="20" value="' . check($_POST['name']) . '" /></div>';
       
       echo '<div class="menu"><b>Страна команды:</b></div>';
        $matile = mysql_query('SELECT * from `team_2` GROUP BY `strana`;');
                echo '<div class="menu"><select name="strana">';
                while ($mat = mysql_fetch_array($matile)) {
                
                    echo '<option value="' . $mat['strana'] . '" >';
                    echo '' . $mat['divizion'] . '</option>';
                }
       echo '</select></div>';
       
   echo '<div class="menu">Если Вы не видите рисунок с кодом, включите поддержку графики в настройках браузера и обновите страницу.</div>';
   echo '<div class="menu"><img src="../captcha.php?r=' . rand(1000, 9999) . '" alt="Проверочный код"/></div>';
   echo '<div class="menu"><b>Код с картинки:</b></div><div class="menu"><input type="text" size="5" maxlength="5"  name="kod"/></div>';
   
   echo '<div class="menu"><input type="submit" name="submit" value="Создать комманду"/></div></form>';

}
	if (!$user_id)
{	
echo '<div class="menu" style="text-align:center"><span style="color:green;"><b>goal-futs.tu</b></span> - бесплатная браузерная онлайн игра в жанре футбольного менеджера.
Вы создаёте футбольный клуб и управляете им, соревнуетесь с тысячами реальных соперников. Здесь вам не пригодится мастерство удара, умение обводить противника и закалка. Зато понадобится стратегическое мышление, развитая интуиция и, конечно, спортивный азарт. Ведь на ваши плечи ляжет забота о целом футбольном клубе!</div>';
}
}
		
break;	

case 'login':
echo '<div><center><img src="' . $home . '/theme/' . $set_user['skin'] . '/images/logo.jpg" height=350 width=350  alt=""/></center></div>';
echo '<div class="gmenu"><form action="login.php" method="post">' .
        'Имя:<br/><input type="text" name="n" value="' . htmlentities($user_login, ENT_QUOTES, 'UTF-8') . '" maxlength="20"/><br/>' .
        'Пароль:<br/><input type="password" name="p" maxlength="20"/><br/>' .
        '<input type="checkbox" name="mem" value="1" checked="checked"/>Запомнить меня<br/>' .
        '<input type="submit" value="Вход"/></form></div>' .
        '<div class="phdr"><a href="str/skl.php?continue">Забыли пароль?</a></div>';
break;	
}
}
require_once ("incfiles/end.php");

?>