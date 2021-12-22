<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

if (!$id)
{
echo "Ошибка<br/>";
require_once ("incfiles/end.php");
exit;
}
$bb = mysql_query("SELECT COUNT(*) FROM `gnews_2` WHERE `tid`='".$id."';");
 $colmes=mysql_result($bb,0);
 if($colmes>0){
 $bb = mysql_query("SELECT * FROM `gnews_2` WHERE `tid`='".$id."' ORDER BY `id` DESC LIMIT " . $start . ", 30;");
 	echo '<div class="gmenu">';
echo 'Ход игры:</div>';				
				$i="0";
                
                while ($bb1 = mysql_fetch_assoc($bb))
                {
                    echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<div class="list1">' : '<div class="list2">';
					$menu = explode("|",$bb1['news']);
echo $div .'<img src="/manag/img/txt/s_' . $menu[1] . '.gif" alt=""/>'.$bb1['time'].'м. ' . $menu[2] .'</div>';
                    ++$i;
                }

                if ($colmes > 30)
{
echo '<div class="c">' . pagenav('tsee.php?id='.$id.'&amp;', $start, $colmes, 30) . '</div>';
}
}else{
echo "Ошибка<br/>";
require_once ("incfiles/end.php");
exit;
}
echo '<a href="trans.php?id=' . $id . '">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>