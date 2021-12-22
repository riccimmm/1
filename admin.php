<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
require_once ('incfiles/class_upload.php');

if ($rights >= 7) {



    switch ($act) {

      case 'set':
            if (isset($_POST['submit'])) {

mysql_query("UPDATE `set_2` SET `val`='" . check($_POST['fed']) . "' WHERE `key` = 'fed'");

     header('location: admin.php?act=set');
            } else {
                echo '<div class="phdr"><b><a href="admin.php">Админ Панель</a></b> | Настройки</div>';
                echo '<div class="rmenu">Настройки менеджера';



                
                echo "$set_m[fed]";
                echo '
                <form action="admin.php?act=set" method="post">';
                echo '<h3>Редактирование федерации</h3>';
        
        echo '<input type="radio" value="1" name="fed" ' . ($set_m['fed'] == 1 ? 'checked="checked"' : '') . '/>&nbsp;Вкл.<br />';
        echo '<input type="radio" value="0" name="fed" ' . ($set_m['fed'] == 0 ? 'checked="checked"' : '') . '/>&nbsp;Выкл.';
                echo '<br/><input type="submit" name="submit" value="Сохранить" /></form>';
                echo '</div>';
            }
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            break;   


        default:




            echo '<div class="gmenu"><b>Админка</b></div>';

            echo '<p><h3><img src="images/modules.png" width="16" height="16" class="left" />&nbsp;Модули</h3><ul>';
			if ($rights >= 6 || $rights == 1) {
            if ($_GET['menu'] == 1) {

                echo '<li><a href="admin.php">Управление командами</a></li>';
                $matile = mysql_query('SELECT * from `team_2` GROUP BY `strana`;');
                while ($mat = mysql_fetch_array($matile)) {
                    echo '<li><img src="flag/' . $mat['strana'] .
                        '.png" alt=""/> <a href="admin.php?act=divizion&amp;strana=' . $mat['strana'] .
                        '">' . $mat['divizion'] . '</a></li>';
                }

            } else {
               if ($user_id == 1){


}          
  }

                echo '<li><a href="admin.php?menu=1">Управление командами</a></li>';
				echo '<li><a href="union/admin.php">Админка союза</a></li>';
			}
			
            if ($rights = 7) {
                echo '<li><a href="admin.php?act=dom">Управление постройками</a></li>';
				echo '<li><a href="admin.php?act=sponsor">Управление спонсорами</a></li>';
                echo '<li><a href="admin.php?act=tur">Управление турнирами</a></li>';
                echo '<li><a href="http://futmen.net/team/shop.php?act=admin">Управление магазином</a></li>';

                echo '<li><a href="admin.php?act=clean">Чистка менеджеров</a></li>';
               

            }   
			    if ($rights >= 7) {
			    echo '<li><a href="admin.php?act=liga">Управление чемпионатамы</a></li>';
                echo '<li><a href="admin.php?act=ligac">Управление лигой чемпионов</a></li>';
                }
            echo '</ul></p>';
            break;

        case 'ligac':
            echo '<div class="gmenu"><b>Управление лигой чемпионов</b></div>';
            echo '<a href="admin.php?act=lc">Добавление команд</a><br/>';
            echo '<a href="admin.php?act=rozp">Розпределить по групам</a><br/>';
            echo '<a href="admin.php?act=kalend">Создать кадлендарь</a><br/>';
            echo '<a href="admin.php?act=priz">Начислить приз победителю</a><br/>';
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';

            break;



     case 'liga':
            echo '<div class="menu"> Чемпионаты</div>';
            if (isset($_POST['submit'])) {
                $chemp = $_POST['name'];

                if (empty($chemp))
                    $error = $error . 'Не выбрана лига!<br/>';
                if (empty($error)) {


                    $q1 = mysql_query("SELECT * FROM `team_2` where `strana`='" . $chemp .
                        "' ORDER BY `oo` DESC, `raz` DESC, `mz` DESC ;");
                    $mesto = 1;
                    while ($arr = mysql_fetch_array($q1)) {
                        if ($mesto == 1) {
                            $q1 = @mysql_query("select * from `team_2` where id='" . $arr[id_team] .
                                "' LIMIT 1;");
                            $winkom = @mysql_fetch_array($q1);

                            $rate = $winkom[rate] + 100;
                            $money = $winkom[money] + 1000000;
                            $fans = $winkom[fan] + 10000;

                            // mysql_query("insert into `priz_2` set
                            // `id_cup`='".$act."',
                            // `time`='".$realtime."',
                            // `name`='".$name_liga."',
                            // `priz`='10000',
                            // `win`='454'
                            // ;");

                            mysql_query("update `team_2` set `rate`='" . $rate . "', `money`='" . $money .
                                "',  `fan`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
                        }

                        if ($mesto == 2) {
                            $q1 = @mysql_query("select * from `team_2` where id='" . $arr[id_team] .
                                "' LIMIT 1;");
                            $winkom = @mysql_fetch_array($q1);

                            $rate = $winkom[rate] + 50;
                            $money = $winkom[money] + 500000;
                            $fans = $winkom[fan] + 5000;

                            mysql_query("update `team_2` set `rate`='" . $rate . "', `money`='" . $money .
                                "', `fan`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
                        }

                        if ($mesto == 3) {
                            $q1 = @mysql_query("select * from `team_2` where id='" . $arr[id_team] .
                                "' LIMIT 1;");
                            $winkom = @mysql_fetch_array($q1);

                            $rate = $winkom[rate] + 25;
                            $money = $winkom[money] + 250000;
                            $fans = $winkom[fan] + 2500;

                            mysql_query("update `team_2` set `rate`='" . $rate . "', `money`='" . $money .
                                "', `fan`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
                        }


                        ++$mesto;
                        ++$i;
                    }


                    mysql_query("update `team_2` SET 
`ii`='0',	
`vv`='0',	 	
`nn`='0',	 	
`pp`='0',	 	
`mz`='0',	 	
`mp`='0',	 	
`raz`='0',	 	
`oo`='0' WHERE `strana` = '" . $chemp . "';");


                    echo $chemp;
                    mysql_query("DELETE FROM `tur_2` WHERE `chemp` = '" . $chemp . "' ;");

                    function add($tur, $id1, $id2)
                    {
                        global $chemp;

                        $req = mysql_query('SELECT * FROM `team_2` where `strana`="' . $chemp .
                            '" order by id asc;');
                        $i = 1;
                        while ($arr = mysql_fetch_array($req)) {
                            $id[$i] = $arr['id'];
                            $name[$i] = $arr['name'];
                            ++$i;
                        }


                        // $tur = 31-$tur;

                        if ($tur == 1) {
                            $turtime = strtotime($_POST['time']);
                        } else {
                            $turtime = strtotime($_POST['time']) + (3600 * 24 * ($tur - 1));
                        }


                        $str = mysql_query("insert into `tur_2` set 
`chemp`='" . $chemp . "',
`tur`='" . $tur . "',
`time`='" . $turtime . "',
`id_team1`='" . $id[$id1] . "',
`id_team2`='" . $id[$id2] . "',
`name_team1`='" . $name[$id1] . "',
`name_team2`='" . $name[$id2] . "'
");

                        if ($chemp == 'ua' || $chemp == 'rus' || $chemp == 'ge' || $chemp == 'fr' || $chemp ==
                            'bel' || $chemp == 'por') {
                            $tur2 = $tur + 15;
                            $turtime2 = $turtime + (3600 * 24 * 16);
                        } else {
                            $tur2 = $tur + 19;
                            $turtime2 = $turtime + (3600 * 24 * 20);
                        }
                        $str = mysql_query("insert into `m_tur` set 
`chemp`='" . $chemp . "',
`tur`='" . $tur2 . "',
`time`='" . $turtime2 . "',
`id_team1`='" . $id[$id2] . "',
`id_team2`='" . $id[$id1] . "',
`name_team1`='" . $name[$id2] . "',
`name_team2`='" . $name[$id1] . "'
");

                        return $str;
                    }


                    if ($chemp == 'ua' || $chemp == 'rus' || $chemp == 'ge' || $chemp == 'fr' || $chemp ==
                        'bel' || $chemp == 'por') {


                        //1
                        echo add(1, 1, 2);
                        echo add(1, 3, 4);
                        echo add(1, 5, 6);
                        echo add(1, 7, 8);
                        echo add(1, 9, 10);
                        echo add(1, 11, 12);
                        echo add(1, 13, 14);
                        echo add(1, 15, 16);


                        //2
                        echo add(2, 4, 5);
                        echo add(2, 6, 3);
                        echo add(2, 8, 9);
                        echo add(2, 10, 7);
                        echo add(2, 12, 13);
                        echo add(2, 14, 11);
                        echo add(2, 16, 1);
                        echo add(2, 2, 15);


                        //3
                        echo add(3, 3, 8);
                        echo add(3, 5, 10);
                        echo add(3, 7, 4);
                        echo add(3, 9, 6);
                        echo add(3, 11, 16);
                        echo add(3, 13, 2);
                        echo add(3, 15, 12);
                        echo add(3, 1, 14);


                        //4
                        echo add(4, 4, 9);
                        echo add(4, 6, 7);
                        echo add(4, 8, 5);
                        echo add(4, 10, 3);
                        echo add(4, 12, 1);
                        echo add(4, 14, 15);
                        echo add(4, 16, 13);
                        echo add(4, 2, 11);


                        //5
                        echo add(5, 3, 12);
                        echo add(5, 5, 14);
                        echo add(5, 7, 16);
                        echo add(5, 9, 2);
                        echo add(5, 11, 4);
                        echo add(5, 13, 6);
                        echo add(5, 15, 8);
                        echo add(5, 1, 10);

                        //6
                        echo add(6, 4, 13);
                        echo add(6, 6, 11);
                        echo add(6, 8, 1);
                        echo add(6, 10, 15);
                        echo add(6, 12, 5);
                        echo add(6, 14, 3);
                        echo add(6, 16, 9);
                        echo add(6, 2, 7);


                        //7
                        echo add(7, 3, 16);
                        echo add(7, 5, 2);
                        echo add(7, 7, 12);
                        echo add(7, 9, 14);
                        echo add(7, 11, 8);
                        echo add(7, 13, 10);
                        echo add(7, 15, 4);
                        echo add(7, 1, 6);


                        //8
                        echo add(8, 4, 1);
                        echo add(8, 6, 15);
                        echo add(8, 8, 13);
                        echo add(8, 10, 11);
                        echo add(8, 12, 9);
                        echo add(8, 14, 7);
                        echo add(8, 16, 5);
                        echo add(8, 2, 3);


                        //9
                        echo add(9, 6, 4);
                        echo add(9, 10, 8);
                        echo add(9, 14, 12);
                        echo add(9, 2, 16);
                        echo add(9, 5, 3);
                        echo add(9, 9, 7);
                        echo add(9, 13, 11);
                        echo add(9, 1, 15);


                        //10
                        echo add(10, 4, 10);
                        echo add(10, 3, 9);
                        echo add(10, 8, 6);
                        echo add(10, 7, 5);
                        echo add(10, 12, 2);
                        echo add(10, 11, 1);
                        echo add(10, 16, 14);
                        echo add(10, 15, 13);


                        //11
                        echo add(11, 6, 12);
                        echo add(11, 5, 11);
                        echo add(11, 10, 16);
                        echo add(11, 9, 15);
                        echo add(11, 14, 4);
                        echo add(11, 13, 3);
                        echo add(11, 2, 8);
                        echo add(11, 1, 7);

                        //12
                        echo add(12, 4, 2);
                        echo add(12, 3, 1);
                        echo add(12, 8, 14);
                        echo add(12, 7, 13);
                        echo add(12, 12, 10);
                        echo add(12, 11, 9);
                        echo add(12, 16, 6);
                        echo add(12, 15, 5);


                        //13
                        echo add(13, 8, 4);
                        echo add(13, 7, 3);
                        echo add(13, 16, 12);
                        echo add(13, 15, 11);
                        echo add(13, 10, 6);
                        echo add(13, 9, 5);
                        echo add(13, 2, 14);
                        echo add(13, 1, 13);


                        //14
                        echo add(14, 4, 16);
                        echo add(14, 3, 15);
                        echo add(14, 6, 2);
                        echo add(14, 5, 1);
                        echo add(14, 12, 8);
                        echo add(14, 11, 7);
                        echo add(14, 14, 10);
                        echo add(14, 13, 9);


                        //15
                        echo add(15, 12, 4);
                        echo add(15, 11, 3);
                        echo add(15, 14, 6);
                        echo add(15, 13, 5);
                        echo add(15, 16, 8);
                        echo add(15, 15, 7);
                        echo add(15, 2, 10);
                        echo add(15, 1, 9);
                    } else {

                        //1
                        echo add(1, 1, 2);
                        echo add(1, 3, 4);
                        echo add(1, 5, 6);
                        echo add(1, 7, 8);
                        echo add(1, 9, 10);
                        echo add(1, 11, 12);
                        echo add(1, 13, 14);
                        echo add(1, 15, 16);
                        echo add(1, 17, 18);
                        echo add(1, 19, 20);
                        //2
                        echo add(2, 4, 5);
                        echo add(2, 6, 3);
                        echo add(2, 8, 9);
                        echo add(2, 10, 7);
                        echo add(2, 12, 13);
                        echo add(2, 14, 11);
                        echo add(2, 16, 1);
                        echo add(2, 2, 15);
                        echo add(2, 18, 19);
                        echo add(2, 17, 20);


                        //3
                        echo add(3, 3, 8);
                        echo add(3, 5, 10);
                        echo add(3, 7, 4);
                        echo add(3, 9, 6);
                        echo add(3, 11, 16);
                        echo add(3, 13, 2);
                        echo add(3, 15, 12);
                        echo add(3, 1, 14);
                        echo add(3, 20, 18);
                        echo add(3, 17, 19);

                        //4
                        echo add(4, 4, 9);
                        echo add(4, 6, 7);
                        echo add(4, 8, 5);
                        echo add(4, 10, 3);
                        echo add(4, 17, 1);
                        echo add(4, 12, 20);
                        echo add(4, 2, 18);
                        echo add(4, 19, 11);
                        echo add(4, 14, 15);
                        echo add(4, 16, 13);


                        //5
                        echo add(5, 3, 12);
                        echo add(5, 5, 14);
                        echo add(5, 7, 16);
                        echo add(5, 9, 2);
                        echo add(5, 11, 4);
                        echo add(5, 13, 6);
                        echo add(5, 17, 15);
                        echo add(5, 8, 20);
                        echo add(5, 1, 18);
                        echo add(5, 19, 10);


                        //6
                        echo add(6, 4, 13);
                        echo add(6, 6, 11);
                        echo add(6, 8, 1);
                        echo add(6, 10, 15);
                        echo add(6, 12, 5);
                        echo add(6, 14, 3);
                        echo add(6, 16, 18);
                        echo add(6, 17, 9);
                        echo add(6, 7, 20);
                        echo add(6, 19, 2);


                        //7
                        echo add(7, 3, 16);
                        echo add(7, 5, 2);
                        echo add(7, 7, 12);
                        echo add(7, 9, 14);
                        echo add(7, 11, 8);
                        echo add(7, 15, 4);
                        echo add(7, 10, 18);
                        echo add(7, 17, 13);
                        echo add(7, 1, 19);
                        echo add(7, 20, 6);


                        //8
                        echo add(8, 4, 1);
                        echo add(8, 6, 15);
                        echo add(8, 8, 13);
                        echo add(8, 10, 11);
                        echo add(8, 12, 9);
                        echo add(8, 16, 5);
                        echo add(8, 17, 14);
                        echo add(8, 18, 7);
                        echo add(8, 19, 3);
                        echo add(8, 20, 2);


                        //9
                        echo add(9, 6, 4);
                        echo add(9, 10, 8);
                        echo add(9, 14, 12);
                        echo add(9, 2, 16);
                        echo add(9, 9, 7);
                        echo add(9, 13, 11);
                        echo add(9, 5, 17);
                        echo add(9, 3, 18);
                        echo add(9, 15, 19);
                        echo add(9, 1, 20);


                        //10
                        echo add(10, 4, 10);
                        echo add(10, 3, 9);
                        echo add(10, 7, 5);
                        echo add(10, 12, 2);
                        echo add(10, 11, 1);
                        echo add(10, 15, 13);
                        echo add(10, 18, 8);
                        echo add(10, 6, 17);
                        echo add(10, 19, 16);
                        echo add(10, 14, 20);


                        //11
                        echo add(11, 6, 12);
                        echo add(11, 10, 16);
                        echo add(11, 9, 15);
                        echo add(11, 14, 4);
                        echo add(11, 2, 8);
                        echo add(11, 1, 7);
                        echo add(11, 17, 3);
                        echo add(11, 18, 13);
                        echo add(11, 19, 5);
                        echo add(11, 20, 11);


                        //12
                        echo add(12, 4, 2);
                        echo add(12, 3, 1);
                        echo add(12, 8, 14);
                        echo add(12, 7, 13);
                        echo add(12, 16, 6);
                        echo add(12, 15, 5);
                        echo add(12, 9, 18);
                        echo add(12, 11, 17);
                        echo add(12, 10, 20);
                        echo add(12, 12, 19);


                        //13
                        echo add(13, 7, 3);
                        echo add(13, 16, 12);
                        echo add(13, 15, 11);
                        echo add(13, 10, 6);
                        echo add(13, 2, 14);
                        echo add(13, 1, 13);
                        echo add(13, 17, 8);
                        echo add(13, 4, 18);
                        echo add(13, 19, 9);
                        echo add(13, 5, 20);


                        //14
                        echo add(14, 4, 16);
                        echo add(14, 3, 15);
                        echo add(14, 6, 2);
                        echo add(14, 5, 1);
                        echo add(14, 12, 8);
                        echo add(14, 11, 7);
                        echo add(14, 18, 14);
                        echo add(14, 17, 10);
                        echo add(14, 20, 9);
                        echo add(14, 19, 13);


                        //15
                        echo add(15, 12, 4);
                        echo add(15, 11, 3);
                        echo add(15, 1, 9);
                        echo add(15, 13, 5);
                        echo add(15, 16, 8);
                        echo add(15, 2, 10);
                        echo add(15, 7, 17);
                        echo add(15, 18, 15);
                        echo add(15, 14, 19);
                        echo add(15, 20, 6);


                        //16
                        echo add(16, 1, 10);
                        echo add(16, 19, 7);
                        echo add(16, 2, 11);
                        echo add(16, 13, 3);
                        echo add(16, 17, 12);
                        echo add(16, 20, 4);
                        echo add(16, 18, 5);
                        echo add(16, 14, 6);
                        echo add(16, 15, 8);
                        echo add(16, 16, 9);


                        //17
                        echo add(17, 1, 15);
                        echo add(17, 17, 2);
                        echo add(17, 16, 19);
                        echo add(17, 18, 6);
                        echo add(17, 8, 4);
                        echo add(17, 14, 7);
                        echo add(18, 14, 10);
                        echo add(17, 20, 3);
                        echo add(17, 5, 11);
                        echo add(18, 13, 9);

                        //18
                        echo add(19, 12, 1);
                        echo add(18, 2, 7);
                        echo add(18, 5, 3);
                        echo add(19, 19, 4);
                        echo add(19, 8, 6);
                        echo add(18, 11, 9);
                        echo add(19, 13, 10);
                        echo add(18, 18, 12);
                        echo add(18, 20, 15);
                        echo add(17, 17, 16);

                        //19
                        echo add(18, 1, 6);
                        echo add(19, 2, 3);
                        echo add(19, 9, 5);
                        echo add(17, 12, 10);
                        echo add(19, 18, 11);
                        echo add(19, 16, 14);
                        echo add(18, 19, 8);
                        echo add(19, 15, 7);
                        echo add(19, 20, 13);
                        echo add(18, 17, 4);

                    }
                    header('location: admin.php');
                } else {
                    echo '<div class="rmenu"><p><b>ОШИБКА!</b><br />' . $error . '</p></div>';
                }

            } else {
                echo '<form action="admin.php?act=liga" method="post">';
                echo '<div class="gmenu">';
                echo '<b>Лига</b><br/><small>Выберете лигу</small><br />';
                $matile = mysql_query('SELECT * from `team_2` GROUP BY `strana`;');
                while ($mat = mysql_fetch_array($matile)) {
                    echo '<input type="radio" name="name" value="' . $mat['strana'] . '" /> ' . $mat['divizion'] .
                        '<br/>
              ';
                }
                echo '<p><b>Дата первого тура</b><br /><small>00.00.0000 00:00</small><br /><input type="text" size="20" maxlength="16" name="time" /></p>';
                echo '<p><input type="submit" name="submit" value="ок" /></p></div></form>';
            }
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            break;




        case 'reload':
            if (isset($_POST['submit'])) {

                $req = @mysql_query("select * from `player_2` ;");
                while ($arr = mysql_fetch_array($req)) {

                    $tal = rand(2, 4);

                    $otbor = rand(1, 5);
                    $opeka = rand(1, 5);
                    $drib = rand(1, 5);
                    $priem = rand(1, 5);
                    $vunos = rand(1, 5);
                    $pas = rand(1, 5);
                    $sila_ud = rand(1, 5);
                    $to_ud = rand(1, 5);

                    $mas = $otbor + $opeka + $drib + $priem + $vunos + $pas + $sila_ud + $to_ud;

                    mysql_query("update `player_2` set 
`t_time`='0',
`t_money`='0',
`tal`='" . $tal . "', 
`mas`='" . $mas . "', 
`fiz`='100', 
`opit`='0', 
`rm`='" . $mas . "',  
`otbor`='" . $otbor . "', 
`opeka`='" . $opeka . "', 
`drib`='" . $drib . "', 
`priem`='" . $priem . "', 
`vonos`='" . $vunos . "', 
`pas`='" . $pas . "', 
`sila`='" . $sila_ud . "', 
`tocnost`='" . $to_ud . "',
`goal`='0',
`yellow`='0',
`utime`='0',
`btime`='0' where id='" . $arr['id'] . "'
;");
                    ++$i;
                }

                mysql_query("update `team_2` set 
`rate`='0',
`money`='10000',
`timeres`='0',
`trener`='0',
`trenertime`='0',
`lvl_stad`='0',
`bilet`='0',
`tmatch`='0',
`med`='0',
`fan`='0',
`sponsor`='0',
`lost`='0',
`lvl`='0',
`name_stadium`='Арена',
`mest`='0',
`price_bilet`='0',
`prib_stadium`='0'
;");


                header('location: admin.php');
            } else {
                echo '<div class="phdr"><b><a href="admin.php">Админ Панель</a></b> | удалить матч</div>';
                echo '<div class="rmenu"><p>Внимание!<br/>Вы действительно хотите збросить систему ?';
                echo '</p><p><form action="admin.php?act=reload" method="post"><input type="submit" name="submit" value="Зброс" /></form>';
                echo '</p></div>';
            }
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            break;
            
            
      
           
            
        case 'priz':
            echo '<div class="menu"> Лига чемпионов</div>';
            if (isset($_POST['submit'])) {

                $money = $_POST['money'];
                $fan = $_POST['fan'];
                $oput = $_POST['oput'];
                if (empty($money) || empty($fan) || empty($oput))
                    $error = $error . 'Пустой параметр!<br/>';
                if (empty($error)) {

                    // Выводим туры
                    $g = @mysql_query("select * from `liga_game_2` where gr='1/1' LIMIT 1;");


                    $arr = mysql_fetch_array($g);

                    //Кто победил?
                    if ($arr[rez1] > $arr[rez2] || $arr[pen1] > $arr[pen2]) {
                        $id_win_1 = $arr['id_team1'];
                        $name_win_1 = $arr['name_team1'];
                    } else {
                        $id_win_1 = $arr['id_team2'];
                        $name_win_1 = $arr['name_team2'];
                    }


                    echo '<br/>Победитель: ' . $name_win_1 . '<br/>';


                    $q1 = @mysql_query("select * from `team_2` where id='" . $id_win_1 .
                        "' LIMIT 1;");
                    $winkom = @mysql_fetch_array($q1);

                    $oput = $winkom[rate] + $_POST['oput'];
                    $money = $winkom[money] + $_POST['money'];


                    $fans = $winkom[fan] + $_POST['fan'];

                    mysql_query("update `team_2` set `rate`='" . $oput . "', `money`='" . $money .
                        "', `fan`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");

                    header('location: admin.php');
                } else {
                    echo '<div class="rmenu"><p><b>ОШИБКА!</b><br />' . $error . '</p></div>';
                }

            } else {
                echo '<form action="admin.php?act=priz" method="post">';
                echo '<div class="gmenu">';
                echo '<b>Приз</b><br/><small>Начисление приза победителю</small><br />';
                echo '<p><b>Деньги</b><br /><br /><input type="text" size="20" maxlength="16" name="money" /></p>';
                echo '<p><b>Фаны</b><br /><br /><input type="text" size="20" maxlength="16" name="fan" /></p>';
                echo '<p><b>Опит</b><br /><br /><input type="text" size="20" maxlength="16" name="oput" /></p>';
                echo '<p><input type="submit" name="submit" value="ок" /></p></div></form>';
            }
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            break;

        case 'kalend':
            echo '<div class="menu"> Чемпионаты</div>';
            if (isset($_POST['submit'])) {
                $do = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
                mysql_query("TRUNCATE TABLE `liga_game_2`");
                foreach ($do as $gr) {
                    $req = mysql_query("SELECT * FROM `liga_group_2` where `group`='" . $gr .
                        "' order by ochey DESC, `gz` DESC LIMIT 4;");
                    $mesto = 1;

                    while ($arr = mysql_fetch_array($req)) {
                        echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';

                        echo '</tr>';

                        switch ($mesto) {
                            case "1":
                                $id_1 = $arr['id_team'];
                                $name_1 = $arr['name_team'];
                                $level_1 = $arr['level_team'];
                                $union_1 = $arr['union_team'];
                                break;

                            case "2":
                                $id_2 = $arr['id_team'];
                                $name_2 = $arr['name_team'];
                                $level_2 = $arr['level_team'];
                                $union_2 = $arr['union_team'];
                                break;

                            case "3":
                                $id_3 = $arr['id_team'];
                                $name_3 = $arr['name_team'];
                                $level_3 = $arr['level_team'];
                                $union_3 = $arr['union_team'];
                                break;

                            case "4":
                                $id_4 = $arr['id_team'];
                                $name_4 = $arr['name_team'];
                                $level_4 = $arr['level_team'];
                                $union_4 = $arr['union_team'];
                                break;
                        }

                        ++$mesto;
                    }
                    echo '</table>';


                    //Проверяем туры
                    $q = @mysql_query("select * from `liga_game_2` where gr='" . $gr . "';");
                    $totalgame = mysql_num_rows($q);

                    if ($totalgame == 0) {
                        $turtime1 = $realtime;
                        $turtime2 = $turtime1 + (1 * 24 * 3600);
                        $turtime3 = $turtime1 + (2 * 24 * 3600);
                        $turtime4 = $turtime1 + (3 * 24 * 3600);
                        $turtime5 = $turtime1 + (4 * 24 * 3600);
                        $turtime6 = $turtime1 + (5 * 24 * 3600);

                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='1',`time`='" .
                            $turtime1 . "',`id_team1`='" . $id_1 . "',`id_team2`='" . $id_2 .
                            "',`union_team1`='" . $union_1 . "',`union_team2`='" . $union_2 .
                            "',`name_team1`='" . $name_1 . "',`name_team2`='" . $name_2 .
                            "',`level_team1`='" . $level_1 . "',`level_team2`='" . $level_2 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='1',`time`='" .
                            $turtime1 . "',`id_team1`='" . $id_3 . "',`id_team2`='" . $id_4 .
                            "',`union_team1`='" . $union_3 . "',`union_team2`='" . $union_4 .
                            "',`name_team1`='" . $name_3 . "',`name_team2`='" . $name_4 .
                            "',`level_team1`='" . $level_3 . "',`level_team2`='" . $level_4 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='2',`time`='" .
                            $turtime2 . "',`id_team1`='" . $id_2 . "',`id_team2`='" . $id_3 .
                            "',`union_team1`='" . $union_2 . "',`union_team2`='" . $union_3 .
                            "',`name_team1`='" . $name_2 . "',`name_team2`='" . $name_3 .
                            "',`level_team1`='" . $level_2 . "',`level_team2`='" . $level_3 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='2',`time`='" .
                            $turtime2 . "',`id_team1`='" . $id_4 . "',`id_team2`='" . $id_1 .
                            "',`union_team1`='" . $union_4 . "',`union_team2`='" . $union_1 .
                            "',`name_team1`='" . $name_4 . "',`name_team2`='" . $name_1 .
                            "',`level_team1`='" . $level_4 . "',`level_team2`='" . $level_1 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='3',`time`='" .
                            $turtime3 . "',`id_team1`='" . $id_1 . "',`id_team2`='" . $id_3 .
                            "',`union_team1`='" . $union_1 . "',`union_team2`='" . $union_3 .
                            "',`name_team1`='" . $name_1 . "',`name_team2`='" . $name_3 .
                            "',`level_team1`='" . $level_1 . "',`level_team2`='" . $level_3 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='3',`time`='" .
                            $turtime3 . "',`id_team1`='" . $id_2 . "',`id_team2`='" . $id_4 .
                            "',`union_team1`='" . $union_2 . "',`union_team2`='" . $union_4 .
                            "',`name_team1`='" . $name_2 . "',`name_team2`='" . $name_4 .
                            "',`level_team1`='" . $level_2 . "',`level_team2`='" . $level_4 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='4',`time`='" .
                            $turtime4 . "',`id_team1`='" . $id_3 . "',`id_team2`='" . $id_1 .
                            "',`union_team1`='" . $union_3 . "',`union_team2`='" . $union_1 .
                            "',`name_team1`='" . $name_3 . "',`name_team2`='" . $name_1 .
                            "',`level_team1`='" . $level_3 . "',`level_team2`='" . $level_1 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='4',`time`='" .
                            $turtime4 . "',`id_team1`='" . $id_4 . "',`id_team2`='" . $id_2 .
                            "',`union_team1`='" . $union_4 . "',`union_team2`='" . $union_2 .
                            "',`name_team1`='" . $name_4 . "',`name_team2`='" . $name_2 .
                            "',`level_team1`='" . $level_4 . "',`level_team2`='" . $level_2 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='5',`time`='" .
                            $turtime5 . "',`id_team1`='" . $id_3 . "',`id_team2`='" . $id_2 .
                            "',`union_team1`='" . $union_3 . "',`union_team2`='" . $union_2 .
                            "',`name_team1`='" . $name_3 . "',`name_team2`='" . $name_2 .
                            "',`level_team1`='" . $level_3 . "',`level_team2`='" . $level_2 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='5',`time`='" .
                            $turtime5 . "',`id_team1`='" . $id_1 . "',`id_team2`='" . $id_4 .
                            "',`union_team1`='" . $union_1 . "',`union_team2`='" . $union_4 .
                            "',`name_team1`='" . $name_1 . "',`name_team2`='" . $name_4 .
                            "',`level_team1`='" . $level_1 . "',`level_team2`='" . $level_4 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='6',`time`='" .
                            $turtime6 . "',`id_team1`='" . $id_2 . "',`id_team2`='" . $id_1 .
                            "',`union_team1`='" . $union_2 . "',`union_team2`='" . $union_1 .
                            "',`name_team1`='" . $name_2 . "',`name_team2`='" . $name_1 .
                            "',`level_team1`='" . $level_2 . "',`level_team2`='" . $level_1 . "';");
                        mysql_query("insert into `liga_game_2` set `gr`='" . $gr . "',`tur`='6',`time`='" .
                            $turtime6 . "',`id_team1`='" . $id_4 . "',`id_team2`='" . $id_3 .
                            "',`union_team1`='" . $union_4 . "',`union_team2`='" . $union_3 .
                            "',`name_team1`='" . $name_4 . "',`name_team2`='" . $name_3 .
                            "',`level_team1`='" . $level_4 . "',`level_team2`='" . $level_3 . "';");
                        //sql_query("insert into `liga_game_2` set `gr`='".$gr."',`tur`='6',`time`='".$turtime6."',`id_team1`='".$id_4."',`id_team2`='".$id_3."',`union_team1`='".$union_4."',`union_team2`='".$union_3."',`name_team1`='".$name_4."',`name_team2`='".$name_3."',`level_team1`='".$level_4."',`level_team2`='".$level_3."';");
                    }

                }
                header('location: admin.php?act=ligac');


            } else {
                echo '<div class="phdr"><b><a href="admin.php">Админ Панель</a></b> | генерация каледаря</div>';
                echo '<div class="rmenu"><p>Внимание!<br/>Вы действительно хотите создать новый календарь лиги чемпионов? Все старые игры будут удалены!';
                echo '</p><p><form action="admin.php?act=kalend" method="post"><input type="submit" name="submit" value="ok" /></form>';
                echo '</p></div>';
                echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';

            }
            break;


        case 'rozp':
            $q1 = mysql_query("SELECT * FROM `liga_group_2` ORDER BY `id_team` DESC LIMIT 32;");

            $mesto = 1;
            while ($res = mysql_fetch_array($q1)) {

                if ($mesto == 1 || $mesto == 9 || $mesto == 17 || $mesto == 25) {
                    $group = 'A';
                } elseif ($mesto == 2 || $mesto == 10 || $mesto == 18 || $mesto == 26) {
                    $group = 'B';
                } elseif ($mesto == 3 || $mesto == 11 || $mesto == 19 || $mesto == 27) {
                    $group = 'C';
                } elseif ($mesto == 4 || $mesto == 12 || $mesto == 20 || $mesto == 28) {
                    $group = 'D';
                } elseif ($mesto == 5 || $mesto == 13 || $mesto == 21 || $mesto == 29) {
                    $group = 'E';
                } elseif ($mesto == 6 || $mesto == 14 || $mesto == 22 || $mesto == 30) {
                    $group = 'F';
                } elseif ($mesto == 7 || $mesto == 15 || $mesto == 23 || $mesto == 31) {
                    $group = 'G';
                } elseif ($mesto == 8 || $mesto == 16 || $mesto == 24 || $mesto == 32) {
                    $group = 'H';
                }


                //echo ''.$mesto.' '.$group.'  '.$res[id_team].'<br/>';


                mysql_query("UPDATE `liga_group_2` SET `group`='" . $group . "' WHERE `id_team`='" .
                    $res['id_team'] . "'");

                mysql_query("delete from `tur_2`  WHERE `chemp`='liga'");

                ++$mesto;
                ++$i;
            }

            header('location: admin.php?act=ligac');
            break;

        case 'lc':
            echo '<div class="menu"> Чемпионаты</div>';
            if (isset($_POST['submit'])) {
                $do = array('ua', 'rus', 'en', 'sp', 'it', 'ge', 'bel', 'por', 'fr');
                mysql_query("TRUNCATE TABLE `liga_group_2`");

                foreach ($do as $chemp) {

                    $q1 = mysql_query("SELECT * FROM `team_2` where `strana`='" . $chemp .
                        "' ORDER BY `oo` DESC, `raz` DESC, `mz` DESC ;");

                    $mesto = 1;

                    while ($arr = mysql_fetch_array($q1)) {

                        if ($chemp == 'en' || $chemp == 'sp' || $chemp == 'it' || $chemp == 'ge' || $chemp ==
                            'fr') {

                            if ($mesto >= 1 && $mesto <= 4) {
                                //СОЗДАЁМ ЛЧ
                                mysql_query("insert into `liga_group_2` set 
`group`='', 
`id_team`='" . $arr[id] . "', 
`name_team`='" . $arr[name] . "',
`level_team`='" . $arr[lvl] . "',
`oo`='" . $arr[oo] . "'
;");
                            }

                        } else {
                            if ($mesto >= 1 && $mesto <= 3) {
                                //СОЗДАЁМ ЛЧ
                                mysql_query("insert into `liga_group_2` set 
`group`='', 
`id_team`='" . $arr[id] . "', 
`name_team`='" . $arr[name] . "',
`level_team`='" . $arr[lvl] . "',
`oo`='" . $arr[oo] . "'
;");
                            }
                        }
                        ++$mesto;
                        ++$i;
                    }
                }
                header('location: admin.php?act=ligac');


            } else {
                echo '<div class="phdr"><b><a href="admin.php">Админ Панель</a></b> | Добавление команд</div>';
                echo '<div class="rmenu"><p>Внимание!<br/>Вы действительно хотите новые команды в Лигу Чемпионов? Все старые команды будут удалены!';
                echo '</p><p><form action="admin.php?act=lc" method="post"><input type="submit" name="submit" value="ok" /></form>';
                echo '</p></div>';
                echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            }

            break;

        case 'liga_2':
            echo '<div class="menu"> Чемпионаты</div>';
            if (isset($_POST['submit'])) {
                $chemp = $_POST['name'];

                if (empty($chemp))
                    $error = $error . 'Не выбрана лига!<br/>';
                if (empty($error)) {


                    $q1 = mysql_query("SELECT * FROM `team_2` where `strana`='" . $chemp .
                        "' ORDER BY `oo` DESC, `raz` DESC, `mz` DESC ;");
                    $mesto = 1;
                    while ($arr = mysql_fetch_array($q1)) {
                        if ($mesto == 1) {
                            $q1 = @mysql_query("select * from `team_2` where id='" . $arr[id_team] .
                                "' LIMIT 1;");
                            $winkom = @mysql_fetch_array($q1);

                            $rate = $winkom[rate] + 100;
                            $money = $winkom[money] + 1000000;
                            $fans = $winkom[fan] + 10000;

                            // mysql_query("insert into `m2_priz` set
                            // `id_cup`='".$act."',
                            // `time`='".$realtime."',
                            // `name`='".$name_liga."',
                            // `priz`='10000',
                            // `win`='454'
                            // ;");

                            mysql_query("update `team_2` set `rate`='" . $rate . "', `money`='" . $money .
                                "',  `fan`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
                        }

                        if ($mesto == 2) {
                            $q1 = @mysql_query("select * from `team_2` where id='" . $arr[id_team] .
                                "' LIMIT 1;");
                            $winkom = @mysql_fetch_array($q1);

                            $rate = $winkom[rate] + 50;
                            $money = $winkom[money] + 500000;
                            $fans = $winkom[fan] + 5000;

                            mysql_query("update `team_2` set `rate`='" . $rate . "', `money`='" . $money .
                                "', `fan`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
                        }

                        if ($mesto == 3) {
                            $q1 = @mysql_query("select * from `team_2` where id='" . $arr[id_team] .
                                "' LIMIT 1;");
                            $winkom = @mysql_fetch_array($q1);

                            $rate = $winkom[rate] + 25;
                            $money = $winkom[money] + 250000;
                            $fans = $winkom[fan] + 2500;

                            mysql_query("update `team_2` set `rate`='" . $rate . "', `money`='" . $money .
                                "', `fan`='" . $fans . "' where id='" . $winkom[id] . "' LIMIT 1;");
                        }


                        ++$mesto;
                        ++$i;
                    }


                    mysql_query("update `team_2` SET 
`ii`='0',	
`vv`='0',	 	
`nn`='0',	 	
`pp`='0',	 	
`mz`='0',	 	
`mp`='0',	 	
`raz`='0',	 	
`oo`='0' WHERE `strana` = '" . $chemp . "';");


                    echo $chemp;
                    mysql_query("DELETE FROM `tur_2` WHERE `chemp` = '" . $chemp . "' ;");

                    function add($tur, $id1, $id2)
                    {
                        global $chemp;

                        $req = mysql_query('SELECT * FROM `team_2` where `strana`="' . $chemp .
                            '" order by id asc;');
                        $i = 1;
                        while ($arr = mysql_fetch_array($req)) {
                            $id[$i] = $arr['id'];
                            $name[$i] = $arr['name'];
                            ++$i;
                        }


                        // $tur = 31-$tur;

                        if ($tur == 1) {
                            $turtime = strtotime($_POST['time']);
                        } else {
                            $turtime = strtotime($_POST['time']) + (3600 * 24 * ($tur - 1));
                        }


                        $str = mysql_query("insert into `tur_2` set 
`chemp`='" . $chemp . "',
`tur`='" . $tur . "',
`time`='" . $turtime . "',
`id_team1`='" . $id[$id1] . "',
`id_team2`='" . $id[$id2] . "',
`name_team1`='" . $name[$id1] . "',
`name_team2`='" . $name[$id2] . "'
");

                        if ($chemp == 'ua' || $chemp == 'rus' || $chemp == 'ge' || $chemp == 'fr' || $chemp ==
                            'bel' || $chemp == 'por') {
                            $tur2 = $tur + 15;
                            $turtime2 = $turtime + (3600 * 24 * 16);
                        } else {
                            $tur2 = $tur + 19;
                            $turtime2 = $turtime + (3600 * 24 * 20);
                        }
                        $str = mysql_query("insert into `tur_2` set 
`chemp`='" . $chemp . "',
`tur`='" . $tur2 . "',
`time`='" . $turtime2 . "',
`id_team1`='" . $id[$id2] . "',
`id_team2`='" . $id[$id1] . "',
`name_team1`='" . $name[$id2] . "',
`name_team2`='" . $name[$id1] . "'
");

                        return $str;
                    }


                    if ($chemp == 'ua' || $chemp == 'rus' || $chemp == 'ge' || $chemp == 'fr' || $chemp ==
                        'bel' || $chemp == 'por') {


                        //1
                        echo add(1, 1, 2);
                        echo add(1, 3, 4);
                        echo add(1, 5, 6);
                        echo add(1, 7, 8);
                        echo add(1, 9, 10);
                        echo add(1, 11, 12);
                        echo add(1, 13, 14);
                        echo add(1, 15, 16);


                        //2
                        echo add(2, 4, 5);
                        echo add(2, 6, 3);
                        echo add(2, 8, 9);
                        echo add(2, 10, 7);
                        echo add(2, 12, 13);
                        echo add(2, 14, 11);
                        echo add(2, 16, 1);
                        echo add(2, 2, 15);


                        //3
                        echo add(3, 3, 8);
                        echo add(3, 5, 10);
                        echo add(3, 7, 4);
                        echo add(3, 9, 6);
                        echo add(3, 11, 16);
                        echo add(3, 13, 2);
                        echo add(3, 15, 12);
                        echo add(3, 1, 14);


                        //4
                        echo add(4, 4, 9);
                        echo add(4, 6, 7);
                        echo add(4, 8, 5);
                        echo add(4, 10, 3);
                        echo add(4, 12, 1);
                        echo add(4, 14, 15);
                        echo add(4, 16, 13);
                        echo add(4, 2, 11);


                        //5
                        echo add(5, 3, 12);
                        echo add(5, 5, 14);
                        echo add(5, 7, 16);
                        echo add(5, 9, 2);
                        echo add(5, 11, 4);
                        echo add(5, 13, 6);
                        echo add(5, 15, 8);
                        echo add(5, 1, 10);

                        //6
                        echo add(6, 4, 13);
                        echo add(6, 6, 11);
                        echo add(6, 8, 1);
                        echo add(6, 10, 15);
                        echo add(6, 12, 5);
                        echo add(6, 14, 3);
                        echo add(6, 16, 9);
                        echo add(6, 2, 7);


                        //7
                        echo add(7, 3, 16);
                        echo add(7, 5, 2);
                        echo add(7, 7, 12);
                        echo add(7, 9, 14);
                        echo add(7, 11, 8);
                        echo add(7, 13, 10);
                        echo add(7, 15, 4);
                        echo add(7, 1, 6);


                        //8
                        echo add(8, 4, 1);
                        echo add(8, 6, 15);
                        echo add(8, 8, 13);
                        echo add(8, 10, 11);
                        echo add(8, 12, 9);
                        echo add(8, 14, 7);
                        echo add(8, 16, 5);
                        echo add(8, 2, 3);


                        //9
                        echo add(9, 6, 4);
                        echo add(9, 10, 8);
                        echo add(9, 14, 12);
                        echo add(9, 2, 16);
                        echo add(9, 5, 3);
                        echo add(9, 9, 7);
                        echo add(9, 13, 11);
                        echo add(9, 1, 15);


                        //10
                        echo add(10, 4, 10);
                        echo add(10, 3, 9);
                        echo add(10, 8, 6);
                        echo add(10, 7, 5);
                        echo add(10, 12, 2);
                        echo add(10, 11, 1);
                        echo add(10, 16, 14);
                        echo add(10, 15, 13);


                        //11
                        echo add(11, 6, 12);
                        echo add(11, 5, 11);
                        echo add(11, 10, 16);
                        echo add(11, 9, 15);
                        echo add(11, 14, 4);
                        echo add(11, 13, 3);
                        echo add(11, 2, 8);
                        echo add(11, 1, 7);

                        //12
                        echo add(12, 4, 2);
                        echo add(12, 3, 1);
                        echo add(12, 8, 14);
                        echo add(12, 7, 13);
                        echo add(12, 12, 10);
                        echo add(12, 11, 9);
                        echo add(12, 16, 6);
                        echo add(12, 15, 5);


                        //13
                        echo add(13, 8, 4);
                        echo add(13, 7, 3);
                        echo add(13, 16, 12);
                        echo add(13, 15, 11);
                        echo add(13, 10, 6);
                        echo add(13, 9, 5);
                        echo add(13, 2, 14);
                        echo add(13, 1, 13);


                        //14
                        echo add(14, 4, 16);
                        echo add(14, 3, 15);
                        echo add(14, 6, 2);
                        echo add(14, 5, 1);
                        echo add(14, 12, 8);
                        echo add(14, 11, 7);
                        echo add(14, 14, 10);
                        echo add(14, 13, 9);


                        //15
                        echo add(15, 12, 4);
                        echo add(15, 11, 3);
                        echo add(15, 14, 6);
                        echo add(15, 13, 5);
                        echo add(15, 16, 8);
                        echo add(15, 15, 7);
                        echo add(15, 2, 10);
                        echo add(15, 1, 9);
                    } else {

                        //1
                        echo add(1, 1, 2);
                        echo add(1, 3, 4);
                        echo add(1, 5, 6);
                        echo add(1, 7, 8);
                        echo add(1, 9, 10);
                        echo add(1, 11, 12);
                        echo add(1, 13, 14);
                        echo add(1, 15, 16);
                        echo add(1, 17, 18);
                        echo add(1, 19, 20);
                        //2
                        echo add(2, 4, 5);
                        echo add(2, 6, 3);
                        echo add(2, 8, 9);
                        echo add(2, 10, 7);
                        echo add(2, 12, 13);
                        echo add(2, 14, 11);
                        echo add(2, 16, 1);
                        echo add(2, 2, 15);
                        echo add(2, 18, 19);
                        echo add(2, 17, 20);


                        //3
                        echo add(3, 3, 8);
                        echo add(3, 5, 10);
                        echo add(3, 7, 4);
                        echo add(3, 9, 6);
                        echo add(3, 11, 16);
                        echo add(3, 13, 2);
                        echo add(3, 15, 12);
                        echo add(3, 1, 14);
                        echo add(3, 20, 18);
                        echo add(3, 17, 19);

                        //4
                        echo add(4, 4, 9);
                        echo add(4, 6, 7);
                        echo add(4, 8, 5);
                        echo add(4, 10, 3);
                        echo add(4, 17, 1);
                        echo add(4, 12, 20);
                        echo add(4, 2, 18);
                        echo add(4, 19, 11);
                        echo add(4, 14, 15);
                        echo add(4, 16, 13);


                        //5
                        echo add(5, 3, 12);
                        echo add(5, 5, 14);
                        echo add(5, 7, 16);
                        echo add(5, 9, 2);
                        echo add(5, 11, 4);
                        echo add(5, 13, 6);
                        echo add(5, 17, 15);
                        echo add(5, 8, 20);
                        echo add(5, 1, 18);
                        echo add(5, 19, 10);


                        //6
                        echo add(6, 4, 13);
                        echo add(6, 6, 11);
                        echo add(6, 8, 1);
                        echo add(6, 10, 15);
                        echo add(6, 12, 5);
                        echo add(6, 14, 3);
                        echo add(6, 16, 18);
                        echo add(6, 17, 9);
                        echo add(6, 7, 20);
                        echo add(6, 19, 2);


                        //7
                        echo add(7, 3, 16);
                        echo add(7, 5, 2);
                        echo add(7, 7, 12);
                        echo add(7, 9, 14);
                        echo add(7, 11, 8);
                        echo add(7, 15, 4);
                        echo add(7, 10, 18);
                        echo add(7, 17, 13);
                        echo add(7, 1, 19);
                        echo add(7, 20, 6);


                        //8
                        echo add(8, 4, 1);
                        echo add(8, 6, 15);
                        echo add(8, 8, 13);
                        echo add(8, 10, 11);
                        echo add(8, 12, 9);
                        echo add(8, 16, 5);
                        echo add(8, 17, 14);
                        echo add(8, 18, 7);
                        echo add(8, 19, 3);
                        echo add(8, 20, 2);


                        //9
                        echo add(9, 6, 4);
                        echo add(9, 10, 8);
                        echo add(9, 14, 12);
                        echo add(9, 2, 16);
                        echo add(9, 9, 7);
                        echo add(9, 13, 11);
                        echo add(9, 5, 17);
                        echo add(9, 3, 18);
                        echo add(9, 15, 19);
                        echo add(9, 1, 20);


                        //10
                        echo add(10, 4, 10);
                        echo add(10, 3, 9);
                        echo add(10, 7, 5);
                        echo add(10, 12, 2);
                        echo add(10, 11, 1);
                        echo add(10, 15, 13);
                        echo add(10, 18, 8);
                        echo add(10, 6, 17);
                        echo add(10, 19, 16);
                        echo add(10, 14, 20);


                        //11
                        echo add(11, 6, 12);
                        echo add(11, 10, 16);
                        echo add(11, 9, 15);
                        echo add(11, 14, 4);
                        echo add(11, 2, 8);
                        echo add(11, 1, 7);
                        echo add(11, 17, 3);
                        echo add(11, 18, 13);
                        echo add(11, 19, 5);
                        echo add(11, 20, 11);


                        //12
                        echo add(12, 4, 2);
                        echo add(12, 3, 1);
                        echo add(12, 8, 14);
                        echo add(12, 7, 13);
                        echo add(12, 16, 6);
                        echo add(12, 15, 5);
                        echo add(12, 9, 18);
                        echo add(12, 11, 17);
                        echo add(12, 10, 20);
                        echo add(12, 12, 19);


                        //13
                        echo add(13, 7, 3);
                        echo add(13, 16, 12);
                        echo add(13, 15, 11);
                        echo add(13, 10, 6);
                        echo add(13, 2, 14);
                        echo add(13, 1, 13);
                        echo add(13, 17, 8);
                        echo add(13, 4, 18);
                        echo add(13, 19, 9);
                        echo add(13, 5, 20);


                        //14
                        echo add(14, 4, 16);
                        echo add(14, 3, 15);
                        echo add(14, 6, 2);
                        echo add(14, 5, 1);
                        echo add(14, 12, 8);
                        echo add(14, 11, 7);
                        echo add(14, 18, 14);
                        echo add(14, 17, 10);
                        echo add(14, 20, 9);
                        echo add(14, 19, 13);


                        //15
                        echo add(15, 12, 4);
                        echo add(15, 11, 3);
                        echo add(15, 1, 9);
                        echo add(15, 13, 5);
                        echo add(15, 16, 8);
                        echo add(15, 2, 10);
                        echo add(15, 7, 17);
                        echo add(15, 18, 15);
                        echo add(15, 14, 19);
                        echo add(15, 20, 6);


                        //16
                        echo add(16, 1, 10);
                        echo add(16, 19, 7);
                        echo add(16, 2, 11);
                        echo add(16, 13, 3);
                        echo add(16, 17, 12);
                        echo add(16, 20, 4);
                        echo add(16, 18, 5);
                        echo add(16, 14, 6);
                        echo add(16, 15, 8);
                        echo add(16, 16, 9);


                        //17
                        echo add(17, 1, 15);
                        echo add(17, 17, 2);
                        echo add(17, 16, 19);
                        echo add(17, 18, 6);
                        echo add(17, 8, 4);
                        echo add(17, 14, 7);
                        echo add(18, 14, 10);
                        echo add(17, 20, 3);
                        echo add(17, 5, 11);
                        echo add(18, 13, 9);

                        //18
                        echo add(19, 12, 1);
                        echo add(18, 2, 7);
                        echo add(18, 5, 3);
                        echo add(19, 19, 4);
                        echo add(19, 8, 6);
                        echo add(18, 11, 9);
                        echo add(19, 13, 10);
                        echo add(18, 18, 12);
                        echo add(18, 20, 15);
                        echo add(17, 17, 16);

                        //19
                        echo add(18, 1, 6);
                        echo add(19, 2, 3);
                        echo add(19, 9, 5);
                        echo add(17, 12, 10);
                        echo add(19, 18, 11);
                        echo add(19, 16, 14);
                        echo add(18, 19, 8);
                        echo add(19, 15, 7);
                        echo add(19, 20, 13);
                        echo add(18, 17, 4);

                    }
                    header('location: admin.php');
                } else {
                    echo '<div class="rmenu"><p><b>ОШИБКА!</b><br />' . $error . '</p></div>';
                }

            } else {
                echo '<form action="admin.php?act=liga" method="post">';
                echo '<div class="gmenu">';
                echo '<b>Лига</b><br/><small>Выберете лигу</small><br />';
                $matile = mysql_query('SELECT * from `team_2` GROUP BY `strana`;');
                while ($mat = mysql_fetch_array($matile)) {
                    echo '<input type="radio" name="name" value="' . $mat['strana'] . '" /> ' . $mat['divizion'] .
                        '<br/>
              ';
                }
                echo '<p><b>Дата первого тура</b><br /><small>00.00.0000 00:00</small><br /><input type="text" size="20" maxlength="16" name="time" /></p>';
                echo '<p><input type="submit" name="submit" value="ок" /></p></div></form>';
            }
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            break;


        case 'upload':
            $kom = $_GET['id'];
            echo '<form action="admin.php?act=upl&amp;id=' . $kom .
                '" method="post" name="form" enctype="multipart/form-data">';
            echo 'Картинка:<br/>';
            echo '<input type="file" name="filename" /><br/>';
            echo '<input type="submit" value="Добавить" />';
            echo '</form>';
            break;

        case 'upl':
            $id = htmlentities($_GET['id'], ENT_QUOTES, 'UTF-8');
            $fname = strtolower($_FILES['filename']['name']);
            $fsize = $_FILES['filename']['size'];


            // Список допустимых расширений файлов.
            $al_ext = array('jpg', 'jpeg', 'gif', 'png');
            $ext = explode(".", $fname);

            // Проверка на допустимый размер файла
            if ($fsize >= 1024 * $flsz) {
                echo '<p><b>ОШИБКА!</b></p><p>Вес файла превышает ' . $flsz . ' кб.';
                echo '</p><p><a href="index.php?act=addfile&amp;id=' . $id .
                    '">Повторить</a></p>';
                require_once ('incfiles/end.php');
                exit;
            }

            // Проверка файла на наличие только одного расширения
            if (count($ext) != 2) {
                echo '<p><b>ОШИБКА!</b></p><p>Неправильное имя файла!<br />';
                echo 'К отправке разрешены только файлы имеющие имя и одно расширение (<b>' . $_FILES['filename'] .
                    '</b>).<br />';
                echo 'Запрещены файлы не имеющие имени, расширения, или с двойным расширением.';
                echo '</p><p><a href="index.php?act=addfile&amp;id=' . $id .
                    '">Повторить</a></p>';
                require_once ('incfiles/end.php');
                exit;
            }

            // Проверка допустимых расширений файлов
            if (!in_array($ext[1], $al_ext)) {
                echo '<p><b>ОШИБКА!</b></p><p>Запрещенный тип файла!<br />';
                echo 'К отправке разрешены только файлы, имеющие следующее расширение:<br />';
                echo implode(', ', $al_ext);
                echo '</p><p><a href="index.php?act=addfile&amp;id=' . $id .
                    '">Повторить</a></p>';
                require_once ('incfiles/end.php');
                exit;
            }


            $nameimg = $id . '.' . $ext[1];

            function create_img($name_big, $name_small, $xs, $ys) {
                list($x, $y, $t, $attr) = getimagesize($name_big);

                if ($t == IMAGETYPE_GIF)
                    $big = imagecreatefromgif($name_big);
                else
                    if ($t == IMAGETYPE_JPEG)
                        $big = imagecreatefromjpeg($name_big);
                    else
                        if ($t == IMAGETYPE_PNG)
                            $big = imagecreatefrompng($name_big);
                        else
                            return;

                $small = imagecreatetruecolor($xs, $ys);
                $res = imagecopyresampled($small, $big, 0, 0, 0, 0, $xs, $ys, $x, $y);
                imagedestroy($big);
                imagejpeg($small, $name_small);
                imagedestroy($small);
            }

            create_img('' . $_FILES["filename"]["tmp_name"] . '', 'logo/big' . $nameimg, 70,
                70);
            create_img('' . $_FILES["filename"]["tmp_name"] . '', 'logo/small' . $nameimg,
                15, 15);
            echo '<br/><br/><img src="logo/' . $nameimg . '" alt=""/>Готово ';
            mysql_query("update `team_2` set `logo`='" . $nameimg . "' where id='" . $id .
                "';");
            break;


        case 'team': //Команда

            $kom = $_GET['id'];
            $qk = @mysql_query("select * from `team_2` where id='" . $kom . "';");
            $krr = @mysql_fetch_array($qk);

            echo '<div class="gmenu"><b>' . $krr['name'] . '</b></div>';
            echo '<div class="c">Менеджер: <b>' . $krr['name_admin'] .
                '</b> <a href="admin.php?act=delman&amp;id=' . $id . '">Уволить</a></div>';
            if ($krr['logo'] == '') {
                echo '<div class="gmenu"><a href="admin.php?act=upload&amp;id=' . $kom .
                    '">Добавить лого</a></div>';
            }
            $req = mysql_query("SELECT * FROM `player_2` where `kom`='" . $kom .
                "' order by nomer asc;");
            while ($arr = mysql_fetch_array($req)) {
                echo '<div class="c"><img src="flag/' . $arr[strana] . '.png" alt=""/> ' . $arr[nomer] .
                    ' <a href="player.php?id=' . $arr[id] . '">' . $arr[name] . '</a></div>';
                echo '<div class="sub">';
                echo '<a href="admin.php?act=edit_2&amp;id=' . $arr['id'] . '">Изменить </a> | ';
                echo '<a href="admin.php?act=omol&amp;id=' . $arr['id'] . '">Омолодить </a> | ';
                echo '<a href="admin.php?act=delete&amp;id=' . $arr['id'] . '">Удалить</a>';
                echo '</div>';

            }


            echo '<div class="gmenu"><b>Бюджет клуба</b></div>';
            echo $krr[money];
            echo '<div class="c"><form action="admin.php?act=addmoney&amp;id=' . $id .
                '" method="post">';
            echo '<input type="text" name="money"  value="1000"/> Денег<br/>';
            echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Добавить'/></form></div>";
            



 echo '<div class="c"><form action="admin.php?act=delmoney&amp;id=' . $id .
                '" method="post">';
            echo '<input type="text" name="money"  value="1000"/> Денег<br/>';
            echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Уменьшить'/></form></div>";
            




echo '<div class="gmenu"><b>Создать игрока</b></div>';
            echo '<div class="c"><form action="admin.php?act=addplay&amp;id=' . $id .
                '" method="post">';
            echo '<table cellpadding="2" cellspacing="0"><tr>';


            echo '<td><b>Имя</b></td><td><input type="text" name="name"  value="Иван Иванов"/></td></tr><tr>';
            echo '<td><b>Номер</b></td><td><input type="text" name="nomer"  value="10"/></td></tr><tr>';
            echo '<td><b>Возраст</b></td><td><input type="text" name="voz"  value="20"/></td></tr><tr>';
            echo '<td><b>Позицыя</b></td><td>

<select name="poz" style="font-size:x-small">
	<option selected="selected">Выберите позицию</option>
	<option value="Вр">Вратарь [Вр]</option>
	<option value="ЛЗ">Левый защитник [ЛЗ ]</option>
    <option value="ЦЗ">Центральный защитник [ЦЗ]</option>
    <option value="ПЗ">Правый защитник [ПЗ]</option>
    <option value="ЛП">Левый полузащитник [ЛП]</option>
    <option value="ЦП">Центральный полузащитник [ЦП]</option>
    <option value="ПП">Правый полузащитник [ПП]</option>
    <option value="ЛФ">Левый форвард [ЛФ]</option>
	<option value="ЦФ">Центральный форвард [ЦФ]</option>
	<option value="ПФ">Правый форвард [ПФ ]</option>
	</select></td></tr><tr>';

            echo '<td><b>Страна</b></td><td>
<select name="strana" style="font-size:x-small">
<option selected="selected">Выберите страну</option>
<option  value="liga"> Лига Наций</option>
<option  value="en"> Англия</option>
<option  value="alb"> Албания</option>
<option  value="arg"> Аргентина</option>
<option  value="aus"> Австралия</option>
<option  value="avs"> Австрия</option>
<option  value="bel"> Бельгия</option>
<option  value="bol"> Болгария</option>
<option  value="br"> Бразилия</option>
<option  value="ven"> Венгрия</option>
<option  value="gana"> Гана</option>
<option  value="ge"> Германия</option>
<option  value="go"> Голландия</option>
<option  value="gon"> Гондурас</option>
<option  value="gre"> Греция</option>
<option  value="gvi"> Гвинея</option>
<option  value="cam"> Камерун</option>
<option  value="che"> Чехия</option>
<option  value="cher"> Черногория</option>
<option  value="chili"> Чили</option>
<option  value="dan"> Дания</option>
<option  value="ekv"> Еквадор</option>
<option  value="fin"> Финляндия</option>
<option  value="fr"> Франция</option>
<option  value="iran"> Иран</option>
<option  value="irl"> Ирландия</option>
<option  value="isl"> Исландия</option>
<option  value="isr"> Израиль</option>
<option  value="it"> Италия</option>
<option  value="sp"> Испания</option>
<option  value="kan"> Канада</option>
<option  value="kol"> Колумбия</option>
<option  value="kor"> Корея</option>
<option  value="kot"> Котдивуар</option>
<option  value="mak"> Македония</option>
<option  value="mali"> Малибу</option>
<option  value="mar"> Марокко</option>
<option  value="mek"> Мексика</option>
<option  value="nig"> Нигерия</option>
<option  value="nor"> Норвегия</option>
<option  value="par"> Парагвай</option>
<option  value="peru"> Перу</option>
<option  value="pol"> Польща</option>
<option  value="por"> Португалия</option>
<option  value="rum"> Румуния</option>
<option  value="rus"> Россия</option>
<option  value="sen"> Сенегал</option>
<option  value="ser"> Сербия</option>
<option  value="sho"> Шотландия</option>
<option  value="shv"> Швеция</option>
<option  value="slo"> Словатчина</option>
<option  value="hor"> Хорватия</option>
<option  value="togo"> Того</option>
<option  value="tur"> Турция</option>
<option  value="ua"> Украина</option>
<option  value="uels"> Уельс</option>
<option  value="uru"> Уругвай</option>
<option  value="usa"> США</option>
<option  value="yam"> Ямайка</option>
<option  value="yap"> Япония</option>
<option  value="zel"> Зеландия</option></select></td></tr><tr>';

            echo '<td><b>Талант</b></td><td><input type="text" name="tal"  value="3"/></td></tr><tr>';
            echo '<td><b>Отбор</b></td><td><input type="text" name="otbor"  value="5"/></td></tr><tr>';
            echo '<td><b>Опека</b></td><td><input type="text" name="opeka"  value="5"/></td></tr><tr>';
            echo '<td><b>Дриблинг</b></td><td><input type="text" name="drib"  value="5"/></td></tr><tr>';
            echo '<td><b>Прием мяча</b></td><td><input type="text" name="priem"  value="5"/></td></tr><tr>';
            echo '<td><b>Выносливость</b></td><td><input type="text" name="vonos"  value="5"/></td></tr><tr>';
            echo '<td><b>Пас</b></td><td><input type="text" name="pas"  value="5"/></td></tr><tr>';
            echo '<td><b>Сила удара</b></td><td><input type="text" name="sila"  value="5"/></td></tr><tr>';
            echo '<td><b>Точность удара</b></td><td><input type="text" name="tocnost"  value="5"/></td></tr><tr>';
            echo '<td><b>Цена</b></td><td><input type="text" name="money"  value="80000"/></td></tr><tr>';


            echo '</tr>';
            echo '</table>';
            echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Создать'/></form></div>";
            break;


        case 'addmoney': //деньги
            $money = htmlspecialchars($_POST['money'], ENT_QUOTES, 'UTF-8');
            $com = $_GET['id'];
            $qk = @mysql_query("select * from `team_2` where id='" . $com . "';");
            $krr = @mysql_fetch_array($qk);
            $money = $krr[money] + $money;
            mysql_query("update `team_2` set `money`='" . $money . "' where id='" . $com .
                "';");
            header("location: admin.php?act=team&id=$id");
            break;
case 'delmoney': //деньги
            $money = htmlspecialchars($_POST['money'], ENT_QUOTES, 'UTF-8');
            $com = $_GET['id'];
            $qk = @mysql_query("select * from `m2_team` where id='" . $com . "';");
            $krr = @mysql_fetch_array($qk);
            $money = $krr[money] - $money;
            mysql_query("update `team_2` set `money`='" . $money . "' where id='" . $com .
                "';");
            header("location: admin.php?act=team&id=$id");
            break;
        case 'divizion': //Дивизион

            $strana = $_GET['strana'];
            echo '<div class="gmenu"><img src="flag/' . $strana . '.png" alt=""/> <b>' . $strana .
                '</b></div>';
            $req = mysql_query("SELECT * FROM `team_2` where `strana`='" . $strana .
                "' order by oo desc;");
            while ($arr = mysql_fetch_array($req)) {
                echo '<div class="c"><img src="logo/small' . $arr[logo] .
                    '" alt=""/> <a href="admin.php?act=team&amp;id=' . $arr[id] . '">' . $arr[name] .
                    '</a></div>';
            }
            echo '<div class="gmenu"><b>Создать команду</b></div>';
            echo '<div class="c"><form action="admin.php?act=addteam&amp;strana=' . $strana .
                '" method="post">';
            echo '<input type="text" name="name"  value=""/> ';
            echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Создать'/></form></div>";
            break;

        case 'zav':
            $req = mysql_query("SELECT `id`, `type`, `id_team`, `name_team`, `id_admin`, `time`, `money` FROM `money_2` WHERE `money_2` = 0 ");
            while ($res = mysql_fetch_assoc($req)) {
                echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                    '<tr bgcolor="f3f3f3">';
                echo '<td><center>' . date("d.m / H:i", $res['time']) . '</center></td>';
                echo '' . $res[id_team] . '';

            }
            break;

        case 'addteam': // Создаем команду
            $strana = $_GET['strana'];
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

            $qk = @mysql_query("select * from `team_2` where strana='" . $strana . "';");
            $krr = @mysql_fetch_array($qk);

            mysql_query("insert into `team_2` set `name`='" . $name . "', `strana`='" . $strana .
                "', `divizion`='" . $krr[divizion] . "';");
            header("location: admin.php?act=divizion&strana=$strana");
            break;


        case 'addplay': // Создаем игрока
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $strana = htmlspecialchars($_POST['strana'], ENT_QUOTES, 'UTF-8');
            $nomer = htmlspecialchars($_POST['nomer'], ENT_QUOTES, 'UTF-8');
            $poz = htmlspecialchars($_POST['poz'], ENT_QUOTES, 'UTF-8');
            $voz = htmlspecialchars($_POST['voz'], ENT_QUOTES, 'UTF-8');
            $tal = htmlspecialchars($_POST['tal'], ENT_QUOTES, 'UTF-8');
            $mas = htmlspecialchars($_POST['mas'], ENT_QUOTES, 'UTF-8');
            $money = htmlspecialchars($_POST['money'], ENT_QUOTES, 'UTF-8');

            $otbor = htmlspecialchars($_POST['otbor'], ENT_QUOTES, 'UTF-8');
            $opeka = htmlspecialchars($_POST['opeka'], ENT_QUOTES, 'UTF-8');
            $drib = htmlspecialchars($_POST['drib'], ENT_QUOTES, 'UTF-8');
            $priem = htmlspecialchars($_POST['priem'], ENT_QUOTES, 'UTF-8');
            $vonos = htmlspecialchars($_POST['vonos'], ENT_QUOTES, 'UTF-8');
            $pas = htmlspecialchars($_POST['pas'], ENT_QUOTES, 'UTF-8');
            $sila = htmlspecialchars($_POST['sila'], ENT_QUOTES, 'UTF-8');
            $tocnost = htmlspecialchars($_POST['tocnost'], ENT_QUOTES, 'UTF-8');


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
            $error = false;

            if (empty($_POST['name']) || empty($_POST['nomer']) || empty($_POST['voz']) ||
                empty($_POST['poz']) || empty($_POST['tal']) || empty($_POST['otbor']) || empty
                ($_POST['opeka']) || empty($_POST['drib']) || empty($_POST['priem']) || empty($_POST['vonos']) ||
                empty($_POST['pas']) || empty($_POST['sila']) || empty($_POST['tocnost']) ||
                empty($_POST['money']))
                $error = 'Какое-то поле  не заполнено<br />';

            if (!$error) {

                $mas = $otbor + $drib + $priem + $vonos + $pas + $sila + $tocnost + $opeka;
                mysql_query("insert into `player_2` set `name`='" . $name . "', `kom`='" . $id .
                    "', `strana`='" . $strana . "', `nomer`='" . $nomer . "', 
`poz`='" . $poz . "', 
`line`='" . $line . "', 
`voz`='" . $voz . "', 
`tal`='" . $tal . "', 
`mas`='" . $mas . "', 
`rm`='" . $mas . "', 
`otbor`='" . $otbor . "', 
`opeka`='" . $opeka . "', 
`drib`='" . $drib . "', 
`priem`='" . $priem . "', 
`vonos`='" . $vonos . "', 
`pas`='" . $pas . "', 
`sila`='" . $sila . "', 
`tocnost`='" . $tocnost . "', 
`fiz`='100', 
`mor`='0', 
`money`='" . $money . "';");


                header("location: admin.php?act=team&id=$id");


            } else {
                echo '<div class="rmenu"><p>ОШИБКА!<br />' . $error .
                    '<a href="admin.php?act=team&amp;id=' . $id . '">Повторить</a></p></div>';
            }


            break;

        case 'delman': //Увольняем менеджера
            mysql_query("update `users` set `manager2`='' where manager2='" . $id . "';");
            mysql_query("update `team_2` set `name_admin`='', `id_admin`='' where id='" . $id .
                "';");
            header("location: admin.php?act=team&id=$id");
            break;


        case 'zay': //Заявки менеджера

            echo '<b>Заявки</b><br/>';
            $req = mysql_query("select * from `money_2`  order by money desc;");
            $total = mysql_num_rows($req);
            if ($total == '0') {
                echo "Заявок нет<br/>";
                require_once ("incfiles/end.php");
                exit;
            }
            echo '<table border="0" style="width:100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">';
            echo '<tr bgcolor="40B832"  align="center" class="whiteheader" >
<td></td>
<td><b>Время</b></td>
<td><b>Команда</b></td>
<td><b>Менеджер</b></td>
<td><b>Денег</b></td>
</tr>';

            $mesto = 1;
            while ($za = mysql_fetch_array($req)) {

                if (!empty($_SESSION['uid']) && $user_id == $za[id_admin]) {
                    echo '<tr bgcolor="e9ccd2">';
                } else {
                    echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                        '<tr bgcolor="f3f3f3">';
                }

                echo '<td><center>' . $mesto . '</center></td>
<td>' . date("d.m.y H:i", $za['time']) . '</td>
<td><img src="logo/small' . $arr[logo] . '" alt=""/> <a href="team.php?id=' . $za['id_team'] .
                    '">' . $za[name_team] . '</a></td>
<td><a href="str/anketa.php?id=' . $za['id_admin'] . '">' . $za[name_admin] .
                    '</a></td>
<td><center><font color="green"><b>' . $za[money] . ' €</b></font> ';

                if ($rights >= 6) {
                    echo '<a href="buyteam.php?act=del&amp;id=' . $za['id'] . '">Del</a>';
                }

                if ($rights >= 6) {
                    echo ' <a href="buyteam.php?act=admbuy&amp;id=' . $za['id'] . '">>></a>';
                }

                echo '</center></td>';
                echo '</tr>';

                ++$mesto;
                ++$i;
            }
            echo '</table>';
            break;

        case 'dom':
            /* Управление постойками */
            if (isset($_POST['submit'])) {

                $name = mysql_real_escape_string(htmlspecialchars(trim($_POST['name'])));
                $ops = mysql_real_escape_string(htmlspecialchars(trim($_POST['ops'])));
                $price = (int)$_POST['price'];
                $prib = (int)$_POST['prib'];
                $type = (int)$_POST['type'];
                if (!$name || !$price || $price < 1 || !$prib || !$ops) {
                    echo display_error('Пустые параметры!');
                    require_once ("incfiles/end.php");
                    exit;
                }
                $handle = new upload($_FILES['imagefile']);
                if ($handle->uploaded) {
                    // Обрабатываем фото
                    $handle->file_new_name_body = $realtime;
                    //$handle->mime_check = false;
                    $handle->allowed = array('image/jpeg', 'image/gif', 'image/png');
                    $handle->file_max_size = 1024 * $set['flsz'];
                    $handle->file_overwrite = true;
                    $handle->image_resize = true;
                    $handle->image_x = 100;
                    $handle->image_y = 100;
                    $handle->image_convert = 'jpg';
                    $handle->process('dom/');
                    $nameimg = '' . $realtime . '.jpg';
                    if ($handle->processed) {


                        mysql_query("INSERT INTO `dom_2` (`name`,`price`,`path`,`prib`,`ops`,`type`)VALUES('$name','$price','$nameimg','$prib','$ops','$type')");
                        header("Location: admin.php?act=dom");
                    } else {
                        echo display_error($handle->error);
                    }

                    $handle->clean();
                }
            } else {

                echo '<div class="phdr">Управление постойками</div>';
                $x = mysql_query("SELECT * FROM `dom_2` ORDER BY `id` DESC");
                if (!mysql_num_rows($x)) {
                    echo 'Нет построек';
                } else {
                    while ($row = mysql_fetch_assoc($x)) {
                        echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
                        echo 'Название: <b>' . $row['name'] . '</b> ';
                        echo '<a href="admin.php?act=deldom&amp;id=' . $row['id'] .
                            '">[Удалить]</a><br/>';
                        echo 'Цена: <b>' . $row['price'] . '</b><br/>';
                        echo 'Прибыль: <b>' . $row['prib'] . '</b><br/>';
                        if ($row['type'] == '0') {
                            $out = 'простая';
                        } else {
                            $out = 'к стадиону';
                        }
                        echo 'Тип: <b>' . $out . '</b><br/>';
                        ++$i;
                        echo '</div>';
                    }

                }


                echo '<form enctype="multipart/form-data" action="admin.php?act=dom" method="post">';
                echo '<div class="gmenu">';
                echo '<table cellpadding="2" cellspacing="0"><tr>';

                echo '<td><b>Имя</b></td><td><input type="text" name="name"  value=""/></td></tr><tr>';
                echo '<td><b>Описание</b></td><td><input type="text" name="ops"  value=""/></td></tr><tr>';
                echo '<td><b>Цена</b></td><td><input type="text" name="price"  value="10000"/></td></tr><tr>';
                echo '<td><b>Прибыль</b></td><td><input type="text" name="prib"  value="1"/></td></tr><tr>';
                echo '<td><b>Тип</b></td><td>';
                echo '<select name="type">
                <option value="0">Простая</option>
                <option value="1">К стадиону</option>
                 </select>';

                echo '</td></tr><tr>';

                echo '<td><b>Изображение</b></td><td><input type="file" name="imagefile" value="" /></td></tr><tr>';

                echo '</tr>';
                echo '</table>';

                echo '<p><input type="submit" name="submit" value="Добавить" /></p></div></form>';

            }
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            break;

        case 'deldom':
            /* Удаляю постройку */

            if (!$id) {
                echo display_error('Пустые параметры!');
                echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
                require_once ("incfiles/end.php");
                exit;
            }
            mysql_query("DELETE FROM `dom_2` WHERE `id`='$id'");
            header("Location: admin.php?act=dom");
            break;

        case 'bazar':
            echo '<div class="phdr">Управление школами</div>';
            $school = array("rus", "ua", "bel", "en", "sp", "it", "br", "ge", "fr", "go",
                "pol");
            $scl = array("rus" => "Россия", "ua" => "Украина", "bel" => "Бельгия", "en" =>
                "Англия", "sp" => "Испания", "it" => "Италия", "br" => "Бразилия", "ge" =>
                "Германия", "fr" => "Франция", "go" => "Голландия", "pol" => "Польша");
            if (isset($_POST['submit'])) {
                $name = mysql_real_escape_string(htmlspecialchars(trim($_POST['name'])));
                $ops = mysql_real_escape_string(htmlspecialchars(trim($_POST['ops'])));
                $price = (int)$_POST['price'];
                $strana = $_POST['strana'];
                if (!$name || !$price || $price < 1 || !$ops || !$strana) {
                    echo display_error('Пустые параметры!');
                    require_once ("incfiles/end.php");
                    exit;
                }
                ;
                mysql_query("INSERT INTO  `shcool_2` (`name`,`ops`,`price`,`strana`)VALUES('$name','$ops','$price','$strana')");
                header("Location: admin.php?act=bazar");
            } else {
                $x = mysql_query("SELECT * FROM  `shcool_2` ORDER BY `id` DESC");
                if (!mysql_num_rows($x)) {
                    echo 'Школ нет';
                } else {
                    while ($row = mysql_fetch_assoc($x)) {
                        echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
                        echo $row['name'] . '<b> (' . $row['price'] . ') </b>[' . $row['ops'] . '] ';
                        echo '<a href="admin.php?act=delbazar&amp;id=' . $row['id'] .
                            '">[Удалить]</a><br/>';
                        ++$i;
                        echo '</div>';
                    }

                }

                echo '<form enctype="multipart/form-data" action="admin.php?act=bazar" method="post">';
                echo '<div class="gmenu">';
                echo '<table cellpadding="2" cellspacing="0"><tr>';


                echo '<td><b>Имя</b></td><td><input type="text" name="name"  value=""/></td></tr><tr>';
                echo '<td><b>Описание</b></td><td><input type="text" name="ops"  value=""/></td></tr><tr>';

                echo '<td><b>Страна</b></td><td>
<select name="strana" style="font-size:x-small">';

                foreach ($school as $a) {

                    echo '<option  value="' . $a . '">' . $scl[$a] . '</option>';
                }


                echo '</select></td></tr><tr>';

                echo '<td><b>Цена</b></td><td><input type="text" name="price"  value="10000"/></td></tr><tr>';

                echo '</tr>';
                echo '</table>';

                echo '<p><input type="submit" name="submit" value="Добавить" /></p></div></form>';
            }
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            break;


        case 'delbazar':
            if (!$id) {
                echo display_error('Пустые параметры!');
                echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
                require_once ("incfiles/end.php");
                exit;
            }
            mysql_query("DELETE FROM  `shcool_2` WHERE `id`='$id'");
            header("Location: admin.php?act=bazar");
            break;

        case 'clean': ////////////////////////////////////////////////////////////
            // Очистка                                       //
            ////////////////////////////////////////////////////////////
            if ($rights >= 7) {
                if (isset($_POST['submit'])) {

                    $cl = isset($_POST['cl']) ? intval($_POST['cl']) : '';
                    switch ($cl) {


                        default:
                            // Чистим сообщения, старше 1 недели
                            $z = mysql_query("selest * FROM  `users` WHERE  `lastdate` < '" . ($realtime -
                                604800) . "'");
                            $pp = @mysql_fetch_array($z);

                            $z = mysql_query("SELECT * FROM `users` WHERE  `lastdate` < '" . ($realtime -
                                604800) . "' AND `manager` > '0'");

                            while ($arr = mysql_fetch_array($z)) {
                                mysql_query("update `users` set `manager2`='' where id='" . $arr['id'] . "';");
                                mysql_query("update `team_2` set `name_admin`='', `id_admin`='' where id_admin='" .
                                    $arr['id'] . "';");

                            }
                            echo '<p>Все игороки кто не заходил больше  1 недели удалены .</p><p><a href="admin.php">Вернуться</a></p>';
                    }

                } else {
                    echo '<p><b>Очистка менеджеров</b></p>';
                    echo '<u>Что чистим?</u>';
                    echo '<form id="clean" method="post" action="admin.php?act=clean">';
                    echo '<input type="radio" name="cl" value="0" checked="checked" />Старше 1 недели<br />';

                    echo '<input type="submit" name="submit" value="Очистить" />';
                    echo '</form>';
                    echo '<p><a href="admin.php">Отмена</a></p>';
                }
            }
            break;

        case 'sponsor':
/* Управление спонсорами */
echo '<b>Управление спонсорами</b><br/>';
$x=mysql_query("SELECT * FROM `m_sponsor` ORDER BY `id` DESC");
if(!mysql_num_rows($x)){echo 'Нет спонсоров';
}else{
while($row=mysql_fetch_assoc($x)){
echo 'Название: '.$row['name'].' ';
echo '<a href="admin.php?act=delsponsor&amp;id='.$row['id'].'">[Удал]</a><br/>';
echo 'Деньги за матч: <b>['.$row['money'].']</b><br/>';

echo 'Лимит поражений: <b>['.$row['limit'].']</b><br/>';
};
};
echo '<form action="admin.php?act=addsponsor" method="post" name="form" enctype="multipart/form-data">';
echo 'Картинка:<br/>';
echo '<input type="file" name="ava" /><br/>';
echo 'Название: <br/>';
echo '<input type="text" name="name" /><br/>';
echo 'Стоимость контракта: <br/>';
echo '<input type="text" name="mon" /><br/>';
echo 'Деньги за матч: <br/>';
echo '<input type="text" name="money" /><br/>';
echo 'Лимит поражений: <br/>';
echo '<input type="text" name="limit" /><br/>';
echo '<input type="submit" value="Добавить" />';
echo '</form>';

echo '<a href="admin.php">Админка</a>';
break;

case 'delsponsor':
/* Удаляю спонсор */

$id=(int)$_GET['id'];
if(!$id){echo 'Пустые параметры!';break;};
mysql_query("DELETE FROM `m_sponsor` WHERE `id`='$id'");
echo 'Удалено!<br/>';
echo '<a href="admin.php">Админка</a>';
break;

case 'addsponsor':
$name=mysql_real_escape_string(htmlspecialchars(trim($_POST['name'])));
$money=(int)$_POST['money'];
$limit=(int)$_POST['limit'];
$mon=(int)$_POST['mon'];
if(!$name || !$money || $money<1 || !$limit || !$mon ){echo 'Пустые параметры!';break;};
if($_FILES['ava']['error']>0){echo 'Ошибка при загрузке файла!';break;};
if($_FILES['ava']['size']>(1000*250)){echo 'Слишком большой размер файла!';break;};
$info=@getimagesize($_FILES['ava']['tmp_name']);
if(!preg_match('{image/(.*)}is',$info['mime'],$p)){echo 'Попытка загрузки запрещенного файла!';break;};
$fname=$realtime.'.'.$p[1];
$tmp=$_FILES['ava']['tmp_name'];
move_uploaded_file($tmp,'img/'.$fname);

mysql_query("INSERT INTO `m_sponsor` SET
                    `name` = '" . mysql_real_escape_string(mb_substr(trim($_POST['name']), 0, 64)) . "',
					`mon` = '" . $_POST['mon'] . "',
                    `money` = '" . $_POST['money'] . "',
					`logo` = '" . $fname . "',
                    `limit`   = '" . $_POST['limit'] . "';");


echo 'Добавлено!<br/>';
echo '<a href="admin.php">Админка</a>';
break;


            //Кубковые турниры
        case 'tur':
        
        if ($id){
$sql = "WHERE `liga`='$id'";
}else{
$sql = "WHERE `liga`='1'";
$id = 1;
}
        
        
        
            if (isset($_POST['submit'])) {


                $name = (trim($_POST['name']));
                $priz = (int)$_POST['priz'];
                $time = $realtime;
				$min_lvl = isset($_POST['min_lvl']) ? intval($_POST['min_lvl']) : '';
				$max_lvl = isset($_POST['max_lvl']) ? intval($_POST['max_lvl']) : '';


                if (!$name || !$priz || !$time || !$max_lvl) {
                    echo display_error('Пустые параметры!');
                    require_once ("incfiles/end.php");
                    exit;
                }

				if($min_lvl > $max_lvl){
                    echo display_error('Не допустимые параметры!');
                    require_once ("incfiles/end.php");
                    exit;
                }

                $handle = new upload($_FILES['imagefile']);
                if ($handle->uploaded) {
                    // Обрабатываем фото
                    $handle->file_new_name_body = $realtime;
                    //$handle->mime_check = false;
                    $handle->allowed = array('image/jpeg', 'image/gif', 'image/png');
                    $handle->file_max_size = 1024 * $set['flsz'];
                    $handle->file_overwrite = true;
                    $handle->image_resize = true;
                    $handle->image_x = 100;
                    $handle->image_ratio_y = true;
                    $handle->image_convert = 'jpg';
                    $handle->process('img/');
                    if ($handle->processed) {
                        // Обрабатываем превьюшку
                        $handle->file_new_name_body = $realtime . '_small';
                        $handle->file_overwrite = true;
                        $handle->image_resize = true;
                        $handle->image_x = 32;
                        $handle->image_ratio_y = true;
                        $handle->image_convert = 'jpg';
                        $handle->process('img/');
                        if ($handle->processed) {
                            mysql_query("INSERT INTO `tournaments_2` SET
                    `name` = '" . mysql_real_escape_string(mb_substr(trim($_POST['name']),
                                0, 64)) . "',
                    `priz` = '" . $_POST['priz'] . "',
					`komand` = '16',
					`path` = '" . $realtime . "',
					`max_lvl` = '" . $min_lvl . "|" . $max_lvl . "',
					`liga` = '" . $id . "',
					
                    `time`   = '" . $realtime . "';");

                            header("Location: admin.php?act=tur");
                        } else {
                            echo functions::display_error($handle->error);
                        }
                    } else {
                        echo display_error($handle->error);
                    }
                    $handle->clean();
                }
            } else {
                echo '<div class="phdr">Управление кубковыми турнирами</div>';
                //$x = mysql_query("SELECT * FROM `tournaments_2` ORDER BY `id` DESC");
                
                $x = mysql_query("SELECT * FROM `tournaments_2` $sql order by `id` asc;");
                
                if (!mysql_num_rows($x)) {
                    echo 'Нет турниров';
                } else {
                    while ($row = mysql_fetch_assoc($x)) {
                        echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
                        echo 'Название: <b>' . $row['name'] . '</b> ';
                        echo '<a href="admin.php?act=deltur&amp;id=' . $row['id'] .
                            '">[Удалить]</a><br/>';
                        echo 'Приз:  <b>' . $row['priz'] . '</b><br/>';
                        echo 'Уровень: <b>' . $row['max_lvl'] . '</b><br/>';

                        ++$i;
                        echo '</div>';
                    }

                }

                echo '<form enctype="multipart/form-data" action="admin.php?act=tur" method="post">';
                echo '<div class="gmenu">';
                echo '<table cellpadding="2" cellspacing="0"><tr>';

                echo '<td><b>Имя</b></td><td align="right"><input type="text" name="name"  value=""/></td></tr><tr>';
                //echo '<td><b>Дата</b></td><td><small>'.$realtime.'</small><br/><input type="text" name="time"  value="01.12.2011 10:00"/></td></tr><tr>';
                echo '<td><b>Приз</b></td><td align="right"><input type="text" name="priz"  value=""/></td></tr><tr>';
                
                echo '<td><b>Уровень min</b></td><td align="right">';
                echo "
                 <select name='min_lvl'>
                 <option value='1'>1 новичок</option>
                 <option value='2'>2 </option>
                 <option value='3'>3</option>
                 <option value='4'>4 </option>
                 <option value='5'>5 </option>
                 <option value='6'>6 </option>
                 <option value='7'>7 </option>
                 <option value='8'>8 </option>

                 </select></td></tr><tr>";
				 echo '<td><b>Уровень max</b></td><td align="right">';
				                 echo "
                 <select name='max_lvl'>
                 <option value='1'>1 новичок</option>
                 <option value='2'>2 </option>
                 <option value='3'>3</option>
                 <option value='4'>4 </option>
                 <option value='5'>5 </option>
                 <option value='6'>6 </option>
                 <option value='7'>7 </option>
                 <option value='8'>8 </option>

                 </select>";
                
                echo'
                
                
                </td></tr><tr>';
                
                echo '<td><b>Изображение</b></td><td align="right"><input type="file" name="imagefile" value="" /></td></tr><tr>';

                echo '</tr>';
                echo '</table>';

                echo '<p><input type="submit" name="submit" value="Добавить турнир" /></p></div></form>';


            }
            
$rqq = mysql_query("SELECT * FROM `liga_2` order by `id` asc;");
    echo '<div class="menu">';
    while ($liga = mysql_fetch_array($rqq)) {
if ($id == $liga[id])
       echo "<li><b>$liga[name]</b></li>";
else
       echo "<li><a href='admin.php?act=tur&amp;id=$liga[id]'>$liga[name]</a></li>";
       
       
       ++$i;
    }
echo '</div>';
            
            
            
            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            
            break;

        case 'deltur':
            if (!$id) {
                echo display_error('Пустые параметры!');
                echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
                require_once ("incfiles/end.php");
                exit;
            }

            mysql_query("DELETE FROM `tournaments_2` WHERE `id`='$id'");
            header("Location: admin.php?act=tur");
            break;

        case 'delete': ////////////////////////////////////////////////////////////
            // Удалить Игрока                                           //
            ////////////////////////////////////////////////////////////

            if (isset($_POST['submit'])) {
                mysql_query("DELETE FROM `player_2` WHERE `id` = '" . $id . "' LIMIT 1;");
                mysql_query("OPTIMIZE TABLE `player_2`;");

                header('Location: admin.php');
            } else {
                echo '<div class="phdr"><b><a href="admin.php">Админ Панель</a></b> | удалить матч</div>';
                echo '<div class="rmenu"><p>Внимание!<br/>Вы действительно хотите удалить игрока ?';
                echo '</p><p><form action="admin.php?act=delete&amp;id=' . $id .
                    '" method="post"><input type="submit" name="submit" value="Удалить" /></form>';
                echo '</p></div>';
                echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
            }

            break;
        case 'omol':

  $req = mysql_query("SELECT * FROM `player_2` WHERE `id`='" . $id . "' LIMIT 1;");
            if (!mysql_num_rows($req)) {
                header("Location: admin.php");
                exit;
            }

            $res = mysql_fetch_array($req);

            echo '<div class="phdr">Омоложение игрока</div>';

            if (isset($_POST['submit'])) {
                $error = false;

                if (empty($_POST['voz']))
                    
                    $error = 'Поле  не заполнено<br />';

                if (!$error) {
                    mysql_query("UPDATE `player_2` SET
                `voz` = '" . (float)$_POST['voz'] . "' WHERE `id`='" . $id . "';");

                    header('Location: admin.php');
                } else {
                    echo '<div class="rmenu"><p>ОШИБКА!<br />' . $error .
                        '<a href="admin.php?act=omol&amp;id=' . $id . '">Повторить</a></p></div>';
                }
            } else {
                echo '<form action="admin.php?act=omol&amp;id=' . $id . '" method="post">';
                echo '<div class="gmenu">';
                echo '<table cellpadding="2" cellspacing="0"><tr>';


                echo '<td><b>Возраст</b></td><td><input type="text" name="voz"  value="' . $res['voz'] .
                    '"/></td></tr>';
     

                
                echo '</table>';

                echo '<p><input type="submit" name="submit" value="Омолодить" /></p></div></form>';
            }

            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';

            break;


       





        case 'edit_2': ////////////////////////////////////////////////////////////
            // Редактировать матч                                     //
            ////////////////////////////////////////////////////////////


            $req = mysql_query("SELECT * FROM `player_2` WHERE `id`='" . $id . "' LIMIT 1;");
            if (!mysql_num_rows($req)) {
                header("Location: admin.php");
                exit;
            }

            $res = mysql_fetch_array($req);

            echo '<div class="phdr"><b><a href="admin.php">Админ Панель</a></b> | редактировать коэффициенты матча</div>';

            if (isset($_POST['submit'])) {
                $error = false;

                if (empty($_POST['name']) || empty($_POST['nomer']) || empty($_POST['voz']) ||
                    empty($_POST['poz']) || empty($_POST['tal']) || empty($_POST['otbor']) || empty
                    ($_POST['opeka']) || empty($_POST['drib']) || empty($_POST['priem']) || empty($_POST['vonos']) ||
                    empty($_POST['pas']) || empty($_POST['sila']) || empty($_POST['tocnost']))
                    
                    $error = 'Какое-то поле  не заполнено<br />';

                if (!$error) {
                    mysql_query("UPDATE `player_2` SET
                `name` = '" . $_POST['name'] . "',
                `nomer`  = '" . (float)$_POST['nomer'] . "',
                `voz` = '" . (float)$_POST['voz'] . "',
                `poz` = '" . $_POST['poz'] . "',
				`strana` = '" . $_POST['strana'] . "',
				
                `tal` = '" . (float)$_POST['tal'] . "',
                `mas` = '" . (float)$_POST['mas'] . "',
                `otbor` = '" . (float)$_POST['otbor'] . "',
                `opeka` = '" . (float)$_POST['opeka'] . "',
                `drib` = '" . (float)$_POST['drib'] . "',
                `priem` = '" . (float)$_POST['priem'] . "',
				`vonos` = '" . (float)$_POST['vonos'] . "',
				`pas` = '" . (float)$_POST['pas'] . "',
				`sila` = '" . (float)$_POST['sila'] . "',
				`tocnost` = '" . (float)$_POST['tocnost'] . "'
				WHERE `id`='" . $id . "';");

                    header('Location: admin.php');
                } else {
                    echo '<div class="rmenu"><p>ОШИБКА!<br />' . $error .
                        '<a href="admin.php?act=edit_2&amp;id=' . $id . '">Повторить</a></p></div>';
                }
            } else {
                echo '<form action="admin.php?act=edit_2&amp;id=' . $id . '" method="post">';
                echo '<div class="gmenu">';
                echo '<table cellpadding="2" cellspacing="0"><tr>';


                echo '<td><b>Имя</b></td><td><input type="text" name="name"  value="' . $res['name'] .
                    '"/></td></tr><tr>';
                echo '<td><b>Номер</b></td><td><input type="text" name="nomer"  value="' . $res['nomer'] .
                    '"/></td></tr><tr>';
                echo '<td><b>Возраст</b></td><td><input type="text" name="voz"  value="' . $res['voz'] .
                    '"/></td></tr><tr>';
                echo '<td><b>Позиция</b></td><td>

<select name="poz" style="font-size:x-small">
	<option selected="selected">Выберите позицыю</option>
	<option value="Вр">Вратарь [Вр]</option>
	<option value="ЛЗ">Левый защитник [ЛЗ]</option>
    <option value="ЦЗ">Центральный защитник [ЦЗ]</option>
    <option value="ПЗ">Правый защитник [ПЗ]</option>
    <option value="ЛП">Левый полузащитник [ЛП]</option>
    <option value="ЦП">Центральный полузащитник [ЦП]</option>
    <option value="ПП">Правый полузащитник [ПП]</option>
    <option value="ЛФ">Левый форвард [ЛФ]</option>
	<option value="ЦФ">Центральный форвард [ЦФ]</option>
	<option value="ПФ">Правый форвард [ПФ]</option>
	</select></td></tr><tr>';

                echo '<td><b>Страна</b></td><td>
<select name="strana" style="font-size:x-small">
<option selected="selected">Выберите страну</option>
<option  value="liga"> Лига Наций</option>
<option  value="en"> Англия</option>
<option  value="alb"> Албания</option>
<option  value="arg"> Аргентина</option>
<option  value="aus"> Австралия</option>
<option  value="avs"> Австрия</option>
<option  value="bel"> Бельгия</option>
<option  value="bol"> Болгария</option>
<option  value="br"> Бразилия</option>
<option  value="ven"> Венгрия</option>
<option  value="gana"> Гана</option>
<option  value="ge"> Германия</option>
<option  value="go"> Голландия</option>
<option  value="gon"> Гондурас</option>
<option  value="gre"> Греция</option>
<option  value="gvi"> Гвинея</option>
<option  value="cam"> Камерун</option>
<option  value="che"> Чехия</option>
<option  value="cher"> Черногория</option>
<option  value="chili"> Чили</option>
<option  value="dan"> Дания</option>
<option  value="ekv"> Еквадор</option>
<option  value="fin"> Финляндия</option>
<option  value="fr"> Франция</option>
<option  value="iran"> Иран</option>
<option  value="irl"> Ирландия</option>
<option  value="isl"> Исландия</option>
<option  value="isr"> Израиль</option>
<option  value="it"> Италия</option>
<option  value="sp"> Испания</option>
<option  value="kan"> Канада</option>
<option  value="kol"> Колумбия</option>
<option  value="kor"> Корея</option>
<option  value="kot"> Котдивуар</option>
<option  value="mak"> Македония</option>
<option  value="mali"> Малибу</option>
<option  value="mar"> Марокко</option>
<option  value="mek"> Мексика</option>
<option  value="nig"> Нигерия</option>
<option  value="nor"> Норвегия</option>
<option  value="par"> Парагвай</option>
<option  value="peru"> Перу</option>
<option  value="pol"> Польща</option>
<option  value="por"> Португалия</option>
<option  value="rum"> Румуния</option>
<option  value="rus"> Россия</option>
<option  value="sen"> Сенегал</option>
<option  value="ser"> Сербия</option>
<option  value="sho"> Шотландия</option>
<option  value="shv"> Швеция</option>
<option  value="slo"> Словатчина</option>
<option  value="hor"> Хорватия</option>
<option  value="togo"> Того</option>
<option  value="tur"> Турция</option>
<option  value="ua"> Украина</option>
<option  value="uels"> Уельс</option>
<option  value="uru"> Уругвай</option>
<option  value="usa"> США</option>
<option  value="yam"> Ямайка</option>
<option  value="yap"> Япония</option>
<option  value="zel"> Зеландия</option></select></td></tr><tr>';

                echo '<td><b>Талант</b></td><td><input type="text" name="tal"  value="' . $res['tal'] .
                    '"/></td></tr><tr>';
                echo '<td><b>Отбор</b></td><td><input type="text" name="otbor"  value="' . $res['otbor'] .
                    '"/></td></tr><tr>';
                echo '<td><b>Опека</b></td><td><input type="text" name="opeka"  value="' . $res['opeka'] .
                    '"/></td></tr><tr>';
                echo '<td><b>Дриблинг</b></td><td><input type="text" name="drib"  value="' . $res['drib'] .
                    '"/></td></tr><tr>';
                echo '<td><b>Прием мяча</b></td><td><input type="text" name="priem"  value="' .
                    $res['priem'] . '"/></td></tr><tr>';
                echo '<td><b>Выносливость</b></td><td><input type="text" name="vonos"  value="' .
                    $res['vonos'] . '"/></td></tr><tr>';
                echo '<td><b>Пас</b></td><td><input type="text" name="pas"  value="' . $res['pas'] .
                    '"/></td></tr><tr>';
                echo '<td><b>Сила удара</b></td><td><input type="text" name="sila"  value="' . $res['sila'] .
                    '"/></td></tr><tr>';
               echo '<td><b>Точность удара</b></td><td><input type="text" name="tocnost"  value="' . $res['tocnost'] .
                    '"/></td></tr><tr>';


                echo '</tr>';
                echo '</table>';

                echo '<p><input type="submit" name="submit" value="Редактировать" /></p></div></form>';
            }

            echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';

            break;
    }
}
echo'<br/><a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>