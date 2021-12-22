<?php
define('_IN_JOHNCMS', 1);
$headmod = 'manager';
$rootpath = '../../';
require_once ("../../incfiles/core.php");


$cup = isset ($_REQUEST['cup']) ? abs(intval($_REQUEST['cup'])) : false;

$req = mysql_query("SELECT * FROM `r_union_cup` where `id`='" . $cup ."' LIMIT 1;");
$k = mysql_fetch_array($req);
$total = mysql_num_rows($req);



$reqq = mysql_query("SELECT * FROM `team_2` where `id`='" . $datauser[manager2] ."' AND `union`='$id' LIMIT 1;");
$uch = mysql_num_rows($reqq);

if ( $rights < 7){
if ($uch == 0) {
require_once ("../../incfiles/head.php");
	echo '<div class="rmenu">';    
    echo "Вы не учасник союза и не можете просматривать кубки!</div>";
    require_once ("../../incfiles/end.php");
    exit;
}
}

if ($total == 0) {
require_once ("../../incfiles/head.php");
    echo "Турнира не существует<br/>";
    require_once ("../../incfiles/end.php");
    exit;
}
$textl = $k['name'];
require_once ("../../incfiles/head.php");


if (!empty($datauser['manager2'])) {
    switch ($act) {

        case 'restart':
            mysql_query("DELETE FROM `union_bilet` WHERE   `chemp`='" . $k['id'] . "';");
            mysql_query("DELETE FROM `game_2` WHERE   `chemp`='" . $k['id'] . "';");
            mysql_query("update `r_union_cup` set `time` = '$realtime', `status`='0' where `id`='" . $k['id'] . "' ; ");
			header('location: cup.php?id='.$id.'&cup='.$cup.'');	
            break;

        case 'say':



            $u = mysql_query("SELECT `name_team` FROM `union_bilet` where  `id_team`= '" . $datauser[manager2] . "' and `chemp`='" . $k['id'] . "' ;");
            $total = mysql_num_rows($u);

            if ($total != 0) {
                echo display_error('Вы уже подали заявку!');
                require_once ("../incfiles/end.php");
                exit;
            } else {

                mysql_query("INSERT INTO `union_bilet` set `chemp`='" . $k['id'] . "',`id_team`='" .
                    $fid . "',`name_team`='" . $names . "' ;");
                header("location: cup.php?id=$id&cup=$cup");
            }

            break;
/*
        case 'del':
            if (isset($_POST['submit'])) {
                mysql_query("DELETE FROM `union_bilet` WHERE `id_team` = '" . $fid . "' LIMIT 1;");
                mysql_query("OPTIMIZE TABLE `union_bilet`;");

                header("location: cup.php?id=$id");
            } else {
                echo '<div class="phdr"><b><a href="cup.php">Кубок</a></b> | удалить заявку</div>';
                echo '<div class="rmenu"><p>Внимание!<br/>Вы действительно хотите забрать заявку ?';
                echo '</p><p><form action="cup.php?act=del&amp;id=' . $id .
                    '" method="post"><input type="submit" name="submit" value="Удалить" /></form>';
                echo '</p></div>';
                echo '<div class="phdr"><a href="cup.php?id=' . $id . '">К кубкам</a></div>';
            }
            break;*/

        default:
            if ($k['status'] == '1') {
                echo '<div class="gmenu"><center>' . $k['name'] . ' ' . date("d.m / H:i", $k['time']) . '</center></div>';
                echo '<div class="list2"><center><img src="img/' . $k['img'] .'.jpg" alt=""/></center></div>';

                $q1 = mysql_query("SELECT * FROM `union_bilet` WHERE `chemp`='" . $k['id'] . "' ");
                $krr = mysql_fetch_array($q1);
                $total = mysql_num_rows($q1);
                //туры
                
if ($total == '8' && $krr['tur'] == '2' || $total == '4' && $krr['tur'] == '3' ||$total == '2' && $krr['tur'] == '4') {
                    
                    $tur = $krr['tur'];
                    $time = $realtime + 400;
                    $a = null;
                    $rows = mysql_query('SELECT `team_2`.`id` AS `tid`, `team_2`.`name` AS `tname` FROM `union_bilet` LEFT JOIN `team_2` ON (`team_2`.`name` = `union_bilet`.`name_team`) WHERE `union_bilet`.`chemp` = \'' .
                        $k['id'] . '\' ');
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
                            mysql_query('INSERT INTO `game_2` set  
                `time` = \'' . $time . '\',
                `tur`=\'' . $tur . '\',  
                `chemp`=\'' . $k['id'] . '\',  
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
                    mysql_query("DELETE FROM `union_bilet` WHERE `chemp`='" . $k['id'] . "' ;");
                }


                // 1/8
                $req = mysql_query("SELECT * from `game_2` WHERE `chemp`='" . $k['id'] . "' AND `tur`= '1' ;");
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
                            echo ' <a href="../trans.php?id=' . $arr[id] . '"><font color="green"><b>' .
                                $arr[rez1] . ':' . $arr[rez2] . '</b>';
                            if ($arr[rez1] == $arr[rez2]) {
                                echo ' (п. ' . $arr[pen1] . ':' . $arr[pen2] . ')';
                            }
                            echo '</font></a>';
                        } else {
                            echo ' <a href="../trans.php?id=' . $arr[id] .
                                '"><font color="green"><b>?:?</b></font></a>';
                        }

                        echo '</td></tr>';


                        ++$i;

                    }
                    echo '</table>';

                }

                // 1/4
                $req = mysql_query("SELECT * from `game_2` WHERE `chemp`='" . $k['name'] .
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
                $req = mysql_query("SELECT * from `game_2` WHERE `chemp`='" . $k['id'] . "' AND `tur`= '3' ;");
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
                            echo ' <a href="trans.php?id=' . $arr[id] . '"><font color="green"><b>?:?</b></font></a>';
                        }

                        echo '</td></tr>';


                        ++$i;

                    }
                    echo '</table>';
                }

                // 1/1
                $req = mysql_query("SELECT * from `game_2` WHERE `chemp`='" . $k['id'] .
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
                                mysql_query("update `r_union_cup` set  `status`='1', `time`='$realtime' where id='" . $cup. "' LIMIT 1;");
									
mysql_query("insert into `priz_2` set 
`id_cup`='".$k[id]."', 
`time`='".$k[time]."', 
`name`='".$k[name]."',
`logo`='".$k[logo]."',
`priz`='".$k[priz]."',
`win`='".$id_win_1."',
`url`='$home/union/cup.php?id=".$k[id]."'
;");	

                                $text = 'Команда <a href="../team.php?id=' . $id_win_1 . '">' . $name_win_1 .
                                    '</a>  стала владельцем кубка - ' . $k[name] . '';
                          
                                mysql_query("insert into `union_journal` set 
                    `time`='" . $realtime . "', 
                    `unid`='$k[id]',
                    `text`='" . $text . "' ;");


                                $q1 = mysql_query("select * from `team_2` where id='" . $id_win_1 .
                                    "' LIMIT 1;");
                                $winkom = mysql_fetch_array($q1);

                                $rate = $winkom[rate] + 10;
                                $money = $winkom[money] + $k[priz];

                                $kfcup = round($k[priz] / 100);
                                $fans = $winkom[fan] + (2 * $kfcup);

                                mysql_query("update `team_2` set `rate`='" . $rate . "', `money`='" . $money .
                                    "', `fan`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");

                            }


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
            } else {
            echo '<div class="phdr"><center>' . $k['name'] . ' ' . date("d.m / H:i", $k['time']) . '</center></div>';
                echo '<div class="list2"><center><img src="img/' . $k['img'] . '.jpg" alt=""/></center></div>';
					
		



       		
$qdd = mysql_query("select * from `start_2` where `chemp`='" . $k['id'] ."' AND `id_team`='$datauser[manager2]';");

		if(mysql_num_rows($qdd) == 0)
		{
                echo '<div class="gmenu"><p align="center"><a href="cup.php?act=say&amp;id=' . $id .'&amp;cup='.$k[id].'">Подать заявку</a></p></div>';
		}
	


	
                $q = mysql_query("select * from `union_bilet` where `chemp`='" . $k['id'] ."';");
                $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `union_bilet` WHERE `chemp`='" .$k['id'] . "' "), 0);
if ($total){
                echo '<div class="bmenu">Заявку на участие в турнире подали следующие комманды</div>';
                echo '<div class="list1">';
                while ($arr = mysql_fetch_array($q)) {

                    echo '<a href="../team.php?id=' . $arr['id_team'] . '">' . $arr['name_team'] . '</a>, ';

                    ++$i;
                }
                echo '</div>';
                echo '<div class="phdr">Всего: ' . $total . '</div>';
                }else{
                echo '<div class="rmenu">Учасников пока нет!</div>';
                }
                //echo '<div class="phdr">Всего: ' . $k[komm] . '</div>';
                /* начало */
                if ($total == $k[kOmm] && $realtime > $k['time'] ) {
                    mysql_query("update `r_union_cup` set `status` = '1' where `id`='" . $k['id'] ."' ;");
                    $a = null;
                  
                 if ($k[kOmm]==16){
                   $tttt = 1;
                 }else{
                   $tttt = 2;
                   }
                    
                    $rows = mysql_query('SELECT `team_2`.`id` AS `tid`, `team_2`.`name` AS `tname` FROM `union_bilet` LEFT JOIN `team_2` ON (`team_2`.`name` = `union_bilet`.`name_team`) WHERE `union_bilet`.`chemp` = \'' .
                        $k['id'] . '\'  LIMIT 16');
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
                            mysql_query('INSERT INTO `game_2` set  
                `time` = \'' . $realtime . '\',  
                `tur`=\''.$tttt.'\',  
                `chemp`=\'' . $k['id'] . '\',  
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

mysql_query("DELETE FROM `union_bilet` WHERE   `chemp`='" . $k['id'] ."';");
                }
            }

            if ($rights == 9) {
                echo '<a href = "cup.php?act=restart&amp;id=' . $id . '&amp;cup='.$cup.'">Перезапуск</a>';
            }

            break;
    }


}
echo '<br/><a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
?>