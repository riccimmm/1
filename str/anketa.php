<?php

define('_IN_JOHNCMS', 1);
$headmod = 'anketa';
require_once('../incfiles/core.php');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once('../incfiles/head.php');
require_once ("../incfiles/manag2.php");
echo '<div style="text-align:center" class="gmenu">';
echo '<b>' . $user['imname'] . ' ' . $user['imfamilia'] . ' (' . $user['name'] . ')</b>';
if ($realtime > $user['lastdate'] + 300) {
    echo '&nbsp;<img src="'.$home.'/images/icons/off.png" />';
    $lastvisit = date("d.m.Y (H:i)", $user['lastdate']);
} else {
    echo '&nbsp;<img src="'.$home.'/images/icons/on.png" />';
}
echo'</div>';

$ban = mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_ban_users` WHERE `user_id` = '" . $user['id'] . "'"), 0);
if ($ban) {
echo '<a href="users_ban.php' . ($id && $id != $user_id ? '?id=' . $user['id'] : '') . '"><div class="rmenu"><b>Нарушения&nbsp;<span class="red">(' . $ban . ')</span></b></div></a>';}

echo '<div class="c">';
if (!empty($user['status']))
echo ''.$user['status'].' <br />';
else
echo 'Привет!<br />';


if(!$id || $id == $user_id){
echo '<a href="status.php">Изменить статус</a>';
}


echo '</div>';

echo'<center><div class="photo" style="border-top: 1px solid #DAE1E8; padding-top: 0px"><br/>';
if (file_exists(('../files/photo/' . $user['id'] . '.jpg'))){
echo '<a href="../files/photo/' . $user['id'] . '.jpg"><img style="border-radius:5px;" src="../files/photo/' . $user['id'] . '.jpg" alt="' . $user['name'] . '" width="250px" height="300px"/></a>';
}

else{
if(!$id || $id == $user_id){
echo'<a href="my_images.php?act=up_photo&amp;id=' . $user['id'] . '"><img style="border-radius:5px;" src="../files/photo/nophoto.jpg" alt="' . $user['name'] . '" width="250" height="300"/></a>';
}else{
echo'<img style="border-radius:5px;" src="../files/photo/nophoto.jpg" alt="' . $user['name'] . '" width="238" height="250"/>';}
}
if ($id && $id != !$user_id) {
echo'<br/><br/><center><a href="pradd.php?act=write&amp;adr=' . $user['id'] . '" class="button">Отправить сообщение</a></center><br />';
}
echo'</div></center>';



if(!$id || $id == $user_id){
echo'<div class="menu" style="margin:0px"><a href="my_images.php?act=up_photo&amp;id=' . $user['id'] . '">Изменить фотографию</a></div>';
echo'<div class="menu" style="margin:0px"><a href="my_pass.php?id=' . $user['id'] . '">Сменить пароль</a></div>';
}


echo'<div class="flexHeader"><b>Футбольный клуб</b></div>';
echo '<div class="d">';
    $k = @mysql_query("select * from `team_2` where id='".$user['manager2']."' LIMIT 1;");
    $kom = @mysql_fetch_array($k);
echo'<table >';
echo'	<tr valign="top"><td><div class="grey">Команда:</div></td><td><a href="../team.php?id=' . $kom['id'] .
        '">' . $kom[name] . '</a> [' . $kom[lvl] . ']</td></tr>';
echo '<tr valign="top"><td><div class="grey">Деньги:</div></td><td><a href="http://futmen.net/admin.php?act=team&id=' . $kom['id'] . '"><b>'.$kom[money].' &euro;</b></a></td></tr>';
echo '<tr valign="top"><td><div class="grey">Фаны:</div></td><td>'.$kom[fan].'</td></tr>';
if ($rights >= 7)
{echo '<tr valign="top"><td><div class="grey">Буцеры:</div></td><td><a href="/panel/bonus.php?id=' . $kom['id'] . '"><b>'.$kom['butcer'].'</b></a></td></tr>';}
echo '</table>';

echo '</div>';




echo'<div class="flexHeader"><b>Информация</b>';
if(!$id || $id == $user_id || $rights >= 7){ echo'<span style="font-weight: 400; padding-right: 7px; float: right;"><a href="my_data.php?id=' . $user['id'] . '">ред.</a></span>';
}
  if ($rights >= 9){
echo '<span style="font-weight: 400; padding-right: 7px; float: right;"><a href="../' . $admp . '/index.php?act=usr_del&amp;id=' . $user['id'] . '">Удалить</a> |</span>';
}
  if ($rights >= 7){
echo '<span style="font-weight: 400; padding-right: 7px; float: right;"><a href="users_ban.php?act=ban&amp;id=' . $user['id'] . '">Банить</a> | </span>';
}
echo' </div>';

echo'<div class="d">';

echo'<table >';
echo'	<tr valign="top"><td><div class="grey">Рождения</div></td><td>' . $user['dayb'] . '&nbsp;' . $mesyac[$user['monthb']] . '&nbsp;' . $user['yearofbirth'] . '</td></tr>';
if (!empty($user['live']))
echo '<tr valign="top"><td><div class="grey">Город</div></td><td>' . $user['live'] . '</td></tr>';

	$out = '';
	if (!empty($user['mail']) && (($id && $user['mailvis']) || !$id || $rights >= 7)) {
	$out .= '<tr valign="top"><td><div class="grey">E-mail</div></td><td>' . $user['mail'];
    $out .= ($user['mailvis'] ? '' : '<span class="gray"> [скрыт]</span>') . '</td></tr>';
	}
	echo $out;
	
echo'	<tr valign="top"><td><div class="grey">Регистр.</div></td><td>' . date("d.m.Y", $user['datereg']) . '</td></tr>';
echo '<tr valign="top"><td><div class="grey">На сайте</div></td><td>' . timecount($user['total_on_site']) . '</td></tr>';

echo '</table>';


if ($rights >= 1 && $rights >= $user['rights']) {
echo '<table id="example">';
echo '<tr valign="top"><td><div class="grey">Адрес IP:</div></td><td><a href="../' . $admp . '/index.php?act=usr_search_ip&amp;ip=' . $user['ip'] . '">' . long2ip($user['ip']) . '</a></td></tr>';
echo '<tr valign="top"><td><div class="grey">Браузер:</div></td><td>' . $user['browser'] . '</td></tr>';
echo '</table>';
}

echo '<center><a class="at" href="info.php?id='.$user['id'].'">Полная информация »</a></center>';
echo '</div>';

$new = mysql_result(mysql_query("SELECT COUNT(*) FROM `wall`  WHERE `user_id`=" . $user['id'] . " AND `time`>'" . ($realtime - 259200) . "'"), 0);
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id`=" . $user['id'] . ""), 0);
            if ($new > 0) {
            $wall = $total;
}
else {
    $wall = $total;
}

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


