<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

$req = mysql_query("SELECT * FROM `tournaments_2` where `id`='" . $id .
    "' order by id asc;");
$k = mysql_fetch_array($req);
$total = mysql_num_rows($req);

if ($total == 0) {
    echo "Турнира не существует<br/>";
    require_once ("incfiles/end.php");
    exit;
}
$textl = $k['name'];
require_once ("incfiles/head.php");
require_once ("incfiles/manag2.php");

$level = explode('|', $k['max_lvl']);
if (!empty($datauser['manager2'])) {
    switch ($act) {


			


        case 'say':
            /* Подаю заявку */



            if ($lvl < $level[0] || $lvl > $level[1]) {
                echo display_error('Вы не можете участвовать в этом турнире из-за ограничения по уровню');
                require_once ('incfiles/end.php');
                exit;
            }




            $u = mysql_query("SELECT `name_team` FROM `start_2` where  `id_team`= '" . $datauser[manager2] . "' and `chemp`='" . $k['name'] . "' ;");
            $total = mysql_num_rows($u);

            if ($total != 0) {
                echo display_error('Вы уже подали заявку!');
                require_once ("incfiles/end.php");
                exit;
            } else {

                mysql_query("INSERT INTO `start_2` set `chemp`='" . $k['name'] . "',`id_team`='" .
                    $fid . "',`name_team`='" . $names . "' ;");
                header("location: cup.php?id=$id");
            }

            break;

        case 'del':
            if (isset($_POST['submit'])) {
                mysql_query("DELETE FROM `start_2` WHERE `id_team` = '" . $fid . "' LIMIT 1;");
                mysql_query("OPTIMIZE TABLE `start_2`;");

                header("location: cup.php?id=$id");
            } else {
                echo '<div class="phdr"><b><a href="cup.php">Кубок</a></b> | удалить заявку</div>';
                echo '<div class="rmenu"><p>Внимание!<br/>Вы действительно хотите забрать заявку ?';
                echo '</p><p><form action="cup.php?act=del&amp;id=' . $id .
                    '" method="post"><input type="submit" name="submit" value="Удалить" /></form>';
                echo '</p></div>';
                echo '<div class="phdr"><a href="cup.php?id=' . $id . '">К кубкам</a></div>';
            }
            break;

        default:
            if ($k['on'] == '1') {
                echo '<div class="gmenu"><center>' . $k['name'] . ' ' . date("d.m / H:i", $k['time']) .
                    '</center></div>';
                echo '<div class="c"><center><img src="img/' . $k['path'] .
                    '.jpg" alt=""/></center></div>';

                $q1 = mysql_query("SELECT * FROM `start_2` WHERE `chemp`='" . $k['name'] . "' ");
                $krr = mysql_fetch_array($q1);
                $total = mysql_num_rows($q1);
                //туры
                
if ($total == '8' && $krr['tur'] == '2' || $total == '4' && $krr['tur'] == '3' ||$total == '2' && $krr['tur'] == '4') {
                    
                    $tur = $krr['tur'];
                    $time = $realtime + 150;
                    $a = null;
                    $rows = mysql_query('SELECT `team_2`.`id` AS `tid`, `team_2`.`name` AS `tname` FROM `start_2` LEFT JOIN `team_2` ON (`team_2`.`name` = `start_2`.`name_team`) WHERE `start_2`.`chemp` = \'' .
                        $k['name'] . '\' ');
                    while ($row = mysql_fetch_array($rows)) {
                        $a[] = array($row['tid'], $row['tname']);
                    }

                    shuffle($a);

                    $first = true;
                    foreach ($a as & $item) {
                        if ($first) {
                            $f_id = $item[0];
                            $f_name = $item[1];
                            $first = false;
                        } else {
                            mysql_query('INSERT INTO `tur_2` set  
                `time` = \'' . $time . '\',
                `tur`=\'' . $tur . '\',  
                `chemp`=\'' . $k['name'] . '\',  
                `id_team1` = \'' . $f_id . '\',  
                `name_team1` = \'' . $f_name . '\',  
                `id_team2` = \'' . $item[0] . '\',  
                `name_team2` = \'' . $item[1] . '\' 
            ;');

                            $f_id = null;
                            $f_name = null;

                            $first = true;
                        }
                    }
                    mysql_query("DELETE FROM `start_2` WHERE `chemp`='" . $k['name'] . "' ;");
                }


                // 1/8
                $req = mysql_query("SELECT * from `tur_2` WHERE `chemp`='" . $k['name'] .
                    "' AND `tur`= '1' ;");
                $total = mysql_num_rows($req);
                if ($total != 0) {
                    echo '<div class="bmenu"><center>1/8 Финала</center></div>';

                    echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">';
                    while ($arr = mysql_fetch_array($req)) {
                        echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("d.m/H:i", $arr['time']) . '</td>';
                        echo '<td>';


                        echo '<a href="team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b>';
                        } else {
                            echo '' . $arr[name_team1] . '';
                        }


                        echo '</a>  - ';
                        echo '<a href="team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b>';
                        } else {
                            echo '' . $arr[name_team2] . '';
                        }

                        echo '</a> </td>';


                        echo '<td width="10%" align="center">';

                        if ($arr[rez1] != '—' || $arr[rez2] != '—' || $arr[rez1] == '0' || $arr[rez2] ==
                            '0') {
                            echo ' <a href="trans.php?id=' . $arr[id] . '"><font color="green"><b>' .
                                $arr[rez1] . ':' . $arr[rez2] . '</b>';
                            if ($arr[rez1] == $arr[rez2]) {
                                echo ' (п. ' . $arr[pen1] . ':' . $arr[pen2] . ')';
                            }
                            echo '</font></a>';
                        } else {
                            echo ' <a href="trans.php?id=' . $arr[id] .
                                '"><font color="green"><b>?:?</b></font></a>';
                        }

                        echo '</td></tr>';


                        ++$i;

                    }
                    echo '</table>';

                }

                // 1/4
                $req = mysql_query("SELECT * from `tur_2` WHERE `chemp`='" . $k['name'] .
                    "' AND `tur`= '2' ;");
                $total = mysql_num_rows($req);
                if ($total != 0) {
                    echo '<div class="bmenu"><center>1/4 Финала</center></div>';

                    echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">';
                    while ($arr = mysql_fetch_array($req)) {
                        echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("d.m/H:i", $arr['time']) . '</td>';
                        echo '<td>';


                        echo '<a href="team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b>';
                        } else {
                            echo '' . $arr[name_team1] . '';
                        }


                        echo '</a>  - ';
                        echo '<a href="team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b>';
                        } else {
                            echo '' . $arr[name_team2] . '';
                        }

                        echo '</a> </td>';


                        echo '<td width="10%" align="center">';

                        if ($arr[rez1] != '—' || $arr[rez2] != '—' || $arr[rez1] == '0' || $arr[rez2] ==
                            '0') {
                            echo ' <a href="trans.php?id=' . $arr[id] . '"><font color="green"><b>' .
                                $arr[rez1] . ':' . $arr[rez2] . '</b>';
                            if ($arr[rez1] == $arr[rez2]) {
                                echo ' (п. ' . $arr[pen1] . ':' . $arr[pen2] . ')';
                            }
                            echo '</font></a>';
                        } else {
                            echo ' <a href="trans.php?id=' . $arr[id] .
                                '"><font color="green"><b>?:?</b></font></a>';
                        }

                        echo '</td></tr>';


                        ++$i;

                    }
                    echo '</table>';

                }
                // 1/2
                $req = mysql_query("SELECT * from `tur_2` WHERE `chemp`='" . $k['name'] .
                    "' AND `tur`= '3' ;");
                $total = mysql_num_rows($req);
                if ($total != 0) {
                    echo '<div class="bmenu"><center>1/2 Финала</center></div>';

                    echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">';
                    while ($arr = mysql_fetch_array($req)) {
                        echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("d.m/H:i", $arr['time']) . '</td>';
                        echo '<td>';


                        echo '<a href="team.php?id=' . $arr['id_team1'] . '">';


                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b>';
                        } else {
                            echo '' . $arr[name_team1] . '';
                        }


                        echo '</a>  - ';
                        echo '<a href="team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b>';
                        } else {
                            echo '' . $arr[name_team2] . '';
                        }

                        echo '</a> </td>';


                        echo '<td width="10%" align="center">';

                        if ($arr[rez1] != '—' || $arr[rez2] != '—' || $arr[rez1] == '0' || $arr[rez2] ==
                            '0') {
                            echo ' <a href="trans.php?id=' . $arr[id] . '"><font color="green"><b>' .
                                $arr[rez1] . ':' . $arr[rez2] . '</b>';
                            if ($arr[rez1] == $arr[rez2]) {
                                echo ' (п. ' . $arr[pen1] . ':' . $arr[pen2] . ')';
                            }
                            echo '</font></a>';
                        } else {
                            echo ' <a href="trans.php?id=' . $arr[id] .
                                '"><font color="green"><b>?:?</b></font></a>';
                        }

                        echo '</td></tr>';


                        ++$i;

                    }
                    echo '</table>';
                }

                // 1/1
                $req = mysql_query("SELECT * from `tur_2` WHERE `chemp`='" . $k['name'] .
                    "' AND `tur`= '4' ;");
                $total = mysql_num_rows($req);
                if ($total != 0) {
                    echo '<div class="bmenu"><center>Финал</center></div>';

                    echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">';
                    while ($arr = mysql_fetch_array($req)) {
                        echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';
                        echo '<td width="15%" align="center">' . date("d.m/H:i", $arr['time']) . '</td>';
                        echo '<td>';


                        echo '<a href="team.php?id=' . $arr['id_team1'] . '">';

 $time = $arr[time];
                        if ($arr[rez1] > $arr[rez2]) {
                            echo '<b>' . $arr[name_team1] . '</b>';
                        } else {
                            echo '' . $arr[name_team1] . '';
                        }


                        echo '</a>  - ';
                        echo '<a href="team.php?id=' . $arr['id_team2'] . '">';

                        if ($arr[rez2] > $arr[rez1]) {
                            echo '<b>' . $arr[name_team2] . '</b>';
                        } else {
                            echo '' . $arr[name_team2] . '';
                        }

                        echo '</a> </td>';


                        // Кто победил?
                        if ($arr[rez1] > $arr[rez2] || $arr[pen1] > $arr[pen2]) {
                            $id_win_1 = $arr['id_team1'];
                            $name_win_1 = $arr['name_team1'];
                        } else {
                            $id_win_1 = $arr['id_team2'];
                            $name_win_1 = $arr['name_team2'];
                        }

                        echo '<td width="10%" align="center">';

                        if ($arr[rez1] != '—' || $arr[rez2] != '—' || $arr[rez1] == '0' || $arr[rez2] ==
                            '0') {
                            if ($k[status] == 0) {
                                mysql_query("update `tournaments_2` set  `status`='1', `time`='$realtime' where id='" . $id . "' LIMIT 1;");
									
								mysql_query("insert into `priz_2` set 
`id_cup`='".$k[id]."', 
`time`='".$k[time]."', 
`name`='".$k[name]."',
`logo`='".$k[logo]."',
`priz`='".$k[priz]."',
`win`='".$id_win_1."',
`url`='cup.php?id=".$id."'
;");	

                                $text = 'Команда <a href="team.php?id=' . $id_win_1 . '">' . $name_win_1 .
                                    '</a>  стала владельцем кубка - ' . $k[name] . '';
                                mysql_query("insert into `m2_history` set 
                    `time`='" . $realtime . "', 
                    `type`='cup',
                    `text`='" . $text . "' ;");

$opcup=rand(15,25);

                                $q1 = mysql_query("select * from `team_2` where id='" . $id_win_1 .
                                    "' LIMIT 1;");
                                $winkom = mysql_fetch_array($q1);

                                $oput = $winkom[rate] + $opcup;
                                $money = $winkom[money] + $k[priz];

                                $kfcup = round($k[priz] / 100);
                                $fans = $winkom[fan] + (2 * $kfcup);
                                $slava = $winkom[slava]+(1*$kfcup);
                                mysql_query("update `team_2` set `rate`='" . $oput . "', `money`='" . $money .
                                    "', `fan`='" . $fans . "', `slava`='".$slava."' where id='" . $winkom[id] . "' LIMIT 1;");

                            }


                            echo ' <a href="trans.php?id=' . $arr[id] . '"><font color="green"><b>' .
                                $arr[rez1] . ':' . $arr[rez2] . '</b>';
                            if ($arr[rez1] == $arr[rez2]) {
                                echo ' (п. ' . $arr[pen1] . ':' . $arr[pen2] . ')';
                            }
                            echo '</font></a>';
							
																	//Рестар кубка
                    if ($time + 2* 3600 < time()) {
                        mysql_query("DELETE FROM `start_2` WHERE   `chemp`='" . $k['name'] . "';");
                        mysql_query("DELETE FROM `tur_2` WHERE `chemp`='" . $k['name'] . "' ; ");

                        $time = time() + 1800;
                        mysql_query("update `tournaments_2` set `time`='" . $time ."',`on` = '0', `status`='0' where `name`='" . $k['name'] . "' ; ");
echo 'a';
                    }
							
							
                        } else {
                            echo ' <a href="trans.php?id=' . $arr[id] .
                                '"><font color="green"><b>?:?</b></font></a>';
                        }

                        echo '</td></tr>';


                        ++$i;

                    }
                    echo '</table>';
                }
            } else {
			
                echo '<div class="menu"><center><img src="img/' . $k['path'] . '.jpg" alt=""/></center></div>';
					
		


//Закрытый турнир
$q1 = mysql_query("select * from `tournaments_2` WHERE `liga`='" . $k[liga] ."' ORDER by `status` DESC, `id` DESC LIMIT 1;");	
$q11 = mysql_fetch_array($q1);


//Второй турнир
$q2 = mysql_query("select * from `tournaments_2` WHERE `liga`='" . $k[liga] ."' AND `status`!='1' ORDER by `id`,`status` DESC LIMIT 1;");	
$q22 = mysql_fetch_array($q2);
       		
       		
//Заявка на участие       		
$q = mysql_query("select * from `start_2` where `name_team`='" . $names ."';");
       		

if($lvl >= $level[0] || $lvl <= $level[1]){
		
$time_start = $q22[time];
$tt = ($time_start + 1800) -$realtime;


		if (!mysql_num_rows($q)) {
                echo '<div class="menu"><p align="center"><a class="button" href="cup.php?act=say&amp;id=' . $id .
                    '">Подать заявку</a></p></div>';
		}

	}
	if ($q11[time]>$realtime - 1800)
		{
	if(mysql_num_rows($q) == 0 && $id == $q22[id]){
	       echo '<div class="menu"><p align="center">До начала осталось: ' . date("i:s", $tt) . '</p></div>';
		
		}
	}

$q47 = mysql_query("select * from `start_2` where `name_team`='" . $names ."' and `chemp`='" . $k['name'] . "'  ;");

		if (mysql_num_rows($q47)) {
    echo '<div class="menu"><center><a href = "cup.php?act=del&amp;id=' . $id . '" class="redbutton">Забрать заявку</a></center></div>';
		}



                $q = mysql_query("select * from `start_2` where `chemp`='" . $k['name'] ."';");
                $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `start_2` WHERE `chemp`='" .
                    $k['name'] . "' "), 0);

