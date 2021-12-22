<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');


echo '<div class="phdr" align="center">Участники игры</div>';
        echo '<div class="c">';
echo '
<table border="0" width="100%"  id="example2" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Страна</b></td>
<td><b>Команда</b></td>
<td><b>Опыт</b></td>
</tr>
';

$req = mysql_query("SELECT * FROM `team_2` WHERE `id_admin`!=0 ORDER BY `rate` DESC ");


$mesto =1;
while ($arr = mysql_fetch_array($req))
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
echo '
<td><center>'.$mesto.'</center></td>
<td><center><img src="flag/'.$arr['strana'].'.png" alt=""/></center></td>
<td><a href="team.php?id='.$arr['id'].'">'.$arr['name'].'</a> <br/><small><a href="str/anketa.php?id=' . $res['id'] . '"></a></small></td>
<td align="center"><font color="green"><b>'.$arr['rate'].'</b></font></td>
';		
echo '</tr>';
	++$mesto;
    ++$i;
}
echo '</table><br/></div>';


require_once ("incfiles/end.php");
?>