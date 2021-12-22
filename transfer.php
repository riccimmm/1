<?php

define('_IN_JOHNCMS', 1);

$textl = 'Трансферный рынок';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
require_once ("incfiles/manager_func.php");
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

if (!empty($manag)) {


        switch ($act) {

            default:
                echo '<div class="phdr"><b>Трансферный рынок</b></div>';
                $do = array("Вр", "ЛЗ", "ЦЗ", "ПЗ", "ЛП", "ЦП", "ПП", "ЛФ", "ЦФ", "ПФ");
                $do_name = array('Gk' => 'Вр', 'Ld' => 'ЛЗ', 'Cd' => 'ЦЗ', 'Rd' => 'ПЗ', 'Lw' =>
                    'ЛП', 'Am' => 'ЦП', 'Rw' => 'ПП', 'Lf' => 'ЛФ', 'Cf' => 'ЦФ', 'Rf' => 'ПФ');
                echo '<div class="c"><p>Амплуа: 
<a href="transfer.php?poz=Gk">ВР</a> | 
<a href="transfer.php?poz=Ld">ЛЗ</a> | 
<a href="transfer.php?poz=Cd">ЦЗ</a> | 
<a href="transfer.php?poz=Rd">ПЗ</a> | 
<a href="transfer.php?poz=Lw">ЛП</a> | 
<a href="transfer.php?poz=Am">ЦП</a> | 
<a href="transfer.php?poz=Rw">ПП</a> | 
<a href="transfer.php?poz=Lf">ЛФ</a> | 
<a href="transfer.php?poz=Cf">ЦФ</a> | 
<a href="transfer.php?poz=Rf">ПФ</a> | 
<a href="transfer.php">Все</a> 
</p></div>';

                if (!empty($_GET['poz'])) {


                    $req = mysql_query("SELECT COUNT(*) FROM `player_2` where t_money != '0' AND poz = '" .$do_name[$_GET['poz']] . "'");
                    $total = mysql_result($req, 0);

                    $req = mysql_query("SELECT * FROM `player_2` where t_money != '0' AND poz = '" . $do_name[$_GET['poz']] . "' order by t_time desc LIMIT " . $start . ", 10;");

                    echo '<div class="c">';
                    echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">';
                    echo '
<tr bgcolor="40B832" align="center" class="whiteheader">
<td><b>Игрок</b></td>
<td><b>Гр</b></td>
<td><b>Поз</b></td>
<td><b>Воз</b></td>
<td><b>Тал</b></td>
<td><b>Мас</b></td>
<td><b>Цена</b></td>
</tr>';


                    while ($arr = mysql_fetch_array($req)) {

                        echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                            '<tr bgcolor="f3f3f3">';

                        echo '<td><a href="player.php?id=' . $arr[id] . '">' . $arr[name] . '</a>';


                        // if ($arr[team] != $datauser[manager2])
                        // {
                        echo ' <a href="transfer.php?act=buy&amp;id=' . $arr[id] .
                            '"><img src="img/buy.gif" alt=""/></a>';
                        // }
$mast = $arr[otbor] + $arr[opeka] + $arr[drib] + $arr[priem] + $arr[vonos] + $arr[pas] +
            $arr[sila] + $arr[tocnost];
                        echo '</td>';

                        echo '
<td align="center"><img src="flag/' . $arr[strana] . '.png" alt=""/></td>
<td align="center">' . $arr[poz] . '</td>
<td align="center">' . $arr[voz] . '</td>
<td align="center">' . $arr[tal] . '</td>
<td align="center">' . $mast. '</td>
<td align="center"><font color="green"><b>' . $arr[t_money] .
                            ' €</b></font></td>
';

                        echo '</tr>';

                        ++$i;
                    }
                    echo '</table>';
                    echo '</div>';


                    echo '<div class="phdr"><p>Всего: ' . $total . '';
                    if ($total > 30) {
                        echo '<div style="float: right;">' . pagenav('transfer.php?poz=' . $act .
                            '&amp;', $start, $total, 30) . '</div>';
                    }
                    echo '</p></div>';

                    require_once ("incfiles/end.php");
                    exit;
                }

                // ТРАНСФЕРЫ
                $req = mysql_query("SELECT COUNT(*) FROM `player_2` where t_money != '0'");
                $total = mysql_result($req, 0);

                $req = mysql_query("SELECT * FROM `player_2` where t_money != '0' order by t_time desc LIMIT " .
                    $start . ", 30;");

                echo '<div class="c">';
                echo '<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">';
                echo '
<tr bgcolor="40B832" align="center" class="whiteheader">
<td><b>Игрок</b></td>
<td><b>Гр</b></td>
<td><b>Поз</b></td>
<td><b>Воз</b></td>
<td><b>Тал</b></td>
<td><b>Мас</b></td>
<td><b>Цена</b></td>
</tr>';


                while ($arr = mysql_fetch_array($req)) {

                    echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' :
                        '<tr bgcolor="f3f3f3">';

                    echo '<td><a href="player.php?id=' . $arr[id] . '">' . $arr[name] . '</a>';


                    // if ($arr[team] != $datauser[manager2])
                    // {
                    echo ' <a href="transfer.php?act=buy&amp;id=' . $arr[id] .
                        '"><img src="img/buy.gif" alt=""/></a>';
                    // }

                    echo '</td>';
$mast = $arr[otbor] + $arr[opeka] + $arr[drib] + $arr[priem] + $arr[vonos] + $arr[pas] +
            $arr[sila] + $arr[tocnost];
                    echo '
<td align="center"><img src="flag/' . $arr[strana] . '.png" alt=""/></td>
<td align="center">' . $arr[poz] . '</td>
<td align="center">' . $arr[voz] . '</td>
<td align="center">' . $arr[tal] . '</td>
<td align="center">' . $mast . '</td>
<td align="center"><font color="green"><b>' . $arr[t_money] .
                        ' €</b></font></td>
';

                    echo '</tr>';

                    ++$i;
                }
                echo '</table>';
                echo '</div>';


                echo '<div class="phdr"><p>Всего: ' . $total . '';
                if ($total > 30) {
                    echo '<div style="float: right;">' . pagenav('transfer.php?', $start, $total, 30) .
                        '</div>';
                }
                echo '</p></div>';

                echo '<div class="list2"><a href="transfer.php?act=history&amp;type=buy">История переходов</a></div>';
                break;
      
            
            
             case 'buy':
                $q = mysql_query("select * from `player_2` where id='" . $id . "' LIMIT 1;");
                $arr = mysql_fetch_array($q);

                if (empty($arr[id])) {
                    echo display_error('Игрока не существует');
                    require_once ("incfiles/end.php");
                    exit;
                }

                if ($arr['t_money'] == 0) {
                    echo display_error('Игрок не на трансфере');
                    require_once ("incfiles/end.php");
                    exit;
                }


                if (isset($_GET['yes'])) {

                    if ($arr[kom] == $datauser[manager2]) {
                        echo display_error('Вы не можете купить своего игрока');
                        require_once ("incfiles/end.php");
                        exit;
                    }

                    // Считаем игроков
                    $req = mysql_query("SELECT * FROM `player_2` where `kom`='" . $datauser['manager2'] .
                        "';");
                    $total = mysql_num_rows($req);

                    // Покупатель
                    $k1 = mysql_query("select * from `team_2` where id='" . $datauser['manager2'] .
                        "' LIMIT 1;");
                    $kom1 = mysql_fetch_array($k1);

                    // Продавец
                    $k2 = mysql_query("select * from `team_2` where id='" . $arr['kom'] .
                        "' LIMIT 1;");
                    $kom2 = mysql_fetch_array($k2);


                    /* if ($kom1[baza] == 1) {
                    $mest = 23;
                    } else {
                    $mest = 20;
                    }

                    if ($total >= $mest) {
                    echo display_error('Ваш клуб может позволить себе только ' . $mest . ' игроков');
                    require_once ("incfiles/end.php");
                    exit;
                    }*/


                    if ($arr[t_money] > $kom1[money]) {
                        echo display_error('У вас недостаточно денег');
                        require_once ("incfiles/end.php");
                        exit;
                    }

                    $moneykom1 = $kom1[money] - $arr[t_money];
                    $moneykom2 = $kom2[money] + $arr[t_money];

                    mysql_query("update `team_2` set `money`='" . $moneykom1 . "' where id = '" . $kom1[id] .
                        "' LIMIT 1;");
                    mysql_query("update `team_2` set `money`='" . $moneykom2 . "' where id = '" . $kom2[id] .
                        "' LIMIT 1;");


                    // Редачим игрока
                    mysql_query("update `player_2` set `t_time`= '', `t_money`= '', `kom`='" . $datauser['manager2'] .
                        "', `sostav`='0' where id='" . $arr[id] . "' LIMIT 1;");
                    //Пишем в историю
                    $text = 'Игрок <a href="player.php?id=' . $arr['id'] . '">' . $arr['name'] .
                        '</a> перешол в  <a href="team.php?id=' . $kom1['id'] . '">' . $kom1['name'] .
                        '</a>  из <a href="team.php?id=' . $kom2['id'] . '">' . $kom2['name'] . '</a>';


        // Отправляем письмо
        mysql_query("INSERT INTO `privat` SET
		`user`='" . $kom2['name_admin'] . "',
		`text`='Здравствуйте " . $kom2['name_admin'] . "\r\n\r\nМы подписали вашего игрока " .
                    $arr['name'] . "\r\nСумма сделки составила " . $arr['t_money'] . " €\r\n\r\nМенеджер клуба " .
                    $kom1['name'] . "\r\n" . $kom1['name_admin'] . "',
		`time`='" . $realtime . "',
		`author`='" . $kom['name_admin'] . "',
		`type`='in',
		`chit`='no',
		`temka`='Трансферы',
		`otvet`='0'	;");





                    header('location: team.php?id=' . $datauser[manager2] . '"');
                } else {
                    echo '<div class="gmenu"><b>Трансфер</b></div>';
                    echo '<div class="c">';
                    echo 'Игрок: <b>' . $arr[name] . '</b><br/>';
                    echo 'Цена: <b>' . $arr[t_money] . ' €</b><br/><br/>';

                    echo '<a href="transfer.php?act=buy&amp;id=' . $arr[id] .
                        '&amp;yes" class="redbutton"><b>Купить игрока</b></a><br/><br/>';
                    echo '</div>';
                }

                break;

            case 'money':
                /*$qs = mysql_query("select * from `player_2` where player_id='" . $id . "';");
                $colm_team = mysql_num_rows($qs);
                if ($colm_team != 0) {
                    echo display_error('Игрок уже  на трансфере');
                    require_once ("incfiles/end.php");
                    exit;
                }*/

                if ($lvl < 1) {
                    echo display_error('Трансферный рынок доступен с 1-го уровня');
                    require_once ("incfiles/end.php");
                    exit;
                }

                $totalp = mysql_result(mysql_query("SELECT COUNT(*) FROM `player_2` where kom='" .
                    $datauser[manager2] . "'"), 0);
                if ($totalp < 15) {
                    echo display_error('В команде должно оставаться минимум 15 игроков');
                    require_once ("incfiles/end.php");
                    exit;
                }

                // Считаем игроков на трансфере
                $req = mysql_query("SELECT * FROM `player_2` where `kom`='" . $datauser['manager2'] .
                    "' AND `t_money`!='0';");
                $total = mysql_num_rows($req);

                if ($total >= 3) {
                    echo display_error('Вы не можете выставить на трансфер более 3 игроков');
                    require_once ("incfiles/end.php");
                    exit;
                }
                //$ass = mysql_fetch_array($qs);

                $q = mysql_query("select * from `player_2` where id='" . $id . "';");
                $info = mysql_fetch_array($q);

                if ($info['kom'] != $datauser['manager2']) {
                    echo display_error('Трансфер не возможен');
                    require_once ("incfiles/end.php");
                    exit;
                }

$mast = $info[otbor] + $info[opeka] + $info[drib] + $info[priem] + $info[vonos] + $info[pas] +
            $info[sila] + $info[tocnost];

                $nom = $mast * 10 * $info['tal'];
                $nominal = nominal($info['voz'], $nom);

                $min = intval($nominal * 0.75);
                $max = intval($nominal * 1.25);

//$min = '7000';
//$max = '20000';
                if (isset($_POST['submit'])) {
                    $money = intval($_POST['money']);


                    if ($money >= $min && $money <= $max) {
                        mysql_query("update `player_2` set `t_time`='" . $realtime . "', `t_money`='" .
                            $money . "' where id='" . $id . "' LIMIT 1;");
                    } else {
                        echo display_error('Цена должна быть Min. <b>' . $min . ' €</b> Max. <b>' . $max .
                            ' €</b>');
                        require_once ("incfiles/end.php");
                        exit;
                    }


                    header('location: transfer.php');
                } else {
                    echo '<div class="gmenu"><b>' . $info['name'] . '</b></div>';
                    echo '<div class="c">
Номинал: <b>' . $nominal . ' €</b><br/>
Минимальная: <b>' . $min . ' €</b><br/>
Максимальная: <b>' . $max . ' €</b>
</div>';
                    echo '<div class="c">';
                    echo '<form action="transfer.php?act=money&amp;id=' . $id . '" method="post">';
                    echo '<input type="text" size="5" name="money" value="' . $nominal . '"/> ';
                    echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/></form>";
                    echo '</div>';
                }
                break;

            case 'pred':
                echo '<div class="c">';
                echo '<a href="transfer.php?act=me">Мои предложения</a><br/>';
                echo '<a href="transfer.php?act=mne">Предложения мне</a>';
                echo '</div>';
                break;

            case 'me':
                echo '<div class="menu"><center>Мои предложения</center></div>';
                echo '<div class="c">';
                echo '
<table id="example">
<tr  align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Дата</b></td>
<td><b>Игрок</b></td>
<td><b>Цена</b></td>
<td><b>Действие</b></td>
</tr>';
                $req = mysql_query("SELECT * FROM `buy_2` where `id_team2`='" . $fid .
                    "' order by time desc ;");
                $mesto = 1;
                while ($arr = mysql_fetch_array($req)) {
                    echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr class="oddrows">' :
                        '<tr class="evenrows">';
                    echo '
<td width="5%" align="center">' . $mesto . '</td>
<td><center>' . date("d.m.y / H:i", $arr['time']) . '</center></td>
<td><a href="player.php?id=' . $arr['id'] . '">' . $arr['player_name'] .
                        '</a></td>
<td width="5%" align="center">' . $arr['money'] . '</td>
<td width="10%" align="center"><a href="transfer.php?act=no&amp;id=' . $arr['id'] .
                        '">Отменить</a></td>
';
                    echo '</tr>';
                    ++$mesto;
                    ++$i;
                }
                echo '</table><br/></div>';
                break;

            case 'mne':
                echo '<div class="menu"><center>Предложения мне</center></div>';
                echo '<div class="c">';
                echo '
<table id="example">
<tr  align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Дата</b></td>
<td><b>Игрок</b></td>
<td><b>Цена</b></td>
<td><b>Действие</b></td>
</tr>';
                $req = mysql_query("SELECT * FROM `buy_2` where `id_team1`='" . $fid .
                    "' order by time desc ;");
                $mesto = 1;
                while ($arr = mysql_fetch_array($req)) {
                    echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr class="oddrows">' :
                        '<tr class="evenrows">';
                    echo '
<td width="5%" align="center">' . $mesto . '</td>
<td><center>' . date("d.m.y / H:i", $arr['time']) . '</center></td>
<td><a href="player.php?id=' . $arr['player_id'] . '">' . $arr['player_name'] .
                        '</a></td>
<td width="5%" align="center">' . $arr['money'] . '</td>
<td width="10%" align="center"><a href="transfer.php?act=yes&amp;id=' . $arr['id'] .
                        '">Принять</a><hr/><a href="transfer.php?act=no&amp;id=' . $arr['id'] .
                        '">Отменить</a></td>
';
                    echo '</tr>';
                    ++$mesto;
                    ++$i;
                }
                echo '</table><br/></div>';
                break;

            case 'no':

                if (isset($_GET['yes'])) {

                    mysql_query("DELETE FROM `buy_2`  WHERE `id` = '" . $id . "' LIMIT 1");

                    header("Location: index.php");
                } else {
                    require_once ("incfiles/head.php");
                    echo '<p>Вы действительно хотите отменить предложение?<br/><a href="transfer.php?act=no&amp;yes&amp;id=' .
                        $id . '">Да</a> | <a href="index.php">Нет</a></p>';
                    require_once ("incfiles/end.php");
                    exit;
                }
                break;

            case 'yes':
                $req = mysql_query("SELECT * FROM `buy_2` where `id`='" . $id . "'  ;");
                $arr = mysql_fetch_array($req);
                if ($arr['id_team1'] != $fid) {
                    echo 'Error';
                    require_once ("incfiles/end.php");
                    exit;
                }
                if (isset($_GET['yes'])) {

                    mysql_query("DELETE FROM `buy_2`  WHERE `id` = '" . $id . "' LIMIT 1");
                    mysql_query("insert into `trans_2` set `id_team1`='" . $arr['id_team2'] .
                        "', `id_team2`='" . $fid . "', `name`='" . $arr['player_name'] . "', `money`='" .
                        $arr['money'] . "',`time`='" . $realtime . "', `id_us`='" . $arr['player_id'] .
                        "' ;");
                    mysql_query("update `team_2` set `money`=money-" . $arr['money'] .
                        "  WHERE `id` = '" . $arr['id_team2'] . "' LIMIT 1");
                    mysql_query("update `team_2` set `money`=money+" . $arr['money'] .
                        "  WHERE `id` = '" . $arr['id_team1'] . "' LIMIT 1");
                    header("Location: index.php");
                } else {
                    require_once ("incfiles/head.php");
                    echo '<p>Вы действительно хотите принять предложение?<br/><a href="transfer.php?act=no&amp;yes&amp;id=' .
                        $id . '">Да</a> | <a href="index.php">Нет</a></p>';
                    require_once ("incfiles/end.php");
                    exit;
                }
                break;

            case 'history':
                echo '<div class="gmenu"><b>История трасферных переходов</b></div>';
                $req = mysql_query("SELECT COUNT(*) FROM `history_2` where type='buy'");
                $total = mysql_result($req, 0);
                $type = $_GET['type'];
                        if ($type == "") {
            echo display_error('Не правильный запрос');
            require_once ("incfiles/end.php");
            exit;
        }
                
                $req = mysql_query("SELECT * FROM `history_2` where type='".$type."' ORDER BY `time` DESC LIMIT $start, $kmess");

                while ($arr = mysql_fetch_array($req)) {
                    echo ($i % 2) ? '<div class="gmenu">' : '<div class="gmenu">';
                    echo '' . date("d.m / H:i", $arr['time']) . ' ' . $arr['text'] . '<br/>';
                    ++$i;
                    echo '</div>';
                }
                if ($total > $kmess) {
                    echo '<p>' . pagenav('transfer.php?act=history&amp;', $start, $total, $kmess) .
                        '</p>';
                    echo '<p><form action="transfer.php?act=history&amp;" method="post"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
                }
                break;
        }



} else {
    echo 'Игра доступна только зарегистрированым пользователям';
}
echo '<div class="c">


<br /><a href="http://m.futmen.net/team.php?id=' . $kom['id'] .'" class="button">Вернуться</a></div>';
require_once ("incfiles/end.php");
?>