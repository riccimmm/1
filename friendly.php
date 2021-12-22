<?php

define('_IN_JOHNCMS', 1);

$textl = 'Товарические матчи';

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


if (mysql_num_rows($manager) == 0) {
    echo "Команды не существует<br/>";
    require_once ("incfiles/end.php");
    exit;
}
/*
    $rtop = mysql_query("SELECT * FROM `tur_2` WHERE `time`<'" .($realtime - 300) . "' AND `rez2`='—' AND `id_team1`='" . $datauser[manager2]  . "' OR `id_team2`='" . $datauser[manager2]  . "' ORDER by `time` DESC LIMIT 1;");
    
    $pro = mysql_num_rows($rtop);
    //$pro2 = $rtop ;
    //$pro2 = mysql_query("SELECT * FROM `tur_2` WHERE `id`='" . $id . "';");
    $prott = mysql_fetch_assoc($rtop);
    if ($pro == 0 && $prott[chemp]=='tov')
    {
    $time_start = $prott[time];
    $tt = ($time_start + 300) -$realtime;
    echo '<div class="gmenu" align="center"><a href="team.php?id='.$prott[id_team1].'">'.$prott[name_team1].'</a> vs <a href="team.php?id='.$prott[id_team2].'">'.$prott[name_team2].'</a><br/>';
    echo 'До начала матча осталось: ' . date("i:s", $tt) . '<br/><br/>';
    
    echo '<a href="sostav.php?act=editsostav&amp;id='.$datauser['manager2'].'">Изменить состав</a><br/>';
    echo '<a href="sostav.php?act=tactics&amp;id='.$datauser['manager2'].'">Изменить тактику</a>';
    echo '</div>';

    }
*/

