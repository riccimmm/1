<?php
define('_IN_JOHNCMS', 1);

$textl = 'Логотип союза';
require_once ('../incfiles/core.php');
require_once ('../incfiles/head.php');
require_once ('../incfiles/class_upload.php');

if (!$user_id) {
    display_error('Только для зарегистрированных посетителей');
    require_once ('../incfiles/end.php');
    exit;
}

if ($id) {
    $req = mysql_query("SELECT * FROM `union` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $team = mysql_fetch_assoc($req);
        if ($team['id_prez'] != $user_id) {
            echo display_error('Вы не можете выгружать Логотип для чужой команды!');
            require_once ('../incfiles/end.php');
            exit;
        }
    }
    else {
        echo display_error('Такой команды не существует!');
        require_once ('../incfiles/end.php');
        exit;
    }
}
else {
        echo display_error('Не указана команда!');
        require_once ('../incfiles/end.php');
        exit; 
}

switch ($act) {
    case 'up_logo' :
        echo '<div class="bmenu"><b>Выгружаем Логотип</b></div>';
        if (isset ($_POST['submit'])) {
            $handle = new upload($_FILES['imagefile']);
            if ($handle->uploaded) {
                // Обрабатываем лого
                $handle->file_new_name_body = 'big' . $id;
                //$handle->mime_check = false;
                $handle->allowed = array('image/jpeg', 'image/gif', 'image/png');
                $handle->file_max_size = 1024 * $flsz;
                $handle->file_overwrite = true;
                $handle->image_resize = true;
                $handle->image_x = 100;
                $handle->image_y = 100;
                $handle->image_convert = 'jpeg';
                $handle->process('../union/logo/');
                if ($handle->processed) {
                      $handle->file_new_name_body = 'small' . $id;
                      //$handle->mime_check = false;
                      $handle->allowed = array('image/jpeg', 'image/gif', 'image/png');
                      $handle->file_max_size = 1024 * $flsz;
                      $handle->file_overwrite = true;
                      $handle->image_resize = true;
                      $handle->image_x = 18;
                      $handle->image_y = 18;
                      $handle->image_convert = 'jpeg';
                      $handle->process('../union/logo/');
                     mysql_query("UPDATE `union` SET `unionlogo` = '" . $id . ".jpeg' WHERE `id` = '$id';");
                    echo '<div class="gmenu"><p>Логотип загружен!<br /><a href="index.php?id=' . $id . '">Продолжить</a></p></div>';
                    echo '<div class="phdr"><a href="index.php?id=' . $id . '">В союз</a></div>';
                }
                else {
                    echo display_error($handle->error);
                }
                $handle->clean();
            }
        }
        else {
            echo '<form enctype="multipart/form-data" method="post" action="logo.php?act=up_logo&amp;id=' . $id . '"><div class="menu"><p>';
            echo 'Выберите изображение:<br /><input type="file" name="imagefile" value="" />';
            echo '<input type="hidden" name="MAX_FILE_SIZE" value="' . (1024 * $flsz) . '" />';
            echo '</p><p><input type="submit" name="submit" value="Выгрузить" />';
            echo '</p></div></form>';
            echo '<div class="phdr"><small>Для выгрузки разрешены файлы JPG, JPEG, PNG, GIF<br />Размер файла не должен превышать ' . $flsz . ' кб.<br />';
            echo 'Вне зависимости от разрешения исходного файла, он будет преобразован в размеры 100х100 и 15х15<br />';
            echo 'Новое изображение заменит старое (если оно было)';
            echo 'Для лучшего результата, исходное изображение должно иметь равное соотношение сторон</small></div>';
        }
        break;

    
}

require_once ('../incfiles/end.php');

?>