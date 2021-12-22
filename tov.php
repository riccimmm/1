<?php


$pro = mysql_query("SELECT COUNT(*) FROM `game_2` WHERE `timeend`<'".$realtime."';");
if( mysql_result($pro, 0)>0)
{include ("tovend.php");}

$matile = mysql_query("SELECT * FROM `tur` WHERE `time`<'".($realtime-1000)."' AND `shema1`='' AND `id`='".$id."';");
if(mysql_num_rows($matile)>0)
{
while($art=mysql_fetch_array($matile))

{
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////                               Расчёт                                //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

$k1 = mysql_query("select * from `team_2` where id='" . $art['id_team1'] . "';");
$krr1 = mysql_fetch_array($k1);


$k2 = mysql_query("select * from `team_2` where id='" . $art['id_team2'] . "';");
$krr2 = mysql_fetch_array($k2);

if ($realtime >= ($arr1['time']+950)) 
{


$req1 = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr1['id']."' AND `sostav`='1'  LIMIT 11;");
$total1 = mysql_num_rows($req1);
while ($arr1 = mysql_fetch_assoc($req1))
{
/* Опит */
$r=rand(1,25);
if($krr1['trener'] != 0){
$r=round($r*$krr1['trener']);
}
$id1[]=$arr1['id'];
$sila1 = $sila1 + $arr1['rm'];
$fiza1 = $arr1['fiz'] - $arr1['voz'];

$rmm1=round($arr1['mas']/100*$fiza1);
$rand=rand(1,100);

######################
## Красная карточка ##
######################
/*
if($rand==50 && $krr1['id_admin']!=0)
{
$news='Игрок '.$arr1['name'].' из команды '.$art['name_team1'].' получает красную карточку и дисквалифицируется на 2 следующих игры.';
mysql_query("update `player_2` set `sostav`='4', `utime`='" . ($realtime+174000) . "' where id='" . $arr1['id'] . "';");
mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] . "' , `news`='" . $news . "' ;");}	
*/
#####################
## Желтые карточки ##
#####################

/*if($rand==25 && $krr1['id_admin']!=0)
{
$news='Игрок '.$arr1['name'].' из команды '.$art['name_team1'].' получает желтую карточку. ';
$arr1['yellow']++;
if($arr1['yellow']==3)
{$arr1['yellow']=0;
 $news=$news.'Это третья карточка. игрок дисквалифицируется на 3 следующих игры';
 mysql_query("update `player_2` set `sostav`='4', `utime`='" . ($realtime+260000) . "',`yellow`='" . $arr1['yellow'] . "' where id='" . $arr1['id'] . "';");
}else
{mysql_query("update `player_2` set  `yellow`='" . $arr1['yellow'] . "' where id='" . $arr1['id'] . "';");}

mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] . "' , `news`='" . $news . "' ;");
}*//*
if($rand==75 && $krr1['id_admin']!=0)
{
$news='Игрок '.$arr1['name'].' из команды '.$art['name_team1'].' очень сильно травмировался и будет находиться на лечении 2 следующих игры.';
mysql_query("update `player_2` set `sostav`='3', `btime`='" . ($realtime+174000) . "' where id='" . $arr1['id'] . "';");
mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] . "' , `news`='" . $news . "' ;");}	
*/
if($krr1['id_admin']!=0)
mysql_query("update `player_2` set `fiz`='" . $fiza1 . "', `rm`='" . $rmm1 . "', `opit`=`opit`+$r where id='" . $arr1['id'] . "';");
}
$silak1 = round($sila1);



$req2 = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr2['id']."' AND `sostav`='1' LIMIT 11;");
$total2 = mysql_num_rows($req2);
while ($arr2 = mysql_fetch_assoc($req2))
{
/* Опит */
$r=rand(1,25);
if($krr2['trener'] != 0){
$r=round($r*$krr2['trener']);
}
	$id2[]=$arr2['id'];
$sila2 = $sila2 + $arr2['rm'];
$fiza2 = $arr2['fiz'] - $arr2['voz'];
$mast = $arr2['otbor'] + $arr2['opeka'] + $arr2['drib'] + $arr2['priem'] + $arr2['vonos'] + $arr2['pas'] + $arr2['sila'] + $arr2['tocnost'];
$rmm2=round($arr1['mas']/100*$fiza2);
$rand=rand(1,100);

######################
## Красная карточка ##
######################

/*
if($rand==50 && $krr2['id_admin']!=0)
{
$news='Игрок '.$arr2['name'].' из команды '.$art['name_team2'].' получает красную карточку и дисквалифицируется на 2 следующих игры.';
mysql_query("update `player_2` set `sostav`='4', `utime`='" . ($realtime+174000) . "' where id='" . $arr2['id'] . "';");
mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] . "' , `news`='" . $news . "' ;");}	
*/

#####################
## Желтые карточки ##
#####################
/*
if($rand==25 && $krr2['id_admin']!=0)
{
$news='Игрок '.$arr2['name'].' из команды '.$art['name_team2'].' получает желтую карточку. ';
$arr2['yellow']++;
if($arr2['yellow']==3)
{$arr2['yellow']=0;
 $news=$news.'Это третья карточка. игрок дисквалифицируется на 3 игровых дня';
 mysql_query("update `player_2` set `sostav`='4', `utime`='" . ($realtime+260000) . "',`yellow`='" . $arr2['yellow'] . "' where id='" . $arr2['id'] . "';");
}else
{mysql_query("update `player_2` set  `yellow`='" . $arr2['yellow'] . "' where id='" . $arr2['id'] . "';");}

mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] . "' , `news`='" . $news . "' ;");
}
*/

/*
if($rand==75 && $krr2['id_admin']!=0)
{
$news='Игрок '.$arr2['name'].' из команды '.$art['name_team2'].' очень сильно травмировался и будет находиться на лечении в течение двух дней.';
mysql_query("update `player_2` set `sostav`='3', `btime`='" . ($realtime+174000) . "' where id='" . $arr2['id'] . "';");
mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] . "' , `news`='" . $news . "' ;");}
*/

if($krr2['id_admin']!=0)
mysql_query("update `player_2` set `fiz`='" . $fiza2 . "', `rm`='" . $rmm2 . "', `opit`=`opit`+$r where id='" . $arr2['id'] . "';");
}


$silak2 = round($sila2);

$razn = abs($sila1 - $sila2);

$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr1['id']."' AND `line`='1' AND `sostav`='1' order by poz asc;");
$totalk10 = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{
$sostav1 = '<b>'.$arr['nomer'].'</b> <a href="player.php?id='.$arr['id'].'">'.$arr['name'].'</a><br/>';	
}
//////////////////////////////////
$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr1['id']."' AND `line`='2' AND `sostav`='1' order by poz asc;");
$totalk11 = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{
$sostav1 = $sostav1.'<b>'.$arr['nomer'].'</b> <a href="player.php?id='.$arr['id'].'">'.$arr['name'].'</a><br/>';	
}
////////////////////////////////////
$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr1['id']."' AND `line`='3' AND `sostav`='1' order by poz asc;");
$totalk12 = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{
$sostav1 = $sostav1.'<b>'.$arr['nomer'].'</b> <a href="player.php?id='.$arr['id'].'">'.$arr['name'].'</a><br/>';	
}
///////////////////////////////////////
$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr1['id']."' AND `line`='4' AND `sostav`='1' order by poz asc;");
$totalk13 = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{
$sostav1 = $sostav1.'<b>'.$arr['nomer'].'</b> <a href="player.php?id='.$arr['id'].'">'.$arr['name'].'</a><br/>';
}