echo'<div class="flexHeader"><a href="wall.php?user='.$user['id'].'"><b>Стена</b> (' . $wall . ')</a></div>';
echo '<div class="c">';
       echo '<form method="post" name="mess" action="wall.php?user='.$user['id'].'"><center>'.bbcode('mess', 'message').'</center><textarea style="width: 97%" title="Введите текст сообщения" name="message"></textarea><br/>';
	echo'<input type="submit" value="Написать на стене"/>';
	$refr = rand(0, 999);
        echo '<a class="button" href="#">Обновить</a>';
	
	echo '</form></div>';
echo '<div class="">';
$k_post = @mysql_result(@mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = '$user[id]'"), 0);
        $refr = rand(0, 999);	
        $req = mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = '$user[id]'");
        $total = mysql_result($req, 0);
if ($total) {
        $req = mysql_query("SELECT * FROM `wall` WHERE `user_id` = '$user[id]' ORDER BY `time` DESC LIMIT " . $start . "," . $kmess . ";");
while ($array = mysql_fetch_array($req))
            {
                echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<div class="">' : '<div class="">';
		$user_nick = mysql_result(mysql_query("SELECT `name` FROM `users` WHERE `id` = '".$array['who']."';"), 0);

                $uz = @mysql_query("select `sex`,`status` from `users` where id='" . $array['who'] . "';");
                $arrz = @mysql_fetch_array($uz);

                $vrp = $array['time'] + $sdvig * 3600;
                $vr = date("d.m в H:i", $vrp);
        echo $div;
				
		
		
		/*
		echo '<td>';
						if (file_exists(('../files/photo/' . $user['id'] . '.jpg'))){
						echo '<img style="border-radius:5px;" src="../files/photo/' . $user['id'] . '.jpg" alt="' . $user['name'] . '" width="64px" height="64px"/>&nbsp;';
						}else{
						echo ' <img style="border-radius:5px;" src="../files/photo/nophoto.jpg" alt="' . $user['name'] . '" width="64px" height="64px"/>&nbsp;';
						}
		echo '</td>';
		*/
		
		
		echo '<div class="b">';
                if ((!empty ($_SESSION['uid'])) && ($_SESSION['uid'] != $array['who']))
        {
        echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($arrz['sex'] == 'm' ? 'm' : 'w') . '.png" alt=""/>&nbsp;<a href="anketa.php?id=' . $array['who'] . '"><b>' . $user_nick . '</b></a>&nbsp;';
        } else
        {
        echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($arrz['sex'] == 'm' ? 'm' : 'w') . '.png" alt=""/>&nbsp;<b>' . $user_nick . '</b>&nbsp;';
        }
		
		echo $vr;	
		echo '</div>';
		
		
		
		
		
			    $text = $array['message'];	
                            $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
                            if ($offsm != 1)
                            {            if ($set_user['smileys'])
                            $text = smileys($text, ($massiv1['from'] == $nickadmina || $massiv1['from'] == $nickadmina2 || $massiv11['rights'] >= 1) ? 1 : 0);
                            }
                            $text = str_replace("\r\n", "<br/>", $text);
                            $text = tags($text);
                            echo '<div class="c"> '.$text.'';
							
							if(!$id || $id == $user_id) {
							
                            echo '<div style="text-align:right">
							[<a href="wall.php?delete='.$array['id'].'" >Del</a>]
							</div>';	
							}
							
							
							echo '</div>';
							
                            
		
            echo '</div>';
            ++$i;
            }
}else {
echo '<div class="b"><p style="text-align:center;">Сообщений нет, будь первым!</p></div>';
}

echo '</div>';






require_once('../incfiles/end.php');

?>