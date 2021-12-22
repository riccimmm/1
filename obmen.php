<?php
define('_IN_JOHNCMS', 1);
$headmod = 'butcer';
$textl = 'Обмен буцеров';
// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';
require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
  
$posts_forum = 25; // Количество постов форума за 1 буц
$chat_messages = 80; // Количество сообщений чата за 1 буц
$limit_butcers = 200; //  Количество буцов при наличии которых нельзя производить обмен
$time_limit = 20; // Количество буцов которые можно обменять в течении 24 часов 
$bonus = 4;
$club = true;
  
  if (!$user_id) {
    echo display_error('Только для зарегистрированных пользователей!');
    require_once "incfiles/end.php";
    exit;
  }
  $req = mysql_query("SELECT * FROM `team_2` WHERE `id_admin` = '$user_id';");
  if (!mysql_num_rows($req)) {
	$club = false;
  }
  $res = mysql_fetch_array($req);
  $obmenko = explode("|", $res['obmen']);
  $obmenko_time = (int) $obmenko[0];
  $obmenko_buc = (int) $obmenko[1];
  
  if ($res['butcer'] >= $limit_butcers) {
    echo display_error('Обмен можно производить только если у Вас менее ' . $limit_butcers . ' буцеров!');
    require_once "incfiles/end.php";
    exit;
  }
  if ($datauser['postforum'] < $posts_forum  && $datauser['postchat'] < $chat_messages) {
    echo display_error('У Вас нет достаточного количества постов форума или сообщений чата для обмена!');
    require_once "incfiles/end.php";
    exit;
  }
  if ($obmenko_time >= ($realtime - 86400)) {
    if ($obmenko_buc >= $time_limit) {
      echo display_error('Вы можете менять не более ' . $time_limit . ' буцеров в сутки!');
      require_once "incfiles/end.php";
      exit;
    } else {
      $obmenko_ostatok = $time_limit - $obmenko_buc;
    }
  } else {
    $obmenko_time = $realtime;
    $obmenko_buc = 0;
    $obmenko_ostatok = $time_limit;
  } 
    
    if (isset($_POST['submit'])) {
    
    
    if (empty($_POST['bucc'])) {
        echo display_error('Вы не ввели количество буцеров,которые хотите обменять!');
        require_once "incfiles/end.php";
        exit;
    }
      if (isset($_POST['for']) || isset($_POST['cht'])) {
           $i = 0;
           $bucc = abs(intval($_POST['bucc']));
		   
		if ($bucc <= 0) {
			echo display_error('Неккоректное значение обмена');
			require_once "incfiles/end.php";
			exit;
		}
		   
		   
           if ($bucc > $obmenko_ostatok) {
             echo display_error('Вы можете обменять не более ' . $obmenko_ostatok . ' за текущие сутки!');
             require_once "incfiles/end.php";
             exit;
            }
           
           $ostatok_forum = $datauser['postforum'];
           if (isset($_POST['for'])) {
             while ($i < $bucc) {
               $ostatok_forum = $ostatok_forum - $posts_forum;
             if ($ostatok_forum >= 0) {
               if ($ostatok_forum >= $posts_forum) {
                 $i = $i + 1;
               } else {
                 $i = $i + 1;
                 break;
               }    
             }
             }
             
             
           }
           $ostatok_chat = $datauser['postchat'];
			if (isset($_POST['cht'])) {
				while ($i < $bucc) {
					$ostatok_chat = $ostatok_chat - $chat_messages;
					if ($ostatok_chat >= 0) {
						if ($ostatok_chat >= $chat_messages) {
							$i = $i + 1;
						} else {
							$i = $i + 1;
							break;
						}    
					}
				}
            }
			if($i >= $bonus)
				$i = $i + 1;
			
			
            $rec_obmen = $obmenko_time . '|' . intval($obmenko_buc + $i); 
			
			
            mysql_query("UPDATE `users` SET `postforum` = '$ostatok_forum', `postchat` = '$ostatok_chat'WHERE `id` = '$user_id';");
            if(isset($_POST['menedger'])){
        mysql_query("UPDATE `team_2` SET `butcer` = `butcer` + $i WHERE `id_admin` = '$user_id';");
        $p = mysql_query("SELECT `butcer` FROM `team_2` WHERE `id_admin` = '$user_id' LIMIT 1");
        $f = mysql_fetch_assoc($p);
        $skoka = $f['butcer'];
			}else{
        mysql_query("UPDATE `team_2` SET `butcer` = `butcer` + $i WHERE `id_admin` = '$user_id';");
        $p = mysql_query("SELECT `butcer` FROM `team_2` WHERE `id_admin` = '$user_id' LIMIT 1");
        $f = mysql_fetch_assoc($p);
        $skoka = $f['butcer'];
			}
			echo '<div class="list2"><p>Обмен успешно выполнен! теперь у Вас <b>' . intval($skoka) . '</b> буцеров!</p></div>';
      } else {
        echo display_error('Вы не выбрали ресурсы для обмена!');
        require_once "incfiles/end.php";
        exit;
      }
    
    } else {
          echo '<div class="bmenu"><b>Обменник</b></div>'; 
    echo '<div class="c">
         На этой странице Вы можете обменять Ваши сообщения чата и(или) посты форума
         на буцеры!<br />Курс обмена:<br /> <b>' . $posts_forum . '</b> постов форума
          на <b>1</b> буцер<br /> <b>' . $chat_messages . '</b> сообщений чата на <b>1</b> буцер<br /><br />
          Обмен можно производить только если у Вас менее <b>' . $limit_butcers . '</b> буцеров!<br />
          Если Вы за один раз обмениваете более <b>' . $bonus . '</b> буцеров, то вы получите в подарок <b>1</b> буцер!<br />
          Вы можете обменять не более <b>' . $time_limit . '</b> буцеров в сутки!<br /><br />
          Сейчас у Вас есть <b>' . $datauser['postforum'] . '</b> постов форума и <b>' . $datauser['postchat'] . '</b> сообщений чата!</div>';
    echo '<div class="c"><form action="obmen.php?" method="POST"><p>
      Количество буцеров которые хотите обменять:<br /><input type="text" name="bucc" maxlength="1" /><br />';
    if ($datauser['postforum'] >= $posts_forum)
		echo '<input type="checkbox" name="for" value="1" /> на посты форума<br />';
    if ($datauser['postchat'] >= $chat_messages)
		echo '<input type="checkbox" name="cht" value="1" /> на сообщения чата<br />';
		
    echo '<input type="submit" name="submit" value="Обменять" /></p></form></div>';      
    }

echo '<div class="c">
<a href="http://futzone.net/futzers/">Вернуться</a></div>';

  require_once ("incfiles/end.php");
?>