$shema1 = ''.$totalk11.'-'.$totalk12.'-'.$totalk13.'';






//////////////////////////////////

$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr2['id']."' AND `line`='1' AND `sostav`='1' order by poz asc;");
$totalk20 = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{
$sostav2 = '<b>'.$arr[nomer].'</b> <a href="player.php?id='.$arr['id'].'">'.$arr['name'].'</a><br/>';	
}
//////////////////////////////////

$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr2['id']."' AND `line`='2' AND `sostav`='1' order by poz asc;");
$totalk21 = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{
$sostav2 = $sostav2.'<b>'.$arr['nomer'].'</b> <a href="player.php?id='.$arr['id'].'">'.$arr['name'].'</a><br/>';	
}
////////////////////////////////////

$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr2['id']."' AND `line`='3' AND `sostav`='1' order by poz asc;");
$totalk22 = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{
$sostav2 = $sostav2.'<b>'.$arr['nomer'].'</b> <a href="player.php?id='.$arr['id'].'">'.$arr['name'].'</a><br/>';	
}
///////////////////////////////////////

$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr2['id']."' AND `line`='4' AND `sostav`='1' order by poz asc;");
$totalk23 = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{
$sostav2 = $sostav2.'<b>'.$arr['nomer'].'</b> <a href="player.php?id='.$arr['id'].'">'.$arr['name'].'</a><br/>';
}

