<?php
/*
//////////////////////////////////////////////////////////////////////////////////////////////////////
// mod manager by 1_Kl@S Syava Andrusiv                                    //
// Официальный сайт сайт Менеджера: http://megasport.name       //
// СДЕСЬ НИЧЕГО НЕ МЕНЯТЬ!!!!!!!!!!!!!!!                                        //
// Официальный сайт сайт проекта:      http://johncms.com             //
// Дополнительный сайт поддержки:      http://gazenwagen.com      //
/////////////////////////////////////////////////////////////////////////////////////////////////////
// JohnCMS core team:                                                                  //
// Евгений Рябинин aka john77          john77@johncms.com            //
// Олег Касьянов aka AlkatraZ          alkatraz@johncms.com           //
//                                                                                                  //
// Информацию о версиях смотрите в прилагаемом файле version.txt//
//////////////////////////////////////////////////////////////////////////////////////////////////////
*/

define('_IN_JOHNCMS', 1);
$headmod = 'manager2';
$textl = 'Изменить название';
$rootpath = '../';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");
require_once ('../incfiles/class_upload.php');

// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="../login.php">авторизованным</a> посетителям';
if ($error) {
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
	require_once ("../incfiles/end.php");
    exit;
}



if ($set_m[fed]==0){
    echo '<div class="rmenu"><p>Закрыто!</p></div>';
    echo '<a href="index.php">В менеджер</a>';
    require_once ("../incfiles/end.php");
    exit;
}





echo '<div class="phdr2"><b>Изменить название</b></div>';
$id = $datauser[manager2];
$q = mysql_query("select * from `team_2` where `id`='$id' LIMIT 1;");
$krr = mysql_fetch_array($q);        


if ($krr['butcer']<5){
    echo '<div class="rmenu"><p>У вас не достаточно средств!</p></div>';
    echo '<a href="index.php">В менеджер</a>';
    require_once ("../incfiles/end.php");
    exit;
}




        
if ($krr['id_admin'] == $user_id || $rights > 7) {

if (isset ($_POST['submit'])) {

$name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (!$name){
    echo '<div class="rmenu"><p>Ошибка!</p></div>';
    echo '<a href="index.php">В менеджер</a>';
    require_once ("../incfiles/end.php");
    exit;
}


$num = 5;

mysql_query("UPDATE `team_2` SET `strana` = '$name', `butcer`=`butcer`-'$num' WHERE `id` = '$id';");

//mysql_query("UPDATE `team_2` SET `name` = '$name' WHERE `id` = '$id';");                    
                    
echo '<div class="gmenu"><p style="text-align:center;">Федерация команды изменена<br/>
                         <a href="../team.php?id=' . $datauser[manager2] . '">Продолжить</a></p></div>';

                        echo '<div class="phdr"><a href="../index.php">Вернуться</a></div>';
          
        } else {
        //echo "$id";    
           echo '<form action="country.php" method="post">';
           
         echo '<b>Выберите федерацию:</b><br/>';
        $matile = mysql_query('SELECT * from `team_2` GROUP BY `strana`;');
                echo '<select name="name">';
                while ($mat = mysql_fetch_array($matile)) {
                
                    echo '<option value="' . $mat['strana'] . '" >';
                    echo '' . $mat['divizion'] . '</option>';
                }
       echo '</select>';
           
           
           //echo '<b>Имя команды:</b><br/><input type="text" name="name" maxlength="30" value="'.$krr[name].'" />';


echo '<div class="bmenu"><input type="submit" name="submit" value="Сохранить"/></div></form>';

        
            
        }
        }
        else
        {
        header("location: ../index.php");
        }

        
echo '<a href="../team.php?id=' . $datauser[manager2] . '">Вернуться</a>';

require_once ("../incfiles/end.php");
?>