<?php
/*
//////////////////////////////////////////////////////////////////////////////////////////////////////
// mod manager by 1_Kl@S Syava Andrusiv                                    //
// Официальный сайт сайт Менеджера: http://megasport.name       //
// СДЕСЬ НИЧЕГО НЕ МЕНЯТЬ!!!!!!!!!!!!!!!                                        //
// Официальный сайт сайт проекта:      http://johncms.com             //
// Дополнительный сайт поддержки:      http://gazenwagen.com      //
/////////////////////////////////////////////////////////////////////////////////////////////////////
// JohnCMS core team:                                                                  //
// Евгений Рябинин aka john77          john77@johncms.com            //
// Олег Касьянов aka AlkatraZ          alkatraz@johncms.com           //
//                                                                                                  //
// Информацию о версиях смотрите в прилагаемом файле version.txt//
//////////////////////////////////////////////////////////////////////////////////////////////////////
*/

define('_IN_JOHNCMS', 1);
$headmod = 'manager2';
$textl = 'Создание комманды';
$rootpath = '../';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");
//require_once ('../incfiles/class_upload.php');
    // Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="../login.php">авторизованным</a> посетителям';
if ($error) {
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
	require_once ("../incfiles/end.php");
    exit;
}
    
    if ($_POST['submit']) {
        // Создаем команду
    $error = false;
    $reg_kod = isset($_POST['kod']) ? trim($_POST['kod']) : '';
    $strana = isset($_POST['strana']) ? trim($_POST['strana']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';     
	// Проверка страны
    if (empty($strana))
        $error = 'Вы не выбрали страну<br/>';
    // Проверка имени
    if (mb_strlen($name) < 3)
        $error = 'Название комманды слишком короткое<br/>';
    // Проверка имени
    if (mb_strlen($name) > 25)
        $error = 'Название комманды слишком длинное<br/>';

// Проверка кода CAPTCHA
    if (empty($reg_kod) || mb_strlen($reg_kod) < 4)
        $error = $error . 'Не введён проверочный код!<br/>';
    elseif ($reg_kod != $_SESSION['code'])
        $error = $error . 'Проверочный код неверен!<br/>';
    unset($_SESSION['code']);
 if (mysql_result(mysql_query("SELECT COUNT(*) FROM `team_2` WHERE `name` = '$name'"), 0) > 0)
            $error = 'Команда с таким названием уже есть!<br/>';
        

if (!$error) {


            $qk = mysql_query("select * from `team_2` where strana='" . $strana . "';");
            $krr = mysql_fetch_array($qk);

$i111 = rand(0,8);

$fn = "../base/shema.txt"; 
$fp = @fopen ($fn,"r"); 
$stsh =fread($fp,filesize($fn)); 
fclose($fp); 
$stsh =explode("|",$stsh); 

mysql_query("insert into `team_2` set
`time` = '$realtime',
`name`='" . $name . "',
`strana`='" . $strana . "',
`divizion`='" . $krr[divizion] . "',
`name_admin`='" . $login . "',
`id_admin`='" . $user_id . "',
`shema`='".$stsh[$i111]."',
`tactics`='60',
`money`='0',
`fan`='0';
");
$komanda = mysql_insert_id();


$i2 = rand(0,14087);
$i1 = rand(0,1241);
$i3 = rand(0,61);

$i5 = rand(0,14087);
$i4 = rand(0,1241);
$i6 = rand(0,61);

$i8 = rand(0,14087);
$i7 = rand(0,1241);
$i9 = rand(0,61);

$i11 = rand(0,14087);
$i10 = rand(0,1241);
$i12 = rand(0,61);

$i14 = rand(0,14087);
$i13 = rand(0,1241);
$i15 = rand(0,61);

$i17 = rand(0,14087);
$i16 = rand(0,1241);
$i18 = rand(0,61);

$i20 = rand(0,14087);
$i19 = rand(0,1241);
$i21 = rand(0,61);

$i23 = rand(0,14087);
$i22 = rand(0,1241);
$i24 = rand(0,61);

$i26 = rand(0,14087);
$i25 = rand(0,1241);
$i27 = rand(0,61);

$i29 = rand(0,14087);
$i28 = rand(0,1241);
$i30 = rand(0,61);

$i32 = rand(0,14087);
$i31 = rand(0,1241);
$i33 = rand(0,61);

$i35 = rand(0,14087);
$i34 = rand(0,1241);
$i36 = rand(0,61);


$i38 = rand(0,14087);
$i37 = rand(0,1241);
$i39 = rand(0,61);

$i41 = rand(0,14087);
$i40 = rand(0,1241);
$i42 = rand(0,61);

$i44 = rand(0,14087);
$i43 = rand(0,1241);
$i45 = rand(0,61);

$i47 = rand(0,14087);
$i46 = rand(0,1241);
$i48 = rand(0,61);

$i50 = rand(0,14087);
$i49 = rand(0,1241);
$i51 = rand(0,61);

$i53 = rand(0,14087);
$i52 = rand(0,1241);
$i54 = rand(0,61);


//54

$fn="../base/name.txt"; 
$fp = @fopen ($fn,"r"); 
$str1 = fread($fp,filesize($fn)); 
fclose($fp); 
$str1 = explode("\n",$str1); 


$fn ="../base/surname.txt"; 
$fp = @fopen ($fn,"r"); 
$str2 = fread($fp,filesize($fn)); 
fclose($fp); 
$str2 = explode("\n",$str2); 

$fn="../base/country.txt"; 
$fp = @fopen ($fn,"r"); 
$str3=fread($fp,filesize($fn)); 
fclose($fp); 
$str3=explode("|",$str3); 

$age = rand(16,24); //Возраст
$age1 = rand(16,24); //Возраст
$age2 = rand(16,24); //Возраст
$age3 = rand(16,24); //Возраст
$age4 = rand(16,24); //Возраст
$age5 = rand(16,24); //Возраст
$age6 = rand(16,24); //Возраст
$age7 = rand(16,24); //Возраст
$age8 = rand(16,24); //Возраст
$age9 = rand(16,24); //Возраст
$age10 = rand(16,24); //Возраст


$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Вратарь основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i3]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i1]." ".$str2[$i2]."',
`nomer`='1',`tal`='$har1',`poz`='Вр',`voz`='$age',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='1';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Вратарь запасной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i6]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i4]." ".$str2[$i5]."',
`nomer`='18',`tal`='$har',`poz`='Вр',`voz`='$age1',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='0',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='1';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Левый защитник основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i9]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i7]." ".$str2[$i8]."',
`nomer`='2',`tal`='$har',`poz`='ЛЗ',`voz`='$age2',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='2';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Левый защитник запасной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i12]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i10]." ".$str2[$i11]."',
`nomer`='17',`tal`='$har',`poz`='ЛЗ',`voz`='$age3',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='0',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='2';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Правый защитник основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i15]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i13]." ".$str2[$i14]."',
`nomer`='3',`tal`='$har',`poz`='ПЗ',`voz`='$age',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='2';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Правый защитник запасной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i18]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i16]." ".$str2[$i17]."',
`nomer`='16',`tal`='$har',`poz`='ПЗ',`voz`='$age4',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='0',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='2';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Центральный защитник основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i21]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i19]." ".$str2[$i20]."',
`nomer`='4',`tal`='$har',`poz`='ЦЗ',`voz`='$age5',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='2';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Центральный защитник основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i24]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i22]." ".$str2[$i23]."',
`nomer`='5',`tal`='$har',`poz`='ЦЗ',`voz`='$age6',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='2';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Центральный полу защитник основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i27]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i25]." ".$str2[$i26]."',
`nomer`='6',`tal`='$har',`poz`='ЦП',`voz`='$age',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='3';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Центральный полу защитник запасной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i30]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i28]." ".$str2[$i29]."',
`nomer`='15',`tal`='$har',`poz`='ЦП',`voz`='$age7',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='0',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='3';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Левый полу защитник основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i33]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i31]." ".$str2[$i32]."',
`nomer`='7',`tal`='$har',`poz`='ЛП',`voz`='$age8',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='3';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Левый полу защитник запасной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i36]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i34]." ".$str2[$i35]."',
`nomer`='14',`tal`='$har',`poz`='ЛП',`voz`='$age9',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='0',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='3';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Правый полу защитник основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i39]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i37]." ".$str2[$i38]."',
`nomer`='8',`tal`='$har',`poz`='ПП',`voz`='$age',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='3';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Правый полу защитник запасной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i42]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i40]." ".$str2[$i41]."',
`nomer`='13',`tal`='$har',`poz`='ПП',`voz`='$age10',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='0',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='3';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики


## Правый форвард основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i45]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i43]." ".$str2[$i44]."',
`nomer`='9',`tal`='$har3',`poz`='ПФ',`voz`='$age6',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='4';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Правый форвард запасной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i48]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i46]." ".$str2[$i47]."',
`nomer`='12',`tal`='$har3',`poz`='ПФ',`voz`='$age4',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='0',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='4';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Центральный форвард основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i51]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i49]." ".$str2[$i50]."',
`nomer`='10',`tal`='$har7',`poz`='ЦФ',`voz`='$age5',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='4';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики

## Левый форвард основной
mysql_query("insert into `player_2` set 
`strana`='".$str3[$i54]."', `kom`='".$komanda."', `time`='".$realtime."', `name`='".$str1[$i52]." ".$str2[$i53]."',
`nomer`='11',`tal`='$har6',`poz`='ЛФ',`voz`='$age3',`mas`='30',`fiz`='100',`mor`='30',`rm`='40',`sostav`='1',`money`='25000',
`opit`='0',`otbor`='$har3',`opeka`='$har4',`drib`='$har2',`priem`='$har1',`pas`='$har5',`sila`='$har7',`vonos`='$har6',`tocnost`='$har4',`zarplata`='5000',`line`='4';");

$har = rand(1,5); // Характеристики
$har1 = rand(1,5); // Характеристики
$har2 = rand(1,5); // Характеристики
$har3 = rand(1,5); // Характеристики
$har4 = rand(1,5); // Характеристики
$har5 = rand(1,5); // Характеристики
$har6 = rand(1,5); // Характеристики
$har7 = rand(1,5); // Характеристики


   mysql_query("update `users` set  `manager2`='" . $komanda . "' where id='" . $user_id . "' LIMIT 1;");

/*
## Вратарь запасной
mysql_query("insert into `player_2` set 
`strana`='".$strana."', 
`kom`='".$komanda."', 
`time`='".$realtime."', 
`name`='".$str1[$i1]." ".$str2[$i2]."', 
`nomer`='1',
`tal`='5',
`poz`='Вр',
`voz`='$age',
`mas`='30',
`fiz`='100',
`mor`='30',
`rm`='40',
`sostav`='0',
`money`='25000',
`opit`='0',
`otbor`='5',
`opeka`='$har',
`drib`='5',
`priem`='$har',
`pas`='5',
`sila`='$har',
`vonos`='$har',
`tochnost`='5',
`zarplata`='5000',
`line`='1'
;");

*/
//echo '<div class="rmenu"><p><b>ОК!</b></p></div>';

header("location: ../team.php?id=$komanda");
}else {echo '<div class="rmenu"><p><b>ОШИБКА!</b><br />' . $error . '</p></div>';}



}

echo '<div class="phdr2">Создание нового клуба</div>';   
   echo '<form action="add.php" method="post">';
   
   echo '<b>Введите название:</b><br/><input type="text" name="name" maxlength="20" value="' . check($_POST['name']) . '" /><br />';
       
       echo '<b>Выберите страну:</b><br/>';
        $matile = mysql_query('SELECT * from `team_2` GROUP BY `strana`;');
                echo '<select name="strana">';
                while ($mat = mysql_fetch_array($matile)) {
                
                    echo '<option value="' . $mat['strana'] . '" >';
                    echo '' . $mat['divizion'] . '</option>';
                }
       echo '</select>';
       
   echo '<div class="gmenu"><p>Если Вы не видите рисунок с кодом, включите поддержку графики в настройках браузера и обновите страницу.<br />';
   echo '<img src="../captcha.php?r=' . rand(1000, 9999) . '" alt="Проверочный код"/><br />';
   echo '<b>Код с картинки:</b><br/><input type="text" size="5" maxlength="5"  name="kod"/></p></div>';
   
   echo '<div class="bmenu"><input type="submit" name="submit" value="Создать комманду"/></div></form>';
   echo '<a href="../index.php">Вернуться</a>';


require_once ("../incfiles/end.php");
?>