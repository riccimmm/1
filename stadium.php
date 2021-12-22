<?php

define('_IN_JOHNCMS', 1);

$textl = 'Стадион';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
//require_once ("incfiles/manag2.php");
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

$q = @mysql_query("select * from `team_2` where id='" . $id . "';");
$kom = @mysql_fetch_array($q);
$total = mysql_num_rows($q);


if (mysql_num_rows($q) == 0) {
    echo "Команды не существует<br/>";
    require_once ("incfiles/end.php");
    exit;
}
$stadium = floor($kom['mest'] / 10000);
if($stadium == 0){
$stadium = 1;
}
$mestomoney = $stadium * 10;

// Add Вместимость
if ($act == "add" && $user_id)
{

if ($datauser[manager2] != $kom[id])
{
header('Location: stadium.php?id=' . $id);
exit;
}

$mest = intval($_POST['mest']);
if($mest < 0 || $mest > 1000)
	$mest = 0;

$money = $mest*$mestomoney;

if ($mest == 0)
{
header('Location: stadium.php?id=' . $id);
exit;
}

if ($money > $kom[money])
{
echo '<div class="c">Недостаточно денег</div>';
require_once ("incfiles/end.php");
exit;
}

$deneg = $kom[money] - $money;
$vmestimost = $kom[mest] + $mest;

mysql_query("update `team_2` set `money`='" . $deneg . "', `mest`='" . $vmestimost . "' where id='" . $kom[id] . "';");
header('Location: stadium.php?id=' . $id);
exit;
}

switch ($act) {

    default:


        if ($datauser[manager2] == $kom[id] || $rights == 9)
            echo '<div class="gmenu"><center><b>' . $kom['name_stadium'] .
                ' </b> [<a href="stadium.php?act=rename&amp;id=' . $id .
                '">Переим.</a>]</center></div>';


        echo '<div class="c">';

        echo '<center>Вместимость: <b>' . $kom[mest] . '</b></center>';
        echo '<center>Фанаты: <b>' . $kom[fan] . '</b></center>';

        echo '<hr/><center><img src="stadium/' . $stadium . '.jpg" alt=""/></center>';

        echo '</div>';
if ($datauser[manager2] == $kom[id])
{
echo '<div class="gmenu"><b>Увеличить вместимость</b></div>';
echo '<div class="c">';
echo '<form action="stadium.php?act=add&amp;id='.$id.'" method="post">';

echo '<select name="mest">';
echo '<option value="5">На 5 мест</option>';
echo '<option value="10">На 10 мест</option>';
echo '<option value="25">На 25 мест</option>';
echo '<option value="50">На 50 мест</option>';
echo '<option value="100">На 100 мест</option>';
echo '<option value="1000">На 1000 мест</option>';
echo '</select>';

//echo '<input type="text" name="mest" value="0"/><br/>';

echo " <input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/></form><br/>";
echo '<b>1</b> место = <b>'.$mestomoney.' €</b>';
echo '</div>';
}

        break;



    case 'rename':
        echo '<form action="stadium.php?act=gorename&amp;id=' . $id . '" method="post">';
        echo '<div class="gmenu">';
        echo '<table cellpadding="2" cellspacing="0"><tr>';
        echo '<td><b>Новое название стадиона:</b></td><td><input type="text" name="name"  maxlength="25"/></td></tr><tr>';

        echo '<br/><small>Цена смены имени 10000.</small><br/>';

        echo '</tr>';
        echo '</table>';
        echo '<p><input type="submit" name="submit" value="Редактировать" /></p></div></form>';
        break;


    case 'gorename':

        if ($datauser[manager2] != $kom[id]) {
            header('Location: stadium.php?id=' . $id);
            exit;
        }

        $_POST['name'] = ereg_replace("/[^1-9a-z\-\@\*\(\)\?\!\~\_\=\[\]]+/", "", $_POST['name']);
        $_POST['name'] = str_replace("\\", "", $_POST['name']);
        if (isset($_POST['name']) && !empty($_POST['name']) && strlen($_POST['name']) >3 && $kom['money'] >= '10000') {

            mysql_query("update `team_2` set `money`=money-10000, 
`name_stadium`='" . mysql_real_escape_string(mb_substr(trim($_POST['name']), 0,
                25)) . "' where `id`='" . $kom['id'] . "';");

            header("location: stadium.php?id=$id");

        } else {
            echo '<div class="rmenu">Ошибка: не введено новое название стадиона или оно слишком короткое, либо нет денег<br/>
            [<a href="stadium.php?id='.$id.'">Назад</a>]<br/></div>';
        }
        break;
}


echo '<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");

?>
