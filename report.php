<?php
define('_IN_JOHNCMS', 1);

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

$headmod = 'report';
require_once ("incfiles/core.php");

$q = mysql_query("select `name_team1`,`name_team2`,`rez1`,`rez2` from `tur_2` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

$textl = $arr[name_team1] . ' - ' . $arr[name_team2].' '.$arr[rez1].':'.$arr[rez2];
require_once ("incfiles/head.php");

$q = mysql_query("select * from `tur_2` where id='" . $id . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (empty($arr['id']))
{
echo display_error('Отчёт не найден');
require_once ("incfiles/end.php");
exit;
}


echo '<div class="phdr"><b>Отчет матча</b></div>';
echo'<center>';
$k1 = mysql_query("select * from `team_2` where id='" . $arr[id_team1] . "' LIMIT 1;");
$kom1 = mysql_fetch_array($k1);

$k2 = mysql_query("select * from `team_2` where id='" . $arr[id_team2] . "' LIMIT 1;");
$kom2 = mysql_fetch_array($k2);


echo '<b>'.date("d.m / H:i", $arr['time']).'</b>';

echo '<br><a href="stadium.php?id=' . $kom1['id'] . '"><img src="img/pole.jpg" alt=""/><br>'.$kom1[name].' Arena</a><br/>';


if (!empty($kom1[logo]))
{
echo '<img src="logo/small' . $kom1[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/> ';
}


echo '<a href="team.php?id=' . $kom1['id'] . '">'.$kom1[name].'</a> ['.$kom1[lvl].'] - <a href="team.php?id=' . $kom2['id'] . '">'.$kom2[name].'</a> ['.$kom2[lvl].'] ';


if (!empty($kom2[logo]))
{
echo '<img src="logo/small' . $kom2[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/>';
}


echo '<br/>';


if ($arr[rez1] != '' || $arr[rez2] != '')
{
echo '<h1>';
echo ''.$arr[rez1].':'.$arr[rez2].'';

if ($arr[rez1] == $arr[rez2] && $arr[chemp] == 'cup')
{echo ' (п. '.$arr[pen1].':'.$arr[pen2].')';}

echo '</h1>';



$menus = explode("\r\n",$arr[menus]);
asort($menus);
next($menus);

while (list($key, $val) = each($menus)) 
{
$menu = explode("|",$menus[$key]);
echo intval($menu[0]) . ' <img src="img/G.gif" alt=""/> <a href="player.php?id=' . $menu[2] . '">' . $menu[3] . '</a> ' . $menu[4] . '<br/>';
}

if(!empty($arr['text']))
echo '<a href="txt.php?id=' . $id . '">Посмотреть трансляцию</a>';
echo '</p>';



////////////////
$tactics1 = explode("|",$arr[tactics1]);
$tactics2 = explode("|",$arr[tactics2]);

$players1 = explode("\r\n",$arr[sostav1]);
$players2 = explode("\r\n",$arr[sostav2]);
////////////////




///////////////////////////////////////////////////////
//echo '<table valign="top" align="center"><tr><td>';//
///////////////////////////////////////////////////////
echo'</center>';
echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4"><tr bgcolor="40B832" align="center" class="whiteheader" ></tr>';

echo '<tr bgcolor="dddddd" align="center" class="whiteheader"><td colspan="3"><b>' . $arr['name_team1'] . '</b></td></tr>';

$all1 = sizeof($players1);
if($all1)
{
for($i=0; $i<($all1-1); $i++)
{

echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
$play1 = explode("|",$players1[$i]);
echo '<td>'.$play1[0] . '</td><td width="1200px"><a href="player.php?id=' . $play1[1] . '">' . $play1[2] . '</a></td><td>' . $play1[3] . '</td>';
echo '</tr>';


}
}

echo '</center></table>';

echo '</center><br/>';

echo 'Схема: <b>' . $tactics1[0] . '</b><br/>';

switch ($tactics1[1])
{
case "0":
echo 'Пасы: <b>Смешанные</b><br/>';
break;
case "1":
echo 'Пасы: <b>Дальние</b><br/>';
break;
case "2":
echo 'Пасы: <b>Короткие</b><br/>';
break;
}


switch ($tactics1[2])
{
case "0":
echo 'Стратегия: <b>Нормальная</b><br/>';
break;
case "1":
echo 'Стратегия: <b>Дальние удары</b><br/>';
break;
case "2":
echo 'Стратегия: <b>Техничная игра</b><br/>';
break;
case "3":
echo 'Стратегия: <b>Игра в пас</b><br/>';
break;
}


switch ($tactics1[3])
{
case "0":
echo 'Прессинг: <b>Нет</b><br/>';
break;
case "1":
echo 'Прессинг: <b>Да</b><br/>';
break;
}


switch ($tactics1[4])
{
case "10":
echo 'Тактика: <b>10 Суперзащитная</b><br/>';
break;
case "20":
echo 'Тактика: <b>20 Суперзащитная</b><br/>';
break;
case "30":
echo 'Тактика: <b>30 Защитная</b><br/>';
break;
case "40":
echo 'Тактика: <b>40 Защитная</b><br/>';
break;
case "50":
echo 'Тактика: <b>50 Нормальная</b><br/>';
break;
case "60":
echo 'Тактика: <b>60 Нормальная</b><br/>';
break;
case "70":
echo 'Тактика: <b>70 Атакующая</b><br/>';
break;
case "80":
echo 'Тактика: <b>80 Атакующая</b><br/>';
break;
case "90":
echo 'Тактика: <b>90 Суператакующая</b><br/>';
break;
case "100":
echo 'Тактика: <b>100 Суператакующая</b><br/>';
break;
}

echo 'Сила: <b>' . $tactics1[5] . '</b><br/>';


echo '<br/>';


//////////////////////
//echo '</td><td>';///
//////////////////////
echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4"><tr bgcolor="40B832" align="center" class="whiteheader" ></tr>';

echo '<tr bgcolor="dddddd" align="center" class="whiteheader"><td colspan="3"><b>' . $arr['name_team2'] . '</b></td></tr>';

$all2 = sizeof($players2);
if($all2)
{
for($i=0; $i<($all2-1); $i++)
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
$play2 = explode("|",$players2[$i]);
echo '<td>'.$play2[0] . '</td><td width="1200px"><a href="player.php?id=' . $play2[1] . '">' . $play2[2] . '</a></td><td>' . $play2[3] . '</td>';
echo '</tr>';
}
}
echo '</table>';

echo '</center><br/>';

echo 'Схема: <b>' . $tactics2[0] . '</b><br/>';

switch ($tactics2[1])
{
case "0":
echo 'Пасы: <b>Смешанные</b><br/>';
break;
case "1":
echo 'Пасы: <b>Дальние</b><br/>';
break;
case "2":
echo 'Пасы: <b>Короткие</b><br/>';
break;
}


switch ($tactics2[2])
{
case "0":
echo 'Стратегия: <b>Нормальная</b><br/>';
break;
case "1":
echo 'Стратегия: <b>Дальние удары</b><br/>';
break;
case "2":
echo 'Стратегия: <b>Техничная игра</b><br/>';
break;
case "3":
echo 'Стратегия: <b>Игра в пас</b><br/>';
break;
}


switch ($tactics2[3])
{
case "0":
echo 'Прессинг: <b>Нет</b><br/>';
break;
case "1":
echo 'Прессинг: <b>Да</b><br/>';
break;
}


switch ($tactics2[4])
{
case "10":
echo 'Тактика: <b>10 Суперзащитная</b><br/>';
break;
case "20":
echo 'Тактика: <b>20 Суперзащитная</b><br/>';
break;
case "30":
echo 'Тактика: <b>30 Защитная</b><br/>';
break;
case "40":
echo 'Тактика: <b>40 Защитная</b><br/>';
break;
case "50":
echo 'Тактика: <b>50 Нормальная</b><br/>';
break;
case "60":
echo 'Тактика: <b>60 Нормальная</b><br/>';
break;
case "70":
echo 'Тактика: <b>70 Атакующая</b><br/>';
break;
case "80":
echo 'Тактика: <b>80 Атакующая</b><br/>';
break;
case "90":
echo 'Тактика: <b>90 Суператакующая</b><br/>';
break;
case "100":
echo 'Тактика: <b>100 Суператакующая</b><br/>';
break;
}

echo 'Сила: <b>' . $tactics2[5] . '</b><br/>';

echo '</table>';

}
///////////////////////////////
//echo '</td></tr></table>';///
///////////////////////////////

 
 
  $bb = mysql_query("SELECT * FROM `news_2` WHERE `tid`='".$id."' ORDER BY `time` DESC ");
 if(mysql_num_rows($bb)>0){
 	echo '<div class="gmenu">';
echo 'Статистика игры:</div>';				
				$i="0";
                
                while ($bb1 = mysql_fetch_assoc($bb))
                {
                    echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<div class="list1">' : '<div class="list2">';
                    					$menu = explode("|",$bb1['news']);
echo $div .'<img src="/manag/img/txt/s_' . $menu[1] . '.gif" alt=""/>  ' . $menu[2] .'</div>';
                    ++$i;
                }}

require_once ("incfiles/end.php");
?>