$shema2 =  ''.$totalk21.'-'.$totalk22.'-'.$totalk23.'';

if ($sila1 >= $sila2) 
{

if ($razn >= 100 && $krr1['tactics'] >= 90) 
{
//echo 'Первая +10%<br/>';
$sila1 = $sila1/100*10 + $sila1;
}

if ($razn >= 100 && $krr1['tactics'] <= 20) 
{
//echo 'Первая -10%<br/>';
$sila1 = $sila1 - ($sila1/100*10);
}

}


if ($sila2 <= $sila1) 
{
if ($razn >= 100 && $krr2['tactics'] <= 20) 
{
//echo 'Вторая +10%<br/>';
$sila2 = $sila2/100*10 + $sila2;
}

if ($razn >= 100 && $krr2['tactics'] >= 90) 
{
//echo 'Вторая -10%<br/>';
$sila2 = $sila2 - ($sila2/100*10);
}

}

$razn = abs($sila1 - $sila2);
//echo 'Разница '.$razn.'<br/>';


//////////////////////////////////////////////////////////////////////////////////////
//echo '.........................................<br/>';

//echo 'пас1 '.$krr1[pass].'<br/>';
//echo 'пас2 '.$krr2[pass].'<br/>';

switch ($krr1['pass'])
{
case "0":
if ($krr2['pass'] == 2)
{
//echo 'Вторая +10%<br/>';
$sila2 = $sila2/100*10 + $sila2;
}
break;
case "1":
if ($krr2['pass'] == 0)
{
//echo 'Вторая +10%<br/>';
$sila2 = $sila2/100*10 + $sila2;
}
break;
case "2":
if ($krr2['pass'] == 1)
{
//echo 'Вторая +10%<br/>';
$sila2 = $sila2/100*10 + $sila2;
}
break;
}

switch ($krr2['pass'])
{
case "0":
if ($krr1['pass'] == 2)
{
//echo 'Первая +10%<br/>';
$sila1 = $sila1/100*10 + $sila1;
}
break;
case "1":
if ($krr1['pass'] == 0)
{
//echo 'Первая +10%<br/>';
$sila1 = $sila1/100*10 + $sila1;
}
break;
case "2":
if ($krr1['pass'] == 1)
{
//echo 'Первая +10%<br/>';
$sila1 = $sila1/100*10 + $sila1;
}
break;
}

$razn = abs($sila1 - $sila2);
//echo 'Разница '.$razn.'<br/>';

//////////////////////////////////////////////////////////////////////////////////////
//echo '.........................................<br/>';

//echo 'strat1 '.$krr1[strat].'<br/>';
//echo 'strat2 '.$krr2[strat].'<br/>';

switch ($krr1['strat'])
{
case "0":
if ($krr2['strat'] == 3 || $krr2['strat'] == 2)
{
//echo 'Вторая +10%<br/>';
$sila2 = $sila2/100*10 + $sila2;
}
break;
case "1":
if ($krr2['strat'] == 2 || $krr2['strat'] == 0)
{
//echo 'Вторая +10%<br/>';
$sila2 = $sila2/100*10 + $sila2;
}
break;
case "2":
if ($krr2['strat'] == 3 || $krr2['strat'] == 1)
{
//echo 'Вторая +10%<br/>';
$sila2 = $sila2/100*10 + $sila2;
}
break;
case "3":
if ($krr2['strat'] == 1 || $krr2['strat'] == 0)
{
//echo 'Вторая +10%<br/>';
$sila2 = $sila2/100*10 + $sila2;
}
break;
}



switch ($krr2['strat'])
{
case "0":
if ($krr1['strat'] == 3 || $krr1['strat'] == 2)
{
//echo 'Первая +10%<br/>';
$sila1 = $sila1/100*10 + $sila1;
}
break;
case "1":
if ($krr1['strat'] == 2 || $krr1['strat'] == 0)
{
//echo 'Первая +10%<br/>';
$sila1 = $sila1/100*10 + $sila1;
}
break;
case "2":
if ($krr1['strat'] == 3 || $krr1['strat'] == 1)
{
//echo 'Первая +10%<br/>';
$sila1 = $sila1/100*10 + $sila1;
}
break;
case "3":
if ($krr1['strat'] == 1 || $krr1['strat'] == 0)
{
//echo 'Первая +10%<br/>';
$sila1 = $sila1/100*10 + $sila1;
}
break;
}



