<?php

define('_IN_JOHNCMS', 1);
$headmod = 'stena';
$textl = 'Стена юзера';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");

// Ограничиваем доступ к стене
        if (!$user_id) {
            echo display_error('Только для зарегистрированных');
            require_once ('../incfiles/end.php');
            exit;
        }

        switch ($act)
        {

    case 'clean' :
        ////////////////////////////////////////////////////////////
        // Чистка стены                                       //
        ////////////////////////////////////////////////////////////
    $id = isset($_GET['id']) ? intval($_GET['id']) : $user_id;
    $q = mysql_query("select * from `users` where id='" . $id . "';");
    $arr = mysql_fetch_array($q);
    if (!$arr[id])
    {
        echo display_error('Пользователь не найден');
        require_once ("../incfiles/end.php");
        exit;
    }
    if (id && $id == $user_id || $rights >= 6) {
    echo "<div class='phdr'><a href='wall.php?user=".$arr['id']."'><b>Стена ".$arr['name']."</b></a> | Чистка</div>";
            if (isset ($_POST['submit'])) {
                $cl = isset ($_POST['cl']) ? intval($_POST['cl']) : '';
                switch ($cl) {
                    case '1' :
                        // Чистим сообщения, старше 1 года
    $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = ".$arr['id']." AND `time`<='" . ($realtime - 31104000) . "';"), 0);
    if ($count)
    {
                        mysql_query("DELETE FROM `wall` WHERE `user_id` = ".$arr['id']." AND `time`<='" . ($realtime - 31104000) . "'");
                        mysql_query("OPTIMIZE TABLE `wall`;");
                        echo '<div class="gmenu"><p>Удалены все посты, старше 1 года<br/><a href="wall.php?user='.$arr['id'].'">Продолжить</a></p></div>';
    } else {
        echo display_error('Постов для удаления нет');
    }
                        break;
                    case '2' :
                        // Чистим сообщения, старше 1 месяца
    $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = ".$arr['id']." AND `time`<='" . ($realtime - 2592000) . "';"), 0);
    if ($count)
    {
                        mysql_query("DELETE FROM `wall` WHERE `user_id` = ".$arr['id']." AND `time`<='" . ($realtime - 2592000) . "'");
                        mysql_query("OPTIMIZE TABLE `wall`;");
                        echo '<div class="gmenu"><p>Удалены все посты, старше 1 месяца<br/><a href="wall.php?user='.$arr['id'].'">Продолжить</a></p></div>';
    } else {
        echo display_error('Постов для удаления нет');
    }
                        break;
                    case '3' :
                        // Чистим сообщения, старше 1 недели
    $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = ".$arr['id']." AND `time`<='" . ($realtime - 604800) . "';"), 0);
    if ($count)
    {
                        mysql_query("DELETE FROM `wall` WHERE `user_id` = ".$arr['id']." AND `time`<='" . ($realtime - 604800) . "'");
                        mysql_query("OPTIMIZE TABLE `wall`;");
                        echo '<div class="gmenu"><p>Удалены все посты, старше 1 недели<br/><a href="wall.php?user='.$arr['id'].'">Продолжить</a></p></div>';
    } else {
        echo display_error('Постов для удаления нет');
    }
                        break;
                    case '4' :
                        // Чистим сообщения, старше 1 дня
    $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = ".$arr['id']." AND `time`<='" . ($realtime - 86400) . "';"), 0);
    if ($count)
    {
                        mysql_query("DELETE FROM `wall` WHERE `user_id` = ".$arr['id']." AND `time`<='" . ($realtime - 86400) . "'");
                        mysql_query("OPTIMIZE TABLE `wall`;");
                        echo '<div class="gmenu"><p>Удалены все посты, старше 1 дня<br/><a href="wall.php?user='.$arr['id'].'">Продолжить</a></p></div>';
    } else {
        echo display_error('Постов для удаления нет');
    }
                        break;
                    default :
                        // Проводим полную очистку
                        mysql_query("DELETE FROM `wall` WHERE `user_id` = ".$arr['id']."");
                        echo '<div class="gmenu"><p>Стена юзера полностью очищена<br/><a href="wall.php?user='.$arr['id'].'">Продолжить</a></p></div>';
                }
            }
            else {
                echo '<div class="gmenu">Удалить посты более:<form action="wall.php?act=clean&amp;id='.$arr['id'].'" method="post"><select name="cl">';
                echo '<option value="1">1 года назад</option>';
                echo '<option value="2">1 месяца назад</option>';
                echo '<option value="3">1 недели назад</option>';
                echo '<option value="4">1 дня назад</option>';
                echo '<option value="0">Очищаем все</option>';
                echo '</select><br/><input value="Удалить" name="submit" type="submit" /></form></div>';
            }
    $req = mysql_query("SELECT COUNT(*) FROM `wall`  WHERE `user_id` = ".$arr['id']."");
    $countp = mysql_result($req, 0);
    echo '<div class="phdr">Всего постов:&nbsp;' . $countp . '</div>';
        }
        else {
            header("location: wall.php?user=".$arr['id']."");
        }
        break;

            default:

    $user = isset($_GET['user']) ? intval($_GET['user']) : $user_id;
    $q = mysql_query("select * from `users` where id='" . $user . "';");
    $arr = mysql_fetch_array($q);

    if (!$arr[id])
    {
        echo display_error('Пользователя с таким ID не существует');
        require_once ("../incfiles/end.php");
        exit;
    }

    // Если был запрос, то выводим стену пользователя
    if ($user && $user != $user_id) {
    ////////////////////////////////////////////////////////////
    // Стена  пользователя                  //
    ////////////////////////////////////////////////////////////

       echo '<div class="phdr"><b>Стена '.$arr[name].'</b></div>';

	// Добавление сообщений
	if(isset($_POST['message']) AND isset($user_id))
	{
		$message = $_POST['message'];
		if(isset($_POST['translit']) AND $_POST['translit']) $message = trans($message);

		$err = '';
			
                if(mb_strlen($message) > 300) $err .= 'Сообщение слишком длинное<br/>';
		if(mb_strlen($message) < 5) $err .= 'Слишком короткое сообщение<br/>';
		
		if(@mysql_result(@mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = '$arr[id]' AND `message` = '".@mysql_escape_string($message)."' AND `time` > '".($time - 300)."' LIMIT 1"), 0) != 0) $err .= 'Ваше сообщение повторяет предыдущее<br/>';
		if(time() - @mysql_result(@mysql_query("SELECT `time` FROM `wall` WHERE `user_id` = '$user_id' ORDER BY `id` DESC LIMIT 1;"), 0) < 30) $err .= 'Не стоит писать сообщения так часто<br/>';
		
		if($err != '')
		{
                        echo display_error($err);
		}
		
		else
		{
                        $message = @mysql_escape_string($message);

			@mysql_query("INSERT INTO `wall` (`user_id`, `who`, `time`, `message`) values('$arr[id]', '".$user_id."', '".time()."', '$message')");
			@mysql_query("UPDATE `users` SET `msg_on_wall` = `msg_on_wall` + 1 WHERE `id` = '$user_id' LIMIT 1");
		
			echo '<div class="rmenu">Сообщение успешно добавлено</div>';
		}
	}

	echo '<div class="gmenu"><form method="post" action="wall.php?user=' . $arr['id'] . '">Сообщение:<br/><textarea name="message"></textarea><br/>';
	
	if ($offtr != 1)
                        {
                            echo "<input type='checkbox' name='translit' value='1' /> Транслит<br/>";
                        }
	echo'<input type="submit" value="Написать на стене"/>';
	$refr = rand(0, 999);
        echo '<a class="button" href="#">Обновить</a>';
	
	echo '</form></div>';
        // Вывод сообщений
	$k_post = @mysql_result(@mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = '$arr[id]'"), 0);

        $req = mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = '$arr[id]'");
        $total = mysql_result($req, 0);
if ($total) {
        $req = mysql_query("SELECT * FROM `wall` WHERE `user_id` = '$arr[id]' ORDER BY `time` DESC LIMIT " . $start . "," . $kmess . ";");
while ($array = mysql_fetch_array($req))
            {
                echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<div class="">' : '<div class="">';
		$user_nick = mysql_result(mysql_query("SELECT `name` FROM `users` WHERE `id` = '".$array['who']."';"), 0);

                $uz = @mysql_query("select `sex`,`status` from `users` where id='" . $array['who'] . "';");
                $arrz = @mysql_fetch_array($uz);

                $vrp = $array['time'] + $sdvig * 3600;
                $vr = date("d.m в H:i", $vrp);
        echo $div;
       echo '<div class="b">';
                if ((!empty ($_SESSION['uid'])) && ($_SESSION['uid'] != $array['who']))
        {
        echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($arrz['sex'] == 'm' ? 'm' : 'w') . '.png" alt=""/>&nbsp;<a href="anketa.php?id=' . $array['who'] . '"><b>' . $user_nick . '</b></a>&nbsp;';
        } else
        {
        echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($arrz['sex'] == 'm' ? 'm' : 'w') . '.png" alt=""/>&nbsp;<b>' . $user_nick . '</b>&nbsp;';
        }
		
		echo $vr;	
		echo '</div>';
			    $text = $array['message'];	
                            $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
                            if ($offsm != 1)
                            {            if ($set_user['smileys'])
                            $text = smileys($text, ($massiv1['from'] == $nickadmina || $massiv1['from'] == $nickadmina2 || $massiv11['rights'] >= 1) ? 1 : 0);
                            }
                            $text = str_replace("\r\n", "<br/>", $text);
                            $text = tags($text);
                            echo '<div class="c">'.$text.'';
							
							
							echo '<div style="text-align:right">
							[<a href="#" >Мне нравится</a>]
							</div></div>';	
            echo '</div>';
            ++$i;
            }
       if ($rights >= 6) {
                echo '<form action="wall.php?act=clean&amp;id='.$arr['id'].'" method="post">';
                echo '<div class="c"><input type="submit" value=" Чистка стены "/></div>';
                echo '</form>';
       }
}
else {
echo '<div class="menu"><p>Сообщений нет, будь первым!</p></div>';
}
       echo '<div class="phdr">Всего:&nbsp;' . $total . '</div>';
	
	
        if ($total > $kmess)
        {
            echo '<p>' . pagenav('wall.php?user=' . $arr['id'] .'&amp;', $start, $total, $kmess) . '</p>';
            echo '<p><form action="wall.php" method="get"><input type="hidden" name="user" value="' . $arr['id'] .'"/><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        }

        echo '<p><a href="anketa.php?id=' . $arr['id'] .'">Анкета пользователя</a></p>';
    } else {
    //////////////////////////////////////////////////
    // Личная стена                                //
    ////////////////////////////////////////////////
 
	 echo '<div class="phdr"><b>Моя стена</b></div>';
         // Удаление сообщений
	 if(isset($_GET['delete']) AND !empty($_GET['delete']))
	{
		$delete = (int)$_GET['delete'];
	
		if($user['level'] > 3 OR $ank['id'] == $user['id'])
		{
			$query = @mysql_query("SELECT `id` FROM `wall` WHERE `user_id` = '$user_id' AND `id` = '$delete';");
			
			if(@mysql_affected_rows() > 0)
			{
				@mysql_query("DELETE FROM `wall` WHERE `user_id` = '$user_id' AND `id` = '$delete' LIMIT 1;");

				echo '<div class="rmenu">Сообщение успешно удалено</div>';
			}
			else
				echo '<div class="rmenu">Сообщение не найдено</div>';
		}
		else
			echo '<div class="rmenu">У Вас нет прав для удаления этого сообщения</div>';
	}

	
	
	
	
	// Добавление сообщений
	if(isset($_POST['message']) AND isset($user_id))
	{
		$message = $_POST['message'];
	
		if(isset($_POST['translit']) AND $_POST['translit']) $message = trans($message);

		$err = '';
			
		if(mb_strlen($message) > 300) $err .= 'Сообщение слишком длинное<br/>';
		if(mb_strlen($message) < 5) $err .= 'Слишком короткое сообщение<br/>';
		
		if(@mysql_result(@mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = '$user_id' AND `message` = '".@mysql_escape_string($message)."' AND `time` > '".($time - 300)."' LIMIT 1"), 0) != 0) $err .= 'Ваше сообщение повторяет предыдущее<br/>';
	        if(time() - @mysql_result(@mysql_query("SELECT `time` FROM `wall` WHERE `user_id` = '$user_id' ORDER BY `id` DESC LIMIT 1;"), 0) < 30) $err .= 'Не стоит писать сообщения так часто<br/>';
		
		if($err != '')
		{
                        echo display_error($err);
		}
		
		else
		{
			$message = @mysql_escape_string($message);

			@mysql_query("INSERT INTO `wall` (`user_id`, `who`, `time`, `message`) values('".$user_id."', '".$user_id."', '".time()."', '$message')");
			@mysql_query("UPDATE `users` SET `msg_on_wall` = `msg_on_wall` + 1 WHERE `id` = '$user_id' LIMIT 1");
		
			echo '<div class="rmenu">Сообщение успешно добавлено</div>';
		}
	}

       echo '<div class="gmenu"><form method="post" action="wall.php"><textarea name="message"></textarea><br/>';
	

	echo'<input type="submit" value="Написать на стене"/>';
	$refr = rand(0, 999);
        echo '<a class="button" href="wall.php?user=' . $arr['id'] .'&amp;start=' . $start . '&amp;ob=' . $refr . '">Обновить</a>';
	
	echo '</form></div>';
	
	
		
	
	// Вывод сообщений
	$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `wall` WHERE `user_id` = '$arr[id]'"), 0);
	
        
        $req = mysql_query("SELECT COUNT(*) FROM `wall`  WHERE `user_id` = ".$arr['id']."");
        $total = mysql_result($req, 0);
if ($total) {
        $req = mysql_query("SELECT * FROM `wall` WHERE `user_id` = ".$arr['id']." ORDER BY `time` DESC LIMIT " . $start . "," . $kmess . ";");
while ($array = mysql_fetch_array($req))
            {
                echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<div class="">' : '<div class="">';
		$user_nick = mysql_result(mysql_query("SELECT `name` FROM `users` WHERE `id` = '".$array['who']."';"), 0);

                $uz = @mysql_query("select `sex`,`status` from `users` where id='" . $array['who'] . "';");
                $arrz = @mysql_fetch_array($uz);

                $vrp = $array['time'] + $sdvig * 3600;
                $vr = date("d.m в H:i", $vrp);
        echo $div;
     
		
		/*
		echo '<td>';
						if (file_exists(('../files/photo/' . $user['id'] . '.jpg'))){
						echo '<img style="border-radius:5px;" src="../files/photo/' . $user['id'] . '.jpg" alt="' . $user['name'] . '" width="64px" height="64px"/>&nbsp;';
						}else{
						echo ' <img style="border-radius:5px;" src="../files/photo/nophoto.jpg" alt="' . $user['name'] . '" width="64px" height="64px"/>&nbsp;';
						}
		echo '</td>';
		*/
		
		
		echo '<div class="b">';
                if ((!empty ($_SESSION['uid'])) && ($_SESSION['uid'] != $array['who']))
        {
        echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($arrz['sex'] == 'm' ? 'm' : 'w') . '.png" alt=""/>&nbsp;<a href="anketa.php?id=' . $array['who'] . '"><b>' . $user_nick . '</b></a>&nbsp;';
        } else
        {
        echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($arrz['sex'] == 'm' ? 'm' : 'w') . '.png" alt=""/>&nbsp;<b>' . $user_nick . '</b>&nbsp;';
        }
		
		echo $vr;	
		echo '</div>';
		
		
			   $text = $array['message'];	
                            $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
                            if ($offsm != 1)
                            {            if ($set_user['smileys'])
                            $text = smileys($text, ($massiv1['from'] == $nickadmina || $massiv1['from'] == $nickadmina2 || $massiv11['rights'] >= 1) ? 1 : 0);
                            }
                            $text = str_replace("\r\n", "<br/>", $text);
                            $text = tags($text);
                            echo '<div class="c"> '.$text.'';
							
                            echo '<div style="text-align:right">
							[<a href="#" >Мне нравится</a>]
							[<a href="wall.php?delete='.$array['id'].'" >Del</a>]
							</div>';	
							
							echo '</div>';
							
                            
		
            echo '</div>';
            ++$i;
		}
       if($ank['id'] == $user['id']) {
                echo '<form action="wall.php?act=clean&amp;id='.$arr['id'].'" method="post">';
                echo '<div class="c"><input type="submit" value=" Очистить стену "/></div>';
                echo '</form>';
       }
}
else {
echo '<div class="menu"><p>Сообщений нет, будь первым!</p></div>';
}
       echo '<div class="phdr">Всего:&nbsp;' . $total . '</div>';
	
	
	
        if ($total > $kmess)
        {
            echo '<p>' . pagenav('wall.php?user=' . $arr['id'] .'&amp;', $start, $total, $kmess) . '</p>';
            echo '<p><form action="wall.php" method="get"><input type="hidden" name="user" value="' . $arr['id'] .'"/><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        }

      
    }
                break;
        }
require_once ("../incfiles/end.php");

?>