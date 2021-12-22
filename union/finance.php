<?php
define('_IN_JOHNCMS', 1);

$headmod = 'union';
$textl = 'Финансы';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");


$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

$k = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$kom = @mysql_fetch_array($k);


if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../incfiles/end.php");
exit;
}



//ВЗНОС
if ($act == "add")
{



if (isset($_POST['submit']))
{
$money = intval($_POST['money']);

if ($kom[money] >= $money && $money >= 100)
{
$moneykom = $kom[money] - $money;

$kredkom = $kom[kred] - $money;
if ($kredkom < 0)
{$kredkom = 0;}

$moneyunion = $arr[money] + $money;

mysql_query("update `team_2` set `money`='" . $moneykom . "', `kred`='" . $kredkom . "' where id = '" . $kom[id] . "' LIMIT 1;");
mysql_query("update `union` set `money`='" . $moneyunion . "' where id = '" . $arr[id] . "' LIMIT 1;");

mysql_query("insert into `finance` set 
`type`='union', 
`id_tran`='".$arr['id']."', 
`time_tran`='".$realtime."', 
`status_tran`='minus', 
`kom_tran`='Сделал взнос в союз', 
`money_tran`='".$money."', 

`id_user`='".$datauser[id]."', 
`name_user`='".$datauser[imname]." ".$datauser[name]."'
;");
mysql_query("INSERT INTO `union_journal` SET `unid` = '" . $arr['id'] . "', `time` = '$realtime', `text` = 'Игрок ".$datauser[imname]." ".$datauser[name]." сделал взнос в союз, в размере " . $money . " евро.';");
} 
else
{
echo '<div class="c">Недостаточно денег.<br/>Минимально 100 €</div>';
require_once ("../incfiles/end.php");
exit;
} 


header('location: finance.php?id='.$arr['id'].'');
} 
else
{
echo '<div class="gmenu"><b>Сделать взнос</b></div>';
echo '<div class="c">';
echo '<form action="finance.php?act=add&amp;id='.$arr['id'].'" method="post">';
echo '<input type="text" name="money" value="0"/><br/>';
echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/></form><br/>";
echo '</div>';

}








require_once ("../incfiles/end.php");
exit;
}



//ПЕРЕВОД
if ($act == "vsouz")
{
if ($arr[id_prez] != $datauser[id])
{
header('location: finance.php?id='.$arr[id]);
exit;
}

if (isset($_POST['submit']))
{
$union = intval($_POST['union']);
$money = intval($_POST['money']);

$q2 = mysql_query("select * from `union` where id='" . $union . "' LIMIT 1;");
$arr2 = mysql_fetch_array($q2);


if ($arr[money] >= $money && $money > 0)
{
$moneyunion1 = $arr[money] - $money;
$moneyunion2 = $arr2[money] + $money;

mysql_query("update `union` set `money`='" . $moneyunion1 . "' where id = '" . $arr[id] . "' LIMIT 1;");
mysql_query("update `union` set `money`='" . $moneyunion2 . "' where id = '" . $arr2[id] . "' LIMIT 1;");

mysql_query("insert into `finance` set 
`type`='union', 
`id_tran`='".$arr2['id']."', 
`time_tran`='".$realtime."', 
`status_tran`='minus', 
`kom_tran`='Перевод от союза ".$arr['name']."', 
`money_tran`='".$money."', 

`id_user`='".$datauser[id]."', 
`name_user`='".$datauser[imname]." ".$datauser[name]."'
;");

mysql_query("INSERT INTO `union_journal` SET `unid` = '" . $arr2['id'] . "', `time` = '$realtime', `text` = 'Перевод от союза ".$arr['name'].", в размере " . $money . " евро.';");

mysql_query("insert into `finance` set 
`type`='union', 
`id_tran`='".$arr['id']."', 
`time_tran`='".$realtime."', 
`status_tran`='plus', 
`kom_tran`='Перевод в союз ".$arr2['name']."', 
`money_tran`='".$money."', 

`id_user`='".$datauser[id]."', 
`name_user`='".$datauser[imname]." ".$datauser[name]."'
;");

mysql_query("INSERT INTO `union_journal` SET `unid` = '" . $arr['id'] . "', `time` = '$realtime', `text` = 'Перевод в союз ".$arr['name'].", в размере " . $money . " евро.';");
} 
else
{
echo '<div class="c">Недостаточно денег</div>';
require_once ("../incfiles/end.php");
exit;
} 


header('location: finance.php?id='.$arr['id'].'');
} 
else
{
echo '<div class="gmenu"><b>Перевод в другой союз</b></div>';
echo '<div class="c">';

$req = mysql_query("SELECT * FROM `union` where id != '" . $arr[id] . "' order by players desc;");

echo '<form action="finance.php?act=vsouz&amp;id='.$arr['id'].'" method="post">';
echo '<input type="text" name="money" value="0"/><br/>';
echo '<select name="union">';
while ($arr = mysql_fetch_array($req))
{
echo '<option value="'.$arr[id].'">'.$arr[name].'</option>';
}
echo '</select><br/>';
echo '<input type="submit" name="submit" value="Перевести" />';
echo '</form>';
echo '</div>';

}

require_once ("../incfiles/end.php");
exit;
}






//ПЕРЕВОД
if ($act == "vteam")
{
if ($arr[id_prez] != $datauser[id])
{
header('location: finance.php?id='.$arr[id]);
exit;
}


if (isset($_POST['submit']))
{
$team = intval($_POST['team']);
$money = intval($_POST['money']);

$q2 = mysql_query("select * from `team_2` where id='" . $team . "' LIMIT 1;");
$kom2 = mysql_fetch_array($q2);


if ($arr[money] >= $money && $money > 0 && $money <= 30000 && $kom2[kred] == 0)
{
$moneyunion1 = $arr[money] - $money;
$moneykom2 = $kom2[money] + $money;

mysql_query("update `union` set `money`='" . $moneyunion1 . "' where id = '" . $arr[id] . "' LIMIT 1;");
mysql_query("update `team_2` set `money`='" . $moneykom2 . "', `kred`='" . $money . "' where id = '" . $kom2[id] . "' LIMIT 1;");

mysql_query("insert into `finance` set 
`type`='union', 
`id_tran`='".$arr['id']."', 
`time_tran`='".$realtime."', 
`status_tran`='plus', 
`kom_tran`='Кредит команде ".$kom2['name']."', 
`money_tran`='".$money."', 

`id_user`='".$datauser[id]."', 
`name_user`='".$datauser[imname]." ".$datauser[name]."'
;");

mysql_query("INSERT INTO `union_journal` SET `unid` = '" . $arr['id'] . "', `time` = '$realtime', `text` = 'Кредит команде ".$kom2['name'].", в размере " . $money . " евро.';");

mysql_query("insert into `finance` set 
`type`='team', 
`id_tran`='".$kom2['id']."', 
`time_tran`='".$realtime."', 
`status_tran`='plus', 
`kom_tran`='Кредит от союза ".$arr['name']."', 
`money_tran`='".$money."', 

`id_user`='".$datauser[id]."', 
`name_user`='".$datauser[imname]." ".$datauser[name]."'
;");

mysql_query("INSERT INTO `union_journal` SET `unid` = '" . $arr2['id'] . "', `time` = '$realtime', `text` = 'Кредит от союза ".$arr['name'].", в размере " . $money . " евро.';");

} 
else
{
echo '<div class="c">Недостаточно денег.<br/>Максимальный кредит 3000 €<br/>У команды уже есть непогашеный кредит</div>';
require_once ("../incfiles/end.php");
exit;
} 


header('location: finance.php?id='.$arr['id'].'');
} 
else
{
echo '<div class="gmenu"><b>Выдать кредит</b></div>';
echo '<div class="c">';

$req = mysql_query("SELECT * FROM `team_2` where `union` = '" . $arr[id] . "' order by rate desc;");

echo '<form action="finance.php?act=vteam&amp;id='.$arr['id'].'" method="post">';
echo '<input type="text" name="money" value="0"/><br/>';
echo '<select name="team">';
while ($res = mysql_fetch_array($req))
{
echo '<option value="'.$res[id].'">'.$res[name].'</option>';
}
echo '</select><br/>';
echo '<input type="submit" name="submit" value="Перевести" />';
echo '</form>';
echo '</div>';

}


require_once ("../incfiles/end.php");
exit;
}













echo '<div class="gmenu"><b>Финансы</b></div>';


if($kom['union'] == $id)
{
echo '<div class="c"><a href="finance.php?act=add&amp;id='.$arr['id'].'">Сделать взнос</a></div>';
}




$req = mysql_query("SELECT COUNT(*) FROM `finance` where `type`='union' AND `id_tran`='" . $id . "';");
$colmes = mysql_result($req, 0);

$q1 = mysql_query("SELECT * FROM `finance`  where `type`='union' AND `id_tran`='" . $id . "' ORDER BY `time_tran` DESC LIMIT " . $start . ", 30;");

$mesto = $start + 1;

echo '<table id="example">';



while ($res = mysql_fetch_array($q1))
{

if (!empty($_SESSION['uid']) && $user_id == $res[id_admin])
{
echo '<tr class="redrows">';
}
else
{
echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="evenrows">';
}

echo '<td width="15%" align="center">'.date("d.m H:i", $res[time_tran]).'</td>';
echo '<td><a href="/id' . $res['id_user'] . '">'.$res[name_user].'</a></td>
<td>'.$res[kom_tran].'</td>
<td width="10%" align="center"><font color="green"><b>+'.$res[money_tran].' €</b></font></td>';	
echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';

if ($colmes > 30)
{
echo '<div class="c">' . pagenav('finance.php?id='.$arr['id'].'&amp;', $start, $colmes, 30) . '</div>';
}

//echo '<div class="c">Всего: '.$colmes.'</div>';
if ($datauser[id] == $arr['id_prez'])
{
echo '<div class="c">';
echo '<a href="finance.php?act=vsouz&amp;id='.$arr['id'].'"><font color="red"><b>Перевод в другой союз</b></font></a><br/>';
echo '<a href="finance.php?act=vteam&amp;id='.$arr['id'].'"><font color="red"><b>Выдать кредит</b></font></a><br/>';
echo '</div>';
}

require_once ("../incfiles/end.php");
?>