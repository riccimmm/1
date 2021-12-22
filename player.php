<?php

define('_IN_JOHNCMS', 1);

$textl = 'Игрок';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ('incfiles/class_upload.php');
require_once ("incfiles/manag2.php");

require_once ("incfiles/manager_func.php");

$id = intval(trim($id));
$q = mysql_query("select * from `player_2` where id='" . $id . "';");
if (!mysql_num_rows($q)) {
    echo "Игрока не существует<br/>";
    require_once ("incfiles/end.php");
    exit;
}
$arr = mysql_fetch_array($q);
$kk = mysql_query("select * from `team_2` where id='" . $arr[kom] . "';");
$kom = mysql_fetch_array($kk);



switch ($act) {


    default:

        echo '<div class="phdr" style="text-align:center;"><b>' . $arr['name'] . '</b></div>';
        echo '<div class="list1" style="text-align:center;"><p align="left">';

if (file_exists(('foto/' . $arr['id'] . '_big.png')))
		echo '<center><img src="foto/' . $arr['id'] . '_big.png" alt=""/></center>';
else
echo '<center><img src="foto/nofoto_big.jpeg" alt=""/></center>';
		

	
	

	      if ($kom['id_admin'] == $user_id || $rights > 7) { 
	echo '<table  id="example" >';
echo '<tr>';

            
            if ($arr['arend'] == 0) {

                if ($arr['money_2'] == 0) {
                    echo '<td><a href="transfer.php?act=money&amp;id=' . $arr['id'] .
                        '">Выставить на трансфер</a></td>';
                } else {
                    echo '<td><a href="player.php?act=del&amp;id=' . $arr['id'] . '">Снять с трансфера</a></td>';
                }

                echo '<td><a href="player.php?act=sell&amp;id=' . $arr['id'] . '">Продать за полцены</a></td>';
            }
            
    if ($rights >= 7)
{
			 echo '<td><a href="player.php?act=up_photo&amp;id=' . $arr['id'] . '">Изменить фото</a></td>';
			 }
            echo '<td><a href="player.php?act=nomer&amp;id=' . $arr['id'] . '">Изменить номер</a></td>';
      
echo '</tr>';		
echo '</table>';		
		  }
		
		
		

        echo '</p></div>';
$mast = $arr[otbor] + $arr[opeka] + $arr[drib] + $arr[priem] + $arr[vonos] + $arr[pas] +
            $arr[sila] + $arr[tocnost];
			
		//echo '<table align="left">';
echo '<left><table  id="example" cellspacing="1" cellpadding="4"><tr align="center" ></tr>';
echo '<tr align="left" class="whiteheader"><td colspan="2"><b>Мастерство: ' . $mast . '</b></td></tr>';	



echo '<tr bgcolor="f3f3f3"><td>Отбор:</td><td width="40px" align="right"><b>' . $arr[otbor] . '</b></td></tr>
<tr bgcolor="ffffff"><td>Опека:</td><td align="right"><b>' . $arr[opeka] . '</b></td></tr>
<tr bgcolor="f3f3f3"><td>Дриблинг:</td><td align="right"><b>' . $arr[drib] . '</b></td></tr>
<tr bgcolor="ffffff"><td>Прием мяча:</td><td align="right"><b>' . $arr[priem] . '</b></td></tr>
<tr bgcolor="f3f3f3"><td>Выносливость:</td><td align="right"><b>' . $arr[vonos] . '</b></td></tr>
<tr bgcolor="ffffff"><td>Пас:</td><td align="right"><b>' . $arr[pas] . '</b></td></tr>
<tr bgcolor="f3f3f3"><td>Сила удара:</td><td align="right"><b>' . $arr[sila] . '</b></td></tr>
<tr bgcolor="ffffff"><td>Точность удара:</td><td align="right"><b>' . $arr[tocnost] . '</b></td></tr>
';
//echo '<b>Мастерство: ' . $mast . '</b>';
/*
echo '<b>Мастерство: ' . $mast . '</b><br/>
Отбор:<b>' . $arr[otbor] . '</b><br/>
Опека:<b>' . $arr[opeka] . '</b><br/>
Дриблинг:<b>' . $arr[drib] . '</b><br/>
Прием мяча:<b>' . $arr[priem] . '</b><br/>
Выносливость:<b>' . $arr[vonos] . '</b><br/>
Пас:<b>' . $arr[pas] . '</b><br/>
Сила удара:<b>' . $arr[sila] . '</b><br/>
Точность удара:<b>' . $arr[tocnost] . '</b>';
*/

echo '</table>';

		$nominal = $arr[mas] * 10 * $arr[tal];
		$nominal2 = $mast * 10 * $arr[tal];	

		
		

echo '<left><table  id="example" cellspacing="1" cellpadding="4"><tr align="center" ></tr>';
echo '<tr align="left" class="whiteheader"><td colspan="2"><b>Характеристика</b></td></tr>';	

echo '
<tr bgcolor="f3f3f3"><td>Номер:</td><td align="right"><b>' . $arr[nomer] . '</b></td></tr>
<tr bgcolor="ffffff"><td>Страна:</td><td align="right"><img src="flag/' . $arr[strana] . '.png" alt=""/></td></tr>
<tr bgcolor="f3f3f3"><td>Возраст:</td><td align="right"><b>' . $arr[voz] . '</b></td></tr>
<tr bgcolor="ffffff"><td>Позиция:</td><td align="right"><b>' . $arr[poz] . '</b></td></tr>
<tr bgcolor="f3f3f3"><td>Физготовность:</td><td align="right"><b>' . $arr[fiz] . '%</b></td></tr>
<tr bgcolor="ffffff"><td>Мораль:</td><td align="right"><b>' . $arr[mor] . '</b></td></tr>
<tr bgcolor="f3f3f3"><td>Талант:</td><td align="right"><b>' . $arr[tal] . '</b></td></tr>
<tr bgcolor="ffffff"><td>Роль:</td><td align="right"><b>Без роли</b></td></tr>
<tr bgcolor="f3f3f3"><td>Команда:</td><td align="right"><a href="team.php?id=' . $kom['id'] . '">' . $kom[name] .' [' .$kom[lvl].']</a></td></tr>
<tr bgcolor="ffffff"><td>Менеджер:</td><td align="right"><a href="'.$home.'/str/anketa.php?id='.$kom[id_admin].'">' . $kom[name_admin] . '</a></td></tr>
<tr bgcolor="f3f3f3"><td>Цена:</td><td align="right"><b>' . nominal($arr[voz], $nominal2) .' €</b></td></tr>
<tr bgcolor="ffffff"><td>Голы:</td><td align="right"><b>' . $arr[goal] . '</b></td></tr>

</table>';
/*
        if ($arr['btime'] != 0 || $arr['utime'] != 0) {
            if ($arr['btime'] != 0)
                $travma1 = round(($arr['btime'] - $realtime) / 3600);
            if ($arr['utime'] != 0)
                $travma2 = round(($arr['utime'] - $realtime) / 3600);
            $travma = $travma1 + $travma2;
        } else {
            $travma = '0';
        }        
        */


//echo '</table>';				
			
		
        if ($arr['arend'] != '0') {
            $rea = mysql_query("select `time`, `team_id1` from `arenda_2` where player_id='" .
                $id . "' AND sost = 'yes' AND
		obm = '0' AND time < '" . $realtime . "' LIMIT 1;");
            if (mysql_num_rows($rea)) {
                $rep = mysql_fetch_array($rea);
                echo 'В аренде до: <b>(' . date("d.m.y / H:i", $rep['time']) . ')</b><br/>';
                if ($rep['time'] < $realtime) {
                    mysql_query("update `player_2` set `kom` = '" . $rep['team_id1'] .
                        "', `sostav`='0', `arend` = '0' WHERE   id='" . $id . "'  LIMIT 1;");
                    mysql_query("update `arenda_` set  `obm` = '1' WHERE   player_id='" . $id .
                        "'  LIMIT 1;");
                }
            }
        }
		  $req = mysql_query("SELECT * FROM `player_2` where `kom`='" . $kom[id] .
            "'  order by line asc;");


       if ($arr['t_money'] != 0) {
            echo '<div class="c"><p>';
            echo '<a href="transfer.php?act=buy&amp;id=' . $arr[id] .
                '"><font color="red"><b>Купить игрока</b></font></a><br/>';
            echo '</p></div>';
        }
    
        break;

    case 'up_photo':
	    if ($rights >= 7)
{
	        if ($kom[id] != $datauser[manager2]) {
            echo '<div class="c">Вы не можете изменить фото не своего игрока</div>';
            require_once ("incfiles/end.php");
            exit;
        }
	header("Content-type:text/html; charset=UTF-8");
        echo '<div class="phdr"><b>Выгружаем фото</b></div>';
        if ($kom['id_admin'] == $user_id || $rights > 7) {
if (isset ($_POST['submit'])) {
            $handle = new upload($_FILES['image']);
            if ($handle->uploaded) {
                // Обрабатываем крупную картинку
                $handle->file_new_name_body = $id . '_big';
                $handle->allowed = array('image/jpeg', 'image/gif', 'image/png');
                $handle->file_max_size = 1024 * $flsz;
                $handle->file_overwrite = true;
                $handle->image_resize = true;
                $handle->image_x = 100;
                $handle->image_y = 130;
                $handle->image_convert = 'png';
                $handle->process('foto/');
                if ($handle->processed) {
                    // Обрабатываем мелкую картинку
                    $handle->file_new_name_body = $id . '_small';
                    $handle->file_overwrite = true;
                    $handle->image_resize = true;
                    $handle->image_x = 20;
                    $handle->image_y = 25;
                    $handle->image_convert = 'png';
                    $handle->process('foto/');
                    if ($handle->processed) {
                        @mysql_query("UPDATE `player_2` SET `photo` = 'yes' WHERE `id` = '$id';");
                        echo '<div class="rmenu"><p style="text-align:center;"><img src="manag/foto/' . $id . '_big.png" alt="" /><br />Фотография загружена<br /><br /><a href="player.php?id=' . $id . '" class="button">Продолжить</a></p></div>';
                      
                    } else {
                        echo display_error($handle->error);
                    }
                } else {
                    echo display_error($handle->error);
                }
                $handle->clean();
            }
        } else {
            echo '<form enctype="multipart/form-data" method="post" action=""player.php?act=up_photo&amp;id=' .
                    $id . '"><div class="menu"><p>';
            echo 'Выберите изображение:<br /><input type="file" name="image" value="" />';
            echo '<input type="hidden" name="MAX_FILE_SIZE" value="' . (1024 * $flsz) . '" />';
            echo '</p><p><input type="submit" name="submit" value="Выгрузить" />';
            echo '</p></div></form>';
            }
        }
}else{echo'<div class="c">Запрешено!</div>';}
        break;


    case 'dell':
        /* Удаляю игрока из комад в агент */
		if ($total < 15) {
            echo 'Минимальное количество игроков <b>15</b>';
            require_once ("incfiles/end.php");
            exit;
        }
        if ($rights < 8) {
            header('Location: index.php');
            exit;
        }
        $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `player_2` where kom='" .
            $arr['kom'] . "'"), 0);


        if ($arr['arend'] != 0) {
            echo 'Игрок находиться в аренде';
            require_once ("incfiles/end.php");
            exit;
        }
        $money = $kom['money'] + round($arr['money'] / 3);
        mysql_query("update `player_2` set `kom`='' where id='" . $id . "';");
        mysql_query("insert into `agent_2` set 
`time`='" . $realtime . "',
`player_id`='" . $id . "',
`player_name`='" . $arr[name] . "', 
`strana`='" . $arr[strana] . "', 
`nomer`='" . $arr[nomer] . "', 
`poz`='" . $arr[poz] . "', 
`line`='" . $arr[line] . "', 
`voz`='" . $arr[voz] . "', 
`tal`='" . $arr[tal] . "', 
`mas`='" . $arr[mas] . "', 
`money`='" . $arr[money] . "';");


        header("location: team.php?id=$arr[kom]");
        break;

    case 'sell':
        /* Уволить игрока */
        if ($kom[id] != $datauser[manager2]) {
            echo '<div class="c">Вы не можете продать не своего игрока</div>';
            require_once ("incfiles/end.php");
            exit;
        }

        if ($arr[t_time] != 0) {
            echo '<div class="rmenu">Этот игрок на трансфере. Пожалуйста сначала снимите с трансфера. <br /><br /> <a href="player.php?act=del&amp;id=' . $arr['id'] . '" class="redbutton" style="text-align:center;">Снять с трансфера</a></div>';
            require_once ("incfiles/end.php");
            exit;
        }

        if ($arr['arend'] != 0) {
            echo '<div class="c">Игрок находиться в аренде</div>';
            require_once ("incfiles/end.php");
            exit;
        }
$mast = $arr[otbor] + $arr[opeka] + $arr[drib] + $arr[priem] + $arr[vonos] + $arr[pas] +
            $arr[sila] + $arr[tocnost];


        $nom = $mast * 10 * $arr[tal];
        $nominal = nominal($arr[voz], $nom);
        $polovina = round($nominal / 2);

        if (isset($_GET['yes'])) {
            $req = mysql_query("SELECT * FROM `player_2` where `kom`='" . $kom[id] . "';");
            $totalplayer = mysql_num_rows($req);

            if ($totalplayer <= 16) {
                echo '<div class="c">В команде должно оставаться минимум 16 игроков</div>';
                require_once ("incfiles/end.php");
                exit;
            }

            $summa = $kom[money] + $polovina;
            mysql_query("update `team_2` set `money`='" . $summa . "' where id = '" . $kom[id] .
                "' LIMIT 1;");
            mysql_query("update `player_2` set `kom`='' where id='" . $id . "';");

            mysql_query("insert into `agent_2` set 
`time`='" . $realtime . "',
`player_id`='" . $id . "',
`player_name`='" . $arr[name] . "', 
`strana`='" . $arr[strana] . "', 
`nomer`='" . $arr[nomer] . "', 
`poz`='" . $arr[poz] . "', 
`line`='" . $arr[line] . "', 
`voz`='" . $arr[voz] . "', 
`tal`='" . $arr[tal] . "', 
`mas`='" . $arr[mas] . "', 
`money`='" . $arr[money] . "';");

            header('location: team.php?id=' . $arr[kom]);
            exit;
        }

        echo '<div class="phdr"><b>Продать за полцены</b></div>';
        echo '<div class="c">';
        echo 'Игрок: <b>' . $arr[name] . '</b><br/>';
        echo 'Цена: <b>' . $polovina . ' €</b><br/><br/>';

        echo '<a href="player.php?act=sell&amp;id=' . $arr[id] .
            '&amp;yes" class="redbutton"><b>Продать</b></a><br/>';

        echo '</div>';
        break;

    case 'nomer':
        /* Изменяю номер */
        if ($kom[id] != $datauser[manager2]) {
            echo '<div class="c">Вы не можете изменить номер не свому игроку</div>';
            require_once ("incfiles/end.php");
            exit;
        }

        if (isset($_POST['submit'])) {
            $nomer = intval($_POST['nomer']);

            $p = @mysql_query("select * from `player_2` where kom='" . $datauser[manager2] .
                "' AND nomer='" . $nomer . "';");
            $totalplayer = mysql_num_rows($p);

            if ($totalplayer != 0) {
                echo '<div class="c">Номер ' . $nomer . ' уже занят</div>';
                require_once ("incfiles/end.php");
                exit;
            }


            if ($nomer >= 1 && $nomer <= 99) {
                mysql_query("update `player_2` set `nomer`='" . $nomer . "' where id='" . $arr[id] .
                    "' LIMIT 1;");
            } else {
                echo '<div class="c">Номер должен быть от 1 до 99</div>';
                require_once ("incfiles/end.php");
                exit;
            }

            header('location: player.php?id=' . $arr[id]);
        } else {
            echo '<div class="gmenu"><b>Номер</b></div>';
            echo '<div class="c">';
            echo '<form action="player.php?act=nomer&amp;id=' . $arr[id] .
                '" method="post">';
            echo '<input type="text" name="nomer" size="3" value="' . $arr[nomer] . '"/>&nbsp;&nbsp;';
            echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Изменить'/></form>";
            echo '</div>';
        }
        break;

    case 'arenda':
        /* Аренда */

        if ($lvl <= 1) {
            echo display_error('У вас не достаточно высок уровень чтоб арендовать игрока, вам необходимо набрать уровень [2]. Ваш текущий уровень [' . $lvl . ']');
            require_once ("incfiles/end.php");
            exit;
        }
        $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `player_2` where kom='" .
            $arr['kom'] . "'"), 0);
            
        if ($arr['arend'] != 0) {
            echo display_error('Игрок находиться в аренде');
            require_once ("incfiles/end.php");
            exit;
        }
        $colm_team = mysql_result(mysql_query("SELECT COUNT(*) FROM `arenda_2` where team_id2='" .
            $datauser['manager2'] . "' and player_id = '" . $id . "' AND `sost` = '' "), 0);

        if ($colm_team != 0) {
            echo display_error('Заявка уже подана');
            require_once ("incfiles/end.php");
            exit;
        }
        if ($kom['id_admin'] != $user_id || $rights > 7) {
            echo '<div class="c">';
            echo '<div class="phdr">Игрок в аренду: <b>' . $arr['name'] . '</b></div>';
            
            echo '<form action="player.php?act=addplay&amp;id=' . $id . '" method="post">';
            echo '<table>';
            echo '<tr><td><b>Время</b><br/><small>(укажите число в днях)</small></td> <td align="right"><input size="7" type="text" name="time"  value=""/></td></tr>';
            
            echo '<tr><td><b>Денег</b><br/><small>(укажите число в €)</small></td> <td align="right"><input size="7" type="text" name="money" value="" /></td></tr>';
            
            echo '</table>';
            echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Здать в аренду'/></form></div>";
        }
        break;

    case 'addplay':
        /* Аренда */
        if ($kom['id_admin'] != $user_id || $rights > 7) {
            $time = trim($_POST['time']);
            $money = trim($_POST['money']);
            $timeval = $time * 86400;

            if (empty($time) || empty($money))
                $error = 'Отсутствуют необходимые данные';
            if (!$error) {
                // Заносим в базу
                mysql_query("INSERT INTO `arenda_2` SET  
`time`= '" . ($realtime + $timeval) . "', 
`player_id`='" . $id . "',
`team_id2`='" . $datauser[manager2] . "', 
`team_id1`='" . $arr[kom] . "',
`money`='" . $money . "' ;");

                header('location: team.php?id=' . $arr[kom] . '"');
            } else {
                echo display_error($error);
            }
        }
        break;

    case 'del':

        $total = mysql_num_rows($q);

        if ($total == 0) {
            echo display_error('Трансфер не существует');
            require_once ("incfiles/end.php");
            exit;
        }

        if ($arr[kom] != $datauser[manager2]) {
            echo display_error('Вы не можете снять не своего игрока');
            require_once ("incfiles/end.php");
            exit;
        }
		
		

        // Редачим игрока
        mysql_query("update `player_2` set `t_time`= '', `t_money`= '' where id='" . $arr[id] .
            "' LIMIT 1;");


        header('Location: team.php?id=' . $datauser['manager2']);
        break;


}

echo '<div class="c">
<a href="'.$home.'/team.php?id=' . $kom['id'] .'" class="button">Вернуться</a></div>';
require_once ("incfiles/end.php");

?>