//echo "22 - $q22[name] 11 - $q11[name]";
                echo '<br/><div class="bmenu">Заявку на участие в турнире подали следующие комманды</div>';
                echo '<div class="menu">';
                while ($arr = mysql_fetch_array($q)) {

                    echo '<a href="team.php?id=' . $arr['id_team'] . '">' . $arr['name_team'] . '</a>, ';

                    ++$i;
                }
                echo '</div>';
                echo '<div class="phdr">Всего: ' . $total . '</div><br/>';
                /* начало */
                if ($total >= 16 && $realtime > $k['time'] ) {
                    mysql_query("update `tournaments_2` set `on` = '1' where `name`='" . $k['name'] ."' ;");

                    $a = null;
                    $rows = mysql_query('SELECT `team_2`.`id` AS `tid`, `team_2`.`name` AS `tname` FROM `start_2` LEFT JOIN `team_2` ON (`team_2`.`name` = `start_2`.`name_team`) WHERE `start_2`.`chemp` = \'' .
                        $k['name'] . '\'  LIMIT 16');
                    while ($row = mysql_fetch_array($rows)) {
                        $a[] = array($row['tid'], $row['tname']);
                    }

                    shuffle($a);

                    $first = true;
                    foreach ($a as & $item) {
                        if ($first) {
                            $f_id = $item[0];
                            $f_name = $item[1];
                            $first = false;
                        } else {
                            mysql_query('INSERT INTO `tur_2` set  
                `time` = \'' . $realtime . '\',  
                `tur`=\'1\',  
                `chemp`=\'' . $k['name'] . '\',  
                `id_team1` = \'' . $f_id . '\',  
                `name_team1` = \'' . $f_name . '\',  
                `id_team2` = \'' . $item[0] . '\',  
                `name_team2` = \'' . $item[1] . '\' 
            ;');

                            $f_id = null;
                            $f_name = null;

                            $first = true;
                        }
                    }

mysql_query("DELETE FROM `start_2` WHERE   `chemp`='" . $k['name'] ."' AND `tur`='0';");
                }
            }



            break;
    }


}
echo '<br/><a href="tournaments.php" class="button">Вернуться</a><br/><br/>';
require_once ("incfiles/end.php");
?>
