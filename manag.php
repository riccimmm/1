<?php

defined('_IN_JOHNCMS') or die('Error:restricted access');

$manag = $datauser['manager2'];
$manager = mysql_query("SELECT * FROM `m2_team` WHERE `id`='".$manag."' LIMIT 1;");

 if (mysql_num_rows($manager) != 0)
    {
     $datamanag = mysql_fetch_array($manager);
	 // Получение параметров пользователя
	 $fid  = $datamanag['id'];
	 $times = $datamanag['time'];
	 $names = $datamanag['name'];
	 $strana = $datamanag['strana'];
	 $logos = $datamanag['logo'];
	 $rates = $datamanag['rate'];
	 $id_admin = $datamanag['id_admin'];
	 $name_admin = $datamanag['name_admin'];
	 $shema = $datamanag['shema'];
     $pass = $datamanag['pass'];
	 $strat = $datamanag['strat'];
	 $press = $datamanag['press'];
	 $tactics = $datamanag['tactics'];
	 $trener = $datamanag['trener'];
	 $fan = $datamanag['fan'];
	 $money = $datamanag['money'];
	 $timeres = $datamanag['timeres'];
	 $bilet = $datamanag['bilet'];
	 $tmatch = $datamanag['tmatch'];
     $med = $datamanag['med'];
     $sponsor = $datamanag['sponsor'];
     $lvl = $datamanag['lvl'];
	 $name_stad = $datamanag['name_stadium'];
	 $mest = $datamanag['mest'];
	 $forma = $datamanag['forma'];
	 $butcer = $datamanag['butcer'];
	 }
	 
	
	$vrp2 = $timeres + $sdvig * 3600;
    $vr2 = date("d.m.y", $vrp2);
    $vrp3 = $realtime + $sdvig * 3600;
    $vr3 = date("d.m.y", $vrp3);
/* Вычисляем текущую дату и дату последнего пополнения */
if ($vr2 !== $vr3){ 
/* Деньги за постройки */	
$x=@mysql_query("SELECT `name` FROM `invent_2` WHERE  `uid`='".$fid."'");
if (@mysql_num_rows($x) != 0)
{
while($ros=mysql_fetch_assoc($x))
{
$xx=mysql_query("SELECT `price` FROM `dom_2`  where `name` = '".$ros['name']."' ;");	
while($row=mysql_fetch_assoc($xx))
{
$postrouka = $postrouka + $row['price'];
}
}
}	
mysql_query("update `team_2` set `money` = `money` + '".$postrouka."', `timeres` = '".$realtime."', `tmatch`='0' 
where id = '" . $fid . "';");
}
//
if($trener!=0){	
$q = @mysql_query("select `time` from `infra_2` where type='trener' and team='" . $datauser['manager2'] . "' LIMIT 1;");
$arr = @mysql_fetch_array($q); 
$vtime = $arr['time']+3600*24*90;
if($realtime >= $vtime){
mysql_query("delete from `infra_2`  where type='trener' and team='" . $datauser['manager2'] . "';");
mysql_query("update `infra_2` set `trener`='0'  where  id_admin='" . $datauser['manager2'] . "';");
}
}

if($med!=0){	
$q = @mysql_query("select `time` from `infra_2` where type='med' and team='" . $datauser['manager2'] . "' LIMIT 1;");
$arr = @mysql_fetch_array($q); 
$vtime = $arr['time']+3600*24*90;
if($realtime >= $vtime){
mysql_query("delete from `infra_2`  where type='med' and team='" . $datauser['manager2'] . "';");
mysql_query("update `infra_2` set `med`='0'  where  id_admin='" . $datauser['manager2'] . "';");
}
}

?>