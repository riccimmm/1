<?php

define('_IN_JOHNCMS', 1);
$headmod = 'union';
$textl = 'Союз';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");


$q = mysql_query("select * from `union` where id='" . $id . "' LIMIT 1;");
  if (mysql_num_rows($q) == 0) {
    echo display_error('Такого союза не существует!');
    require('../incfiles/end.php');
    exit;
  }
  $r = mysql_fetch_array($q);
  if ($r['id_prez'] != $user_id) {
    echo display_error('Вы не являетесь президентом данного союза!');
    require('../incfiles/end.php');
    exit;
  }
  switch ($act) {
    default:
    $qq = mysql_query("SELECT `id`, `name`, `name_admin` FROM `team_2` WHERE `union` = '$id' AND `union_mod` = '0';");
    echo '<div class="phdr"><b>Кандидаты на вступление в союз</b></div>';
    if ($total = mysql_num_rows($qq)) {
        while ($rr = mysql_fetch_assoc($qq)) {
            echo is_integer($i / 2) ? '<div class="list1">' : '<div class="list2">';
            echo '<a href="../team/' . $rr['id'] . '">' . htmlentities($rr['name'], ENT_QUOTES, 'UTF-8') . '</a>';
            echo '<div class="sub"><a href="mod.php?act=prin&amp;id=' . $id . '&amp;unid=' . $rr['id'] . '">принять</a> | <a href="mod.php?act=delete&amp;id=' . $id . '&amp;unid=' . $rr['id'] . '">отклонить</a></div>';
            echo '</div>';
            ++$i;           
        }
        if ($total > 20)
          echo '<div class="menu">' . pagenav('mod.php?id=' . $id . '&amp;', $start, $total, 20) . '</div>';
    } else {
        echo '<div class="rmenu">Нет кандидатов на вступление в союз!</div>';
    }
      echo '<div class="bmenu"> Всего: ' . $total . '</div>';
    break;
    
    case 'delete':
      mysql_query("UPDATE `team_2` SET `union` = '0' WHERE `id` = '" . abs(intval($_GET['unid'])) . "' LIMIT 1;");
      header("Location: mod.php?id=$id");
      exit;
    break;
    
    case 'prin':
      mysql_query("UPDATE `team_2` SET `union_mod` = '1' WHERE `id` = '" . abs(intval($_GET['unid'])) . "' LIMIT 1;");
      $qq = mysql_query("SELECT `name_admin` FROM `team_2` WHERE `id` = '" . abs(intval($_GET['unid'])) . "';");
      $dd = mysql_fetch_array($qq);
      mysql_query("INSERT INTO `union_journal` SET `unid` = '$id', `time` = '$realtime', `text` = 'Игрок " . $dd['name_admin'] . " вступил в союз';");
      header("Location: mod.php?id=$id");
      exit;
    break;
  }
  
  require('../incfiles/end.php');
?>