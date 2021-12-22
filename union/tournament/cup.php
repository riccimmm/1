<?php
define('_IN_JOHNCMS', 1);
$headmod = 'tournament';
$rootpath = '../../';

require_once ("../../incfiles/core.php");
$q = @mysql_query("select * from `r_union_cup` where id='" . $id . "' LIMIT 1;");
$cup = @mysql_fetch_array($q);
$union = $cup['id_union'];

$textl = $cup['name'];
require_once ("../../incfiles/head.php");

if (empty($cup[id]))
{
    echo display_error('Кубка не существует');
    require_once ('../../incfiles/end.php');
    exit;
}

$q = mysql_query("select * from `union` where id='" . $union . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../../incfiles/end.php");
exit;
}

$kz = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$zq = @mysql_fetch_array($kz);


$maxus = ($cup['type'] == 1) ? 16 : 8;



echo '<div class="gmenu"><b>'.$cup['name'].'</b> '.date("H:i", $cup['time']).'</div>';
echo '<div class="c"><p align="center"><img src="/union/logo/';

echo (file_exists('../logo/big'.$union.'.jpeg')) ? 'big'.$union.'.jpeg' : 'empty.jpeg';

echo '" alt=""/></p></div>';

$req = mysql_query("SELECT * FROM `r_union_bilet` where id_cup = '".$id."' order by time asc;");
$totalbilet = mysql_num_rows($req);


if ($cup['time'] > $realtime || $totalbilet < $maxus)
{
$dostart = $cup['time'] - $realtime;
$dostartmin = round(($dostart-900)/60);

if ($dostart > 900)
{
echo '<div class="c"><p>До начала приёма заявок осталось: <b>'.$dostartmin.'</b> мин.</p></div>';
}
else
{


echo '<div class="c"><p>';

if($zq['union'] == $union && $zq['union_mod'] == 1){

echo '<a href="/union/tournament/say.php?id='.$cup[id].'">Подать заявку</a><br/><br/>';
}

while ($arr = mysql_fetch_array($req))
{

if ($arr[union_team] != 0)
{
echo '<a href="/union/group.php?id=' . $arr[union_team] . '"><img src="/images/union/' . $arr[union_team] . '.jpg" alt=""/></a> ';
}

echo '<a href="/team/'.$arr[id_team].'">'.$arr['name_team'].'</a> ['.$arr['lvl_team'].'], ';
}

if ($totalbilet > $maxus)
{
echo '<br/><br/>Число заявившихся игроков превысило вместимость турнира, участники будут отобраны случайным образом.';
}

echo '</p></div>
<div class="c"><p>Всего: '.$totalbilet.'</p></div>';

}


require_once ("../../incfiles/end.php");
exit;
}


