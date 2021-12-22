<?php
/*
//////////////////////////////////////////////////////////////////////////////////////////////////////
// mod manager by 1_Kl@S Syava Andrusiv                                    //
// Официальный сайт сайт Менеджера: http://megasport.name       //
// СДЕСЬ НИЧЕГО НЕ МЕНЯТЬ!!!!!!!!!!!!!!!                                        //
/////////////////////////////////////////////////////////////////////////////////////////////////////
// JohnCMS core team:                                                                  //
// Евгений Рябинин aka john77          john77@johncms.com            //
// Олег Касьянов aka AlkatraZ          alkatraz@johncms.com           //
//                                                                                                  //
// Информацию о версиях смотрите в прилагаемом файле version.txt//
//////////////////////////////////////////////////////////////////////////////////////////////////////
*/

define('_IN_JOHNCMS', 1);
$headmod = 'liga';
$textl = 'Лига Чемпионов';
$rootpath = '../';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");
require_once ("../incfiles/manag2.php");
// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="../login.php">авторизованным</a> посетителям';
if ($error)
{
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
    require_once ("../incfiles/end.php");
    exit;
}

if (mysql_num_rows($manager) == 0)
{
    echo "Команды не существует</div>";
    require_once ("../incfiles/end.php");
    exit;
}

echo '<div class="gmenu"><b>Лига чемпионов</b></div>';

echo '<div class="c"><p align="center"><img src="../chemp/b_liga.jpg" alt=""/></p></div>';


echo '<div class="gmenu"><b>Плей-офф</b></div>';
echo '<div class="menu"><a href="11.php">Финал</a></div>';
echo '<div class="menu"><a href="12.php">1/2 финала</a></div>';
echo '<div class="menu"><a href="14.php">1/4 финала</a></div>';
echo '<div class="menu"><a href="18.php">1/8 финала</a></div>';

echo '<div class="gmenu"><b>Групповой этап</b></div>';
echo '<div class="menu"><a href="group.php?id=1">Группа A</a></div>';
echo '<div class="menu"><a href="group.php?id=2">Группа B</a></div>';
echo '<div class="menu"><a href="group.php?id=3">Группа C</a></div>';
echo '<div class="menu"><a href="group.php?id=4">Группа D</a></div>';
echo '<div class="menu"><a href="group.php?id=5">Группа E</a></div>';
echo '<div class="menu"><a href="group.php?id=6">Группа F</a></div>';
echo '<div class="menu"><a href="group.php?id=7">Группа G</a></div>';
echo '<div class="menu"><a href="group.php?id=8">Группа H</a></div>';

echo'<a href="../index.php">Вернуться</a><br/>';
require_once ("../incfiles/end.php");
?>