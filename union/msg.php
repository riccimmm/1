<?php
  define('_IN_JOHNCMS', 1);
  $textl = 'Рассылка сообщений участникам союза';
  require('../incfiles/core.php');
  require('../incfiles/head.php');
  # Блокировка гостей
  if (!$user_id) {
         echo display_error('Только для зарегистрированных посетителей');
         require('../incfiles/end.php');
         exit;
  }
  $req = mysql_query("select * from `union` where `id` = '$id' limit 1;");
  # Проверка существования союза
  if (mysql_num_rows($req) == 0) {
         echo display_error('Такого союза не существует');
         require('../incfiles/end.php');
         exit;
  }
  $res = mysql_fetch_array($req);
  # Проверка президента союза
  if ($res['id_prez'] != $user_id) {
         echo display_error('Вы не являетесь президентом данного союза!');
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
           $usr = mysql_query("select * from `team_2` where `union` = '$id' order by `id` asc;");
            if (mysql_num_rows($usr) == 0)
                    $err[] = 'В вашем союзе нет ни одного участника!';
          $tema = check($tema);
          $text = check($text);
          if (!$err) {
            $i = 0;
            while ($us = mysql_fetch_assoc($usr)) {
            
           $nm = mysql_fetch_array(mysql_query("select `name` from `users` where id='" . $us['id_admin'] . "';"));
 
            
                if (trim($nm['name']) == $login)
                  continue;
                mysql_query("INSERT INTO `privat` SET
                             `user` = '" . trim($nm['name']) . "',
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
                    . '<div class="list1">'
                    . '<form action="msg.php?id=' . $id . '" method="POST">'
                    . '<p>Тема сообщения:<br /><input type="text" name="tema" value="Рассылка от президента союза ' . $res['name'] . '!" /></p>'
                    . '<p>Текст сообщения:<br /><textarea name="text"></textarea></p>'
                    . '<p><input type="submit" name="submit" title="Нажмите для отправки" value="Отправить" /></p>'
                    . '</form></div>';
  }
  
 require('../incfiles/end.php'); 
?>