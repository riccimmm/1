<?php
define('_IN_JOHNCMS', 1);
$headmod = 'fegokreohie4lkn';
$textl = 'Стена союза';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");

$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

// ДОБАВЛЯЕМ СООБЩЕНИЕ
if ($act == "say")
{

if (empty($_POST['msg']))
{
header('location: wall.php?id='.$arr['id']);
exit;
}

$msg = trim($_POST['msg']);
$msg = mb_substr($msg, 0, 1000);

mysql_query("insert into `stena` set
`idgrupa`='" . $id . "',
`time`='" . $realtime . "',
`user_id`='" . $datauser['id'] . "',
`name`='" . $datauser['imname'] . " " . $datauser['name'] . "',
`text`='" . mysql_real_escape_string($msg) . "';");

header('location: wall.php?id='.$id);
exit;
}


// УДАЛЯЕМ СООБЩЕНИЕ
if ($act == "delpost")
{

if(!empty($_POST['del']) && is_array($_POST['del'])){
if ($rights >= 6 || $datauser[id] == $arr['id_prez'])
{ foreach($_POST['del'] as $delete){ $exp = explode('_', $delete);
if($exp[0] == $arr['id']) mysql_query("delete from `stena` where `id`='".abs(intval($exp[1]))."' LIMIT 1;");
} header('location: wall.php?id='.$arr['id']); die();
} else { header('location: wall.php?id='.$arr['id']); exit; } }

if (empty($_GET['id']))
{
header('location: wall.php?id='.$kom['union']);
exit;
}

if ($rights >= 6 || $datauser[id] == $arr['id_prez'])
{
$s = intval($_GET['s']);
mysql_query("delete from `stena` where `id`='" . $s . "' LIMIT 1;");
}

header('location: wall.php?id='.$kom['union']);
require_once ("../incfiles/end.php");
exit;
}


if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../incfiles/end.php");
exit;
}

$k = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$kom = @mysql_fetch_array($k);

echo '<div class="bmenu"><b>'.$arr['name'].'</b></div>';

if (!empty($datauser['id']) && !$ban['1'])
{

echo '<div class="c">';
echo '<form name="form2" action="wall.php?act=say&amp;id=' . $arr['id'] . '" method="post">';
echo '<textarea rows="4" style="width: 99%" title="Введите текст сообщения" name="msg"></textarea><br/>';
echo '<p><input type="submit" title="Нажмите для отправки" name="submit" value="Отправить" /></p></form>';
echo '</div>';
}

$req = mysql_query("SELECT * FROM `stena` WHERE `idgrupa` = '".$arr['id']."'");
$colmes = mysql_num_rows($req);

         $q1 = mysql_query("
            SELECT `stena`.*, `stena`.`id` AS `sid`, `users`.`rights`, `users`.`lastdate`, `users`.`sex`, `users`.`status`, `users`.`datereg`, `users`.`id`
            FROM `stena` LEFT JOIN `users` ON `stena`.`user_id` = `users`.`id`
            WHERE `stena`.`idgrupa` = '".$arr['id']."' ORDER BY `stena`.`time` DESC LIMIT " . $start . ", 10;");


if ($rights >= 6 || $arr['id_prez'] == $datauser['id'])
{
echo '<form action="?act=delpost&amp;id='.$arr['id'].'" method="post"><div align="right" class="form">
<a href="cleanwall.php?id='.$arr['id'].'">Очистить стену</a><br/><b><label for="all">Отметить все</label></b> <input type="checkbox" id="all" onchange="var o=this.form.elements;for(var i=0;i&lt;o.length;i++)o[i].checked=this.checked" />&nbsp;</div>';
}

                while ($res = mysql_fetch_assoc($q1)) {
                    if ($res['close'])
                        echo '<div class="bmenu">';
                    else
                        echo ($i % 2) ? '<div class="c">' : '<div class="c">';

if ($rights >= 6 || $arr['id_prez'] == $datauser['id']) echo '<input type="checkbox" name="del[]" value="'.$arr['id'].'_'.$res['sid'].'" />';

                    if ($set_user['avatar']) {
                        echo '<table cellpadding="0" cellspacing="0"><tr><td>';
			$header = array_change_key_case(get_headers('http://futmen.net/files/avatar/'.$res['user_id'].'.png', 1), CASE_LOWER);
                        if ($header[0] == 'HTTP/1.1 200 OK')
                            echo '<img src="http://futmen.net/files/avatar/' . $res['user_id'] . '.png" width="32" height="32" alt="' . $res['name'] . '" />&nbsp;';
                        else
                            echo '<img src="http://futmen.net/images/empty.png" width="32" height="32" alt="' . $res['name'] . '" />&nbsp;';
                        echo '</td><td>';
                    }
                    
                    // Ник юзера и ссылка на его анкету
                    if ($user_id && $user_id != $res['user_id']) {
                        echo '<a href="http://futmen.net/str/anketa.php?id=' . $res['user_id'] . '"><b>' . $res['name'] . '</b></a> ';
                    } else {
                        echo '<b>' . $res['name'] . '</b> ';
                    }
                    // Метка Онлайн / Офлайн
                    echo ($realtime > $res['lastdate'] + 300 ? '<span class="red"> [Off]</span> ' : '<span class="green"> [ON]</span> ');
                    // Время поста
                    echo ' <span class="gray">(' . date("d.m.Y / H:i", $res['time'] + $set_user['sdvig'] * 3600) . ')</span><br />';
                    if ($set_user['avatar'])
                        echo '</td></tr></table>';
                    ////////////////////////////////////////////////////////////
                    // Вывод текста поста                                     //
                    ////////////////////////////////////////////////////////////
$text = checkout($res['text'], 1, 1);
                           if ($set_user['smileys'])
                            $text = smileys($text, $res['rights'] ? 1 : 0);
                        echo $text;

         echo '<div class="sub">';
echo '<a href="reply.php?union='.$arr['id'].'&message='.$res['sid'].'&type=yo">Ответить</a> / ';
echo '<a href="reply.php?union='.$arr['id'].'&message='.$res['sid'].'">Цитировать</a>';

if ($rights >= 6 || $arr['id_prez'] == $datauser['id'])
{
echo ' / <a href="wall.php?act=delpost&amp;id='.$arr['id'].'&amp;s='.$res['sid'].'">Удалить</a>';
}
echo '</div>';
                    echo '</div>';
                    ++$i; unset($header);
                }

if ($rights >= 6 || $arr['id_prez'] == $datauser['id'])
{
echo '<input type="submit" value="Удалить выбранное" /></form>';
}


if ($colmes == 0)
{
echo '<div class="c">Здесь никто ничего не написал</div>';
}

if ($colmes > 10)
{
echo '<div class="c">' . pagenav('wall.php?id=' . $id . '&amp;', $start, $colmes, 10) . '</div>';
}

require_once ("../incfiles/end.php");
?>
