<?php



$req = mysql_query("select * from `game_2` where `timeend`<'" . $realtime . "'");
$cnt = mysql_num_rows($req);
if ($cnt > 0) {
    while ($art = mysql_fetch_array($req)) {

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////                               Расчёт                                //////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $k1 = @mysql_query("select * from `team_2` where id='" . $art['id_team1'] . "';");
        $krr1 = @mysql_fetch_array($k1);


        $k2 = @mysql_query("select * from `team_2` where id='" . $art['id_team2'] . "';");
        $krr2 = @mysql_fetch_array($k2);

        $reqe = mysql_query("select * from `tur_2` where id='" . $art['id'] . "';");
        $arts = mysql_fetch_assoc($reqe);

        $pr = @mysql_query("select * from `tournaments_2` where name='" . $arts['chemp'] .
            "' LIMIT 1;");
        $priz = @mysql_fetch_array($pr);

        $tu = $arts['tur'] + 1;

        $timeout = $art['timeend'] - $art['lasttime'];
        if ($timeout < 450) {
            $req1 = mysql_query("SELECT * FROM `player_2` where `kom`='" . $art['id_team1'] .
                "' AND `sostav`='1';");
            $total1 = mysql_num_rows($req1);
            while ($arr1 = mysql_fetch_array($req1)) {
                switch ($krr1[trener]) {
                    case "0":
                        $koftrener1 = 1;
                        break;
                    case "1":
                        $koftrener1 = 1.5;
                        break;
                    case "2":
                        $koftrener1 = 2;
                        break;
                    case "3":
                        $koftrener1 = 3;
                        break;
                }
                $imgfiza1 = '';
                $op1 = round($arr1[tal] * $koftrener1);
                $oputplay1 = $arr1[opit] + $op1;
                $players1 = $players1 . '' . $arr1['poz'] . '|' . $arr1[id] . '|' . $arr1['name'] .
                    ' ' . $imgfiza1 . '|+' . $op1 . '\r\n';
                mysql_query("update `player_2` set `opit`='" . $oputplay1 . "' where id='" . $arr1['id'] .
                    "';");
                $sila1 = $sila1 + $arr1['rm'];
            }


            $req2 = mysql_query("SELECT * FROM `player_2` where `kom`='" . $art['id_team2'] .
                "' AND `sostav`='1';");
            $total2 = mysql_num_rows($req2);
            while ($arr2 = mysql_fetch_array($req2)) {
                switch ($krr2['trener']) {
                    case "0":
                        $koftrener2 = 1;
                        break;
                    case "1":
                        $koftrener2 = 1.5;
                        break;
                    case "2":
                        $koftrener2 = 2;
                        break;
                    case "3":
                        $koftrener2 = 3;
                        break;
                }
                $op2 = round($arr2['tal'] * $koftrener2);
                $oputplay2 = $arr2['opit'] + $op2;
                $imgfiza2 = '';
                $players2 = $players2 . '' . $arr2['poz'] . '|' . $arr2[id] . '|' . $arr2['name'] .
                    ' ' . $imgfiza2 . '|+' . $op2 . '\r\n';

                mysql_query("update `player_2` set  `opit`='" . $oputplay2 . "' where id='" . $arr2['id'] .
                    "';");
                $sila2 = $sila2 + $arr2['rm'];
            }



            ///////////////////////////////////////////////////////////////////
            //////////////////           ПЕНАЛЬТИ          ////////////////////
            ///////////////////////////////////////////////////////////////////

            if ($art['goal1'] == $art['goal2'] || $arts['chemp'] == 'liga') {
                $input = array("5:3", "5:4", "4:2", "4:3", "3:2", "3:5", "4:5", "2:4", "3:4",
                    "2:3");
                $rand_keys = array_rand($input);

                $penult = explode(":", $input[$rand_keys]);

                $pen1 = $penult[0];
                $pen2 = $penult[1];
            }

            /////////////////////////////////////////////////////////////
            ////////////////           Опыт менеджеру     ///////////////
            /////////////////////////////////////////////////////////////
            $rand = rand(1, 100);
            //Спонсоры
            // Команда 1
            if ($krr1['sponsor'] != 0) {
                $x22 = mysql_query("SELECT `money` FROM `sponsor_2` where id='" . $krr1['sponsor'] .
                    "'");
                $ns = mysql_fetch_array($x22);
                $spmoney = $ns['money'];
            } else {
                $spmoney = 0;
            }
            // Команда 2
            if ($krr2['sponsor'] != 0) {
                $x22 = mysql_query("SELECT `money` FROM `sponsor_2` where id='" . $krr2['sponsor'] .
                    "'");
                $ns2 = mysql_fetch_array($x22);
                $spmoney2 = $ns2['money'];
            } else {
                $spmoney2 = 0;
            }


            // Команда 1
            if ($art['goal1'] > $art['goal2']) {
                //П1
                //Пишем в историю
                $text = 'Команда <a href="team.php?id=' . $krr1[id] . '">' . $krr1['name'] .
                    '</a> выиграла команду <a href="team.php?id=' . $krr2[id] . '">' . $krr2['name'] .
                    '</a>';
                if ($krr1['name'] != '' || $krr2['name'] != '') {
                    mysql_query("insert into `history_2` set 
                    `time`='" . $realtime . "', 
                    `type`='game',
                    `text`='" . $text . "' ;");
                }

                $oputman1 = $krr1[rate] + 1;
                $moneyman1 = $krr1['money'] + 500 + $spmoney + round($krr1['prib_stadium'] * 0.1);
                $fan = $krr1['fan'] + $rand;
                $winman1 = $krr1['win']+1;

                mysql_query("update `team_2` set `fan`='" . $fan . "', `rate`='" . $oputman1 .
                    "',`money`='" . $moneyman1 . "', `win`='".$winman1."' where id='" . $krr1[id] . "' LIMIT 1;");
            } elseif ($art['goal1'] == $art['goal2']) {
                //Н

                //Пишем в историю
                $text = 'Команда <a href="team.php?id=' . $krr1[id] . '">' . $krr1['name'] .
                    '</a> и команда <a href="team.php?id=' . $krr2[id] . '">' . $krr2['name'] .
                    '</a> сыграли в ничью';
                if ($krr1['name'] != '' || $krr2['name'] != '') {
                    mysql_query("insert into `history_2` set 
                    `time`='" . $realtime . "', 
                    `type`='game',
                    `text`='" . $text . "' ;");
                }
                $fan = $krr1['fan'] + $rand;
                $moneyman1 = $krr1[money] + 100 + $spmoney + round($krr1['prib_stadium'] * 0.05);
                $nnman1 = $krr1[nnn]+1;

                mysql_query("update `team_2` set `fan`='" . $fan . "', `money`='" . $moneyman1 .
                    "', `nnn`='".$nnman1."' where id='" . $krr1[id] . "' LIMIT 1;");
            } else {
                //П2
                //Пишем в историю
                $text = 'Команда <a href="team.php?id=' . $krr2[id] . '">' . $krr2['name'] .
                    '</a> выиграла команду <a href="team.php?id=' . $krr1[id] . '">' . $krr1['name'] .
                    '</a>';
                if ($krr1['name'] != '' || $krr2['name'] != '') {
                    mysql_query("insert into `history_2` set 
                    `time`='" . $realtime . "', 
                    `type`='game',
                    `text`='" . $text . "' ;");
                }
                $losman1 = $krr1[lost]+1;
                if ($krr1['fan'] > 100) {
                    $fan = $krr1['fan'] - $rand;
                }

                mysql_query("update `team_2` set `fan`='" . $fan . "', `lost`='".$losman1."' where id='" . $krr1[id] .
                    "' LIMIT 1;");
            }

            // Команда 2
            if ($art['goal2'] > $art['goal1']) {
                //П2
                $fan2 = $krr2['fan'] + $rand;
                $oputman2 = $krr2[rate] + 1;
                $moneyman2 = $krr2[money] + 500 + $spmoney2 + round($krr2['prib_stadium'] * 0.1);
                $winman2 = $krr2[win]+1;

                mysql_query("update `team_2` set `fan`='" . $fan2 . "', `rate`='" . $oputman2 .
                    "',`money`='" . $moneyman2 . "', `win`='".$winman2."' where id='" . $krr2[id] . "' LIMIT 1;");
            } elseif ($art['goal1'] == $art['goal2']) {
                //Н
                $fan2 = $krr2['fan'] + $rand;
                $moneyman2 = $krr2[money] + 100 + $spmoney2 + round($krr2['prib_stadium'] * 0.05);
                $nnman2 = $krr2[nnn]+1;

                mysql_query("update `team_2` set `fan`='" . $fan2 . "',`money`='" . $moneyman2 .
                    "', `nnn`='".$nnman2."' where id='" . $krr2[id] . "' LIMIT 1;");
            } else {
                //П2
                $losman2 = $krr2[lost]+1;
                if ($krr2['fan'] > 100) {
                    $fan2 = $krr2['fan'] - $rand;
                }
                mysql_query("update `team_2` set `fan`='" . $fan2 . "', `lost`='".$losman2."' where id='" . $krr2[id] .
                    "' LIMIT 1;");
            }
			
			
            $bb = mysql_query("SELECT * FROM `gnews_2` WHERE `tid`='" . $art['id'] ."' order by time asc ;");
				
			
            while ($bb1 = mysql_fetch_assoc($bb)) {
			    $text2 = $text2.''.$bb1['news'].'\r\n';
            }

			$bb = mysql_query("SELECT `goal_2`.`time`,`goal_2`.`idgoal`, `player_2`.`name` FROM `goal_2` LEFT JOIN `player_2` ON `goal_2`.`idgoal`=`player_2`.`id` WHERE `goal_2`.`tid`='" . $art['id'] ."' ");			
            while ($bb2 = mysql_fetch_assoc($bb)) {
                $menus = $menus.''.$bb2[time].'|goal|'.$bb2[idgoal].'|'.$bb2['name'].'\r\n';
				
            }
			
            mysql_query("update `tur_2` set 
`sostav1`='" . $players1 . "', 
`sostav2`='" . $players2 . "', 

`tactics1`='".$krr1['shema']."|".$krr1['pass']."|".$krr1['strat']."|".$krr1['press']."|".$krr1['tactics']."|".$sila1."',
`tactics2`='".$krr2['shema']."|".$krr2['pass']."|".$krr2['strat']."|".$krr2['press']."|".$krr2['tactics']."|".$sila2."',

`text`='".$text2."',
`menus`='".$menus."',
`rez1`='" . $art['goal1'] . "', 
`rez2`='" . $art['goal2'] . "',

`pen1`='" . $pen1 . "',
`pen2`='" . $pen2 . "'  



where id='" . $art['id'] . "';");


            mysql_query("DELETE FROM `game_2` WHERE `id`='" . $art['id'] . "' LIMIT 1;");
            $bb = mysql_query("SELECT * FROM `gnews_2` WHERE `tid`='" . $art['id'] ."'  ;");
			
            while ($bb2 = mysql_fetch_assoc($bb)) {
                mysql_query("DELETE FROM `gnews_2` WHERE `id`='" . $bb2['id'] . "' ;");
            }

			
			
			

            // ЕСЛИ ЧЕМПИОНАТ
			$do = array('ua', 'rus', 'en', 'sp', 'it', 'ge', 'bel', 'por', 'fr');
            if (in_array($art['chemp'], $do)) {


                if ($art['goal1'] > $art['goal2']) {
                    $igr1 = $krr1[ii] + 1;
                    $igr2 = $krr2[ii] + 1;

                    $raz1 = $krr1[raz] + ($art['goal1'] - $art['goal2']);
                    $raz2 = $krr2[raz] + ($art['goal2'] - $art['goal1']);

                    $win1 = $krr1[vv] + 1;
                    $los2 = $krr2[pp] + 1;

                    $gz1 = $krr1[mz] + $art['goal1'];
                    $gz2 = $krr2[mz] + $art['goal2'];

                    $gp1 = $krr1[mp] + $art['goal2'];
                    $gp2 = $krr2[mp] + $art['goal1'];

                    $ochey1 = $krr1[oo] + 3;
                    $ochey2 = $krr2[oo] + 0;

                    mysql_query("update `team_2` set `ii`='" . $igr1 . "',`vv`='" . $win1 .
                        "',`mz`='" . $gz1 . "',`mp`='" . $gp1 . "', `raz`='" . $raz1 . "', `oo`='" . $ochey1 .
                        "' where id='" . $krr1[id] . "' LIMIT 1;");
                    mysql_query("update `team_2` set `ii`='" . $igr2 . "',`pp`='" . $los2 .
                        "',`mz`='" . $gz2 . "',`mp`='" . $gp2 . "', `raz`='" . $raz2 . "', `oo`='" . $ochey2 .
                        "' where id='" . $krr2[id] . "' LIMIT 1;");
                } elseif ($art['goal2'] > $art['goal1']) {
                    $igr1 = $krr1[ii] + 1;
                    $igr2 = $krr2[ii] + 1;

                    $raz1 = $krr1[raz] + ($art['goal1'] - $art['goal2']);
                    $raz2 = $krr2[raz] + ($art['goal2'] - $art['goal1']);

                    $los1 = $krr1[pp] + 1;
                    $win2 = $krr2[vv] + 1;

                    $gz1 = $krr1[mz] + $art['goal1'];
                    $gz2 = $krr2[mz] + $art['goal2'];

                    $gp1 = $krr1[mp] + $art['goal2'];
                    $gp2 = $krr2[mp] + $art['goal1'];

                    $ochey1 = $krr1[oo] + 0;
                    $ochey2 = $krr2[oo] + 3;

                    mysql_query("update `team_2` set `ii`='" . $igr1 . "',`pp`='" . $los1 .
                        "',`mz`='" . $gz1 . "',`mp`='" . $gp1 . "', `raz`='" . $raz1 . "', `oo`='" . $ochey1 .
                        "' where id='" . $krr1[id] . "' LIMIT 1;");
                    mysql_query("update `team_2` set `ii`='" . $igr2 . "',`vv`='" . $win2 .
                        "',`mz`='" . $gz2 . "',`mp`='" . $gp2 . "', `raz`='" . $raz2 . "', `oo`='" . $ochey2 .
                        "' where id='" . $krr2[id] . "' LIMIT 1;");
                } else {
                    $igr1 = $krr1[ii] + 1;
                    $igr2 = $krr2[ii] + 1;

                    $raz1 = $krr1[raz] + ($art['goal1'] - $art['goal2']);
                    $raz2 = $krr2[raz] + ($art['goal2'] - $art['goal1']);

                    $nn1 = $krr1[nn] + 1;
                    $nn2 = $krr2[nn] + 1;

                    $gz1 = $krr1[mz] + $art['goal1'];
                    $gz2 = $krr2[mz] + $art['goal2'];

                    $gp1 = $krr1[mp] + $art['goal2'];
                    $gp2 = $krr2[mp] + $art['goal1'];

                    $ochey1 = $krr1[oo] + 1;
                    $ochey2 = $krr2[oo] + 1;

                    mysql_query("update `team_2` set `ii`='" . $igr1 . "',`nn`='" . $nn1 .
                        "',`mz`='" . $gz1 . "',`mp`='" . $gp1 . "', `raz`='" . $raz1 . "', `oo`='" . $ochey1 .
                        "' where id='" . $krr1[id] . "' LIMIT 1;");
                    mysql_query("update `team_2` set `ii`='" . $igr2 . "',`nn`='" . $nn2 .
                        "',`mz`='" . $gz2 . "',`mp`='" . $gp2 . "', `raz`='" . $raz2 . "', `oo`='" . $ochey2 .
                        "' where id='" . $krr2[id] . "' LIMIT 1;");
                }


            }

            // ЕСЛИ ЛЧ
            if ($arts['chemp'] == 'liga') {
                mysql_query("update `liga_game_2` set `rez1`='" . $art['goal1'] . "',`rez2`='" . $art['goal2'] .
                    "', `pen1`='" . $pen1 . "',`pen2`='" . $pen2 . "', `id_report`='" . $id .
                    "' where id='" . $arts[id_match] . "' LIMIT 1;");


                $l1 = @mysql_query("select * from `liga_group_2` where id_team='" . $art[id_team1] .
                    "' LIMIT 1;");
                $lrr1 = @mysql_fetch_array($l1);

                $l2 = @mysql_query("select * from `liga_group_2` where id_team='" . $art[id_team2] .
                    "' LIMIT 1;");
                $lrr2 = @mysql_fetch_array($l2);


                if ($art['goal1'] > $art['goal2']) {
                    $igr1 = $lrr1[igr] + 1;
                    $igr2 = $lrr2[igr] + 1;

                    $win1 = $lrr1[win] + 1;
                    $los2 = $lrr2[los] + 1;

                    $gz1 = $lrr1[gz] + $art['goal1'];
                    $gz2 = $lrr2[gz] + $art['goal2'];

                    $gp1 = $lrr1[gp] + $art['goal2'];
                    $gp2 = $lrr2[gp] + $art['goal1'];

                    $ochey1 = $lrr1[ochey] + 3;
                    $ochey2 = $lrr2[ochey] + 0;

                    mysql_query("update `liga_group_2` set `igr`='" . $igr1 . "',`win`='" . $win1 .
                        "',`gz`='" . $gz1 . "',`gp`='" . $gp1 . "', `ochey`='" . $ochey1 .
                        "' where id='" . $lrr1[id] . "' LIMIT 1;");
                    mysql_query("update `liga_group_2` set `igr`='" . $igr2 . "',`los`='" . $los2 .
                        "',`gz`='" . $gz2 . "',`gp`='" . $gp2 . "', `ochey`='" . $ochey2 .
                        "' where id='" . $lrr2[id] . "' LIMIT 1;");
                } elseif ($art['goal2'] > $art['goal1']) {
                    $igr1 = $lrr1[igr] + 1;
                    $igr2 = $lrr2[igr] + 1;

                    $los1 = $lrr1[los] + 1;
                    $win2 = $lrr2[win] + 1;

                    $gz1 = $lrr1[gz] + $art['goal1'];
                    $gz2 = $lrr2[gz] + $art['goal2'];

                    $gp1 = $lrr1[gp] + $art['goal2'];
                    $gp2 = $lrr2[gp] + $art['goal1'];

                    $ochey1 = $lrr1[ochey] + 0;
                    $ochey2 = $lrr2[ochey] + 3;

                    mysql_query("update `liga_group_2` set `igr`='" . $igr1 . "',`los`='" . $los1 .
                        "',`gz`='" . $gz1 . "',`gp`='" . $gp1 . "', `ochey`='" . $ochey1 .
                        "' where id='" . $lrr1[id] . "' LIMIT 1;");
                    mysql_query("update `liga_group_2` set `igr`='" . $igr2 . "',`win`='" . $win2 .
                        "',`gz`='" . $gz2 . "',`gp`='" . $gp2 . "', `ochey`='" . $ochey2 .
                        "' where id='" . $lrr2[id] . "' LIMIT 1;");
                } else {
                    $igr1 = $lrr1[igr] + 1;
                    $igr2 = $lrr2[igr] + 1;

                    $nn1 = $lrr1[nn] + 1;
                    $nn2 = $lrr2[nn] + 1;

                    $gz1 = $lrr1[gz] + $art['goal1'];
                    $gz2 = $lrr2[gz] + $art['goal2'];

                    $gp1 = $lrr1[gp] + $art['goal2'];
                    $gp2 = $lrr2[gp] + $art['goal1'];

                    $ochey1 = $lrr1[ochey] + 1;
                    $ochey2 = $lrr2[ochey] + 1;

                    mysql_query("update `liga_group_2` set `igr`='" . $igr1 . "',`nn`='" . $nn1 .
                        "',`gz`='" . $gz1 . "',`gp`='" . $gp1 . "', `ochey`='" . $ochey1 .
                        "' where id='" . $lrr1[id] . "' LIMIT 1;");
                    mysql_query("update `liga_group_2` set `igr`='" . $igr2 . "',`nn`='" . $nn2 .
                        "',`gz`='" . $gz2 . "',`gp`='" . $gp2 . "', `ochey`='" . $ochey2 .
                        "' where id='" . $lrr2[id] . "' LIMIT 1;");
                }

            }


            if ($arts['chemp'] == $priz['name']) {

                if ($art['goal1'] > $art['goal2']) {
                    if ($tu < 5) {
                        mysql_query("INSERT INTO `start_2` set `chemp`='" . $arts['chemp'] . "',`tur`='" .
                            $tu . "', `id_team`='" . $krr1['id'] . "',`name_team`='" . $krr1['name'] . "' ;");
                    }

                } elseif ($art['goal2'] > $art['goal1']) {
                    if ($tu < 5) {
                        mysql_query("INSERT INTO `start_2` set `chemp`='" . $arts['chemp'] . "',`tur`='" .
                            $tu . "', `id_team`='" . $krr2['id'] . "',`name_team`='" . $krr2['name'] . "' ;");
                    }
                } else {
                    if ($pen1 > $pen2) {
                        if ($tu < 5) {
                            mysql_query("INSERT INTO `start_2` set `chemp`='" . $arts['chemp'] . "',`tur`='" .
                                $tu . "', `id_team`='" . $krr1['id'] . "',`name_team`='" . $krr1['name'] . "' ;");
                        }
                    } else {
                        if ($tu < 5) {
                            mysql_query("INSERT INTO `start_2` set `chemp`='" . $arts['chemp'] . "',`tur`='" .
                                $tu . "', `id_team`='" . $krr2['id'] . "',`name_team`='" . $krr2['name'] . "' ;");
                        }
                    }
                }

            }


        } else {
		
		
            $req1 = mysql_query("SELECT * FROM `player_2` where `kom`='" . $art['id_team1'] ."' AND `sostav`='1';");
            $req2 = mysql_query("SELECT * FROM `player_2` where `kom`='" . $art['id_team2'] ."' AND `sostav`='1';");

			
			
            while ($arr1 = mysql_fetch_array($req1)) {
                switch ($krr1[trener]) {
                    case "0":
                        $koftrener1 = 1;
                        break;
                    case "1":
                        $koftrener1 = 1.5;
                        break;
                    case "2":
                        $koftrener1 = 2;
                        break;
                    case "3":
                        $koftrener1 = 3;
                        break;
                }
                $op1 = round($arr1[tal] * $koftrener1);


                $oputplay1 = $arr1[opit] + $op1;


                $id1[] = $arr1['id'];
                $sila1 = $sila1 + $arr1['rm'];

                $fiza1 = $arr1['fiz'] - ($arr1['voz'] / 2);
                $rmm1 = round($arr1['mas'] / 100 * $fiza1);
                $rand = rand(1, 100);
                $imgfiza1 = '';
               /*
                if ($rand == 50 && $krr1['id_admin'] != 0) {
                    $news = 'Игрок ' . $arr1['name'] . ' из команды ' . $art['name_team1'] .
                        ' получает красную карточку и дисквалифицируется на 2 чяса.';
                    mysql_query("update `player_2` set `sostav`='4', `utime`='" . ($realtime +
                        174000) . "' where id='" . $arr1['id'] . "';");
                    mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] .
                        "' , `news`='" . $news . "' ;");
                }
               
                if ($rand == 25 && $krr1['id_admin'] != 0) {
                    $news = 'Игрок ' . $arr1['name'] . ' из команды ' . $art['name_team1'] .
                        ' получает желтую карточку. ';
                    $arr1['yellow']++;
                    if ($arr1['yellow'] == 3) {
                        $arr1['yellow'] = 0;
                        $news = $news . 'Это третья карточка. игрок дисквалифицируется.';
                        mysql_query("update `m2_player` set `sostav`='4', `utime`='" . ($realtime +
                            260000) . "',`yellow`='" . $arr1['yellow'] . "' where id='" . $arr1['id'] . "';");
                    } else {
                        mysql_query("update `m2_player` set  `yellow`='" . $arr1['yellow'] .
                            "' where id='" . $arr1['id'] . "';");
                    }
 
                    mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] .
                        "' , `news`='" . $news . "' ;");
                }*/
               /*
                if ($rand == 75 && $krr1['id_admin'] != 0) {
                    $imgfiza1 = ' <img src="img/trav.gif" alt=""/>';
                    $news = 'Игрок ' . $arr1['name'] . ' из команды ' . $art['name_team1'] .
                        ' очень сильно травмировался и будет находиться на лечении 2 следующих игры.';
                    mysql_query("update `player_2` set `sostav`='3', `btime`='" . ($realtime +
                        174000) . "' where id='" . $arr1['id'] . "';");
                    mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] .
                        "' , `news`='" . $news . "' ;");
                }*/
                $players1 = $players1 . '' . $arr1['poz'] . '|' . $arr1[id] . '|' . $arr1['name'] .
                    ' ' . $imgfiza1 . '|+' . $op1 . '\r\n';
                if ($krr1['id_admin'] != 0)
                    mysql_query("update `player_2` set `fiz`='" . $fiza1 . "', `rm`='" . $rmm1 .
                        "', `opit`='" . $oputplay1 . "' where id='" . $arr1['id'] . "';");
            }
            $silak1 = round($sila1);



            while ($arr2 = mysql_fetch_array($req2)) {
                switch ($krr2['trener']) {
                    case "0":
                        $koftrener2 = 1;
                        break;
                    case "1":
                        $koftrener2 = 1.5;
                        break;
                    case "2":
                        $koftrener2 = 2;
                        break;
                    case "3":
                        $koftrener2 = 3;
                        break;
                }
                $op2 = round($arr2['tal'] * $koftrener2);


                $oputplay2 = $arr2['opit'] + $op2;

                $id2[] = $arr2['id'];
                $imgfiza2 = '';
                $sila2 = $sila2 + $arr2['rm'];
                $fiza2 = $arr2['fiz'] - ($arr2['voz'] / 2);
                $rmm2 = round($arr2['mas'] / 100 * $fiza2);
                $rand = rand(1, 100);
                /*
                if ($rand == 50 && $krr1['id_admin'] != 0) {

                    $news = 'Игрок ' . $arr2['name'] . ' из команды ' . $art['name_team2'] .
                        ' получает красную карточку и дисквалифицируется на 2 чяса.';
                    mysql_query("update `player_2` set `sostav`='4', `utime`='" . ($realtime +
                        174000) . "' where id='" . $arr2['id'] . "';");
                    mysql_query("INSERT INTO `m2_news` set `time`='" . $realtime . "', `tid`='" . $art['id'] .
                        "' , `news`='" . $news . "' ;");
                }
                if ($rand == 25 && $krr1['id_admin'] != 0) {
                    $news = 'Игрок ' . $arr2['name'] . ' из команды ' . $art['name_team2'] .
                        ' получает желтую карточку. ';
                    $arr2['yellow']++;
                    if ($arr2['yellow'] == 3) {
                        $arr2['yellow'] = 0;
                        $news = $news . 'Это третья карточка. игрок дисквалифицируется на 3 игровых дня';
                        mysql_query("update `player_2` set `sostav`='4', `utime`='" . ($realtime +
                            260000) . "',`yellow`='" . $arr2['yellow'] . "' where id='" . $arr2['id'] . "';");
                    } else {
                        mysql_query("update `player_2` set  `yellow`='" . $arr2['yellow'] .
                            "' where id='" . $arr2['id'] . "';");
                    }

                    mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] .
                        "' , `news`='" . $news . "' ;");
                }*/
                /*
                if ($rand == 75 && $krr1['id_admin'] != 0) {
                    $imgfiza2 = ' <img src="img/trav.gif" alt=""/>';
                    $news = 'Игрок ' . $arr2['name'] . ' из команды ' . $art['name_team2'] .
                        ' очень сильно травмировался и будет находиться на лечении в течение двух дней.';
                    mysql_query("update `m2_player` set `sostav`='3', `btime`='" . ($realtime +
                        174000) . "' where id='" . $arr2['id'] . "';");
                    mysql_query("INSERT INTO `news_2` set `time`='" . $realtime . "', `tid`='" . $art['id'] .
                        "' , `news`='" . $news . "' ;");
                }*/
                $players2 = $players2 . '' . $arr2['poz'] . '|' . $arr2[id] . '|' . $arr2['name'] .
                    ' ' . $imgfiza2 . '|+' . $op2 . '\r\n';
                if ($krr2['id_admin'] != 0)
                    mysql_query("update `player_2` set `fiz`='" . $fiza2 . "', `rm`='" . $rmm2 .
                        "', `opit`='" . $oputplay2 . "' where id='" . $arr2['id'] . "';");
            }

            ///////////////////////////////////////////////
            ///////////////////////////////////////////////
            $silak2 = round($sila2);



            if ($sila1 >= $sila2) {

                if ($razn >= 100 && $krr1['tactics'] >= 90) {
                    //echo 'Первая +10%<br/>';
                    $sila1 = $sila1 / 100 * 10 + $sila1;
                }

                if ($razn >= 100 && $krr1['tactics'] <= 20) {
                    //echo 'Первая -10%<br/>';
                    $sila1 = $sila1 - ($sila1 / 100 * 10);
                }

            }


            if ($sila2 <= $sila1) {
                if ($razn >= 100 && $krr2['tactics'] <= 20) {
                    //echo 'Вторая +10%<br/>';
                    $sila2 = $sila2 / 100 * 10 + $sila2;
                }

                if ($razn >= 100 && $krr2['tactics'] >= 90) {
                    //echo 'Вторая -10%<br/>';
                    $sila2 = $sila2 - ($sila2 / 100 * 10);
                }

            }

            $razn = abs($sila1 - $sila2);
            //echo 'Разница '.$razn.'<br/>';


            //////////////////////////////////////////////////////////////////////////////////////
            //echo '.........................................<br/>';

            //echo 'пас1 '.$krr1[pass].'<br/>';
            //echo 'пас2 '.$krr2[pass].'<br/>';

            switch ($krr1['pass']) {
                case "0":
                    if ($krr2['pass'] == 2) {
                        //echo 'Вторая +10%<br/>';
                        $sila2 = $sila2 / 100 * 10 + $sila2;
                    }
                    break;
                case "1":
                    if ($krr2['pass'] == 0) {
                        //echo 'Вторая +10%<br/>';
                        $sila2 = $sila2 / 100 * 10 + $sila2;
                    }
                    break;
                case "2":
                    if ($krr2['pass'] == 1) {
                        //echo 'Вторая +10%<br/>';
                        $sila2 = $sila2 / 100 * 10 + $sila2;
                    }
                    break;
            }

            switch ($krr2['pass']) {
                case "0":
                    if ($krr1['pass'] == 2) {
                        //echo 'Первая +10%<br/>';
                        $sila1 = $sila1 / 100 * 10 + $sila1;
                    }
                    break;
                case "1":
                    if ($krr1['pass'] == 0) {
                        //echo 'Первая +10%<br/>';
                        $sila1 = $sila1 / 100 * 10 + $sila1;
                    }
                    break;
                case "2":
                    if ($krr1['pass'] == 1) {
                        //echo 'Первая +10%<br/>';
                        $sila1 = $sila1 / 100 * 10 + $sila1;
                    }
                    break;
            }

            $razn = abs($sila1 - $sila2);
            //echo 'Разница '.$razn.'<br/>';

            //////////////////////////////////////////////////////////////////////////////////////
            //echo '.........................................<br/>';

            //echo 'strat1 '.$krr1[strat].'<br/>';
            //echo 'strat2 '.$krr2[strat].'<br/>';

            switch ($krr1['strat']) {
                case "0":
                    if ($krr2['strat'] == 3 || $krr2['strat'] == 2) {
                        //echo 'Вторая +10%<br/>';
                        $sila2 = $sila2 / 100 * 10 + $sila2;
                    }
                    break;
                case "1":
                    if ($krr2['strat'] == 2 || $krr2['strat'] == 0) {
                        //echo 'Вторая +10%<br/>';
                        $sila2 = $sila2 / 100 * 10 + $sila2;
                    }
                    break;
                case "2":
                    if ($krr2['strat'] == 3 || $krr2['strat'] == 1) {
                        //echo 'Вторая +10%<br/>';
                        $sila2 = $sila2 / 100 * 10 + $sila2;
                    }
                    break;
                case "3":
                    if ($krr2['strat'] == 1 || $krr2['strat'] == 0) {
                        //echo 'Вторая +10%<br/>';
                        $sila2 = $sila2 / 100 * 10 + $sila2;
                    }
                    break;
            }


            switch ($krr2['strat']) {
                case "0":
                    if ($krr1['strat'] == 3 || $krr1['strat'] == 2) {
                        //echo 'Первая +10%<br/>';
                        $sila1 = $sila1 / 100 * 10 + $sila1;
                    }
                    break;
                case "1":
                    if ($krr1['strat'] == 2 || $krr1['strat'] == 0) {
                        //echo 'Первая +10%<br/>';
                        $sila1 = $sila1 / 100 * 10 + $sila1;
                    }
                    break;
                case "2":
                    if ($krr1['strat'] == 3 || $krr1['strat'] == 1) {
                        //echo 'Первая +10%<br/>';
                        $sila1 = $sila1 / 100 * 10 + $sila1;
                    }
                    break;
                case "3":
                    if ($krr1['strat'] == 1 || $krr1['strat'] == 0) {
                        //echo 'Первая +10%<br/>';
                        $sila1 = $sila1 / 100 * 10 + $sila1;
                    }
                    break;
            }

            ///////////////////////////////////////////////////////////////////
            //////////////////          РAСЧЕТ СЧЕТА          /////////////////
            ///////////////////////////////////////////////////////////////////

            //ВСЯ СИЛА
            $allsila1 = $sila1;
            $allsila2 = $sila2;


            if ($allsila1 > $allsila2) {
                $razn1 = $allsila1 - $allsila2;

                if ($razn1 > 1500) {
                    $input = array("6:1", "7:2", "10:2");
                } elseif ($razn1 > 1000) {
                    $input = array("6:0", "6:1", "5:0");
                } elseif ($razn1 > 850) {
                    $input = array("4:0", "4:1", "3:0", "3:2", "3:1", "2:1", "0:0", "1:1");
                } elseif ($razn1 > 500) {
                    $input = array("3:0", "3:0", "4:1", "3:1", "2:1", "4:0", "1:1", "3:2");
                } elseif ($razn1 > 350) {
                    $input = array("3:0", "2:0", "1:0", "3:1", "2:1", "1:2", "0:0", "1:1" "2:2");
                } else {
                    $input = array("1:0", "0:0", "1:1", "2:2", "3:3", "2:1", "3:2", "0:1", "1:2");
                }


            } elseif ($allsila2 > $allsila1) {
                $razn2 = $allsila2 - $allsila1;

                if ($razn2 > 1500) {
                    $input = array("1:6", "2:7", "2:10");
                } elseif ($razn2 > 1000) {
                    $input = array("0:6", "1:6", "0:5");
                } elseif ($razn2 > 800) {
                    $input = array("0:4", "1:4", "0:3", "2:3", "1:3", "1:2", "0:0", "1:1");
                } elseif ($razn2 > 500) {
                    $input = array("0:3", "0:3", "1:4", "1:3", "1:2", "4:0", "1:1", "3:2");
                } elseif ($razn2 > 350) {
                    $input = array("0:3", "0:2", "0:1", "1:3", "1:2", "2:1", "2:1", "0:0", "2:2");
                } else {
                    $input = array("0:1", "0:0", "1:1", "2:2", "3:3", "1:2", "2:3", "1:0", "2:1");
                }

            } else {
                $input = array("0:0", "1:1", "2:2", "3:3");
            }


            ///////////////////////////////////////////////////////////////////
            //////////////////          РЕЗУЛЬТАТ          ////////////////////
            ///////////////////////////////////////////////////////////////////

            $rand_keys = array_rand($input);
            $rezult = explode(":", $input[$rand_keys]);


            ///////////////////////////////////////////////////////////////////
            //////////////////           ПЕНАЛЬТИ          ////////////////////
            ///////////////////////////////////////////////////////////////////

            if ($rezult[0] == $rezult[1] || $arts['chemp'] == 'liga') {
                $input = array("5:3", "5:4", "4:2", "4:3", "3:2", "3:5", "4:5", "2:4", "3:4",
                    "2:3");
                $rand_keys = array_rand($input);

                $penult = explode(":", $input[$rand_keys]);

                $pen1 = $penult[0];
                $pen2 = $penult[1];
            }

            /////////////////////////////////////////////////////////////////
            //////////////////////         КТО ЗАБИЛ         ////////////////
            /////////////////////////////////////////////////////////////////

// 1
if ($rezult[0] > 0)
{

$kk1 = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr1['id']."' AND `sostav`='1' order by line desc LIMIT ".$rezult[0].";");
while ($kkom1 = mysql_fetch_array($kk1))
{

$minuta = rand(2,92);if ($minuta < 10){$minuta = '0'.$minuta;}
$menus = $menus.''.$minuta.'|goal|'.$kkom1[id].'|'.$kkom1['name'].'\r\n';



$mor1 = $kkom1[mor]+5;
$goalplay1 = $kkom1[goal]+1;
mysql_query("update `player_2` set `mor`='" . $mor1 . "', `goal`='" . $goalplay1 . "' where id='" . $kkom1[id] . "' LIMIT 1;");
}

}



// 2
if ($rezult[1] > 0)
{

$kk2 = mysql_query("SELECT * FROM `player_2` where `kom`='".$krr2['id']."' AND `sostav`='1' order by line desc LIMIT ".$rezult[1].";");
while ($kkom2 = mysql_fetch_array($kk2))
{

$minuta = rand(2,92);if ($minuta < 10){$minuta = '0'.$minuta;}
$menus = $menus.''.$minuta.'|goal|'.$kkom2[id].'|'.$kkom2['name'].'\r\n';

$mor2 = $kkom2[mor]+5;
$goalplay2 = $kkom2[goal]+1;
mysql_query("update `player_2` set `mor`='" . $mor2 . "', `goal`='" . $goalplay2 . "' where id='" . $kkom2[id] . "' LIMIT 1;");
}

}
            
            /////////////////////////////////////////////////////////////
            ////////////////           Опыт менеджеру        ////////////
            /////////////////////////////////////////////////////////////
            $rand = rand(1, 100);
            //Спонсоры
            // Команда 1
            if ($krr1['sponsor'] != 0) {
                $x22 = mysql_query("SELECT `money` FROM `sponsor_2` where id='" . $krr1['sponsor'] .
                    "'");
                $ns = mysql_fetch_array($x22);
                $spmoney = $ns['money'];
            } else {
                $spmoney = 0;
            }
            // Команда 2
            if ($krr2['sponsor'] != 0) {
                $x22 = mysql_query("SELECT `money` FROM `sponsor_2` where id='" . $krr2['sponsor'] .
                    "'");
                $ns2 = mysql_fetch_array($x22);
                $spmoney2 = $ns2['money'];
            } else {
                $spmoney2 = 0;
            }
            // Команда 1
            if ($rezult[0] > $rezult[1]) {
                //П1

                //Пишем в историю
                $text = 'Команда <a href="team.php?id=' . $krr1[id] . '">' . $krr1['name'] .
                    '</a> выиграла команду <a href="team.php?id=' . $krr2[id] . '">' . $krr2['name'] .
                    '</a>';
                if ($krr1['name'] != '' || $krr2['name'] != '') {
                    mysql_query("insert into `history_2` set 
                    `time`='" . $realtime . "', 
                    `type`='game',
                    `text`='" . $text . "' ;");
                }

                $oputman1 = $krr1[rate] + 1;
                $moneyman1 = $krr1[money] + 500 + $spmoney + round($krr1['prib_stadium'] * 0.1);
                $fan = $krr1['fan'] + $rand;
                $winman1 = $krr1[win]+1;

                mysql_query("update `team_2` set `fan`='" . $fan . "', `rate`='" . $oputman1 .
                    "',`money`='" . $moneyman1 . "',`win`='". $winman1."' where id='" . $krr1[id] . "' LIMIT 1;");
            } elseif ($rezult[0] == $rezult[1]) {
                //Н

                //Пишем в историю
                $text = 'Команда <a href="team.php?id=' . $krr1[id] . '">' . $krr1['name'] .
                    '</a> и команда <a href="team.php?id=' . $krr2[id] . '">' . $krr2['name'] .
                    '</a> сыграли в ничью';
                if ($krr1['name'] != '' || $krr2['name'] != '') {
                    mysql_query("insert into `history_2` set 
                    `time`='" . $realtime . "', 
                    `type`='game',
                    `text`='" . $text . "' ;");
                }
                $fan = $krr1['fan'] + $rand;
                $moneyman1 = $krr1[money] + 100 + $spmoney + round($krr1['prib_stadium'] * 0.05);
                $nnman1 = $krr1[nnn]+1;

                mysql_query("update `team_2` set `fan`='" . $fan . "', `money`='" . $moneyman1 .
                    "',`nnn`='".$nnman1."' where id='" . $krr1[id] . "' LIMIT 1;");
            } else {
                //П2
                //Пишем в историю
                $text = 'Команда <a href="team.php?id=' . $krr2[id] . '">' . $krr2['name'] .
                    '</a> выиграла команду <a href="team.php?id=' . $krr1[id] . '">' . $krr1['name'] .
                    '</a>';
                if ($krr1['name'] != '' || $krr2['name'] != '') {
                    mysql_query("insert into `history_2` set 
                    `time`='" . $realtime . "', 
                    `type`='game',
                    `text`='" . $text . "' ;");
                }
                $losman1 = $krr1[lost]+1;
                if ($krr1['fan'] > 100) {
                    $fan = $krr1['fan'] - $rand;
                }

                mysql_query("update `team_2` set `fan`='" . $fan . "',`lost`='".$losman1."' where id='" . $krr1[id] .
                    "' LIMIT 1;");
            }

            // Команда 2
            if ($rezult[1] > $rezult[0]) {
                //П2
                $fan2 = $krr2['fan'] + $rand;
                $oputman2 = $krr2[rate] + 1;
                $moneyman2 = $krr2[money] + 500 + $spmoney2 + round($krr2['prib_stadium'] * 0.1);
                $winman2 = $krr2[win]+1;

                mysql_query("update `team_2` set `fan`='" . $fan2 . "', `rate`='" . $oputman2 .
                    "',`money`='" . $moneyman2 . "',`win`='".$winman2."' where id='" . $krr2[id] . "' LIMIT 1;");
            } elseif ($rezult[1] == $rezult[0]) {
                //Н
                $fan2 = $krr2['fan'] + $rand;
                $moneyman2 = $krr2[money] + 100 + $spmoney2 + round($krr2['prib_stadium'] * 0.05);
                $nnman2 = $krr2[nnn]+1;

                mysql_query("update `team_2` set `fan`='" . $fan2 . "',`money`='" . $moneyman2 .
                    "',`nnn`='".$nnman2."' where id='" . $krr2[id] . "' LIMIT 1;");
            } else {
                //П2
                $losman2 = $krr2[lost]+1;
                if ($krr2['fan'] > 100) {
                    $fan2 = $krr2['fan'] - $rand;
                }
                mysql_query("update `team_2` set `fan`='" . $fan2 . "',`lost`='".$losman2."' where id='" . $krr2[id] .
                    "' LIMIT 1;");
            }

            $rezult[0] = $rezult[0] + $art['goal1'];
            $rezult[1] = $rezult[1] + $art['goal2'];
            mysql_query("DELETE FROM `game_2` WHERE `id`='" . $art['id'] . "' LIMIT 1;");




            // ЕСЛИ ЛЧ
            if ($arts['chemp'] == 'liga') {
                mysql_query("update `liga_game_2` set `rez1`='" . $rezult[0] . "',`rez2`='" . $rezult[1] .
                    "', `pen1`='" . $pen1 . "',`pen2`='" . $pen2 . "', `id_report`='" . $id .
                    "' where id='" . $arts[id_match] . "' ;");
            }
            mysql_query("update `tur_2` set 
`sostav1`='" . $players1 . "', 
`sostav2`='" . $players2 . "', 

`tactics1`='".$krr1['shema']."|".$krr1['pass']."|".$krr1['strat']."|".$krr1['press']."|".$krr1['tactics']."|".$sila1."',
`tactics2`='".$krr2['shema']."|".$krr2['pass']."|".$krr2['strat']."|".$krr2['press']."|".$krr2['tactics']."|".$sila2."',
`menus`='".$menus."',
 `rez1`='" . $rezult[0] . "', 
`rez2`='" . $rezult[1] . "',
`pen1`='" . $pen1 . "',
`pen2`='" . $pen2 . "'  

where id='" . $art['id'] . "';");

            $bb = mysql_query("SELECT `id` FROM `gnews_2` WHERE `tid`='" . $art['id'] .
                "' ;");
            while ($bb1 = mysql_fetch_assoc($bb)) {
                mysql_query("DELETE FROM `gnews_2` WHERE `id`='" . $bb1['id'] . "' LIMIT 1;");
            }

            // ЕСЛИ ЧЕМПИОНАТ
			$do = array('ua', 'rus', 'en', 'sp', 'it', 'ge', 'bel', 'por', 'fr');
            if (in_array($arts['chemp'], $do)) {


                if ($rezult[0] > $rezult[1]) {
                    $igr1 = $krr1[ii] + 1;
                    $igr2 = $krr2[ii] + 1;

                    $raz1 = $krr1[raz] + ($rezult[0] - $rezult[1]);
                    $raz2 = $krr2[raz] + ($rezult[1] - $rezult[0]);

                    $win1 = $krr1[vv] + 1;
                    $los2 = $krr2[pp] + 1;

                    $gz1 = $krr1[mz] + $rezult[0];
                    $gz2 = $krr2[mz] + $rezult[1];

                    $gp1 = $krr1[mp] + $rezult[1];
                    $gp2 = $krr2[mp] + $rezult[0];

                    $ochey1 = $krr1[oo] + 3;
                    $ochey2 = $krr2[oo] + 0;

                    mysql_query("update `team_2` set `ii`='" . $igr1 . "',`vv`='" . $win1 .
                        "',`mz`='" . $gz1 . "',`mp`='" . $gp1 . "', `raz`='" . $raz1 . "', `oo`='" . $ochey1 .
                        "' where id='" . $krr1[id] . "' LIMIT 1;");
                    mysql_query("update `team_2` set `ii`='" . $igr2 . "',`pp`='" . $los2 .
                        "',`mz`='" . $gz2 . "',`mp`='" . $gp2 . "', `raz`='" . $raz2 . "', `oo`='" . $ochey2 .
                        "' where id='" . $krr2[id] . "' LIMIT 1;");
                } elseif ($rezult[1] > $rezult[0]) {
                    $igr1 = $krr1[ii] + 1;
                    $igr2 = $krr2[ii] + 1;

                    $raz1 = $krr1[raz] + ($rezult[0] - $rezult[1]);
                    $raz2 = $krr2[raz] + ($rezult[1] - $rezult[0]);

                    $los1 = $krr1[pp] + 1;
                    $win2 = $krr2[vv] + 1;

                    $gz1 = $krr1[mz] + $rezult[0];
                    $gz2 = $krr2[mz] + $rezult[1];

                    $gp1 = $krr1[mp] + $rezult[1];
                    $gp2 = $krr2[mp] + $rezult[0];

                    $ochey1 = $krr1[oo] + 0;
                    $ochey2 = $krr2[oo] + 3;

                    mysql_query("update `team_2` set `ii`='" . $igr1 . "',`pp`='" . $los1 .
                        "',`mz`='" . $gz1 . "',`mp`='" . $gp1 . "', `raz`='" . $raz1 . "', `oo`='" . $ochey1 .
                        "' where id='" . $krr1[id] . "' LIMIT 1;");
                    mysql_query("update `team_2` set `ii`='" . $igr2 . "',`vv`='" . $win2 .
                        "',`mz`='" . $gz2 . "',`mp`='" . $gp2 . "', `raz`='" . $raz2 . "', `oo`='" . $ochey2 .
                        "' where id='" . $krr2[id] . "' LIMIT 1;");
                } else {
                    $igr1 = $krr1[ii] + 1;
                    $igr2 = $krr2[ii] + 1;

                    $raz1 = $krr1[raz] + ($rezult[0] - $rezult[1]);
                    $raz2 = $krr2[raz] + ($rezult[1] - $rezult[0]);

                    $nn1 = $krr1[nn] + 1;
                    $nn2 = $krr2[nn] + 1;

                    $gz1 = $krr1[mz] + $rezult[0];
                    $gz2 = $krr2[mz] + $rezult[1];

                    $gp1 = $krr1[mp] + $rezult[1];
                    $gp2 = $krr2[mp] + $rezult[0];

                    $ochey1 = $krr1[oo] + 1;
                    $ochey2 = $krr2[oo] + 1;

                    mysql_query("update `team_2` set `ii`='" . $igr1 . "',`nn`='" . $nn1 .
                        "',`mz`='" . $gz1 . "',`mp`='" . $gp1 . "', `raz`='" . $raz1 . "', `oo`='" . $ochey1 .
                        "' where id='" . $krr1[id] . "' LIMIT 1;");
                    mysql_query("update `team_2` set `ii`='" . $igr2 . "',`nn`='" . $nn2 .
                        "',`mz`='" . $gz2 . "',`mp`='" . $gp2 . "', `raz`='" . $raz2 . "', `oo`='" . $ochey2 .
                        "' where id='" . $krr2[id] . "' LIMIT 1;");
                }


            }

            // ЕСЛИ ЛЧ
            if ($arts['chemp'] == 'liga') {
                mysql_query("update `liga_game_2` set `rez1`='" . $rezult[0] . "',`rez2`='" . $rezult[1] .
                    "', `pen1`='" . $pen1 . "',`pen2`='" . $pen2 . "', `id_report`='" . $id .
                    "' where id='" . $arts[id_match] . "' LIMIT 1;");


                $l1 = @mysql_query("select * from `liga_group_2` where id_team='" . $art[id_team1] .
                    "' LIMIT 1;");
                $lrr1 = @mysql_fetch_array($l1);

                $l2 = @mysql_query("select * from `liga_group_2` where id_team='" . $art[id_team2] .
                    "' LIMIT 1;");
                $lrr2 = @mysql_fetch_array($l2);


                if ($rezult[0] > $rezult[1]) {
                    $igr1 = $lrr1[igr] + 1;
                    $igr2 = $lrr2[igr] + 1;

                    $win1 = $lrr1[win] + 1;
                    $los2 = $lrr2[los] + 1;

                    $gz1 = $lrr1[gz] + $rezult[0];
                    $gz2 = $lrr2[gz] + $rezult[1];

                    $gp1 = $lrr1[gp] + $rezult[1];
                    $gp2 = $lrr2[gp] + $rezult[0];

                    $ochey1 = $lrr1[ochey] + 3;
                    $ochey2 = $lrr2[ochey] + 0;

                    mysql_query("update `liga_group_2` set `igr`='" . $igr1 . "',`win`='" . $win1 .
                        "',`gz`='" . $gz1 . "',`gp`='" . $gp1 . "', `ochey`='" . $ochey1 .
                        "' where id='" . $lrr1[id] . "' LIMIT 1;");
                    mysql_query("update `liga_group_2` set `igr`='" . $igr2 . "',`los`='" . $los2 .
                        "',`gz`='" . $gz2 . "',`gp`='" . $gp2 . "', `ochey`='" . $ochey2 .
                        "' where id='" . $lrr2[id] . "' LIMIT 1;");
                } elseif ($rezult[1] > $rezult[0]) {
                    $igr1 = $lrr1[igr] + 1;
                    $igr2 = $lrr2[igr] + 1;

                    $los1 = $lrr1[los] + 1;
                    $win2 = $lrr2[win] + 1;

                    $gz1 = $lrr1[gz] + $rezult[0];
                    $gz2 = $lrr2[gz] + $rezult[1];

                    $gp1 = $lrr1[gp] + $rezult[1];
                    $gp2 = $lrr2[gp] + $rezult[0];

                    $ochey1 = $lrr1[ochey] + 0;
                    $ochey2 = $lrr2[ochey] + 3;

                    mysql_query("update `liga_group_2` set `igr`='" . $igr1 . "',`los`='" . $los1 .
                        "',`gz`='" . $gz1 . "',`gp`='" . $gp1 . "', `ochey`='" . $ochey1 .
                        "' where id='" . $lrr1[id] . "' LIMIT 1;");
                    mysql_query("update `liga_group_2` set `igr`='" . $igr2 . "',`win`='" . $win2 .
                        "',`gz`='" . $gz2 . "',`gp`='" . $gp2 . "', `ochey`='" . $ochey2 .
                        "' where id='" . $lrr2[id] . "' LIMIT 1;");
                } else {
                    $igr1 = $lrr1[igr] + 1;
                    $igr2 = $lrr2[igr] + 1;

                    $nn1 = $lrr1[nn] + 1;
                    $nn2 = $lrr2[nn] + 1;

                    $gz1 = $lrr1[gz] + $rezult[0];
                    $gz2 = $lrr2[gz] + $rezult[1];

                    $gp1 = $lrr1[gp] + $rezult[1];
                    $gp2 = $lrr2[gp] + $rezult[0];

                    $ochey1 = $lrr1[ochey] + 1;
                    $ochey2 = $lrr2[ochey] + 1;

                    mysql_query("update `liga_group_2` set `igr`='" . $igr1 . "',`nn`='" . $nn1 .
                        "',`gz`='" . $gz1 . "',`gp`='" . $gp1 . "', `ochey`='" . $ochey1 .
                        "' where id='" . $lrr1[id] . "' LIMIT 1;");
                    mysql_query("update `liga_group_2` set `igr`='" . $igr2 . "',`nn`='" . $nn2 .
                        "',`gz`='" . $gz2 . "',`gp`='" . $gp2 . "', `ochey`='" . $ochey2 .
                        "' where id='" . $lrr2[id] . "' LIMIT 1;");
                }

            }

            if ($arts['chemp'] == $priz['name']) {

                if ($rezult[0] > $rezult[1]) {
                    if ($tu < 5) {
                        mysql_query("INSERT INTO `start_2` set `chemp`='" . $arts['chemp'] . "',`tur`='" .
                            $tu . "', `id_team`='" . $krr1['id'] . "',`name_team`='" . $krr1['name'] . "' ;");
                    }

                } elseif ($rezult[1] > $rezult[0]) {
                    if ($tu < 5) {
                        mysql_query("INSERT INTO `start_2` set `chemp`='" . $arts['chemp'] . "',`tur`='" .
                            $tu . "', `id_team`='" . $krr2['id'] . "',`name_team`='" . $krr2['name'] . "' ;");
                    }
                } else {
                    if ($pen1 > $pen2) {
                        if ($tu < 5) {
                            mysql_query("INSERT INTO `start_2` set `chemp`='" . $arts['chemp'] . "',`tur`='" .
                                $tu . "', `id_team`='" . $krr1['id'] . "',`name_team`='" . $krr1['name'] . "' ;");
                        }
                    } else {
                        if ($tu < 5) {
                            mysql_query("INSERT INTO `start_2` set `chemp`='" . $arts['chemp'] . "',`tur`='" .
                                $tu . "', `id_team`='" . $krr2['id'] . "',`name_team`='" . $krr2['name'] . "' ;");
                        }
                    }
                }

            }

        }
    }
}
?>