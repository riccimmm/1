<?php

define('_IN_JOHNCMS', 1);

$textl = 'Состав - FUTMEN.NET';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '../';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("../incfiles/manag.php");
if ($id == $datauser['manager2'] || $rights > 8) {
    $qs = mysql_query("SELECT `id`,`pass`,`strat`,`press`,`tactics` from `r_team` WHERE id='" .
        $id . "' LIMIT 1;");
    $ass = mysql_fetch_array($qs);
    $colm_team = mysql_num_rows($qs);

    if ($colm_team == 0) {
        echo "Такой команды не существует<br/>";
        require_once ("incfiles/end.php");
        exit;
    }


    ///////////      Add Состав     /////////////////
    if ($act == "addsostav") {
        echo '<div class="phdr"><b>Состав</b></div><div class="c">';
        if (count($_POST['elem']) == 11) {
            mysql_query("update `r_player` set `sostav`='0' where `kom` = '" . $ass['id'] .
                "' AND `sostav` = '1';");


            foreach ($_POST["elem"] as $key => $val) {
                mysql_query("update `r_player` set `sostav`='1' where id='" . $val . "';");

            }
            header('location: sostav.php?id=' . $ass['id'] . '');
        } else {
            echo '<div class="rmenu">Вам нужно выбрать 11 игроков</div><br/>';
            echo '<a class="redbutton" href="sostav.php?act=editsostav&amp;id=' . $ass['id'] .
                '">Изменить состав</a><br/><br/>';
        }
        echo '</div>';
        require_once ("incfiles/end.php");
        exit;
    }


    //////////////      Edit Состав     /////////////////
    if ($act == "editsostav") {
        $resurs = mysql_query("SELECT * FROM `r_game` WHERE `id_team1`='" . $fid .
            "'  OR `id_team2`='" . $fid . "' ;");
        if (mysql_num_rows($resurs) != 0) {

header('location: sostav.php?act=editsostavmatch&id=' . $id . '');
        }
        echo '<div class="phdr"><b>Изменить состав</b></div><div class="c">';
        $req = mysql_query("SELECT * FROM `r_player` WHERE `kom`='" . $ass['id'] .
            "'  AND `sostav`<'5' order by line asc, poz asc;");
        $total = mysql_num_rows($req);

        echo '<form action="sostav.php?act=addsostav&amp;id=' . $ass['id'] .'" method="post">';
        echo '<table bgcolor="cccccc" id="example" border="0" width="100%" cellspacing="1" cellpadding="4">
<tr align="center" class="whiteheader" >
<td></td>
<td><b>Игрок</b></td>
<td><b>Поз</b></td>
<td><b>Ф/г</b></td>
<td><b>Мор</b></td>
<td><b>Р/м</b></td>
</tr>';

        while ($arr = mysql_fetch_array($req)) {
$allfizkom = $allfizkom + $arr[fiz];
			switch ($arr['line'])
{
case "1":
case "0":
echo '<tr bgcolor="FFF7E7">';
break;
case "2":
echo '<tr bgcolor="F7FFEF">';
break;
case "3":
echo '<tr bgcolor="E7F7FF">';
break;
case "4":
echo '<tr bgcolor="FFEFEF">';
break;
}
			
			
            echo '<td align="center"><input type="checkbox" name="elem[]" value="' . $arr[id] .
                '"';
            if ($arr['sostav'] == "1") {
			$allfizsos = $allfizsos + $arr[fiz];
                echo ' checked="checked"';
            }
            echo ' /></td><td><a href="player.php?id=' . $arr['id'] . '">' . $arr['name'] .
                '</a></td>
				<td align="center">' . $arr['poz'] . '</td>
				<td align="center">' . $arr['fiz'] .'%</td>
				<td align="center">' . $arr['mor'] .'</td>
				<td align="center"><font color="green"><b>' . $arr['rm'] .
                '</b></font></td>';
            echo '</tr>';
            ++$i;
        }
        echo '</table>';

        echo '<p align="center"><input type="submit" class="button" title="Нажмите для отправки" name="submit" value="Изменить состав"/></p>
</form>';
       echo '</div>';
	   $fizsos = round($allfizsos/11);
$fizkom = round($allfizkom/$total);
echo '<div class="c"><p>
Физготовность основного состава: <font color="#FF0000">'.$fizsos.'%</font><br/>
Физготовность команды <font color="#FF0000">'.$fizkom.'%</font><br/>
</p></div>';
        require_once ("incfiles/end.php");
        exit;
    }

    //////////////      Edit Состав     /////////////////
    if ($act == "editsostavmatch") {
        $resurs = mysql_query("SELECT * FROM `r_game` WHERE `id_team1`='" . $fid .
            "'  OR `id_team2`='" . $fid . "' ;");
        $game = 0;
        if (mysql_num_rows($resurs) != 0) {
            $res = mysql_fetch_array($resurs);
			
			if($res[id_team1] == $fid){
			$zamena = $res[zamena1];
			}else{
			$zamena = $res[zamena2];
			}
			
            if ($zamena <= 0) {
                echo '<div class="c">';
                echo 'Вы зделали все замены!';
                echo '</div>';
                require_once ("incfiles/end.php");
                exit;
            }
            echo '<div class="c">';
            echo 'В настоящий момент команда играет матч. Вы можете зделать ещо <b>' . $zamena .
                '</b> замену(ы)!';
            echo '</div>';
            $game = $res['id'];
            //require_once ("incfiles/end.php");
            //exit;
        }
        echo '<div class="c">';
        $req = mysql_query("SELECT * FROM `r_player` where `kom`='" . $ass[id] .
            "' AND `sostav`=1 order by nomer asc;");
			
		
            
        echo '<div class="gmenu"><b>Выберите кого заменить</b></div>';
        echo '<form action="sostav.php?act=addsostavmatch&amp;id='.$id.'&amp;game='.$res['id'].'" method="post">';
        echo '<select name="player">';
        while ($arr = mysql_fetch_array($req)) {
            echo '<option value="' . $arr[id] . '">' . $arr[nomer] . ' ' . $arr[name] .
                ' ['.$arr[poz].']</option>';
        }
        echo '</select>';
        
        echo '<div class="gmenu"><b>Выберите на кого заменить</b></div>';
                $res = mysql_query("SELECT * FROM `r_player` where `kom`='" . $ass[id] .
            "' AND `sostav`=0 order by nomer asc;");
                echo '<select name="player2">';
        while ($arr2 = mysql_fetch_array($res)) {
            if($arr2['sostav']==0)
            echo '<option value="' . $arr2[id] . '">' . $arr2[nomer] . ' ' . $arr2[name] .' ['.$arr2[poz].']</option>';
        }
        echo '</select><br/>';
        echo '<input type="submit" name="submit" value="Ок" /></form>';
        
        echo '</div>';


        require_once ("incfiles/end.php");
        exit;
    }

    ///////////      Add Состав     /////////////////
    if ($act == "addsostavmatch") {
$player = trim($_POST['player']);
$player2 = trim($_POST['player2']);

$q = @mysql_query("select `name` from `r_player` where id='" . $player . "' LIMIT 1;");
$play = @mysql_fetch_array($q);

$q2 = @mysql_query("select `name` from `r_player` where id='" . $player2 . "' LIMIT 1;");
$play2 = @mysql_fetch_array($q2);
$q3 = @mysql_query("select * FROM `r_game` WHERE id='" . $_GET['game'] ."' LIMIT 1;");
$art2 = mysql_fetch_assoc($q3);


			if($art2['id_team1'] == $fid){
			$zamena = 'zamena1';
			$zam = $art2['zamena1']-1;
			}else{
			$zamena = 'zamena2';
			$zam = $art2['zamena2']-1;
			}
			
            if ($_GET['game'] != 0) {
			$news = '01|reverse|<b>Замена в составе "'.$names.'".</b><br/>Вышел: '.$play2['name'].'<br/>Ушёл: '.$play['name'].'<br/>';
			mysql_query("INSERT INTO `gnews_2` set `time`='" . $art2['time'] . "', `tid`='" . $_GET['game'] . "' , `news`='" . $news . "' ;");

                	mysql_query("update `r_game` set `".$zamena."`='".$zam."' where id='" . $_GET['game'] .
                    "' LIMIT 1;");
           


			
			
			}

mysql_query("update `r_player` set sostav='0' where id='" . $player . "' LIMIT 1;");
mysql_query("update `r_player` set sostav='1' where id='" . $player2 . "' LIMIT 1;");
header('location: sostav.php?id=' . $id . '');
    }

    ///////////      Add Тактика     /////////////////
    if ($act == "addtactics") {
$shema = trim($_POST['shema']);
$pas = trim($_POST['pas']);
$strat = trim($_POST['strat']);
$pres = trim($_POST['pres']);
$tactic = trim($_POST['tactic']);
        mysql_query("update `r_team` set `shema`='".$shema."',`pass`='" . $pas . "', `strat`='" . $strat .
            "', `press`='" . $pres . "', `tactics`='" . $tactic . "' where id='" . $ass['id'] .
            "';");
        header('location: sostav.php?id=' . $ass['id'] . '');
        exit;
    }

    //////////////     Состав     /////////////////


        $resurs = mysql_query("SELECT * FROM `r_game` WHERE `id_team1`='" . $fid .
            "'  OR `id_team2`='" . $fid . "' ;");
        if (mysql_num_rows($resurs) != 0) {

header('location: sostav.php?act=editsostavmatch&id=' . $id . '');
        }
        echo '<div class="phdr"><b>Изменить состав</b></div><div class="c">';
        $req = mysql_query("SELECT * FROM `r_player` WHERE `kom`='" . $ass['id'] .
            "'  AND `sostav`<'5' order by line asc, poz asc;");
        $total = mysql_num_rows($req);

        echo '<form action="sostav.php?act=addsostav&amp;id=' . $ass['id'] .'" method="post">';
        echo '<table bgcolor="cccccc" id="example" border="0" width="100%" cellspacing="1" cellpadding="4">
<tr align="center" class="whiteheader" >
<td></td>
<td><b>Игрок</b></td>
<td><b>Поз</b></td>
<td><b>Ф/г</b></td>
<td><b>Маст</b></td>
<td><b>Р/м</b></td>
</tr>';



        while ($arr = mysql_fetch_array($req)) {
$allfizkom = $allfizkom + $arr[fiz];
			switch ($arr['line'])
{
case "1":
case "0":
echo '<tr bgcolor="FFF7E7">';
break;
case "2":
echo '<tr bgcolor="F7FFEF">';
break;
case "3":
echo '<tr bgcolor="E7F7FF">';
break;
case "4":
echo '<tr bgcolor="FFEFEF">';
break;
}
			
			            $mast = $arr['otbor'] + $arr['opeka'] + $arr['drib'] + $arr['priem'] + $arr['vonos'] +
                $arr['pas'] + $arr['sila'] + $arr['tocnost'];

            echo '<td align="center"><input type="checkbox" name="elem[]" value="' . $arr[id] .
                '"';
            if ($arr['sostav'] == "1") {
			$allfizsos = $allfizsos + $arr[fiz];
                echo ' checked="checked"';
            }
            echo ' /></td><td><a href="player.php?id=' . $arr['id'] . '">' . $arr['name'] .
                '</a></td>
				<td align="center">' . $arr['poz'] . '</td>
				<td align="center">' . $arr['fiz'] .'%</td>
				<td align="center">'.$mast.'</td>
				<td align="center"><font color="green"><b>' . $arr['rm'] .
                '</b></font></td>';
            echo '</tr>';
            ++$i;
        }
        echo '</table>';

        echo '<p align="center"><input type="submit" class="button" title="Нажмите для отправки" name="submit" value="Изменить состав"/></p>
</form>';
       echo '</div>';
	   $fizsos = round($allfizsos/11);
$fizkom = round($allfizkom/$total);
echo '<div class="c"><p>
Физготовность основного состава: <font color="#FF0000">'.$fizsos.'%</font><br/>
Физготовность команды <font color="#FF0000">'.$fizkom.'%</font><br/>
</p></div>';


        echo '<div class="phdr"><b>Тактика</b></div><div class="c">';
        echo '<form action="sostav.php?act=addtactics&amp;id=' . $ass['id'] .
            '" method="post">';
			

		echo '<b>Схема</b><br/>';




echo '<input type="radio" name="shema" value="4-3-3"';
if ($shema == "4-3-3")
{echo ' checked="checked"';}
echo '/> 4-3-3';

echo '<input type="radio" name="shema" value="3-4-3"';
if ($shema == "3-4-3")
{echo ' checked="checked"';}
echo '/> 3-4-3';

echo '<input type="radio" name="shema" value="2-5-3"';
if ($shema == "2-5-3")
{echo ' checked="checked"';}
echo '/> 2-5-3';

echo '<input type="radio" name="shema" value="5-3-2"';
if ($shema == "5-3-2")
{echo ' checked="checked"';}
echo '/> 5-3-2';

echo '<input type="radio" name="shema" value="4-4-2"';
if ($shema == "4-4-2")
{echo ' checked="checked"';}
echo '/> 4-4-2';

echo '<input type="radio" name="shema" value="3-5-2"';
if ($shema == "3-5-2")
{echo ' checked="checked"';}
echo '/> 3-5-2';

echo '<input type="radio" name="shema" value="6-3-1"';
if ($shema == "6-3-1")
{echo ' checked="checked"';}
echo '/> 6-3-1';

echo '<input type="radio" name="shema" value="5-4-1"';
if ($shema == "5-4-1")
{echo ' checked="checked"';}
echo '/> 5-4-1';

echo '<input type="radio" name="shema" value="4-5-1"';
if ($shema == "4-5-1")
{echo ' checked="checked"';}
echo '/> 4-5-1';	
			
			

echo '<br/><b>Пасы</b><br/>';

echo '<input type="radio" name="pas" value="0"';
if ($pass == "0")
{echo ' checked="checked"';}
echo '/> Смешанные';

echo '<input type="radio" name="pas" value="1"';
if ($pass == "1")
{echo ' checked="checked"';}
echo '/> Дальние';

echo '<input type="radio" name="pas" value="2"';
if ($pass == "2")
{echo ' checked="checked"';}
echo '/> Короткие';


echo '<br/><b>Стратегия</b><br/>';

echo '<input type="radio" name="strat" value="0"';
if ($strat == "0")
{echo ' checked="checked"';}
echo '/> Нормальная';

echo '<input type="radio" name="strat" value="1"';
if ($strat == "1")
{echo ' checked="checked"';}
echo '/> Дальние удары';

echo '<input type="radio" name="strat" value="2"';
if ($strat == "2")
{echo ' checked="checked"';}
echo '/> Техничная игра';

echo '<input type="radio" name="strat" value="3"';
if ($strat == "3")
{echo ' checked="checked"';}
echo '/> Игра в пас';


echo '<br/><b>Прессинг</b><br/>';

echo '<input type="radio" name="pres" value="0"';
if ($press == "0")
{echo ' checked="checked"';}
echo '/> Нет';

echo '<input type="radio" name="pres" value="1"';
if ($press == "1")
{echo ' checked="checked"';}
echo '/> Да';


echo '<br/><b>Тактика</b><br/>';

echo '<input type="radio" name="tactic" value="10"';
if ($tactics == "10")
{echo ' checked="checked"';}
echo '/> 10 Суперзащитная';

echo '<input type="radio" name="tactic" value="20"';
if ($tactics == "20")
{echo ' checked="checked"';}
echo '/> 20 Суперзащитная<br/>';

echo '<input type="radio" name="tactic" value="30"';
if ($tactics == "30")
{echo ' checked="checked"';}
echo '/> 30 Защитная';

echo '<input type="radio" name="tactic" value="40"';
if ($tactics == "40")
{echo ' checked="checked"';}
echo '/> 40 Защитная<br/>';

echo '<input type="radio" name="tactic" value="50"';
if ($tactics == "50")
{echo ' checked="checked"';}
echo '/> 50 Нормальная';

echo '<input type="radio" name="tactic" value="60"';
if ($tactics == "60")
{echo ' checked="checked"';}
echo '/> 60 Нормальная<br/>';

echo '<input type="radio" name="tactic" value="70"';
if ($tactics == "70")
{echo ' checked="checked"';}
echo '/> 70 Атакующая';

echo '<input type="radio" name="tactic" value="80"';
if ($tactics == "80")
{echo ' checked="checked"';}
echo '/> 80 Атакующая<br/>';

echo '<input type="radio" name="tactic" value="90"';
if ($tactics == "90")
{echo ' checked="checked"';}
echo '/> 90 Суператакующая';

echo '<input type="radio" name="tactic" value="100"';
if ($tactics == "100")
{echo ' checked="checked"';}
echo '/> 100 Суператакующая<br/>';			
			
        echo "<p align='center'><input type='submit' title='Нажмите для отправки' name='submit' value='Изменить'/></p></form></div>";

        require_once ("incfiles/end.php");
        exit;

} else {
    header('location: index.php');
}

require_once ("incfiles/end.php");
?>