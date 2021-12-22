<?php

define('_IN_JOHNCMS', 1);

$textl = 'Тренировка - FUTMEN.NET';

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
if (!empty($manag))
{
if (mysql_num_rows($manager) == 0)
{
echo "Команды не существует<br/>";
require_once ("incfiles/end.php");
exit;
}
function upoput($var,$oput,$id,$mas)
{
// Функция повышения опыта
$str = '';

if ($var == 1)
{
if ($oput >= 15)
{
$addoput = $oput - 15;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='2' where id='" . $id . "';");
}
}

elseif ($var == 2)
{
if ($oput >= 30)
{
$addoput = $oput - 30;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='3' where id='" . $id . "';");
}
}

elseif ($var == 3)
{
if ($oput >= 60)
{
$addoput = $oput - 60;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='4' where id='" . $id . "';");
}
}

elseif ($var == 4)
{
if ($oput >= 100)
{
$addoput = $oput - 100;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='5' where id='" . $id . "';");
}
}

elseif ($var == 5)
{
if ($oput >= 150)
{
$addoput = $oput - 150;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='6' where id='" . $id . "';");
}
}

elseif ($var == 6)
{
if ($oput >= 200)
{
$addoput = $oput - 200;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='7' where id='" . $id . "';");
}
}

elseif ($var == 7)
{
if ($oput >= 300)
{
$addoput = $oput - 300;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='8' where id='" . $id . "';");
}
}

elseif ($var == 8)
{
if ($oput >= 400)
{
$addoput = $oput - 400;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='9' where id='" . $id . "';");
}
}

elseif ($var == 9)
{
if ($oput >= 550)
{
$addoput = $oput - 550;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='10' where id='" . $id . "';");
}
}

elseif ($var == 10)
{
if ($oput >= 750)
{
$addoput = $oput - 750;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='11' where id='" . $id . "';");
}
}

elseif ($var == 11)
{
if ($oput >= 1000)
{
$addoput = $oput - 1000;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='12' where id='" . $id . "';");
}
}

elseif ($var == 12)
{
if ($oput >= 1500)
{
$addoput = $oput - 1500;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='13' where id='" . $id . "';");
}
}

elseif ($var == 13)
{
if ($oput >= 2000)
{
$addoput = $oput - 2000;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='14' where id='" . $id . "';");
}
}

elseif ($var == 14)
{
if ($oput >= 3000)
{
$addoput = $oput - 3000;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='15' where id='" . $id . "';");
}
}

elseif ($var == 15)
{
if ($oput >= 4000)
{
$addoput = $oput - 4000;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='16' where id='" . $id . "';");
}
}

elseif ($var == 16)
{
if ($oput >= 5500)
{
$addoput = $oput - 5500;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='17' where id='" . $id . "';");
}
}

elseif ($var == 17)
{
if ($oput >= 7500)
{
$addoput = $oput - 7500;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='18' where id='" . $id . "';");
}
}

elseif ($var == 18)
{
if ($oput >= 10000)
{
$addoput = $oput - 10000;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='19' where id='" . $id . "';");
}
}

elseif ($var == 19)
{
if ($oput >= 15000)
{
$addoput = $oput - 15000;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='20' where id='" . $id . "';");
}
}

elseif ($var == 20)
{
if ($oput >= 20000)
{
$addoput = $oput - 20000;
$str = mysql_query("update `player_2` set `opit`='" . $addoput . "', `".$mas."`='21' where id='" . $id . "';");
}
}

return $str;
}
















// Отбор
if ($act == "otbor")
{
$q = @mysql_query("select * from `player_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$total = mysql_num_rows($q);

if ($total == 0 || $datauser[manager2] != $arr[kom])
{
echo '<div class="c">Игрока не существует</div>';
require_once ("incfiles/end.php");
exit;
}

echo upoput($arr[otbor],$arr[opit],$arr[id],otbor);

header('location: train.php');
require_once ("incfiles/end.php");
exit;
}

// Опека
if ($act == "opeka")
{
$q = @mysql_query("select * from `player_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$total = mysql_num_rows($q);

if ($total == 0 || $datauser[manager2] != $arr[kom])
{
echo '<div class="c">Игрока не существует</div>';
require_once ("incfiles/end.php");
exit;
}

echo upoput($arr[opeka],$arr[opit],$arr[id],opeka);

header('location: train.php');
require_once ("incfiles/end.php");
exit;
}

// Дриблинг
if ($act == "drib")
{
$q = @mysql_query("select * from `player_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$total = mysql_num_rows($q);

if ($total == 0 || $datauser[manager2] != $arr[kom])
{
echo '<div class="c">Игрока не существует</div>';
require_once ("incfiles/end.php");
exit;
}

echo upoput($arr[drib],$arr[opit],$arr[id],drib);

header('location: train.php');
require_once ("incfiles/end.php");
exit;
}

// Прием
if ($act == "priem")
{
$q = @mysql_query("select * from `player_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$total = mysql_num_rows($q);

if ($total == 0 || $datauser[manager2] != $arr[kom])
{
echo '<div class="c">Игрока не существует</div>';
require_once ("incfiles/end.php");
exit;
}

echo upoput($arr[priem],$arr[opit],$arr[id],priem);

header('location: train.php');
require_once ("incfiles/end.php");
exit;
}

// Выносливость
if ($act == "vonos")
{
$q = @mysql_query("select * from `player_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$total = mysql_num_rows($q);

if ($total == 0 || $datauser[manager2] != $arr[kom])
{
echo '<div class="c">Игрока не существует</div>';
require_once ("incfiles/end.php");
exit;
}

echo upoput($arr[vonos],$arr[opit],$arr[id],vonos);

header('location: train.php');
require_once ("incfiles/end.php");
exit;
}

// Пас
if ($act == "pas")
{
$q = @mysql_query("select * from `player_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$total = mysql_num_rows($q);

if ($total == 0 || $datauser[manager2] != $arr[kom])
{
echo '<div class="c">Игрока не существует</div>';
require_once ("incfiles/end.php");
exit;
}

echo upoput($arr[pas],$arr[opit],$arr[id],pas);

header('location: train.php');
require_once ("incfiles/end.php");
exit;
}

// Сила удара
if ($act == "sila")
{
$q = @mysql_query("select * from `player_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$total = mysql_num_rows($q);

if ($total == 0 || $datauser[manager2] != $arr[kom])
{
echo '<div class="c">Игрока не существует</div>';
require_once ("incfiles/end.php");
exit;
}

echo upoput($arr[sila],$arr[opit],$arr[id],sila);

header('location: train.php');
require_once ("incfiles/end.php");
exit;
}

// Точность удара
if ($act == "tocnost")
{
$q = @mysql_query("select * from `player_2` where id='" . $id . "';");
$arr = @mysql_fetch_array($q);
$total = mysql_num_rows($q);

if ($total == 0 || $datauser[manager2] != $arr[kom])
{
echo '<div class="c">Игрока не существует</div>';
require_once ("incfiles/end.php");
exit;
}

echo upoput($arr[tocnost],$arr[opit],$arr[id],tocnost);

header('location: train.php');
require_once ("incfiles/end.php");
exit;
}








// ТРЕНИРОВКА
function oput($var,$oput,$id,$mas)
{
// Функция опыта
$str = '';

if ($var == 1)
{
if ($oput >= 15)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(15)';}
else
{$str = $var.'<br/>(15)';}
} 

elseif ($var == 2)
{
if ($oput >= 30)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(30)';}
else
{$str = $var.'<br/>(30)';}
} 

elseif ($var == 3)
{
if ($oput >= 60)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(60)';}
else
{$str = $var.'<br/>(60)';}
} 

elseif ($var == 4)
{
if ($oput >= 100)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(100)';}
else
{$str = $var.'<br/>(100)';}
} 

elseif ($var == 5)
{
if ($oput >= 150)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(150)';}
else
{$str = $var.'<br/>(150)';}
} 

elseif ($var == 6)
{
if ($oput >= 200)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(200)';}
else
{$str = $var.'<br/>(200)';}
} 

elseif ($var == 7)
{
if ($oput >= 300)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(300)';}
else
{$str = $var.'<br/>(300)';}
} 

elseif ($var == 8)
{
if ($oput >= 400)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(400)';}
else
{$str = $var.'<br/>(400)';}
} 

elseif ($var == 9)
{
if ($oput >= 550)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(550)';}
else
{$str = $var.'<br/>(550)';}
} 

elseif ($var == 10)
{
if ($oput >= 750)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(750)';}
else
{$str = $var.'<br/>(750)';}
} 

elseif ($var == 11)
{
if ($oput >= 1000)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(1000)';}
else
{$str = $var.'<br/>(1000)';}
} 

elseif ($var == 12)
{
if ($oput >= 1500)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(1500)';}
else
{$str = $var.'<br/>(1500)';}
} 

elseif ($var == 13)
{
if ($oput >= 2000)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(2000)';}
else
{$str = $var.'<br/>(2000)';}
} 

elseif ($var == 14)
{
if ($oput >= 3000)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(3000)';}
else
{$str = $var.'<br/>(3000)';}
} 

elseif ($var == 15)
{
if ($oput >= 4000)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(4000)';}
else
{$str = $var.'<br/>(4000)';}
} 

elseif ($var == 16)
{
if ($oput >= 5500)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(5500)';}
else
{$str = $var.'<br/>(5500)';}
} 

elseif ($var == 17)
{
if ($oput >= 7500)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(7500)';}
else
{$str = $var.'<br/>(7500)';}
} 

elseif ($var == 18)
{
if ($oput >= 10000)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(10000)';}
else
{$str = $var.'<br/>(10000)';}
} 

elseif ($var == 19)
{
if ($oput >= 15000)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(15000)';}
else
{$str = $var.'<br/>(15000)';}
} 

elseif ($var == 20)
{
if ($oput >= 20000)
{$str = $var.' <a href="train.php?act='.$mas.'&amp;id='.$id.'"><img src="img/up.gif" alt=""/></a><br/>(20000)';}
else
{$str = $var.'<br/>(20000)';}
} 

return $str;
}

$req = mysql_query("SELECT * FROM `player_2` where `kom`='".$datauser[manager2]."' order by line asc, poz asc;");
$total = mysql_num_rows($req);

echo '<div class="phdr"><b>Тренировка</b></div>';
echo '<div class="c"><p>
Футболисты получают опыт за сыгранные матчи.<br/>
При достижении некоторого значения, накопленный опыт можно потратить на повышение выбранного умения.<br/>
Значения всех умений и необходимого для повышения опыта указаны в таблице.<br/>
При достижении этого опыта, около умения появится кнопка для повышения.<br/>
</p></div>';
echo '<div class="c"><p align="center">
<a href="butcer.php?act=oput" class="button">Прокачать на 1000 опыта за 1 буцер</a>
</p></div>';
echo '<div class="c">';



echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>Поз</b></td>
<td><b>Игрок</b></td>
<td><b>Опыт</b></td>

<td><b>От</b></td>
<td><b>Оп</b></td>
<td><b>Др</b></td>
<td><b>Пм</b></td>
<td><b>Вн</b></td>
<td><b>Пс</b></td>
<td><b>Сл</b></td>
<td><b>Тч</b></td>
</tr>
';


while ($arr = mysql_fetch_array($req))
{

$allmas = $arr[otbor]+$arr[opeka]+$arr[drib]+$arr[priem]+$arr[vunos]+$arr[pas]+$arr[sila_ud]+$arr[to_ud];
if ($allmas != $arr[mas])
{
$rmm=ceil($allmas/100*$arr[fiz]);
mysql_query("update `player_2` set `mas`='" . $allmas . "', `rm`='" . $rmm . "' where id='" . $arr[id] . "';");
}

echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';

echo '
<td align="center">'.$arr[poz].'</td>
<td><a href="player.php?id='.$arr[id].'">'.$arr[name].'</a></td>
<td align="center"><font color="green"><b>'.$arr[opit].'</b></font></td>

<td align="center">'.oput($arr[otbor],$arr[opit],$arr[id],otbor).'</td>
<td align="center">'.oput($arr[opeka],$arr[opit],$arr[id],opeka).'</td>
<td align="center">'.oput($arr[drib],$arr[opit],$arr[id],drib).'</td>
<td align="center">'.oput($arr[priem],$arr[opit],$arr[id],priem).'</td>
<td align="center">'.oput($arr[vonos],$arr[opit],$arr[id],vonos).'</td>
<td align="center">'.oput($arr[pas],$arr[opit],$arr[id],pas).'</td>
<td align="center">'.oput($arr[sila],$arr[opit],$arr[id],sila).'</td>
<td align="center">'.oput($arr[tocnost],$arr[opit],$arr[id],tocnost).'</td>
';		
		
echo '</tr>';
++$i;
}
echo '</table>';

echo '</div>';
}

require_once ("incfiles/end.php");
?>
