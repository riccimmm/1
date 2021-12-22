<?php

defined('_IN_JOHNCMS') or die('Error: restricted access');

require_once ("../../incfiles/head.php");
$cup = isset ($_REQUEST['cup']) ? abs(intval($_REQUEST['cup'])) : false;

if (!$id){
echo '<div class="rmenu">Союза не существует</div>';
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
exit;
}

if (!$cup){
echo '<div class="rmenu">Союза не существует</div>';
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
exit;
}

$qc = mysql_query("select * from `union_cup` where `id`='" . $cup . "' AND `union`='$id' LIMIT 1;");
$arc = mysql_fetch_array($qc);

if (mysql_num_rows($qc) == 0) {
    echo display_error('Такого кубка не существует, либо его нет в вашем союзе!');
    echo '<a href="index.php">Вернуться</a>';
    require('../../incfiles/end.php');
    exit;
}



$q = mysql_query("select * from `union` where `id`='" . $id . "' LIMIT 1;");
$arq = mysql_fetch_array($q);

if ($user_id  != $arq['id_prez'])
{
echo '<div class="rmenu">Союза не существует!</div>';
//echo "$arq[id_prez] != $user_id OR $rights <7";
echo '<a href="index.php">Вернуться</a><br/>';
require_once ("../../incfiles/end.php");
exit;
}

        
            if (isset($_GET['yes'])) {

			mysql_query("DELETE FROM `union_cup` WHERE `id`='$cup'");
			@unlink('img/' . $arc['img'].'.jpg');
			@unlink('img/' . $arc['img'].'_small.jpg');

            header("Location: admin.php?act=addcup&id=$id");

            } else {
                echo '<div class="phdr">Удаление кубка</div>';
               echo '<div class="gmenu">Вы действительно хотите удалить кубок <b>'.$arc[name].'</b></div>';
               echo "
               <div class='rmenu'>
               <a href='admin.php?act=deltur&amp;id=$id&amp;cup=$cup&amp;yes'>Удалить</a> | 
               <a href='admin.php?act=addcup&amp;id=$id'>Отмена</a>
               </div>
               ";
               
                }

           
            
                                   

echo '<p><a href="admin.php?id='.$id.'">В админ-панель</a></p>';

?>