$razn = abs($sila1 - $sila2);
//echo 'Разница '.$razn.'<br/>';




$razn = abs($sila1 - $sila2);
//echo 'Разница '.$razn.'<br/>';

if ($razn >= 50) 
{

if ($sila1 >= $sila2)
{
//echo 'Победа 1<br/>';

if ($razn < 350 && $razn >= 50)
{
$input = array ("1:0", "1:0", "2:1", "2:1", "3:2", "4:3");
$rand_keys = array_rand ($input);
//echo $input[$rand_keys];
//echo '1:0<br/>';
}
if ($razn < 500 && $razn >= 350)
{
$input = array ("2:0", "2:0", "3:1", "3:1", "4:2", "5:3");
$rand_keys = array_rand ($input);
//echo $input[$rand_keys];
//echo '2:0<br/>';
}
if ($razn < 800 && $razn >= 500)
{
$input = array ("3:0", "3:0", "4:1", "5:2");
$rand_keys = array_rand ($input);
//echo $input[$rand_keys];
//echo '3:0<br/>';
}
if ($razn >= 800)
{
$input = array ("4:0", "5:1");
$rand_keys = array_rand ($input);
//echo $input[$rand_keys];
//echo '4:0<br/>';
}
$rezult = explode(":",trim($input[$rand_keys]));
//Команда 1
/* Спонсор */
if($krr1['sponsor'] != 0){
$x22=mysql_query("SELECT `money` FROM `sponsor_2` where id='".$krr1['sponsor']."'");
$ns = mysql_fetch_array($x22);
$spmoney = $ns['money'];
}else{$spmoney = 0;}
/*  */
$moneyp = $krr1['money'] + 5000 +  $krr1['prib_stadium'] + $spmoney;
$fan = $krr1['fan'] + 100; 
mysql_query("update `team_2` set `fan`='" . $fan . "', `money`='" . $moneyp . "', `rate` = `rate`+1 where id='" . $krr1['id'] . "';");

//Команда 2
/* Спонсор */
if($krr2['sponsor'] != 0){
$x22=mysql_query("SELECT `money` FROM `sponsor_2` where id='".$krr2['sponsor']."'");
$ns2 = mysql_fetch_array($x22);
$spmoney2 = $ns2['money'];
}else{$spmoney2 = 0;}
/*  */

$moneyn2 = $krr2['money'] + $spmoney2;
if($krr2['fan'] > 100){
$fan2 = $krr2['fan'] - 100; }
$losts = $krr2['lost'] + 1;

mysql_query("update `team_2` set `fan`='" . $fan2 . "', `money`='" . $moneyn2 . "', `lost`='".$losts."' where id='" . $krr2['id'] . "';");


}
else
{
//echo 'Победа 2<br/>';

if ($razn < 350 && $razn >= 50)
{
$input = array ("0:1", "0:1", "1:2", "1:2", "2:3", "3:4");
$rand_keys = array_rand ($input);
//echo $input[$rand_keys];
//echo '0:1<br/>';
}
if ($razn < 500 && $razn >= 350)
{
$input = array ("0:2", "0:2", "1:3", "1:3", "2:4", "3:5");
$rand_keys = array_rand ($input);
//echo $input[$rand_keys];
////echo '0:2<br/>';
}
if ($razn < 800 && $razn >= 500)
{
$input = array ("0:3", "0:3", "1:4", "2:5");
$rand_keys = array_rand ($input);
//echo $input[$rand_keys];
//echo '0:3<br/>';
}
if ($razn >= 800)
{
$input = array ("0:4", "1:5");
$rand_keys = array_rand ($input);

//echo $input[$rand_keys];
////echo '0:4<br/>';
}


$rezult = explode(":",trim($input[$rand_keys]));
//Команда 1

/* Спонсор */
if($krr1['sponsor'] != 0){
$x22=mysql_query("SELECT `money` FROM `sponsor_2` where id='".$krr1['sponsor']."'");
$ns = mysql_fetch_array($x22);
$spmoney = $ns['money'];
}else{$spmoney = 0;}
/*  */

$moneyp =  $krr1['prib_stadium'] + $spmoney;
if($krr1['fan'] > 100){
$fan1 = $krr1['fan'] - 100; }
$losts = $krr1['lost'] + 1;
mysql_query("update `team_2` set `fan`='" . $fan1 . "', `money`=`money`+$moneyp, `lost`='".$losts."' where id='" . $krr1['id'] . "';");

//Команда 2
/* Спонсор */
if($krr2['sponsor'] != 0){
$x22=mysql_query("SELECT `money` FROM `sponsor_2` where id='".$krr2['sponsor']."'");
$ns2 = mysql_fetch_array($x22);
$spmoney2 = $ns2['money'];
}else{$spmoney2 = 0;}
/*  */

$moneyp2 = 3000 + $spmoney2;
$fan2 = $krr2['fan'] + 100; 
mysql_query("update `team_2` set `fan`='" . $fan2 . "', `money`=`money`+$moneyp2, `rate` = `rate`+1 where id='" . $krr2['id'] . "';");

}

}
else
{
//echo 'Ничья<br/>';
$input = array ("0:0", "0:0", "1:1", "1:1", "2:2", "2:2", "3:3");
$rand_keys = array_rand ($input);
$rezult = explode(":",trim($input[$rand_keys]));
//echo $input[$rand_keys];


//Команда 1

/* Спонсор */
if($krr1['sponsor'] != 0){
$x22=mysql_query("SELECT `money` FROM `sponsor_2` where id='".$krr1['sponsor']."'");
$ns = mysql_fetch_array($x22);
$spmoney = $ns['money'];
}else{$spmoney = 0;}
/*  */

$moneyp = 5000 +  $krr1['prib_stadium'] + $spmoney;
$fan1 = $krr1['fan'] + 100; 
mysql_query("update `team_2` set `fan`='" . $fan1 . "', `money`=`money`+$moneyp where id='" . $krr1['id'] . "';");

//Команда 2
/* Спонсор */
if($krr2['sponsor'] != 0){
$x22=mysql_query("SELECT `money` FROM `sponsor_2` where id='".$krr2['sponsor']."'");
$ns2 = mysql_fetch_array($x22);
$spmoney2 = $ns2['money'];
}else{$spmoney2 = 0;}
/*  */

$moneyp2 = 3000 + $spmoney2;
$fan2 = $krr2['fan'] + 100; 
mysql_query("update `team_2` set `fan`='" . $fan2 . "', `money`=`money`+$moneyp2 where id='" . $krr2['id'] . "';");

}



