<?php
  define('_IN_JOHNCMS', 1);
  $textl = 'Рассылка сообщений участникам союза';
  require('../incfiles/core.php');
  require('../incfiles/head.php');
  # Блокировка гостей
  if ($rights != 9) {
         echo display_error('Доступ запрещен!');
         require('../incfiles/end.php');
         exit;
  }
  if (isset($_POST['submit'])) {
  # Проверка и подготовка данных
          $err = array();
          $tema = $_POST['tema'];
          $text = $_POST['text'];
           if (empty($tema))
                    $err[] = ' Не введена тема сообщения!';
           if (empty($text))
                    $err[] = 'Не введен текст сообщения!';
           $usr = mysql_query("select * from `team_2` where `union` > '0' order by `id` asc;");
            if (mysql_num_rows($usr) == 0)
                    $err[] = 'В вашем союзе нет ни одного участника!';
          $tema = check($tema);
          $text = check($text);
          if (!$err) {
            $i = 0;
            while ($us = mysql_fetch_assoc($usr)) {
                if (trim($us['name_admin']) == $login)
                  continue;
                mysql_query("INSERT INTO `privat` SET
                             `user` = '" . trim($us['name_admin']) . "',
                             `text` = '$text',
                             `time` = '$realtime',
                             `author` = '$login',
                             `type` = 'in',
                             `chit` = 'no',
                             `temka` = '$tema';
                             ");
                             ++$i;
            }
            echo '<div class="gmenu">Рассылка выполнена! Отправлено ' . $i . ' сообщений!</div>';
          } else {
            echo display_error($err);
            require('../incfiles/end.php');
            exit;
          }
  } else {
             echo '<div class="phdr"><b>Рассылка сообщений участникам союза</b></div>'
                    . '<div class="c">'
                    . '<form action="adm_msg.php" method="POST">'
                    . '<p>Тема сообщения:<br /><input type="text" name="tema" value="Рассылка от Администратора сайта!" /></p>'
                    . '<p>Текст сообщения:<br /><textarea name="text"></textarea></p>'
                    . '<p><input type="submit" name="submit" title="Нажмите для отправки" value="Отправить" /></p>'
                    . '</form></div>';
  }
  
 require('../incfiles/end.php'); 
?>