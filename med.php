<?php

define('_IN_JOHNCMS', 1);

$textl = 'Больница';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="login.php">авторизованным</a> посетителям';
if ($error) {
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
    require_once ("incfiles/end.php");
    exit;
}
if ($med == '0') {
    echo '<div class="rmenu">У вас не нанят врач!</div>';
    require_once ('incfiles/end.php');
    exit;
}
if ($med == "1") {
    $kost = '5000';
}
if ($med == "2") {
    $kost = '3000';
}
if ($med == "3") {
    $kost = '1000';
}
switch ($act) {
    default:

        $reg = mysql_query("SELECT * FROM `player_2` where `kom`='" . $fid ."' AND `btime`!='0' order by btime asc;");
        if (!mysql_num_rows($reg)) {
            echo '<div class="c">';
            echo '<center><img src="img/med.jpeg" alt=""/></center>';
            echo 'У вас нет травмированых игроков<br/></div>';
            echo '<br/>[<a href="index.php">В панель управления</a>]<br/>';
            require_once ("incfiles/end.php");
            exit;
        }
        echo '<div class="c">';
        echo '
<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">
<tr bgcolor="40B832" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Игрок</b></td>
<td><b>Травма</b></td>
<td><b>Лечить</b></td>
</tr>
';
        while ($arr = mysql_fetch_array($reg)) {
		
            $travma = round(($arr['btime'] - $realtime) / 3600);
			if($travma < 0){
			mysql_query("update `player_2` set `sostav`='0' ,`btime`='0' where id='" . $arr['id'] ."' ;");
			}
            echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                '<tr bgcolor="f3f3f3">';
            echo '
<td><center>' . $arr['nomer'] . '</center></td>
<td><a href="player.php?id=' . $arr['id'] . '">' . $arr['name'] . '</a></td>
<td><center><font color="red"><b>' . $travma . '</b> часов</font></center></td>';
            echo '<td><form action="med.php?act=med&amp;id=' . $arr['id'] .
                '" method="post" name="form" enctype="multipart/form-data">';
            echo '<small>Укажите время в часах. Стоимость одного часа ' . $kost .
                '</small><br />';
            echo '<input type="text" name="times" />';
            echo '<input type="submit" value="Лечить" />';
            echo '</form></td>';


            echo '</tr>';
            ++$i;
        }
        echo '</table><br/></div>';
        break;
    case 'med':
        $kom = $_GET['id'];
        $error = false;

        if (empty($_POST['times']))
            $error .= 'Вы не ввели время<br />';
        if (preg_match("/[-\@\*\(\)\?\!\~\_\=\[\]]+/", $_POST['times']))
            $error = $error . 'Недопустимые символы  !<br/>';
        $r = mysql_query("SELECT `kom`, `btime` FROM `player_2` where `id`='" . $kom .
            "' ;");
        if (!mysql_num_rows($r)) {
            echo "Игрока не существует<br/>";
            echo '<br/>[<a href="index.php">В панель управления</a>]<br/>';
            require_once ("incfiles/end.php");
            exit;
        }
        $ar = @mysql_fetch_array($r);
        if ($ar['kom'] != $fid) {
            echo "Игрок не ваш!<br/>";
            echo '<br/>[<a href="index.php">В панель управления</a>]<br/>';
            require_once ("incfiles/end.php");
            exit;
			
			
			
        }
		    if ($money  < $kost * $_POST['times']) {
            echo "Нет достаточно средств!<br/>";
            echo '<br/>[<a href="index.php">В панель управления</a>]<br/>';
            require_once ("incfiles/end.php");
            exit;
        }
		
		
        $tim = $_POST['times'] * 3600;
        $plata = $money - $kost * $_POST['times'];
        $ttime = $ar['btime'] - $tim;
        $sostav=3;
        if ($realtime >= $ttime) {
            $ttime = 0;
            $sostav = 0;
        }
        if (!$error) {
            mysql_query("update `player_2` set `sostav`='".$sostav."' ,`btime`='" . $ttime . "' where id='" . $kom .
                "' LIMIT 1;");
            mysql_query("update `team_2` set `money`='" . $plata . "' where id='" . $fid .
                "' LIMIT 1;");

            header('Location: med.php?id=' . mysql_insert_id());
        } else {
            echo '<div class="rmenu"><p>ОШИБКА!<br />' . $error .
                '<a href="med.php">Повторить</a></p></div>';
        }
        break;
}
echo '<br/><a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
