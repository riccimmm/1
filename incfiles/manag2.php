<?php

defined('_IN_JOHNCMS') or die('Error:restricted access');
$manag = $datauser['manager2'];
$manager = mysql_query("SELECT * FROM `team_2` WHERE `id`='".$manag."' LIMIT 1;");
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
  $slava = $datamanag['slava'];
  }
  
 
 $vrp2 = $timeres + $sdvig * 3600;
    $vr2 = date("d.m.y", $vrp2);
    $vrp3 = $realtime + $sdvig * 3600;
    $vr3 = date("d.m.y", $vrp3);
/* Вычисляем текущую дату и дату последнего пополнения */ 
if ($vr2 !== $vr3){ 
/* Деньги за постройки */  

$x=mysql_query("SELECT `name` FROM `invent_2` WHERE  `uid`='".$fid."'");
if (mysql_num_rows($x) != 0)
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
mysql_query("delete from `infra2`  where type='med' and team='" . $datauser['manager2'] . "';");
mysql_query("update `infra_2` set `med`='0'  where  id_admin='" . $datauser['manager2'] . "';");
}
}




//////////////////////////////////////////Настройик/////////////////////////////////////////////

if ($datauser['manager2'] != 0) {

    // Проверяем, есть ли игры
    $q1 = mysql_query("SELECT * FROM `game_2` where `id_team1`='" . $datauser['manager2'] .
        "' OR `id_team2`='" . $datauser['manager2'] . "' order by time desc ;");
    $res = mysql_fetch_array($q1);

//echo 'Товарка';

    if ($headmod != "trans" && mysql_num_rows($q1) == 0) {
        // Проверяем, есть ли заявки на товарки
        
        $req = mysql_query("SELECT * FROM `frend_2` where  `id_team2`='" . $datauser['manager2'] .
            "'  order by time desc ;");
        
        if (mysql_num_rows($req) != 0) {
            echo '<div class="gmenu"><a href="'.$home2.'/friendly.php"><b>Вам предлогают товаришескую игру</b></a></div>';
        }
    }
	
	// Проверяем, есть ли игры
$q1 = mysql_query("SELECT * FROM `tur_2` where `id_team1`='".$datauser['manager2']."' OR `id_team2`='".$datauser['manager2']."' order by time desc LIMIT 1;");
$res = mysql_fetch_array($q1);
$tt=$res[time]+300;
$ostime = $tt-$realtime;
if ($headmod != "trans" && !empty($res[id]) && $res[rez1]=='—' && $res[rez2]=='—' && !empty($res[id_team1]) && !empty($res[id_team2]) && $ostime < 300)
{
echo '<div class="c"><center>';
echo '<a href="team.php?id=' . $res['id_team1'] . '">'.$res[name_team1].'</a>  - ';
echo '<a href="team.php?id=' . $res['id_team2'] . '">'.$res[name_team2].'</a> <br/>';
echo '<a href="trans.php?id=' . $res['id'] . '"><font color="red">Перейти к настройке ';
if ($ostime > 0)
{echo date("i:s", $ostime);}
echo '</font></a>';
echo '</center></div>';
}


    $qk = mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
    $kom = mysql_fetch_array($qk);
    // ВОССТАНОВЛЕНИЕ
    if ($kom['time'] < ($realtime - 600)) {
        $req = mysql_query("SELECT * FROM `player_2` where `kom`='" . $kom['id'] . "';");

        while ($arr = mysql_fetch_array($req)) {
            if ($arr[fiz] <= 100 || $arr['mor'] != '0') {

                $mast = $arr['otbor'] + $arr['opeka'] + $arr['drib'] + $arr['priem'] + $arr['vonos'] +
                    $arr['pas'] + $arr['sila'] + $arr['tocnost'];
                $rrr = ceil(($realtime - $kom['time']) / 600);
                $fiza = $arr[fiz] + $rrr;
                if ($fiza > 100) {
                    $fiza = 100;
                }
                if ($fiza < 0) {
                    $fiza = 0;
                }


                //Возращаю аредованых
                $arend = mysql_query("select * from `arenda_2` where player_id='" . $arr['id'] .
                    "' AND `sost`='yes' ;");
                $arenda = mysql_fetch_array($arend);
                if ($realtime >= $arenda['time']) {
                    mysql_query("update `player_2` set `kom` = '" . $krr['team_id1'] .
                        "', `arend` = '0' WHERE   id='" . $arenda['player_id'] . "';");
                }

                $rmm = ceil($mast / 100 * $fiza);
                if ($rmm < 0) {
                    $rmm = 0;
                }
                if ($kom['id_admin'] != 0)
                    mysql_query("update `player_2` set `fiz`='" . $fiza . "', `rm`='" . $rmm .
                        "' where id='" . $arr[id] . "' LIMIT 1;");
            }

            $kommoney = $kom['money'];
            $reload = 24 * 3600 * 30;
            if (($realtime - $arr[time]) > $reload) {
                $voz = $arr[voz] + 1;
                //удаляю игрока
                if ($voz >= 40) {
                    mysql_query("detele from `player_2`  where id='" . $arr[id] . "' LIMIT 1;");
                    //Пишем в историю
                    $text = 'Игрок  <a href="player.php?id=' . $arr['id'] . '">' . $arr['name'] .
                        '</a> ушел из футбола.';

                    mysql_query("insert into `history_2` set `time`='" . $realtime .
                        "', `type`='out', `text`='" . $text . "' ;");
                }

                $nominal2 = $mast * 100 * $arr[tal];
                $zarplata = nominal($arr[voz], $nominal2);
                $kommoney = $kom['money'] - $zarplata;
                mysql_query("update `player_2` set `time`='" . $realtime . "', `voz`='" . $voz .
                    "' where id='" . $arr[id] . "' LIMIT 1;");
            }

        }
        mysql_query("update `team_2` set `time`='" . $realtime . "', `name_admin`='" . $datauser[imname] .
            " " . $datauser[name] . "' , `time_admin`='" . $realtime . "', `money`='" . $kommoney .
            "' where id='" . $kom['id'] . "' LIMIT 1;");
    }


    switch ($kom[lvl]) {
        case "1":
            $oput = 100;
            break;
        case "2":
            $oput = 400;
            break;
        case "3":
            $oput = 800;
            break;
        case "4":
            $oput = 1800;
            break;
        case "5":
            $oput = 3800;
            break;
        case "6":
            $oput = 8800;
            break;
        case "7":
            $oput = 18800;
            break;
    }

    if ($kom[rate] >= $oput) {
        $addlevel = $kom[lvl] + 1;
        mysql_query("update `team_2` set `lvl`='" . $addlevel . "' where id='" . $kom[id] .
            "';");


        // Отправляем письмо
        mysql_query("INSERT INTO `privat` SET
		`user`='" . $datauser['name'] . "',
		`text`='Здравствуйте " . $kom['name_admin'] . "\r\n\r\nМы поздравляем Вас и вашу команду " .
            $kom['name'] . " с достижением " . $addlevel . " уровня\r\nМы внимательно следим за вашими выступлениями и видим в Вас будущего претендента на кубок Лиги Чемпионов.\r\n\r\nПрезидент УЕФА\r\nМишель Платини.',
		`time`='" . $realtime . "',
		`author`='Мишель Платини',
		`type`='in',
		`chit`='no',
		`temka`='Новый уровень',
		`otvet`='0'	;");
    }


}




?>