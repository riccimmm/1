<?php
@ ini_set("max_execution_time", "600");
define('_IN_JOHNCMS', 1);
define('_IN_JOHNADM', 1);
$headmod = 'panel';
$textl = 'Буцер';
require_once ('../incfiles/core.php');
require_once ('../incfiles/head.php');

if ($rights >= 9)
{
$q = @mysql_query("select * from `team_2` where id='" . $id . "' LIMIT 1;");
$kom = @mysql_fetch_array($q);

if (isset($_POST['submit']))
{
$bonus = intval($_POST['bonus']);
$allbonus = $bonus + $kom[butcer];

mysql_query("UPDATE `team_2` SET `butcer` = '" . $allbonus . "' WHERE `id` = '" . $kom[id] . "' LIMIT 1");


        // Отправляем письмо
        mysql_query("INSERT INTO `privat` SET
		`user`='" . $kom['name_admin'] . "',
		`text`='Здравствуйте " . $kom['name_admin'] . ".\r\n\r\nВам начислено: " . $bonus . " буцеров.\r\nВсего у Вас: " . $allbonus . " буцеров.\r\n\Удачной игры.\r\n\\r\n\С уважением, ".$login.".',
		`time`='" . $realtime . "',
		`author`='АДМИНИСТРАЦИЯ',
		`type`='in',
		`chit`='no',
		`temka`='Буцеры',
		`otvet`='0'	;");


header('location: index.php');
exit;
} 
else
{
echo '<div class="gmenu"><b>Буцер</b></div>';
echo '<div class="c"><p>
Команда: <b>' . $kom[name] . '</b><br/>
Менеджер: <b>' . $kom[name_admin] . '</b><br/>
Буцеров: <b>' . $kom[butcer] . '</b><br/>
</p></div>';
echo '<div class="c"><p>';
echo '<form action="/panel/bonus.php?id='.$kom[id].'" method="post">';
echo '<input type="text" value="0" name="bonus" size="5" maxlength="3"/>';
echo ' <input type="submit" value="Начислить" name="submit" />';
echo '</form>';
echo '</p></div>';
}

}

require_once ('../incfiles/end.php');
?>