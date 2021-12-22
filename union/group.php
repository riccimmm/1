<?php
define('_IN_JOHNCMS', 1);
$headmod = 'union';
$textl = 'Союз';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");
require_once ("../incfiles/manag2.php");


$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../incfiles/end.php");
exit;
}

$k = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$kom = @mysql_fetch_array($k);



//ВСТУПАЕМ
if ($act == "add")
{

$access_lvl = ($arr['access_lvl'] == 1 ? 1 : 1);
if ($kom['lvl'] < $access_lvl)
{
echo '<div class="gmenu"><b>Вступить в союз</b></div>
<div class="c">Вступить в союз можно с ' . $access_lvl . '-го уровня.</div>';
require_once ("../incfiles/end.php");
exit;
}

$qqz = mysql_query("select * from `union` where id_prez='" . $user_id . "' LIMIT 1;");
$sarr = mysql_fetch_array($qqz);

if (!empty($sarr['id_prez'])) {
    echo display_error('Вы являетесь создателем какого-либо союза и не можете принимать участие.');
    require_once ('../incfiles/end.php');
    exit;
}

if (empty($kom['union']))
{
$mdr = $arr['union_mod'];

mysql_query("update `team_2` set `union`='" . $arr['id'] . "'" . ($mdr ? ", `union_mod` = 0 " : ", `union_mod` = 1 ") . "where `id`='" . $datauser['manager2'] . "' LIMIT 1;");
if ($mdr) {
echo '<div class="gmenu"><p>Ваша заявка на вступление в этот союз принята! Президент союза рассмотрит её и либо примет вас, либо отклонит вашу заявку! Ожидайте.</p><p><a href="group.php?id='.$arr['id'].'">В союз</a></p></div>';
require_once ("../incfiles/end.php");
exit;
}
} else if($kom['union'] !== $id){
echo '<div class="gmenu"><p>Вы уже подали заявку в другой союз, или Вы состоите в другом союзе, сначала покиньте союз.</p><p><a href="group.php?id='.$arr['id'].'">В союз</a></p></div>';
require_once ("../incfiles/end.php");
exit;
}

else {
header('location: group.php?id='.$arr['id'].'');
exit;
}
} 

//ВЫХОДИМ
if ($act == "exit")
{

if($arr['id_prez'] == $user_id){
echo '<div class="c">Вы президент союза.</div>';
require_once ("../incfiles/end.php"); exit; }

if ($kom[kred] > 0)
{
echo '<div class="c">У вас есть непогашеный кредит, Вы не сможете покинуть союз пока не погасите кредит.</div>';
require_once ("../incfiles/end.php");
exit;
} 


if (isset($_GET['yes']))
{
mysql_query("update `team_2` set `union`='' where `id`='" . $datauser['manager2'] . "' LIMIT 1;");
mysql_query("INSERT INTO `union_journal` SET `unid` = '" . $arr['id'] . "', `time` = '$realtime', `text` = 'Игрок " . $login . " уволился из союза';");
header('location: index.php');
}
else
{
echo '<div class="gmenu"><b>Покинуть союз</b></div>
<div class="c">Вы уверены что хотите покинуть этот союз?<br/>
<a href="group.php?act=exit&amp;id='.$arr['id'].'&amp;yes">Да</a></div>';
}
require_once ("../incfiles/end.php");
exit;
}


