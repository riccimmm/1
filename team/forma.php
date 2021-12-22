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
$headmod = 'manager2';
$textl = 'Выбор формы';
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

//	header("Content-type:text/html; charset=UTF-8");
        echo '<div class="phdr2"><b>Выберите форму для команды</b></div>';
        
$q = mysql_query("select * from `team_2` where `id`='" . $datauser[manager2] . "' LIMIT 1;");
$krr = mysql_fetch_array($q);        

$id = $datauser[manager2];
        
if ($krr['id_admin'] == $user_id || $rights > 7) {
if (isset ($_GET['type'])) {
$type = isset($_GET['type']) ? trim($_GET['type']) : '';





if (file_exists('../forma/' . $type)) {
                        mysql_query("UPDATE `team_2` SET `forma` = '$type' WHERE `id` = '$id';");
                        
                        echo '<div class="gmenu"><p style="text-align:center;">Форма выбрана<br/>
                         <img src="../forma/'.$type.'" alt="" /><br /><a href="../team.php?id=' . $datauser[manager2] . '">Продолжить</a></p></div>';
                        }else
                        {
                          echo '<div class="rmenu"><p style="text-align:center;">Ошибка! Не верный выбор.
                         <br /><a href="forma.php">Повторить</a></p></div>';
                        }
                        //echo '<div class="phdr"><a href="../index.php">Вернуться</a></div>';
          
        } else {
        
        $kmess = 49;
        $array = glob($rootpath . 'forma/*.jpg');
        $total = count($array);
        if ($total > 0) {
            echo '<div class="list1">';
            for ($i = 0; $i < 49; $i++) {
                $smile = preg_replace('#^' . $rootpath . 'manag/forma/(.*?)$#isU', '$1', $array [$i], 1);
                echo is_integer($i / 2) ? '' : '';
                
                //echo '&nbsp;<img src="' . $array [$i] . '" alt="" /> ';
                
                   echo '<a href="forma.php?type='.$smile.'"><img src="thumb.php?file=' . (urlencode($smile)) . '" alt="" /></a>';
                
                }
                echo '</div>';
                echo '<div class="phdr">Всего: '.$total.'</div>';
        }
            
        }
        }
        else
        {
        header("location: ../index.php");
        }

        
echo '<a href="../team.php?id=' . $datauser[manager2] . '">Вернуться</a>';

require_once ("../incfiles/end.php");
?>