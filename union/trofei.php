<?php

  define('_IN_JOHNCMS', 1);
  $textl = 'Трофеи Союза';
  require('../incfiles/core.php');
  require('../incfiles/head.php');

  echo '<div class="bmenu"><b>Трофеи Союза</b></div>';

  $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `priz_2` LEFT JOIN `team_2` ON `priz_2`.`win` = `team_2`.`id` WHERE `team_2`.`union` = '$id';"), 0);
  echo '<div class="gmenu">Всего: ' . $count . '</div>';

  if ($count > 0) {
    $q = mysql_query("SELECT `priz_2`.*, `team_2`.`name` AS `tnm` FROM `priz_2` LEFT JOIN `team_2` ON `priz_2`.`win` = `team_2`.`id` WHERE `team_2`.`union` = '$id' ORDER BY `priz_2`.`priz` DESC LIMIT $start, 20;");
    echo '<table id="example">';
    while ($arr = mysql_fetch_assoc($q)) {
        echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="evenrows">';

        echo '<td width="'.($theme == "wap" ? '32' : '55').'px" align="center">';
        echo '<img src="/images/cup/'.($theme == "wap" ? 's' : 'm').'_'.$arr[id_cup].'.jpg" alt=""/>';
        echo '</td>';

        echo '<td>
        <a href="'.$arr[url].'"><b>'.$arr[name].'</b></a> (' . $arr['tnm'] . ')<br/>
        Время: '.date("d.m.Y H:i", $arr['time']).'<br/>
        Приз: '.$arr['priz'].' €
        </td>';

	
        echo '</tr>';
        ++$i;
    }
    echo '</table>';

  } else {
    echo '<div class="gmenu">Пока в союзе трофеев нет.</div>';
  }
  if ($count > 20)
  echo '<div class="c">' . pagenav('trofei.php?id=' . $id . '&amp;', $start, $count, 20) . '</div>';
  
  
  require('../incfiles/end.php');

?>