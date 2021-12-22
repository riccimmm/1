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
        echo '<div class="phdr2"><b>Выберите лого для команды</b></div>';
        
$q = mysql_query("select * from `team_2` where `id`='" . $datauser[manager2] . "' LIMIT 1;");
$krr = mysql_fetch_array($q);        

$id = $datauser[manager2];
        
if ($krr['id_admin'] == $user_id || $rights > 7) {
if (isset ($_POST['submit'])) {
            $handle = new upload($_FILES['image']);
            if ($handle->uploaded) {
                // Обрабатываем крупную картинку
                $handle->file_new_name_body = 'big'.$id ;
                $handle->allowed = array('image/jpeg', 'image/gif', 'image/png');
                $handle->file_max_size = 1024 * $flsz;
                $handle->file_overwrite = true;
                $handle->image_resize = true;
                $handle->image_x = 130;
                $handle->image_y = 130;
                $handle->image_convert = 'jpg';
                $handle->process('../logo/');
                if ($handle->processed) {
                    // Обрабатываем мелкую картинку
                    $handle->file_new_name_body = 'small'.$id  ;
                    $handle->file_overwrite = true;
                    $handle->image_resize = true;
                    $handle->image_x = 15;
                    $handle->image_y = 15;
                    $handle->image_convert = 'jpg';
                    $handle->process('../logo/');
                    if ($handle->processed) {
                        mysql_query("UPDATE `team_2` SET `logo` = '$id.jpg' WHERE `id` = '$id';");
                        echo '<div class="gmenu"><p style="text-align:center;">
                        <img src="../logo/small' . $id . '.jpg" alt="" /><br />
                        <img src="../logo/big' . $id . '.jpg" alt="" /><br />Логотип загружен<br /><a href="../team.php?id=' . $datauser[manager2] . '">Продолжить</a></p></div>';
                        echo '<div class="phdr"><a href="../index.php">Вернуться</a></div>';
                    } else {
                        echo display_error($handle->error);
                    }
                } else {
                    echo display_error($handle->error);
                }
                $handle->clean();
            }
        } else {
            echo '<form enctype="multipart/form-data" method="post" action="logo.php"><div class="menu"><p>';
            echo 'Выберите изображение:<br /><input type="file" name="image" value="" />';
            echo '<input type="hidden" name="MAX_FILE_SIZE" value="' . (1024 * $flsz) . '" />';
            echo '</p><p><input type="submit" name="submit" value="Выгрузить" />';
            echo '</p></div></form>';
            echo '<div class="gmenu"><small>Для выгрузки разрешены файлы JPG, JPEG, PNG, GIF<br />Размер файла не должен превышать ' . $flsz . 'кб.<br />';
            echo 'Вне зависимости от разрешения исходного файла, он будет преобразован в размеры 130x130 и 20x25<br />';
            echo 'Новое изображение заменит старое (если оно было)</small></div>';
            }
        }
        else
        {
        header("location: ../index.php");
        }

        


require_once ("../incfiles/end.php");
?>