<?php

defined('_IN_JOHNCMS') or die('Error: restricted access');

require_once ("../../incfiles/head.php");

if (!$id){
echo '<div class="rmenu">Союза не существует</div>';
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
exit;
}


$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
$arq = mysql_fetch_array($q);


        
            if (isset($_POST['submit'])) {


                $name = (trim($_POST['name']));
                $komm = (int)$_POST['komm'];
                $time = $realtime;

                if (!$name || !$komm || !$time ) {
                    echo display_error('Пустые параметры!');
                    require_once ("../../incfiles/end.php");
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
                        if ($komm ==8)
                        $priz=250;
                        else
                        $priz=500;
                        
                            mysql_query("INSERT INTO `union_cup` SET
                    `name` = '" . mysql_real_escape_string(mb_substr(trim($_POST['name']),0, 64)) . "',
                    `priz` = '$priz',
                    `komm` = '$komm',
                    `union` = '$id',
                    `status` = '0',
					`img` = '" . $realtime . "',
                    `time`   = '" . $realtime . "';");

                            header("Location: admin.php?act=addcup&id=$id");
                        } else {
                            echo display_error($handle->error);
                        }
                    } else {
                        echo display_error($handle->error);
                    }
                    $handle->clean();
                }
            } else {
                echo '<div class="phdr">Управление кубковыми турнирами</div>';
                //$x = mysql_query("SELECT * FROM `m_tournaments` ORDER BY `id` DESC");
                
                $x = mysql_query("SELECT * FROM `union_cup` WHERE `union`='$id' order by `status`, `id` asc;");
                
                if (!mysql_num_rows($x)) {
                    echo '<div class="rmenu">В союзе кубков нет!</div>';
                } else {
                    while ($row = mysql_fetch_assoc($x)) {
                        echo ($i % 2) ? '<div class="list1">' : '<div class="list2">';
                        echo "<table><tr>";
                        
                        echo '<td><img src="img/'.$row[img].'_small.jpg" /></td>';
                        echo '<td><b>' . $row['name'] . '</b><br/>';
                        echo 'Приз:  <b>' . $row['priz'] . '</b>';
                        echo '  <a href="admin.php?act=deltur&amp;id=' . $id .'&amp;cup='.$row[id].'">[Удалить]</a></td>';
                        
                        echo '</tr></table>';

                        ++$i;
                        echo '</div>';
                    }

                }

$qq = mysql_query("select * from `union_cup` where `union`='" . $id . "' AND `status` = '0';");
//$cups = mysql_fetch_array($qq);

if (mysql_num_rows($qq) == 0){
                echo '<form enctype="multipart/form-data" action="admin.php?act=addcup&amp;id='.$id.'" method="post">';
                echo '<div class="gmenu">';
                echo '<table cellpadding="0" cellspacing="0"><tr>';
                echo '<td><b>Название</b></td><td align="right"><input type="text" name="name"  value=""/></td></tr><tr>';
                echo '<td><b>Участвует</b></td><td align="right">';
                echo '<select name="komm">';
                echo '<option value="8">8 команд</option>';
                echo '<option value="16">16 команд</option>';
                echo '</select></td></tr><tr>';
                echo'</tr><tr>';
                echo '<td><b>Изображение</b></td><td align="right"><input type="file" name="imagefile" value="" /></td></tr><tr>';
				echo '</tr>';
                echo '</table>';
                echo '<p><input type="submit" name="submit" value="Добавить турнир" /></p></div></form>';
}else {echo '<div class="rmenu">Добавить кубок, можно будет тогда, когда все текущие кубки союза будут завершены!</div>';}

            }
        
                                   

echo '<p><a href="admin.php?id='.$id.'">В админ-панель</a></p>';

?>