// ДОБАВЛЯЕМ СООБЩЕНИЕ
if ($act == "say")
{

if (empty($_POST['msg']))
{
header('location: group.php?id='.$arr['id']);
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

header('location: group.php?id='.$id);
exit;
}


// УДАЛЯЕМ СООБЩЕНИЕ
if ($act == "delpost")
{

if (empty($_GET['id']))
{
header('location: group.php?id='.$kom['union']);
exit;
}

if ($rights >= 6 || $datauser[id] == $arr['id_prez'])
{
$s = intval($_GET['s']);
mysql_query("delete from `stena` where `id`='" . $s . "' LIMIT 1;");
}

header('location: group.php?id='.$kom['union']);
require_once ("../incfiles/end.php");
exit;
}

// ВЫВОДИМ СОЮЗ

    echo '<div class="c"><table cellpadding="0" cellspacing="0"><tr><td valign="top">';
    if (file_exists(($rootpath . 'files/avatar/' . $datauser['id'] . '.png')))
        echo '<a href="/union/logo.php?act=up_logo&amp;id='.$arr['id'].'"><img src="/union/logo/big'.$arr['id'].'.jpeg" width="50" height="50" alt="'.$arr['name'].'" /></a>&nbsp;';
    else
        echo '<a href="/union/logo.php?act=up_logo&amp;id='.$arr['id'].'"><img src="/images/empty.jpeg" width="50" height="50" alt="'.$arr['name'].'" /></a>&nbsp;';
    echo '</td><td valign="top">'.
    '<b>'.$arr['name'].'</b> ';
    echo '<br />';
    echo 'Президент: <a href="/str/anketa.php?id='.$arr['id_prez'].'">'.$arr[name_prez].'</a><br/>';
              echo 'Баланс союза: '.$arr[money].' €.</td></tr></table></div>';

if($kom['union'] == $id && $kom['union_mod'] == 1)
{
echo '<div class="c"><center><a href="group.php?act=exit&amp;id='.$arr['id'].'">Покинуть союз</a></center></div>';
}
else {
echo '<br /><center><a class="button" href="group.php?act=add&amp;id='.$arr['id'].'">Вступить в союз</a></center><br />';
}


if ($kom['union'] == $id && !$kom['union_mod'])
  echo '<div class="rmenu">Ваша заявка на вступление рассматривается! Заявки просматривают 2-3 раза в сутки.</div>';
if ($arr['id_prez'] == $user_id) {
    $rty = mysql_result(mysql_query("SELECT COUNT(*) FROM `team_2` WHERE `union` = '$id' AND `union_mod` = '0';"), 0);
    if ($rty > 0)
      echo '<div class="c"><b>Функции президента</b></div>';
      echo '<div class="c">';
      echo '<a href="mod.php?id=' . $id . '">Кандидаты на вступление</a> (' . $rty . ')</a><br/>';
      echo '<a href="msg.php?id=' . $id . '">Рассылка сообщений</a><br/>';
      echo '<a href="tournament/add_cups.php?union=' . $id . '">Добавить кубок</a><br/>';
      echo '</div>';
}

echo '<div class="c"><b>Меню союза</b></div>';
echo '<div class="c">';
echo '<a href="rezident.php?id='.$arr['id'].'">Участники</a> ('.$arr[players].')<br/> ';
echo '<a href="wall.php?id='.$arr['id'].'">Стена</a><br/>';
echo '<a href="journal.php?id='.$arr['id'].'">Журнал<br/>';
echo '<a href="/union/tournament/?union='.$arr['id'].'">Кубки</a><br/>';
echo '<a href="/union/tournament/rating_cups.php?union='.$arr['id'].'">Рейтинг по кубкам</a><br/>';
echo '<a href="news.php?id='.$arr['id'].'">Новости</a><br/>';
echo '<a href="info.php?id='.$arr['id'].'">Информация</a><br/>';
echo '<a href="finance.php?id='.$arr['id'].'">Финансы</a><br/>';
echo '<a href="slava.php?id='.$arr['id'].'">Зал славы</a><br/>';
 $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `priz_2` LEFT JOIN `team_2` ON `priz_2`.`win` = `team_2`.`id` WHERE `team_2`.`union` = '$id';"), 0);
echo '<a href="trofei.php?id='.$arr['id'].'">Трофеи</a> (' . $count . ')<br/>';
echo '</div>';


echo '<div class="c"><b>Последний кубок</b></div>';
$reqz = mysql_query("SELECT * FROM `r_union_cup` WHERE `id_union` = '".$id."' ORDER BY `time` DESC LIMIT 1");
$totalz = mysql_num_rows($reqz); if($totalz > 0){
$zaq = mysql_fetch_assoc($reqz);

echo '<table id="example">';
echo '<tr class="oddrows">';
echo '<td width="'; echo ($theme == "wap") ? '32' : '55';
echo 'px" align="center"><img width="48" height="48" src="/union/logo/';

if(file_exists('logo/big'.$zaq['id_union'].'.jpeg')){
echo ($theme == "wap") ? 'small' : 'big'; echo $zaq['id_union'].'.jpeg" alt=""/></td>';
} else { echo 'empty.jpeg" alt=""/></td>'; }

echo '<td><a href="/union/tournament/cup.php?id='.$zaq[id].'"><b>'.$zaq['name'].'</b></a> '.date("H:i", $zaq['time']).'<br/>';

$b = mysql_query("SELECT * FROM `r_union_bilet` where id_cup = '" . $zaq[id] . "' order by time desc;");
$totalbilet = mysql_num_rows($b);

echo '
Приз: ' . $zaq['priz'] . ' €<br/>
Участников: ' . $totalbilet . ' из '.(($zaq['type'] == 1) ? 16 : 8).'<br/>';
if($zaq['status'] == 'yes') echo 'Турнир окончен<br/>';
echo 'Уровень игрока: ';
if ($zaq['ot'] == $zaq['do'])
{echo ''.$zaq['ot'] . '';}
else
{echo 'от '.$zaq['ot'] . ' до '.$zaq['do'] . '';}

if($zaqz['id_prez'] == $user_id or $rights == 9) echo '<br/><a href="/union/tournament/delete.php?id='.$zaq['id'].'">Удалить кубок</a>';
echo '</td></tr></table>';


} else { echo '<div class="c">В данный момент турниров нет.</div>'; }



// СТЕНА
echo '<div class="c"><b>Стена</b></div>';

if (!empty($datauser['id']) && !$ban['1'])
{

echo '<div class="c">';
echo '<form name="form" action="group.php?act=say&amp;id=' . $arr['id'] . '" method="post">';
echo '<textarea rows="4" style="width: 99%" title="Введите текст сообщения" name="msg"></textarea><br/>';
echo '<p><input type="submit" title="Нажмите для отправки" name="submit" value="Отправить" /></p></form>';
echo '</div>';
}

if ($rights >= 6 || $arr['id_prez'] == $datauser['id'])
{
echo '<form action="wall.php?act=delpost&amp;id='.$arr['id'].'" method="post"><div align="right" class="form"><a class="redton" href="cleanwall.php?id='.$arr['id'].'">Очистить стену</a><br/>&nbsp;</div>';
}


$req = mysql_query("SELECT * FROM `stena` WHERE `idgrupa` = '".$arr['id']."'");
$colmes = mysql_num_rows($req);

         $q1 = mysql_query("
            SELECT `stena`.*, `stena`.`id` AS `sid`, `users`.`rights`, `users`.`lastdate`, `users`.`sex`, `users`.`datereg`, `users`.`id`
            FROM `stena` LEFT JOIN `users` ON `stena`.`user_id` = `users`.`id`
            WHERE `stena`.`idgrupa` = '".$arr['id']."' ORDER BY `stena`.`time` DESC LIMIT " . $start . ", 5;");



                while ($res = mysql_fetch_assoc($q1)) {
                    if ($res['close'])
                        echo '<div class="bmenu">';
                    else
                        echo ($i % 2) ? '<div class="c">' : '<div class="c">';
echo'<div class="">';
if ($rights >= 6 || $arr['id_prez'] == $datauser['id']) echo '<input type="checkbox" name="del[]" value="'.$arr['id'].'_'.$res['sid'].'" />';

                    
                  

                    // Ник юзера и ссылка на его анкету
                    if ($user_id && $user_id != $res['user_id']) {
                        echo '<a href="'.$home.'/str/anketa.php?id=' . $res['user_id'] . '"><b>' . $res['name'] . '</b></a> ';
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
							echo'</div>';
                    
if ($rights >= 6 || $arr['id_prez'] == $datauser['id'])
{
echo '<div class="" style="text-align:right">';
echo '<a class="redton" href="group.php?act=delpost&amp;id='.$arr['id'].'&amp;s='.$res['sid'].'">Удалить</a>';
echo '</div>';
}
                    echo '</div>';
                    ++$i; unset($header);
                }

if ($rights >= 6 || $arr['id_prez'] == $datauser['id'])
{
echo '<input type="submit" value="Удалить выбранное" /></form>';
}

if ($colmes == 0)
{
echo '<div class="b"><p style="text-align:center;">Сообщений нет, будь первым!</p></div>';
}


require_once ("../incfiles/end.php");
?>