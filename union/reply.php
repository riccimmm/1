<?php
define('_IN_JOHNCMS', 1);
$headmod = 'fegokreohie4lkn';
$textl = 'Стена союза';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");

$union = abs(intval($_GET['union']));
$message = abs(intval($_GET['message']));
$type = !empty($_GET['type']) ? 2 : 1;

$q = mysql_query("select * from `union` where id='" . $union . "' LIMIT 1;");
$arr = mysql_fetch_assoc($q);

if(empty($arr['id'])){
echo '<div class="c">Данный союз отсутствует.</div>';
require_once ("../incfiles/end.php"); die();
}

$cmess = mysql_fetch_assoc(mysql_query("SELECT * FROM `stena` WHERE `idgrupa` = '".$arr['id']."' AND `id` = '".$message."' LIMIT 1"));

if(empty($cmess['id'])){
echo '<div class="c">Данного сообщения не существует.</div>';
require_once ("../incfiles/end.php"); die();
}

if(!empty($_POST['msg'])){ $expand = NULL;
if(!empty($_POST['q'])) $expand .= '[c]'.mb_substr(mysql_real_escape_string($_POST['q']), 0, 500).'[/c]';
$expand .= $cmess['name'].', '.mb_substr(mysql_real_escape_string($_POST['msg']), 0, 500);
mysql_query("");

mysql_query("insert into `stena` set `idgrupa`='".$union."', `time`='".$realtime."',
`user_id`='".$datauser['id']."', `name`='".$datauser['imname']." ".$datauser['name']."',
`text`='".$expand."';");
header("location: wall.php?id=".$arr['id']); die(); }

echo '<form action="?union='.$union.'&message='.$message.'" method="post">'; if($type == 1){
echo 'Цитируем <b>'.$cmess['name'].'</b>:<br/><textarea cols="20" rows="4" name="q">'.$cmess['text'].'</textarea><hr/>';
}

echo 'Ваше сообщение:<br/><textarea cols="20" rows="4" name="msg"></textarea>
<input type="submit" name="submit" value="Отправить"/></form>';

require_once ("../incfiles/end.php"); ?>