if($cup['type'] == 1){

// Проверяем 1/8
$g = @mysql_query("select * from `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/8';");
$totalgame = mysql_num_rows($g);




if ($totalgame == 0)
{
$para = 0;

 $i = 0;
$rosp = mysql_query("SELECT * FROM `r_union_bilet` where id_cup = '" . $id . "' ORDER BY RAND() LIMIT 16;");
while ($ros = mysql_fetch_array($rosp))
{


if (is_integer($i / 2))
{


$id_team1 = $ros['id_team'];
$name_team1 = $ros['name_team'];
$lvl_team1 = $ros['lvl_team'];


}

if (!is_integer($i / 2))
{


$id_team2 = $ros['id_team'];
$name_team2 = $ros['name_team'];
$lvl_team2 = $ros['lvl_team'];



$para = $para+1;


mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/8',
`p_chemp`='".$para."',

`time`='".$realtime."',

`id_team1`='".$id_team1."',
`id_team2`='".$id_team2."',
`name_team1`='".$name_team1."',
`name_team2`='".$name_team2."',

`lvl_team1`='".$lvl_team1."',
`lvl_team2`='".$lvl_team2."'

;");

//$lastid = mysql_insert_id();



}



//echo '<div class="c">'.$name_team2.'</div>';

++$i;
}


}

// УДАЛЯЕМ !!!!
if ($totalgame > 8)
{
mysql_query("delete from `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/8';");
}










// Выводим 1/8
$req = mysql_query("SELECT * FROM `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/8' order by time desc LIMIT 8;");
//$total = mysql_num_rows($req);


echo '<div class="c"><p>
<b>1/8 Финала</b><br/>';


while ($arr = mysql_fetch_array($req))
{


echo ''.date("H:i", $arr['time']).' <a href="/team/'.$arr[id_team1].'">'.$arr['name_team1'].'</a> ['.$arr['lvl_team1'].'] - <a href="/team/'.$arr[id_team2].'">'.$arr['name_team2'].'</a> ['.$arr['lvl_team2'].']';


if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
//if (empty($arr[rez1]) && empty($arr[rez2]))
{
echo ' <a href="/report/union/'.$arr[id_report].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b>';
if ($arr[rez1] == $arr[rez2])
{echo ' (п. '.$arr[pen1].':'.$arr[pen2].')';}
echo '</font></a>';



// К то победил?
if ($arr[rez1] > $arr[rez2] || $arr[pen1] > $arr[pen2])
{

if ($arr[p_chemp] == 1)
{
$id_14_1 = $arr['id_team1'];
$name_14_1 = $arr['name_team1'];
$lvl_14_1 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 2)
{
$id_14_2 = $arr['id_team1'];
$name_14_2 = $arr['name_team1'];
$lvl_14_2 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 3)
{
$id_14_3 = $arr['id_team1'];
$name_14_3 = $arr['name_team1'];
$lvl_14_3 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 4)
{
$id_14_4 = $arr['id_team1'];
$name_14_4 = $arr['name_team1'];
$lvl_14_4 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 5)
{
$id_14_5 = $arr['id_team1'];
$name_14_5 = $arr['name_team1'];
$lvl_14_5 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 6)
{
$id_14_6 = $arr['id_team1'];
$name_14_6 = $arr['name_team1'];
$lvl_14_6 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 7)
{
$id_14_7 = $arr['id_team1'];
$name_14_7 = $arr['name_team1'];
$lvl_14_7 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 8)
{
$id_14_8 = $arr['id_team1'];
$name_14_8 = $arr['name_team1'];
$lvl_14_8 = $arr['lvl_team1'];
}








}
else
{

if ($arr[p_chemp] == 1)
{
$id_14_1 = $arr['id_team2'];
$name_14_1 = $arr['name_team2'];
$lvl_14_1 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 2)
{
$id_14_2 = $arr['id_team2'];
$name_14_2 = $arr['name_team2'];
$lvl_14_2 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 3)
{
$id_14_3 = $arr['id_team2'];
$name_14_3 = $arr['name_team2'];
$lvl_14_3 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 4)
{
$id_14_4 = $arr['id_team2'];
$name_14_4 = $arr['name_team2'];
$lvl_14_4 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 5)
{
$id_14_5 = $arr['id_team2'];
$name_14_5 = $arr['name_team2'];
$lvl_14_5 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 6)
{
$id_14_6 = $arr['id_team2'];
$name_14_6 = $arr['name_team2'];
$lvl_14_6 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 7)
{
$id_14_7 = $arr['id_team2'];
$name_14_7 = $arr['name_team2'];
$lvl_14_7 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 8)
{
$id_14_8 = $arr['id_team2'];
$name_14_8 = $arr['name_team2'];
$lvl_14_8 = $arr['lvl_team2'];
}


}









}
else
{
echo ' <a href="/union/tournament/play.php?id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}



echo '<br/>';
}

echo '</p></div>';
} else { $id_14_1 = $id_14_2 = $id_14_3 = $id_14_4 = $id_14_5 = $id_14_6 = $id_14_7 = $id_14_8 = 'Okay'; }































// Проверяем 1/4
if (!empty($id_14_1) && !empty($id_14_2) && !empty($id_14_3) && !empty($id_14_4) && !empty($id_14_5) && !empty($id_14_6) && !empty($id_14_7) && !empty($id_14_8))
{
//echo '1/8 ВСЕ ЕСТЬ!!!!!!!<br/>';

$g = @mysql_query("select * from `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/4';");
$totalgame = mysql_num_rows($g);


if ($totalgame == 0)
{
if($cup['type'] == 2){ $para = 0; $i = 0;
$rosp = mysql_query("SELECT * FROM `r_union_bilet` where id_cup = '" . $id . "' ORDER BY RAND() LIMIT 8;");

while ($ros = mysql_fetch_assoc($rosp))
{
#
if (is_integer($i / 2)){
$id_team1 = $ros['id_team'];
$name_team1 = $ros['name_team'];
$lvl_team1 = $ros['lvl_team'];
}
#

#
if (!is_integer($i / 2))
{
$id_team2 = $ros['id_team'];
$name_team2 = $ros['name_team'];
$lvl_team2 = $ros['lvl_team'];
$para = $para+1;

mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/4',
`p_chemp`='".$para."',
`time`='".$realtime."',
`id_team1`='".$id_team1."',
`id_team2`='".$id_team2."',
`name_team1`='".$name_team1."',
`name_team2`='".$name_team2."',
`lvl_team1`='".$lvl_team1."',
`lvl_team2`='".$lvl_team2."'
;");
} ++$i; }


} else {

mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/4',
`p_chemp`='4',
`time`='".$realtime."',
`id_team1`='".$id_14_1."',
`id_team2`='".$id_14_2."',
`name_team1`='".$name_14_1."',
`name_team2`='".$name_14_2."',
`lvl_team1`='".$lvl_14_1."',
`lvl_team2`='".$lvl_14_2."'

;");

mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/4',
`p_chemp`='3',
`time`='".$realtime."',
`id_team1`='".$id_14_3."',
`id_team2`='".$id_14_4."',
`name_team1`='".$name_14_3."',
`name_team2`='".$name_14_4."',
`lvl_team1`='".$lvl_14_3."',
`lvl_team2`='".$lvl_14_4."';");

mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/4',
`p_chemp`='2',
`time`='".$realtime."',
`id_team1`='".$id_14_5."',
`id_team2`='".$id_14_6."',
`name_team1`='".$name_14_5."',
`name_team2`='".$name_14_6."',
`lvl_team1`='".$lvl_14_5."',
`lvl_team2`='".$lvl_14_6."';");

mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/4',
`p_chemp`='1',
`time`='".$realtime."',
`id_team1`='".$id_14_7."',
`id_team2`='".$id_14_8."',
`name_team1`='".$name_14_7."',
`name_team2`='".$name_14_8."',
`lvl_team1`='".$lvl_14_7."',
`lvl_team2`='".$lvl_14_8."';");

}

}


}
else
{
echo '<div class="c">1/8 не сыграна</div>';
require_once ("../../incfiles/end.php");
exit;
}



// УДАЛЯЕМ !!!!
if ($totalgame > 4)
{
mysql_query("delete from `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/4';");
}





// Выводим 1/4
$req = mysql_query("SELECT * FROM `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/4' order by time desc;");
//$total = mysql_num_rows($req);



echo '<div class="c"><p>
<b>1/4 Финала</b><br/>';

while ($arr = mysql_fetch_array($req))
{
echo ''.date("H:i", $arr['time']).' <a href="/team/'.$arr[id_team1].'">'.$arr['name_team1'].'</a> ['.$arr['lvl_team1'].'] - <a href="/team/'.$arr[id_team2].'">'.$arr['name_team2'].'</a> ['.$arr['lvl_team2'].']';


if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
//if (empty($arr[rez1]) && empty($arr[rez2]))
{
echo ' <a href="/report/union/'.$arr[id_report].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b>';
if ($arr[rez1] == $arr[rez2])
{echo ' (п. '.$arr[pen1].':'.$arr[pen2].')';}
echo '</font></a>';





// К то победил?
if ($arr[rez1] > $arr[rez2] || $arr[pen1] > $arr[pen2])
{



if ($arr[p_chemp] == 1)
{
$id_12_1 = $arr['id_team1'];
$name_12_1 = $arr['name_team1'];
$lvl_12_1 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 2)
{
$id_12_2 = $arr['id_team1'];
$name_12_2 = $arr['name_team1'];
$lvl_12_2 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 3)
{
$id_12_3 = $arr['id_team1'];
$name_12_3 = $arr['name_team1'];
$lvl_12_3 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 4)
{
$id_12_4 = $arr['id_team1'];
$name_12_4 = $arr['name_team1'];
$lvl_12_4 = $arr['lvl_team1'];
}









}
else
{


if ($arr[p_chemp] == 1)
{
$id_12_1 = $arr['id_team2'];
$name_12_1 = $arr['name_team2'];
$lvl_12_1 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 2)
{
$id_12_2 = $arr['id_team2'];
$name_12_2 = $arr['name_team2'];
$lvl_12_2 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 3)
{
$id_12_3 = $arr['id_team2'];
$name_12_3 = $arr['name_team2'];
$lvl_12_3 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 4)
{
$id_12_4 = $arr['id_team2'];
$name_12_4 = $arr['name_team2'];
$lvl_12_4 = $arr['lvl_team2'];
}




}






}
else
{
echo ' <a href="/union/tournament/play.php?id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}






echo '<br/>';
}

echo '</p></div>';













// Проверяем 1/2
if (!empty($id_12_1) && !empty($id_12_2) && !empty($id_12_3) && !empty($id_12_4))
{
//echo '1/4 ВСЕ ЕСТЬ!!!!!!!<br/>';

$g = @mysql_query("select * from `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/2';");
$totalgame = mysql_num_rows($g);


if ($totalgame == 0)
{


mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/2',
`p_chemp`='2',

`time`='".$realtime."',

`id_team1`='".$id_12_1."',
`id_team2`='".$id_12_2."',
`name_team1`='".$name_12_1."',
`name_team2`='".$name_12_2."',
`lvl_team1`='".$lvl_12_1."',
`lvl_team2`='".$lvl_12_2."'

;");

mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/2',
`p_chemp`='1',

`time`='".$realtime."',

`id_team1`='".$id_12_3."',
`id_team2`='".$id_12_4."',
`name_team1`='".$name_12_3."',
`name_team2`='".$name_12_4."',
`lvl_team1`='".$lvl_12_3."',
`lvl_team2`='".$lvl_12_4."'

;");




}



}
else
{
echo '<div class="c">1/4 не сыграна</div>';
require_once ("../../incfiles/end.php");
exit;
}

// УДАЛЯЕМ !!!!
if ($totalgame > 2)
{
mysql_query("delete from `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/2';");
}

















// Выводим 1/2
$req = mysql_query("SELECT * FROM `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/2' order by time desc;");
//$total = mysql_num_rows($req);


echo '<div class="c"><p>
<b>1/2 Финала</b><br/>';

while ($arr = mysql_fetch_array($req))
{
echo ''.date("H:i", $arr['time']).' <a href="/team/'.$arr[id_team1].'">'.$arr['name_team1'].'</a> ['.$arr['lvl_team1'].'] - <a href="/team/'.$arr[id_team2].'">'.$arr['name_team2'].'</a> ['.$arr['lvl_team2'].']';


if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
//if (empty($arr[rez1]) && empty($arr[rez2]))
{
echo ' <a href="/report/union/'.$arr[id_report].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b>';
if ($arr[rez1] == $arr[rez2])
{echo ' (п. '.$arr[pen1].':'.$arr[pen2].')';}
echo '</font></a>';



// К то победил?
if ($arr[rez1] > $arr[rez2] || $arr[pen1] > $arr[pen2])
{



if ($arr[p_chemp] == 1)
{
$id_11_1 = $arr['id_team1'];
$name_11_1 = $arr['name_team1'];
$lvl_11_1 = $arr['lvl_team1'];
}
elseif ($arr[p_chemp] == 2)
{
$id_11_2 = $arr['id_team1'];
$name_11_2 = $arr['name_team1'];
$lvl_11_2 = $arr['lvl_team1'];
}


}
else
{


if ($arr[p_chemp] == 1)
{
$id_11_1 = $arr['id_team2'];
$name_11_1 = $arr['name_team2'];
$lvl_11_1 = $arr['lvl_team2'];
}
elseif ($arr[p_chemp] == 2)
{
$id_11_2 = $arr['id_team2'];
$name_11_2 = $arr['name_team2'];
$lvl_11_2 = $arr['lvl_team2'];
}




}



}
else
{
echo ' <a href="/union/tournament/play.php?id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}






echo '<br/>';
}


echo '</p></div>';





// Проверяем 1/1
if (!empty($id_11_1) && !empty($id_11_2))
{
//echo '1/2 ВСЕ ЕСТЬ!!!!!!!<br/>';

$g = @mysql_query("select * from `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/1';");
$totalgame = mysql_num_rows($g);


if ($totalgame == 0)
{


mysql_query("insert into `r_union_cupgame` set
`id_chemp`='".$id."',
`s_chemp`='1/1',
`p_chemp`='1',

`time`='".$realtime."',

`id_team1`='".$id_11_1."',
`id_team2`='".$id_11_2."',
`name_team1`='".$name_11_1."',
`name_team2`='".$name_11_2."',
`lvl_team1`='".$lvl_11_1."',
`lvl_team2`='".$lvl_11_2."'

;");



}



}
else
{
echo '<div class="c">1/2 не сыграна</div>';
require_once ("../../incfiles/end.php");
exit;
}

// УДАЛЯЕМ !!!!
if ($totalgame > 1)
{
mysql_query("delete from `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/1';");
}



// Выводим ФИНАЛ
$req = mysql_query("SELECT * FROM `r_union_cupgame` where id_chemp = '" . $id . "' and s_chemp = '1/1' LIMIT 1;");
//$total = mysql_num_rows($req);
$arr = mysql_fetch_array($req);



echo '<div class="c"><p>
<b>Финал</b><br/>';

if ($totalgame == 1)
{

echo ''.date("H:i", $arr['time']).' <a href="/team/'.$arr[id_team1].'">'.$arr['name_team1'].'</a> ['.$arr['lvl_team1'].'] - <a href="/team/'.$arr[id_team2].'">'.$arr['name_team2'].'</a> ['.$arr['lvl_team2'].']';


if (!empty($arr[rez1]) || !empty($arr[rez2]) || $arr[rez1] == '0' || $arr[rez2] == '0')
//if (empty($arr[rez1]) && empty($arr[rez2]))
{
echo ' <a href="/report/union/'.$arr[id_report].'"><font color="green"><b>'.$arr[rez1].':'.$arr[rez2].'</b>';
if ($arr[rez1] == $arr[rez2])
{echo ' (п. '.$arr[pen1].':'.$arr[pen2].')';}
echo '</font></a>';


// К то победил?
if ($arr[rez1] > $arr[rez2] || $arr[pen1] > $arr[pen2])
{
$id_win_1 = $arr['id_team1'];
$name_win_1 = $arr['name_team1'];
}
else
{
$id_win_1 = $arr['id_team2'];
$name_win_1 = $arr['name_team2'];
}


echo '<br/>Победитель: '.$name_win_1.'<br/>';
if ($cup[status] != 'yes')
{
mysql_query("update `r_union_cup` set `win`='" . $id_win_1 . "', `status`='yes' where id='" . $id . "' LIMIT 1;");
$moneys = ($cup['type'] == 1) ? 800 : 1500;

mysql_query("UPDATE `union` SET  `money` = money+".$moneys." WHERE `id` ='".$cup['id_union']."' LIMIT 1;");

mysql_query("insert into `priz_2` set
`id_cup`='".$cup[id_cup]."',
`time`='".$cup[time]."',
`name`='".$cup[name]."',
`priz`='".$moneys."',
`win`='".$id_win_1."',
`id_union`='".$cup['id_union']."',
`url`='/union/tournament/cup/".$id."'
;");

$q1 = @mysql_query("select * from `team_2` where id='" . $id_win_1 . "' LIMIT 1;");
$winkom = @mysql_fetch_array($q1);

$money = $winkom[money]+$moneys;
$kfcup = round($cup[priz]/100);
mysql_query("update `team_2` set `rate`=rate+5, `money`='" . $money . "', `fans`=fans+5 where id='" . $winkom[id] . "' LIMIT 1;");
}

} else {
echo ' <a href="/union/tournament/play.php?id='.$arr[id].'"><font color="green"><b>?:?</b></font></a>';
}




}


echo '</p></div>';

require_once ("../../incfiles/end.php");
?>