for ($i=1;$i<=$rezult[0];$i++)
{
$r_k = array_rand ($id1);
$gt=rand(1,90);
mysql_query("INSERT INTO `goal_2` set `time`='" . $gt . "', `tid`='" . $art['id'] . "' , `idgoal`='" . $id1[$r_k] . "' , `idteam`='" . $art['id_team1'] . "';");	
mysql_query("update `player_2` set  `goal`=`goal`+1 where   `id`='".$id1[$r_k]."'  ;"); 
}
for ($i=1;$i<=$rezult[1];$i++)
{$gt=rand(1,90);
$r_k = array_rand ($id2);
mysql_query("INSERT INTO `goal_2` set `time`='" . $gt . "', `tid`='" . $art['id'] . "' , `idgoal`='" . $id2[$r_k] . "' ,`idteam`='" . $art['id_team2'] . "';");	
mysql_query("update `player_2` set  `goal`=`goal`+1 where   `id`='".$id2[$r_k]."'  ;"); 
}
mysql_query("update `m2_tur` set 
`sostav1`='" . $sostav1 . "', `shema1`='" . $shema1 . "', `pass1`='" . $krr1['pass'] . "', `strat1`='" . $krr1['strat'] . "', `press1`='" . $krr1['press'] . "', `tactics1`='" . $krr1['tactics'] . "', `sila1`='" . $silak1 . "',
`sostav2`='" . $sostav2 . "', `shema2`='" . $shema2 . "', `pass2`='" . $krr2['pass'] . "', `strat2`='" . $krr2['strat'] . "', `press2`='" . $krr2['press'] . "', `tactics2`='" . $krr2['tactics'] . "', `sila2`='" . $silak2 . "',
`rez1`='" . $rezult[0] . "', `rez2`='" . $rezult[1] . "', `match` = '1' where id='" . $art['id'] . "';");

}
}
}

?>