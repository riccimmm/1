<?php

define('_IN_JOHNCMS', 1);
$headmod = 'quickchat';
require_once ('../incfiles/core.php');

// настройки
//$set_user['avatar'] = 0; // аватары выключены (если надо включить, то просто закомментируйте строку)
$form_mess = 1; // Форма сообщения в чате
if (eregi('Windows', $agn) || eregi('Linux', $agn) || eregi('Mac', $agn) || eregi('Mini/5', $agn))
  $comp = 1;
else
  $comp = 0;

// функция bb-кодов
function bbcode($form, $field){
global $comp;
if ($comp){
$out = '<script language="JavaScript" type="text/javascript">
    			function tag(text1, text2) {
    			if ((document.selection)) {
    			document.'.$form.'.'.$field.'.focus();
    			document.'.$form.'.document.selection.createRange().text = text1+document.'.$form.'.document.selection.createRange().text+text2;
    			} else if(document.forms[\''.$form.'\'].elements[\''.$field.'\'].selectionStart!=undefined) {
    			var element = document.forms[\''.$form.'\'].elements[\''.$field.'\'];
    			var str = element.value;
    			var start = element.selectionStart;
    			var length = element.selectionEnd - element.selectionStart;
    			element.value = str.substr(0, start) + text1 + str.substr(start, length) + text2 + str.substr(start + length);
    			} else document.'.$form.'.'.$field.'.value += text1+text2;
    			}
    			</script>
    			<a href="javascript:tag(\'[url=]\', \'[/url]\')"><img src="../images/bb/l.png" border="0" alt="url" title="Ссылка" /></a><a href="javascript:tag(\'[b]\', \'[/b]\')"><img src="../images/bb/b.png" border="0" alt="b" title="Жирный"/></a><a href="javascript:tag(\'[i]\', \'[/i]\')"><img src="../images/bb/i.png" border="0" alt="i" title="Наклонный"/></a><a href="javascript:tag(\'[u]\', \'[/u]\')"><img src="../images/bb/u.png" border="0" alt="u" title="Подчёркнутый"/></a><a href="javascript:tag(\'[s]\', \'[/s]\')"><img src="../images/bb/s.png" border="0" alt="s" title="Перечёркнутый"/></a><a href="javascript:tag(\'[c]\', \'[/c]\')"><img src="../images/bb/q.png" border="0" alt="quote" title="Цитата"/></a><a href="javascript:tag(\'[red]\', \'[/red]\')"><img src="../images/bb/re.png" border="0" alt="red" title="Красный"/></a><a href="javascript:tag(\'[green]\', \'[/green]\')"><img src="../images/bb/gr.png" border="0" alt="green" title="Зелёный"/></a><a href="javascript:tag(\'[blue]\', \'[/blue]\')"><img src="../images/bb/bl.png" border="0" alt="blue" title="Синий"/></a><br />';
}else{
$out = '';
}
return $out;
}

// Задаем заголовки страницы
$textl = 'Мини-чат';
require_once ('../incfiles/head.php');

switch ($act){

case 'time':
if (!$user_id || $ban['1'] || $ban['12' ]){
echo display_error('У вас недостаточно прав!');
require_once ('../incfiles/end.php');
exit;
}

if (!empty($set['chat_theme'])){
  $time = explode(':|:', $set['chat_theme']);
  $days = round(($time['1'] - $realtime) / 86400);
}else{
  $days = 3;
  $time= array(20, 0);
}

if ($time['1'] && !$rights){
if ($login != $time['2']){
echo display_error('Дождитесь окончания времени!<br />Осталось дней: '.$days.'!<br /><a href="?">Назад</a>');
require_once ('../incfiles/end.php');
exit;
}
}

if (isset($_GET['del'])){
mysql_query("UPDATE `cms_settings` SET `val`='' WHERE `key`='chat_theme' LIMIT 1 ");
echo '<p>Время сброшено<br /><a href="?">Продолжить</a></p>';
require_once ('../incfiles/end.php');
exit;
}

if (isset($_POST['submit'])){
if ($_POST['time'] > 24 || $_POST['time'] == 0){
echo display_error('Неверный диапозон времени!<br /><a href="?act=time">Повторить</a>');
require_once ('../incfiles/end.php');
exit;
}

$form_time = intval($_POST['time']);
$form_days = $realtime + (86400 * 3);
$sql = $form_time.':|:'.$form_days.':|:'.$login;
mysql_query("UPDATE `cms_settings` SET `val`='".mysql_real_escape_string($sql)."' WHERE `key`='chat_theme' LIMIT 1 ");
echo '<div class="a">Время установлено<br /><a href="?">Продолжить</a></div>';
}else{
echo '<div class="phdr"><a href="?">Быстрый чат</a> | Время встречи</div>';
echo '<form action="?act=time" method="post">';
echo '<div class="list1">Время встречи: <input type="text" name="time" value="'.$time['0'].'" size="2" /> (по Москве)</div>';
echo '<div class="b">Ваше приглашение будет действительно 3 дня</div>';
echo '<div class="gmenu"><input type="submit" name="submit" value="Ok" /></div>';
echo '</form>';
if ($time['1'])
echo '<div class="rmenu"><a href="?act=time&amp;del">Сбросить время</a></div>';
}
break;

case 'del':
// Удаление отдельного поста
if (($rights==2 || $rights >= 6) && $id){
  if (isset($_GET['yes'])){
    mysql_query("DELETE FROM `qchat` WHERE `id`='" . $id . "' LIMIT 1 ");
    header("Location: qchat.php");
	 echo'<div class="rmenu">Успешно! <br /><br /> <a href="'.$home.'/str/qchat.php" class="redbutton">Назад</a></div>';
  }else{
    echo '<div class="phdr"><a href="?">Быстрый чат</a> | Удаление</div>';
    echo '<div class="rmenu">Вы действительно хотите удалить пост?<br /><a href="?act=del&amp;id='.$id.'&amp;yes">Да</a> | <a href="?">Нет</a></div>';
  }
}else{
  echo display_error('У вас недостаточно прав!');
}
break;

case 'say':
// Добавление нового поста
if (!$user_id || $ban['12'] || $ban['1']){
  echo display_error('Доступ закрыт!<br /><a href="?">Назад</a>');
  require_once ('../incfiles/end.php');
  exit;
}

$flood = antiflood();
if ($flood){
  echo display_error('Вы не можете так часто писать<br />Пожалуйста, подождите ' . $flood . ' сек.<br /><a href="?">Назад</a>');
  require_once ('../incfiles/end.php');
  exit;
}

if (isset($_POST['submit']) && !empty($_POST['msg'])){
  $msg = mb_substr($_POST['msg'], 0, 300);
  if ($_POST['msgtrans']==1)
    $msg = trans($msg);

  // Проверка на одинаковые сообщения
  $req = mysql_query("SELECT `text` FROM `qchat` WHERE `user_id` = '$user_id' ORDER BY `time` DESC LIMIT 1");
  $res = mysql_fetch_array($req);
  if ($res['text'] == $msg) {
    echo display_error('Такое сообщение уже было!<br /><a href="?">Назад</a>');
    require_once ('../incfiles/end.php');
  }else{echo'<div class="rmenu">Успешно! <br /><br /> <a href="'.$home.'/str/qchat.php" class="redbutton">Назад</a></div>';}
  
  // Вставляем сообщение в базу
  mysql_query("INSERT INTO `qchat` SET
    `time`='" . $realtime . "',
    `user_id`='" . $user_id . "',
    `text`='" . mysql_real_escape_string($msg) . "';");
  
  // Фиксируем время последнего поста (антиспам)
  $postchat = $datauser['postchat'] + 1;
  mysql_query("UPDATE `users` SET `postchat`='".$postchat."', `lastpost`='".$realtime."' WHERE `id`='".$user_id."' ");
  header('location: qchat.php');
}else{
  echo '<div class="phdr"><a href="?">Быстрый чат</a> | Сообщение</div>';
  echo '<div class="gmenu"><form name="mess" action="?act=say" method="post">';
  echo 'Сообщения(макс. 300):<br />'.bbcode('mess', 'msg').'<textarea cols="30" rows="3" name="msg" ></textarea><br />';
  if ($set_user['translit'])
    echo '<input type="checkbox" name="msgtrans" value="1" /> Транслит<br />';
  echo '<input type="submit" name="submit" value="Отправить" />';
  echo '<br /><a href="smile.php">Смайлы</a>';
  echo '</form></div>';
}
break;

case 'answ':
// Добавление ответа
if (!$id || !$user_id || $ban['1'] || $ban['12']) {
  echo display_error('У вас недостаточно прав!');
  require_once ('../incfiles/end.php');
  exit;
}

// Проверка на флуд
$flood = antiflood();
if ($flood){
  echo display_error('Вы не можете так часто писать<br />Пожалуйста, подождите ' . $flood . ' сек.<br /><a href="?">Назад</a>');
  require_once ('../incfiles/end.php');
  exit;
}

$user = mysql_fetch_array(mysql_query("SELECT `name` FROM `users` WHERE `id`='".$id."' "));

if (isset ($_POST['submit']) && (!empty($_POST['answ']) && $_POST['answ']!= $user['name'].', ')) {

  $msg = trim($_POST['answ']);
  $msg = mb_substr($msg, 0, 500);

  if ($_POST['msgtrans'] == 1) {
    $msg = trans($msg);
  }

  // Проверка на одинаковые сообщения
  $req = mysql_query("SELECT `text` FROM `qchat` WHERE `user_id` = '$user_id' ORDER BY `time` DESC LIMIT 1");
  $res = mysql_fetch_array($req);
  if ($res['text'] == $msg) {
    echo display_error('Такое сообщение уже было!<br /><a href="?">Назад</a>');
    require_once ('../incfiles/end.php');
  }

  // Вставляем сообщение в базу
  mysql_query("INSERT INTO `qchat` SET
	`time`='" . $realtime . "',
	`user_id`='" . $user_id . "',
	`text`='" . mysql_real_escape_string($msg) . "'
	");

  // Фиксируем время последнего поста (антиспам)
  $postchat = $datauser['postchat'] + 1;
  mysql_query("UPDATE `users` SET `postchat` = '$postchat', `lastpost` = '" . $realtime . "' WHERE `id` = '" . $user_id . "'");

  header('location: qchat.php');
}else{
  echo '<div class="phdr"><a href="?">Быстрый чат</a> | Ответ</div>';
  echo '<div class="gmenu"><form name="mess" action="?act=answ&amp;id='.$id.'" method="post">Сообщение (макс. 500 симв.):<br />'.bbcode('mess', 'answ').'<textarea cols="30" rows="4" name="answ">'.$user['name'].', </textarea><br />';
  if ($set_user['translit'])
    echo '<input type="checkbox" name="msgtrans" value="1" /> Транслит<br />';
  echo '<input type="submit" name="submit" value="Написать" />';
  echo '<br /><a href="smile.php">Смайлы</a>';
  echo '</form></div>';
}
break;

case 'clean':
// Очистка быстрого чата
if ($rights>=7){
  if (isset($_POST['submit'])){
    $cl = isset($_POST['cl']) ? intval($_POST['cl']) : '';
    switch ($cl){
      case '1':
        // Чистим сообщения, старше 1 дня
      mysql_query("DELETE FROM `qchat` WHERE `time`<='" . ($realtime - 86400) . "' ");
      mysql_query("OPTIMIZE TABLE `qchat` ");
      echo '<p>Удалены все сообщения, старше 1 дня<br /><a href="?">Вернуться</a></p>';
      break;

      case '2':
      // Проводим полную очистку
      mysql_query("DELETE FROM `qchat` ");
      mysql_query("OPTIMIZE TABLE `qchat` ");
      echo '<p>Удалены все сообщения<br /><a href="?">Вернуться</a></p>';
      break;

      default:
      // Чистим сообщения, старше 1 недели
      mysql_query("DELETE FROM `qchat` WHERE `time`<='" . ($realtime - 604800) . "';");
      mysql_query("OPTIMIZE TABLE `qchat` ");
      echo '<p>Все сообщения, старше 1 недели удалены<br /><a href="?">Вернуться</a></p>';
    }
  }else{
    echo '<div class="phdr"><a href="?">Быстрый чат</a> | Чистка сообщений</div>';
    echo '<div class="rmenu"><form id="clean" method="post" action="?act=clean">';
    echo '<input type="radio" name="cl" value="0" checked="checked" />Старше 1 недели<br />';
    echo '<input type="radio" name="cl" value="1" />Старше 1 дня<br />';
    echo '<input type="radio" name="cl" value="2" />Все<br />';
    echo '<input type="submit" name="submit" value="Очистить" />';
    echo '</form></div>';
  }
}else{
  header('location: qchat.php');
}
break;

default:
// Отображаем быстрый чат

if (!empty($set['chat_theme'])){
  $time = explode(':|:', $set['chat_theme']);
  $days = round(($time['1'] - $realtime) / 86400);
  if ($time['1'] <= $realtime){
    mysql_query("UPDATE `cms_settings` SET `val`='' WHERE `key`='chat_theme' LIMIT 1 ");
    $time = 0;
  }
}else{
  $time = 0;
}
if ($time)
echo '<div class="phdr">Встреча в '.$time['0'].'ч. по мск (осталось '.$days.' дн.)<br />Пригласил: '.$time['2'].'</div>';

//показываем кто в чате (при желании можно переместить вниз)
$onltime = $realtime - 300;
$us = mysql_query("SELECT * FROM `users` WHERE `place`='quickchat' AND `lastdate` > '" . intval($onltime) . "' ");
echo '<div class="b">В чате: ';
$i1 = 1;
$tot = mysql_num_rows($us);
if ($tot){
  while ($use = mysql_fetch_array($us)){
    echo $use['name'];
    if ($i1 !=$tot)
      echo ', ';
    ++$i1;
  }
}else{
 echo 'Никого';
}
echo '.</div>';
////

if ($user_id || $ban['1'] || $ban['12']) {
  echo '<div class="menu"><form name="mess" action="?act=say" method="post">';
  if ($form_mess){
    echo '<div class="bmenu">Сообщение (макс. 500 симв.):</div><br />'.bbcode('mess', 'msg').'<textarea cols="30" rows="4" name="msg"></textarea><br />';
    if ($set_user['translit'])
      echo "<input type='checkbox' name='msgtrans' value='1' /> Транслит<br />";
  }
  echo '<input type="submit" name="submit" value="Написать"/>';
  if ($form_mess)
    echo '<a href="smile.php" class="redbutton">Смайлы</a>';
  echo '</form></div>';
}

$colmes = mysql_result(mysql_query("SELECT COUNT(*) FROM `qchat`"), 0);
  if ($colmes > 0){
    $req = mysql_query("SELECT `qchat`.*, `qchat`.`id` AS `gid`, `users`.`id`, `users`.`name`, `users`.`rights`, `users`.`lastdate`, `users`.`sex`, `users`.`datereg`, `users`.`ip` , `users`.`browser`	FROM `qchat` LEFT JOIN `users` ON `qchat`.`user_id` = `users`.`id` ORDER BY `time` DESC LIMIT ".$start.", ".$kmess.";");
    while ($res = mysql_fetch_array($req)){
      echo ($i % 2) ? '<div class="menu">' : '<div class="menu">';

      $aftrnik = '';
      // Ссылка на ответ
      if ($res['user_id'] != $user_id)
$aftrnik .= ($comp ? '<a href="javascript:tag(\''.$res['name'].', \', \'\')">[о]</a>' : '<a href="?act=answ&amp;id='.$res['user_id'].'">[о]</a>');
      // Время
      $aftrnik .= ' <span class="gray">'.date("d.m-H:i", $res['time'] + $set_user['sdvig'] * 3600).'</span><br />';

      // текст
      $post = checkout($res['text'], 1, 1);
      if ($set_user['smileys'])
        $post = smileys($post, $res['rights'] >= 1 ? 1 : 0);


      // Ссылки на Модерские функции
      $subtext = '<a href="?act=del&amp;id=' . $res['gid'] . '">Удалить</a>';
      echo show_user($res, 0, 0, $aftrnik, $post, (($rights == 2 || $rights >= 6) ? $subtext : ''));
      echo '</div>';
      ++$i;
  }
  echo '<div class="phdr">Сообщений: '.$colmes.'</div>';
  if ($colmes > $kmess)
    echo '<p>'.pagenav('?', $start, $colmes, $kmess) . '</p>';

  }else{
    echo '<div class="list1">Сообщений нет</div>';
  }


// Для Админов даем ссылку на чистку
  if ($rights >= 7 && $colmes)
    echo '<div class="rmenu"><a href="?act=clean" class="redbutton">Чистка сообщений</a></div>';
}
require_once ("../incfiles/end.php");
?>