switch ($act) {
    case "say":
        //Подача заявки на товарку
        echo '<div class="gmenu"><b>Товарищеские матчи</b></div>';

        //Перевіряю фіз готовність команди
        $result = mysql_result(mysql_query('SELECT SUM(fiz) FROM `player_2` WHERE `kom`="' .
            $datauser[manager2] . '" AND `sostav`="1" LIMIT 11'), 0);
        $fizgotov = round($result / 11);

        //Якщо менше 10% вивожу
        if ($fizgotov < 10) {
            echo '<div class="c">Физготовность команды очень слабая (меньше 10%)<br/>';
            echo 'Физготовность основного состава вашей команды: <font color="#FF0000">' . $fizgotov .'%</font></div>';
            require_once ("incfiles/end.php");
            exit;
        }

        //Отримую команди які мають менеджерів
        $req = mysql_query("SELECT `id`,`name`,`logo` FROM `team_2` where `id_admin`!='0' AND `id`!='" . $datauser[manager2] . "' order by id asc;");
        $total = mysql_num_rows($req);
        //echo '<div class="c">';
        //echo "-- $lvl";
        if ($total == 0)
{
echo '<div class="rmenu">Нет комманд, которым вы можете отправить заявку на игру.</div>';
}else{
        
        echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader" >
<td><b>Команда</b></td>
<td>Действие</td>
</tr>
';


        while ($arr = mysql_fetch_array($req)) {
            echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                '<tr bgcolor="f3f3f3">';
            echo '<td><img src="logo/small' . $arr[logo] . '" alt=""/> 
<a href="team.php?id=' . $arr[id] . '">' . $arr[name] . '</a></td>';

            echo '<td><center><a href="friendly.php?act=pred&amp;id=' . $arr[id] .
                '">Предложить</a></center></td>';
            echo '</tr>';
            ++$i;
        }
        echo '</table>';
        }
        echo '<div class="phdr">Всего: ' . $total . '</div>';

        echo '<div class="c">';
        echo '<li><a href="friendly.php">Предложения мне';
        $m = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where `id_team2`= '" . $fid . "';"), 0);

        echo ' (' . $m . ')</a></li>';

        echo '<li><b>Сделать предложение</b></li>';
         $mz = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where  `id_team1`= '" .$fid . "';"), 0);
        echo '<li><a href="friendly.php?act=moi&amp;id=' . $fid . '">Мои предложения  (' . $mz . ')</a></li>';

        echo '<li><a href="friendly.php?act=my_calendar&amp;id=' . $fid . '">Мои тов. игры  </a></li>';
//echo '<li><a href="friendly.php?act=calendar&amp;id=' . $fid .'">Все тов. игры</a></li>';
        echo '</div>';

        break;

    case "pred":
        $t = mysql_query("select `name`, `id_admin` from `team_2` where id='" . $id .
            "';");
        $tov = mysql_fetch_array($t);
        //////////////////////
        $gu = mysql_fetch_array(mysql_query("SELECT `id_team2` FROM `frend_2` where  `id_team1`= '" .
            $fid . "'  ;"));
        $error = array();
        // Проверяем на ошибки
        if (!mysql_num_rows($t))
            $error[] = 'Команды не существует!';
        if ($id == $fid)
            $error[] = 'Нельзя делать предложение самому себе!';
        if ($tmatch >= 10)
            $error[] = 'Вы не можете сделать это предложение: Вы уже сделали 10 предложений!';
        if ($tov['id_admin'] == 10)
            $error[] = 'Вы не можете сделать предложение этой команде: у команды нету менеджера.';
        if ($id == $gu['id_team2'])
            $error[] = 'Вы уже делали предложение этой команде.';
        $u = mysql_result(mysql_query("SELECT COUNT(*) FROM `game_2` where  `id_team1`= '" .$fid . "' OR `id_team2`= '" . $fid . "' ;"), 0);
        if ($u != 0)
            $error[] = 'Вы уже играете матч.';

        if (!$error) {
            mysql_query("insert into `frend_2` set 
`time`='" . $realtime . "', 
`id_team1`='" . $fid . "',
`id_team2`='" . $id . "',  
`name_team1`='" . $names . "', 
`name_team2`='" . $tov['name'] . "', 
`level_team1`='" . $lvl . "', 
`level_team2`='" . $tov['lvl'] . "' 
;");

            //Пишем в историю
            $text = 'Команда <a href="team.php?id=' . $fid . '">' . $names .
                '</a> предлагает сыграть товарищеский матч команде <a href="team.php?id=' . $id .
                '">' . $tov['name'] . '</a> ';
            mysql_query("insert into `history_2` set 
                    `time`='" . $realtime . "', 
                    `type`='tov',
                    `text`='" . $text . "' ;");


            mysql_query("UPDATE `team_2` set `tmatch`=`tmatch`+1 where `id`='" . $fid . "' LIMIT 1;");
            echo '<div class="c"> ';
            echo '<div class="rmenu" style="text-align:center;">Вы предложили товарический матч в команду ' . $tov[name] . '. Ожидайте ответа! </div>';
            echo '<br/><a href="friendly.php" class="button">Назад</a><br/>';
            echo '</div> ';
        } else {
            echo display_error($error, '<a href="friendly.php">Назад</a>');
        }
        break;
    case "mne":
       
        break;

    case "start":

        $q = mysql_query("select * from `frend_2` where id='" . $id . "';");
        $totalz = mysql_num_rows($q);

        if ($totalz != 1) {
            echo display_error('Вашей заявки не найдено');
            require_once ("incfiles/end.php");
            exit;
        }
        $arr = mysql_fetch_array($q);

        $q1 = mysql_query("select * from `team_2` where id='" . $arr[id_team1] .
            "' LIMIT 1;");
        $arr1 = mysql_fetch_array($q1);

        $q2 = mysql_query("select * from `team_2` where id='" . $arr[id_team2] .
            "' LIMIT 1;");
        $arr2 = mysql_fetch_array($q2);

        if ($arr1['id'] == $arr2['id']) {
            echo display_error('Вы не можете играть сами с собой');
            require_once ("incfiles/end.php");
            exit;
        }

        if ($arr2['id'] != $datauser['manager2']) {
            echo display_error('Подтверждение запрещено');
            require_once ("incfiles/end.php");
            exit;
        }


        if (empty($arr1['id']) && empty($arr2['id']) && empty($arr1['name']) && empty($arr2['name'])) {
            echo display_error('Заявка не найдена');
            require_once ("incfiles/end.php");
            exit;
        }
        $u = mysql_result(mysql_query("SELECT COUNT(*) FROM `game_2` where  `id_team1`= '" .
            $fid . "' OR `id_team2`= '" . $fid . "' ;"), 0);
        if ($u != 0) {
            echo display_error('Вы уже играете матч.<br/>[<a href="friendly.php?act=say">Назад</a>]');
            require_once ("incfiles/end.php");
            exit;
        }

        //Удаляем заявку
        mysql_query("delete from `frend_2` where `id`='" . $id . "';");

        //$mtime = $realtime + 300;
        mysql_query("insert into `tur_2` set 
`chemp`='tov',
`time`='" . $realtime . "',
`id_team1`='" . $arr1['id'] . "',
`id_team2`='" . $arr2['id'] . "',
`name_team1`='" . $arr1['name'] . "',
`name_team2`='" . $arr2['name'] . "'
;");

        $lastid = mysql_insert_id();
        header('location: trans.php?id=' . $lastid);

        break;
    case "moi":
        ////////////////////////////////////////////////////////////
        // мои Предложения                                        //
        ////////////////////////////////////////////////////////////
        echo '<div class="gmenu"><b>Мои предложения</b></div>';
        $a = mysql_query("SELECT * FROM `frend_2` where `id_team1`= '" .
            $fid . "' ;");
        if (!mysql_num_rows($a)) {
            echo '<div class="rmenu">Предложений нет</div> ';
            
$m = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where `id_team2`= '" . $fid . "';"), 0);
		echo '<div class="phdr">Всего: ' . $m . '</div>';

        echo '<div class="menu"><a href="friendly.php">Предложения мне (' . $m . ')</a></div>';
         $mz = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where  `id_team1`= '" .$fid . "';"), 0);
        echo '<div class="menu"><b>Мои предложения  (' . $mz . ')</b></div>';

        echo '<div class="menu"><a href="friendly.php?act=my_calendar&amp;id=' . $fid . '">Мои тов. игры  </a></div>';
		echo '<div class="menu"><a href="friendly.php?act=calendar&amp;id=' . $fid .'">Все тов. игры</a></div>';

            
            
			require_once ("incfiles/end.php");
            exit;
        }
        
        echo '
<table border="0" id="example" cellspacing="1" cellpadding="1">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td width="70"><b>Дата</b></td>
<td><b>Команда</b></td>
<td width="180"><b>Действие</b></td>
</tr>';
        
        
        while ($mn = mysql_fetch_assoc($a)) {
            
            echo ($i % 2) ?  '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
   echo '<td align="center">' . date("d.m/H:i", $mn['time']) . '</td>';		
   echo '<td align="center"><a href="team.php?id='.$mn[id_team2].'">' . $mn['name_team2'] . ' </a> [' . $mn['level_team2'] . ']</td>';		
   echo '<td align="center">
<a href="friendly.php?act=moino&amp;id=' . $mn[id] . '&amp;fid=' . $fid .'">Отказатся</a></td>';		

			echo '</tr>';            
            ++$i;
            
            
            
            
            echo '<div class="c">';
            echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';

            echo 'Вы предложили игру команде <a href="team.php?id=' . $mn['id_team2'] . '">
            ' . $mn['name_team2'] .
                '</a>  <a href="friendly.php?act=moino&amp;id=' . $mn[id] . '&amp;fid=' . $fid .
                '">Отказатся</a><br/>';
            echo '</div>';
            
            echo '</div>';
            
            ++$i;
        }
        
        echo '</table>';
         $mz = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where  `id_team1`= '" .$fid . "';"), 0);
    echo '<div class="phdr">Всего: ' . $mz . '</div>';
        $m = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where `id_team2`= '" . $fid . "';"), 0);
        echo '<div class="menu"><a href="friendly.php">Предложения мне (' . $m . ')</a></div>';
        echo '<div class="menu"><b>Мои предложения  (' . $mz . ')</b></div>';
        echo '<div class="menu"><a href="friendly.php?act=my_calendar&amp;id=' . $fid . '">Мои тов. игры  </a></div>';
		echo '<div class="menu"><a href="friendly.php?act=calendar&amp;id=' . $fid .'">Все тов. игры</a></div>';
        
        
        break;

    case "moino":
        ////////////////////////////////////////////////////////
        /// Удаление отдельного матча                              //
        ////////////////////////////////////////////////////////

        if (!$id || $_GET['fid'] != $fid) {
            header("Location: index.php");
            exit;
        }
        mysql_query("DELETE FROM `frend_2` WHERE   `id`='" . $id . "';");
        $tmatch = $tmatch - 1;
        if ($tmatch < 0) {
            $tmatch = 0;
        }
        mysql_query("UPDATE `team_2` set `tmatch`='" . $tmatch . "' where `id`='" . $fid .
            "' LIMIT 1;");
        header("Location: friendly.php");
        break;

    case "mneno":
        ////////////////////////////////////////////////////////////
        // Удаление отдельного матча                              //
        ////////////////////////////////////////////////////////////
        if (!$id || $_GET['fid'] == $fid) {
            header("Location: index.php");
            exit;
        }
        $a = mysql_query("SELECT `id_team1` FROM `game_2` where  `id_team1`= '" . $fid .
            "' ;");
        if (mysql_num_rows($a) != 0) {
            echo display_error('Идет игра! Отменить не возможно!');
            echo '<br/>[<a href="index.php">В панель управления</a>]<br/>';
            require_once ("incfiles/end.php");
            exit;
        }

        $a2 = mysql_query("SELECT * FROM `frend_2` where  `id_team1`= '" . $_GET['fid'] .
            "' AND `id_team2`= '" . $fid . "' AND `id`='" . $id . "' ;");
        if (mysql_num_rows($a2) == 0) {
            echo display_error('Отменить не возможно!');
            echo '<br/>[<a href="index.php">В панель управления</a>]<br/>';
            require_once ("incfiles/end.php");
            exit;
        }

        mysql_query("DELETE FROM `frend_2` WHERE   `id`='" . $id . "';");
        $qk = @mysql_query("select `id`,`tmatch` from `team_2` where id='" . $_GET['fid'] .
            "' LIMIT 1;");
        if (mysql_num_rows($qk) == 0) {
            echo display_error('Команды не существует!');
            echo '<br/>[<a href="index.php">В панель управления</a>]<br/>';
            require_once ("incfiles/end.php");
            exit;
        }
        $kom = @mysql_fetch_array($qk);
        $kom['tmatch'] = $kom['tmatch'] - 1;
        if ($kom['tmatch'] < 0) {
            $kom['tmatch'] = 0;
        }
        mysql_query("UPDATE `team_2` set `tmatch`='" . $kom['tmatch'] . "' where `id`='" .
            $kom['id'] . "' LIMIT 1;");
        header("Location: friendly.php");
        break;

    case "calendar":
        ////////////////////////////////////////////////////////////
        // Результаты                            //
        ////////////////////////////////////////////////////////////
        echo '<div class="gmenu"><b>Результаты</b></div>';
        echo '<div class="c">';

        echo '<table border="0" width="100%" bgcolor="D0D0D0" cellspacing="1" cellpadding="4">
<tr bgcolor="40B832" align="center" class="whiteheader" >
<td><b>Дата</b></td>
<td><b>Матч</b></td>
<td><b>Счет</b></td>
</tr>';
        $req = mysql_query("SELECT COUNT(*) FROM `tur_2` WHERE `chemp`='tov' ");
        $total = mysql_result($req, 0);

        $matile = mysql_query("SELECT * FROM `tur_2` WHERE `chemp`='tov'  ORDER BY `id` DESC LIMIT $start, $kmess");
        while ($mat = mysql_fetch_array($matile)) {
            echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                '<tr bgcolor="f3f3f3">';
            echo '<td><center>' . date("d.m / H:i", $mat['time']) . '</center></td>';
            echo '<td><center><a href="team.php?id=' . $mat['id_team1'] . '">' . $mat['name_team1'] .
                '</a> : <a href="team.php?id=' . $mat['id_team2'] . '">' . $mat['name_team2'] .
                ' </a></center></td>';
            echo '<td><center><a href="trans.php?id=' . $mat['id'] . '">' . $mat['rez1'] .
                ':' . $mat['rez2'] . ' </a></center></td>';
            echo '</tr>';
            ++$i;
        }

        echo '</table>';
        echo '</div>';
        if ($total > $kmess) {
            echo '<p>' . pagenav('friendly.php?act=calendar&amp;', $start, $total, $kmess) .
                '</p>';
            echo '<p><form action="friendly.php?act=calendar&amp;" method="post"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        }
        break;

    case "my_calendar":
        ////////////////////////////////////////////////////////////
        // Результаты                            //
        ////////////////////////////////////////////////////////////
        echo '<div class="gmenu"><b>Результаты</b></div>';

        $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `tur_2` where `chemp`='tov' AND `id_team1`= '" .
            $fid . "' or `chemp`='tov' AND `id_team2`= '" . $fid . "';"), 0);
        $req = mysql_query("SELECT * FROM `tur_2` where `chemp`='tov' AND `id_team1`= '" .
            $fid . "' or `chemp`='tov' AND `id_team2`= '" . $fid .
            "'  ORDER BY `time` DESC LIMIT $start, $kmess");

        echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader" >
<td><b>Дата</b></td>
<td><b>Матч</b></td>
<td><b>Счет</b></td>
</tr>';
        while ($arr = mysql_fetch_array($req)) {


            echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                '<tr bgcolor="f3f3f3">';
            echo '<td><center>' . date("d.m / H:i", $arr['time']) . '</center></td>';
            echo '<td><center><a href="team.php?id=' . $arr['id_team1'] . '">' . $arr['name_team1'] .
                ' </a> : <a href="team.php?id=' . $arr['id_team2'] . '">' . $arr['name_team2'] .
                '</a> </center></td>';
            echo '<td><center><a href="trans.php?id=' . $arr['id'] . '">' . $arr['rez1'] .
                ':' . $arr['rez2'] . ' </a></center></td>';
            echo '</tr>';
            ++$i;

        }
        if ($total > $kmess) {
            echo '<p>' . pagenav('friendly.php?act=my_calendar&amp;', $start, $total, $kmess) .
                '</p>';
            echo '<p><form action="friendly.php?act=my_calendar&amp;" method="post"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        }
        echo '</table>';

                $m = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where `id_team2`= '" . $fid . "';"), 0);
    echo '<div class="phdr">Всего: ' . $total . '</div>';
        echo '<div class="menu"><a href="friendly.php">Предложения мне (' . $m . ')</a></div>';
         $mz = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where  `id_team1`= '" .$fid . "';"), 0);
        echo '<div class="menu"><a href="friendly.php?act=moi&amp;id=' . $fid . '">Мои предложения  (' . $mz . ')</a></div>';

        echo '<div class="menu"><b>Мои тов. игры  </b></div>';
		echo '<div class="menu"><a href="friendly.php?act=calendar&amp;id=' . $fid .'">Все тов. игры</a></div>';
        
        
        
        
        
        
        break;

    case 'clean':
        ////////////////////////////////////////////////////////////
        // Очистка                                       //
        ////////////////////////////////////////////////////////////
        if ($rights >= 7) {
            if (isset($_POST['submit'])) {

                $cl = isset($_POST['cl']) ? intval($_POST['cl']) : '';
                switch ($cl) {
                    case '1':
                        // Чистим сообщения, старше 1 дня
                        $r = mysql_query("SELECT * from `tur_2`  WHERE `chemp`='tov' AND `time` < '" . ($realtime -
                            86400) . "'");
                        while ($arr = mysql_fetch_array($r)) {
                            mysql_query("DELETE FROM `tur_2` WHERE `id`='" . $arr['id'] . "' ; ");
                            mysql_query("DELETE FROM `goal_2` WHERE `tid`='" . $arr['id'] . "' ; ");
                            mysql_query("DELETE FROM `news_2` WHERE `tid`='" . $arr['id'] . "' ; ");
                        }
                        echo '<p>Удалены все матчи, старше 1 дня.</p><p><a href="friendly.php">Вернуться</a></p>';
                        break;

                    case '2':
                        // Проводим полную очистку
                        $r = mysql_query("SELECT * from `tur_2`  WHERE `chemp`='tov'");
                        while ($arr = mysql_fetch_array($r)) {
                            echo $arr[id];
                            mysql_query("DELETE FROM `tur_2` WHERE `id`='" . $arr['id'] . "' ; ");
                            mysql_query("DELETE FROM `goal_2` WHERE `tid`='" . $arr['id'] . "' ; ");
                            mysql_query("DELETE FROM `news_2` WHERE `tid`='" . $arr['id'] . "' ; ");
                        }

                        echo '<p>Удалены все матчи.</p><p><a href="friendly.php">Вернуться</a></p>';
                        break;

                    default:
                        // Чистим сообщения, старше 1 недели
                        $r = mysql_query("SELECT * from `tur_2`  WHERE `chemp`='tov' AND `time` < '" . ($realtime -
                            604800) . "'");
                        while ($arr = mysql_fetch_array($r)) {
                            mysql_query("DELETE FROM `tur_2` WHERE `id`='" . $arr['id'] . "' ; ");
                            mysql_query("DELETE FROM `goal_2` WHERE `tid`='" . $arr['id'] . "' ; ");
                            mysql_query("DELETE FROM `news_2` WHERE `tid`='" . $arr['id'] . "' ; ");
                        }
                        echo '<p>Все матчи, старше 1 недели удалены .</p><p><a href="friendly.php">Вернуться</a></p>';
                }
                mysql_query("OPTIMIZE TABLE  `tur_2`");
            } else {
                echo '<p><b>Очистка сообщений</b></p>';
                echo '<u>Что чистим?</u>';
                echo '<form id="clean" method="post" action="friendly.php?act=clean">';
                echo '<input type="radio" name="cl" value="0" checked="checked" />Старше 1 недели<br />';
                echo '<input type="radio" name="cl" value="1" />Старше 1 дня<br />';
                echo '<input type="radio" name="cl" value="2" />Очищаем все<br />';
                echo '<input type="submit" name="submit" value="Очистить" />';
                echo '</form>';
                echo '<p><a href="friendly.php">Отмена</a></p>';
            }
        }
        break;
    default:
    echo '<div class="gmenu"><b>Заявки на игру</b></div>';
     ////////////////////////////////////////////////////////////
        // Предложения мне                                        //
        //////////////////////////////////////////////////////////
        $a = mysql_query("SELECT * FROM `frend_2` where `id_team2`= '" .
            $fid . "' ;");

        if (!mysql_num_rows($a)) {
            echo '<div class="rmenu">Предложений нет</div> ';
            
                $m = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where `id_team2`= '" . $fid . "';"), 0);
    echo '<div class="phdr">Всего: ' . $m . '</div>';
      
        echo '<div class="menu"><b>Предложения мне (' . $m . ')</b></div>';
         $mz = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where  `id_team1`= '" .$fid . "';"), 0);
        echo '<div class="menu"><a href="friendly.php?act=moi&amp;id=' . $fid . '">Мои предложения  (' . $mz . ')</a></div>';

        echo '<div class="menu"><a href="friendly.php?act=my_calendar&amp;id=' . $fid . '">Мои тов. игры  </a></div>';
		echo '<div class="menu"><a href="friendly.php?act=calendar&amp;id=' . $fid .'">Все тов. игры</a></div>';
       
            
            require_once ("incfiles/end.php");
            exit;
        }
        
        
        //echo '<div class="c">';
echo '
<table border="0" id="example" cellspacing="1" cellpadding="1">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td width="70"><b>Дата</b></td>
<td><b>Команда</b></td>
<td width="180"><b>Действие</b></td>
</tr>';
        
        while ($mne = mysql_fetch_assoc($a)) {
            
         
            echo ($i % 2) ?  '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
            //echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
            
            //echo '<a href="team.php?id=' . $mne['id_team1'] . '"> ' . $mne['name_team1'] . '</a>';
   
   echo '<td align="center">' . date("d.m/H:i", $mne['time']) . '</td>';		
   echo '<td align="center"><a href="team.php?id='.$mne[id_team1].'">' . $mne['name_team1'] . ' </a> [' . $mne['level_team1'] . ']</td>';		
   echo '<td align="center"><a href="friendly.php?act=start&amp;id=' . $mne['id'] . '">Принять</a>
|<a href="friendly.php?act=mneno&amp;id=' . $mne['id'] . '&amp;fid=' . $mne['id_team1'] .'">Отклонить</a></td>';		

			echo '</tr>';            
            ++$i;

        }
        echo '</table>';
        $m = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where `id_team2`= '" . $fid . "';"), 0);
    echo '<div class="phdr">Всего: ' . $m . '</div>';
        echo '<div class="menu">';
        echo '<li><b>Предложения мне (' . $m . ')</b></li>';
         $mz = mysql_result(mysql_query("SELECT COUNT(*) FROM `frend_2` where  `id_team1`= '" .$fid . "';"), 0);
        echo '<li><a href="friendly.php?act=moi&amp;id=' . $fid . '">Мои предложения  (' . $mz . ')</a></li>';
        echo '<li><a href="friendly.php?act=my_calendar&amp;id=' . $fid . '">Мои тов. игры  </a></li>';
//echo '<li><a href="friendly.php?act=calendar&amp;id=' . $fid .'">Все тов. игры</a></li>';
        echo '</div>';
        
/*
        $q = mysql_query("select * from `game_2` where id_team1='" . $fid .
            "' OR id_team2='" . $fid . "';");
        if (mysql_num_rows($q) != 0) {
            echo '<div class="c">';
            while ($art = mysql_fetch_assoc($q)) {
                echo '<div class="c">';
                $q1 = mysql_query("select `name` from `team_2` where id='" . $art['id_team1'] .
                    "' ;");
                $art1 = mysql_fetch_assoc($q1);
                $q2 = mysql_query("select `name` from `team_2` where id='" . $art['id_team2'] .
                    "' ;");
                $art2 = mysql_fetch_assoc($q2);
                echo '<a href="team.php?id=' . $art['id_team1'] . '">' . $art1['name'] .
                    '</a> Vs  <a href="team.php?id=' . $art['id_team2'] . '">' . $art2['name'] .
                    '</a><br/>';
                echo 'Статус: <a href="trans.php?id=' . $art['id'] . '"><b>Идёт</b></a>';
                echo '</div>';
            }
            echo '</div>';
        }*/

        echo '';
        // Для Админов даем ссылку на чистку
        if ($rights >= 7)
            echo '<p><div class="func"><a href="friendly.php?act=clean">Чистка истории</a></div></p>';

        break;
}
require_once ("incfiles/end.php");

?>