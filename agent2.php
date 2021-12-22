<?php

define('_IN_JOHNCMS', 1);

$textl = 'Свободные агенты - FUTMEN.NET';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");






switch ($act) {


    default:



// ПРОВЕРЯЕМ
$req = mysql_query("SELECT * FROM `agent_school_2` where `team`='".$datauser[manager2]."' order by time desc LIMIT 1;");
$arr1 = mysql_fetch_array($req);

$time = $realtime - 24*3600;

if ($time > $arr1[time])
{
//Удаляем
mysql_query("delete from `agent_school_2` where `team`='" . $datauser[manager2] . "';");


for($i=0; $i<5; $i++)
{

// Флаг игрока
$input1 =  array("rus", "ua", "bel", "en", "sp", "it", "br", "ge", "fr", "go","pol"); // наши числа  
$rand_keys1 = array_rand($input1);
$flag = $input1[$rand_keys1];


$fn1='base/'.$flag.'_name.txt'; 
$fp1 = @fopen ($fn1,"r"); 
$str1=fread($fp1,filesize($fn1)); 
fclose($fp1); 
$str1=explode("\n",$str1); 
$all1 = sizeof($str1);

$fn2='base/'.$flag.'_surname.txt'; 
$fp2 = @fopen ($fn2,"r"); 
$str2=fread($fp2,filesize($fn2)); 
fclose($fp2); 
$str2=explode("\n",$str2); 
$all2 = sizeof($str2);

$i1 = rand(0,$all1);
$i2 = rand(0,$all2);

$nomer = rand(1,50);
$voz = rand(18,39);

$tal_arr = array ("1", "1", "1", "2", "2", "2", "3", "3", "3", "4", "4", "5", "5", "6", "7", "8");
$tal = $tal_arr[array_rand($tal_arr)];

$tal = rand(1,8);

$otbor = rand(1,10);
$opeka = rand(1,10);
$drib = rand(1,10);
$priem = rand(1,10);
$vunos = rand(1,10);
$pas = rand(1,10);
$sila_ud = rand(1,10);
$to_ud = rand(1,10);

$mas = $otbor+$opeka+$drib+$priem+$vunos+$pas+$sila_ud+$to_ud;

//  Позиция

$poz_arr = array("Вр", "ЛЗ", "ЦЗ", "ПЗ", "ЛП", "ЦП", "ПП", "ЛФ", "ЦФ", "ПФ"); // наши числа
                $poz = $poz_arr[array_rand($poz_arr)];


                switch ($poz) {
                    case "Вр":
                        $line = 1;
                        break;

                    case "ЛЗ":
                        $line = 2;
                        break;
                    case "ЦЗ":
                        $line = 2;
                        break;
                    case "ПЗ":
                        $line = 2;
                        break;

                    case "ЛП":
                        $line = 3;
                        break;
                    case "ЦП":
                        $line = 3;
                        break;
                    case "ПП":
                        $line = 3;
                        break;

                    case "ЛФ":
                        $line = 4;
                        break;
                    case "ЦФ":
                        $line = 4;
                        break;
                    case "ПФ":
                        $line = 4;
                        break;
                }


mysql_query("insert into `agent_school_2` set 

`team`='".$datauser[manager2]."', 
`time`='".$realtime."', 

`name`='".$str1[$i1]." ".$str2[$i2]."', 
`flag`='".$flag."', 
`nomer`='".$nomer."', 
`poz`='".$poz."', 
`line`='".$line."', 
`voz`='".$voz."', 
`tal`='".$tal."', 
`mas`='".$mas."', 
`otbor`='".$otbor."', 
`opeka`='".$opeka."', 
`drib`='".$drib."', 
`priem`='".$priem."', 
`vunos`='".$vunos."', 
`pas`='".$pas."', 
`sila_ud`='".$sila_ud."', 
`to_ud`='".$to_ud."'
;");


}


}







echo '<div class="phdr"><b>Агенты</b></div>';
echo '<div class="c">';

// ВЫВОДИМ
echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">';

echo '
<tr bgcolor="40B832" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Игрок</b></td>
<td><b>Гр</b></td>
<td><b>Поз</b></td>
<td><b>Воз</b></td>
<td><b>Тал</b></td>
<td><b>Мас</b></td>
<td><b>Цена</b></td>
</tr>
';

$req = mysql_query("SELECT * FROM `agent_school_2` where `team`='".$datauser[manager2]."' order by time desc LIMIT 5;");
$total = mysql_num_rows($req);

while ($arr = mysql_fetch_array($req))
{


$mast = $arr[otbor] + $arr[opeka] + $arr[drib] + $arr[priem] + $arr[vonos] + $arr[pas] +
            $arr[sila] + $arr[tocnost];

$nom = $mast*10*$arr[tal];
$nominal = nominal($arr[voz],$nom);

 echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :'<tr bgcolor="f3f3f3">';

echo '
<td align="center">'.$arr[nomer].'</td>
<td><a href="agent2.php?act=info&amp;id='.$arr[id].'">'.$arr[name].'</a>';

echo ' <a href="agent2.php?act=buy&amp;id='.$arr[id].'"><img src="img/buy.gif" alt=""/></a>';

echo '</td>
<td align="center"><img src="flag/' . $arr[flag] . '.png" alt=""/></td>
<td align="center">'.$arr[poz].'</td>
<td align="center">'.$arr[voz].'</td>
<td align="center">'.$arr[tal].'</td>
<td align="center">'.$arr[mas].'</td>
<td align="center"><font color="green"><b>'.$nominal.' €</b></font></td>
';		
		
echo '</tr>';
++$i;
}
echo '</table>';
echo '</div>';


$ostalos = 24 - ($realtime - $arr1[time]);


echo '
<div class="c"><p>
Каждый день на рынке свободных агентов появляются 5 новых игрока, а старые пропадают.<br/>
Новые агенты появлятся через: 
' . gmdate('H', $ostalos) . ' час.
' . gmdate('i', $ostalos) . ' мин.
</p></div>
';
	break;
	
	case 'info':
	$q = @mysql_query("select * from `agent_school_2` where id='" . $id . "' LIMIT 1;");
$arr = @mysql_fetch_array($q);


if (empty($arr[id]))
{
echo display_error('Игрока не существует');
require_once ("incfiles/end.php");
exit;
}

if ($arr[team] != $datauser[manager2])
{
echo display_error('Етот игрок не доступен');
require_once ("incfiles/end.php");
exit;
}

echo '<div class="phdr"><b>'.$arr['name'].'</b></div>';

echo '<div class="c">';
echo '<br/>
<b>Мастерство ' . $arr[mas] . '</b><br/>';

echo 'Отбор: <b>' . $arr[otbor] . '</b><br/>';
echo 'Опека: <b>' . $arr[opeka] . '</b><br/>';
echo 'Дриблинг: <b>' . $arr[drib] . '</b><br/>';
echo 'Прием мяча: <b>' . $arr[priem] . '</b><br/>';
echo 'Выносливость: <b>' . $arr[vunos] . '</b><br/>';
echo 'Пас: <b>' . $arr[pas] . '</b><br/>';
echo 'Сила удара: <b>' . $arr[sila_ud] . '</b><br/>';
echo ' Точность удара: <b>' . $arr[to_ud] . '</b><br/>';



echo '<br/>
<b>Характеристики</b><br/>';
echo 'Номер: <b>' . $arr[nomer] . '</b><br/>';
echo 'Страна: <img src="flag/' . $arr[flag] . '.png" alt=""/><br/>';
echo 'Возраст: <b>' . $arr[voz] . '</b><br/>';
echo 'Позиция: <b>' . $arr[poz] . '</b><br/>';
echo 'Физготовность: <b>100%</b><br/>';
echo 'Мораль: <b>0</b><br/>';
echo 'Талант: <b>' . $arr[tal] . '</b><br/>';
echo 'Команда: <b>Свободый агент</b><br/>';

$mast = $arr[otbor] + $arr[opeka] + $arr[drib] + $arr[priem] + $arr[vonos] + $arr[pas] +
            $arr[sila] + $arr[tocnost];

$nominal = $mast*10*$arr[tal];
echo 'Цена: <b>' . nominal($arr[voz],$nominal) . ' €</b><br/>';
echo '</div>';


echo '<div class="c"><p>';
echo '<a href="agent2.php?act=buy&amp;id=' . $id . '" class="redbutton"><b>Купить игрока</b></a><br/>';
echo '</p></div>';
	break;
	
	case 'buy':
	$q = @mysql_query("select * from `agent_school_2` where id='" . $id . "' LIMIT 1;");
$arr = @mysql_fetch_array($q);

if (empty($arr[id]))
{
echo display_error('Игрока не существует');
require_once ("incfiles/end.php");
exit;
}

if ($arr[team] != $datauser[manager2])
{
echo display_error('Етот игрок не доступен');
require_once ("incfiles/end.php");
exit;
}

// Считаем игроков
$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$datauser['manager2']."';");
$total = mysql_num_rows($req);

// Покупатель
$k = @mysql_query("select * from `team_2` where id='" . $datauser['manager2'] . "' LIMIT 1;");
$kom = @mysql_fetch_array($k);

$mast = $arr[otbor] + $arr[opeka] + $arr[drib] + $arr[priem] + $arr[vonos] + $arr[pas] +
            $arr[sila] + $arr[tocnost];

$nom = $mast*10*$arr[tal];
$nominal = nominal($arr[voz],$nom);
$moneykom = $kom[money] - $nominal;



if (isset($_GET['yes']))
{

if ($kom[money] < $nominal)
{
echo display_error('У вас недостаточно денег');
require_once ("incfiles/end.php");
exit;
}

mysql_query("update `team_2` set `money`='" . $moneykom . "' where id = '" . $kom[id] . "' LIMIT 1;");
mysql_query("delete from `agent_school_2` where `id`='" . $arr[id] . "' LIMIT 1;");

            mysql_query("insert into `player_2` set 
`time`='".$realtime."',			
`name`='" . $arr[name] . "', 
`strana`='" . $arr[flag] . "', 

`kom`='" . $datauser[manager2] . "', 

`nomer`='" . $arr[nomer] . "', 
`poz`='" . $arr[poz] . "', 
`line`='" . $arr[line] . "', 
`voz`='" . $arr[voz] . "', 
`tal`='" . $arr[tal] . "', 
`mas`='" . $arr[mas] . "', 
`rm`='" . $arr[mas] . "', 
`otbor`='" . $arr[otbor] . "', 
`opeka`='" . $arr[opeka] . "', 
`drib`='" . $arr[drib] . "', 
`priem`='" . $arr[priem] . "', 
`vonos`='" . $arr[vunos] . "', 
`pas`='" . $arr[pas] . "', 
`sila`='" . $arr[sila_ud] . "', 
`tocnost`='" . $arr[to_ud] . "'
;");

echo '<meta http-equiv="refresh" content="0;url=team.php?id='.$datauser[manager2].'"/>';
exit;
}
else
{
echo '<div class="gmenu"><b>Агент</b></div>';
echo '<div class="c">';
echo 'Игрок: <b>'.$arr[name].'</b><br/>';
echo 'Цена: <b>'.$nominal.' €</b><br/>';
echo '</div>';

echo '<div class="c">';
echo '<a href="?act=buy&amp;id='.$arr[id].'&amp;yes"><font color="red"><b>Купить игрока</b></font></a><br/>';
echo '</div>';
}
	break;
}

require_once ("incfiles/end.php");
?>
