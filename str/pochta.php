<?php
	define('_IN_JOHNCMS', 1);
	$headmod = 'pochta';
	require_once('../incfiles/core.php');
/*
* Модуль Личной почты для JohnCMS 3.2.2
* Автор: Krite ( http://upcoder.net )
*/
	$spam['msg'] = 3; //Количество пользователей с неотвеченными сообщениями за промежуток времени
	$spam['block'] = 900; //Промежуток времени блокировки в секундах 
	$spam['time'] = 1; //Время блокировки почты в часах
	switch($act) {
		case 'in':
			$textl = 'Почта | Входящие сообщения';
		break;
		case 'out':
			$textl = 'Почта | Исходящие сообщения';
		break;
		case 'contacts':
			$textl = 'Почта | Контакт-лист';
		break;
		case 'ignor':
			$textl = 'Почта | Игнор-лист';
		break;
		case 'add':
			$textl = 'Почта | Отправка сообщения';
		break;
		case 'read':
			$textl = 'Почта | Чтение сообщения';
		break;
		case 'systems':
			$textl = 'Почта | Системные сообщения';
		break;
		case 'delete':
			$textl = 'Почта | Удаление контакта';
		break;
		case 'sending_out':
			$textl = 'Почта | Рассылка сообщений';
		break;
		case 'new':
			$textl = 'Почта | Непрочитанные сообщения';
		break;
		case 'addcont':
			$textl = 'Почта | Добавление контакта';
		break;
		case 'addignor':
			$textl = 'Почта | Добавление в игнор-лист';
		break;
		case 'history':
			$textl = 'Почта | История переписки';
		break;
		case 'file':
			$textl = 'Почта | Файлы из писем';
		default:
			$textl = 'Личная почта';
		break;
	}
	require_once('../incfiles/head.php');
	
	if (!$user_id) {
		echo display_error('Только для зарегистрированных посетителей');
		require_once('../incfiles/end.php');
		exit;
	}
	
	if($act == 'in') {
		echo '<div class="phdr"><h3>Входящие сообщения</h3></div>';
		$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_msg` WHERE `id_kont`='" . $user_id . "' AND `sys`=1 AND `delete`!='" . $user_id . "' AND `spam`='1'"), 0);
		if($total > 0) {
			$req = mysql_query("SELECT * FROM `mail_msg` WHERE `id_kont`='" . $user_id . "' AND `sys`=1 AND `delete`!='" . $user_id . "' AND `spam`='1' ORDER BY `time` DESC LIMIT $start, $kmess");
			echo '<form action="'.$home.'/str/pochta.php?act=massin" method="post">';
			while($row = mysql_fetch_assoc($req)) {
				$text = '';
				$result = mysql_query('SELECT * FROM `users` WHERE `id` = ' . $row['id_user']);
				if(mysql_num_rows($result))
					$res = mysql_fetch_assoc($result);
				else {
					$res['name'] = $row['from'];
					$res['id'] = $row['id_user'];
					$res['ip'] = $row['ip'];
					$res['browser'] = $row['ua'];
				}
				echo ($i % 2) ? '<div class="list2">':'<div class="list1">';
				if($row['read']==1) $text .='Не прочитано!<br />';
				if($row['file']) $text .='+ Вложение<br />';
				
				$subtext = '<input type="checkbox" name="delmes[]" value="' . $row['id'] . '"/>&nbsp;<a href="'.$home.'/str/pochta.php?act=read&amp;id='.$row['id'].'">Читать</a> | <a href="'.$home.'/str/pochta.php?act=add&amp;id='.$res['id'].'">Ответить</a> | <a href="'.$home.'/str/pochta.php?act=del&amp;id='.$row['id'].'">Удалить</a> | <a href="'.$home.'/str/pochta.php?act=history&amp;id='.$res['id'].'">История</a>';
				echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), '[' . date('d.m.o в H:i',$row['time']) . ']', $text, $subtext);
				
				echo '</div>';
				++$i;
			}
			echo '<div class="rmenu"><input type="submit" value="Удалить отмеченные"/></div>';
			echo '</form>';
			echo '<div class="phdr">Всего: ' . $total . '</div>';
			if ($total > $kmess) {
				echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act=in&amp;', $start, $total, $kmess);
				echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
			}
		}
		else {
			echo '<div class="rmenu">Входящих сообщений нет!</div>';
		}
		echo '<div class="menu"><a href="'.$home.'/str/pochta.php?act=add">Отправить письмо</a></div>';
		echo '<div class="menu"><a href="'.$home .'/str/pochta.php">Назад</a></div>';
	}
	elseif($act == 'spam' || ($act == 'allspam' && $rights>=7)) {
		echo '<div class="phdr"><h3>Сообщения определенные как спам</h3></div>';
		$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_msg` WHERE ".(($act == 'allspam' && $rights>=7)?'':'`id_kont`=' . $user_id . ' AND `sys`=1 AND `delete`!=' . $user_id . ' AND')." `spam`='2'"), 0);
		if($total > 0) {
			$req = mysql_query("SELECT * FROM `mail_msg` WHERE ".(($act == 'allspam' && $rights>=7)?'':'`id_kont`=' . $user_id . ' AND `sys`=1 AND `delete`!=' . $user_id . ' AND')." `spam`='2' ORDER BY `time` DESC LIMIT $start, $kmess");
			echo '<form action="'.$home.'/str/pochta.php?act=masspam" method="post">';
			while($row = mysql_fetch_assoc($req)) {
				$text = '';
				$result = mysql_query('SELECT * FROM `users` WHERE `id` = ' . $row['id_user']);
				if(mysql_num_rows($result))
					$res = mysql_fetch_assoc($result);
				else {
					$res['name'] = $row['from'];
					$res['id'] = $row['id_user'];
					$res['ip'] = $row['ip'];
					$res['browser'] = $row['ua'];
				}
				echo ($i % 2) ? '<div class="list2">':'<div class="list1">';
				if($act == 'allspam' && $rights>=7) {
					$text = checkout($row['msg'], 1, 1);
					if ($set_user['smileys'])
                        $text = smileys($text, $res['rights'] >= 1 ? 1 : 0);
					$subtext = '<input type="checkbox" name="delmes[]" value="' . $row['id'] . '"/>&nbsp;<a href="'.$home.'/str/pochta.php?act=add&amp;id='.$res['id'].'">Ответить</a> | <a href="'.$home.'/str/pochta.php?act=del&amp;id='.$row['id'].'">Удалить</a>';
				}
				else {
					if($row['read']==1) $text .='Не прочитано!<br />';
					if($row['file']) $text .='+ Вложение<br />';
					$subtext = '<input type="checkbox" name="delmes[]" value="' . $row['id'] . '"/>&nbsp;<a href="'.$home.'/str/pochta.php?act=read&amp;id='.$row['id'].'">Читать</a> | <a href="'.$home.'/str/pochta.php?act=add&amp;id='.$res['id'].'">Ответить</a> | <a href="'.$home.'/str/pochta.php?act=del&amp;id='.$row['id'].'">Удалить</a>';
				}
				echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), '[' . date('d.m.o в H:i',$row['time']) . ']', $text, $subtext);
				
				echo '</div>';
				++$i;
			}
			echo '<div class="rmenu"><input type="submit" value="Удалить отмеченные"/></div>';
			echo '</form>';
			echo '<div class="phdr">Всего: ' . $total . '</div>';
			if ($total > $kmess) {
				echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act='.(($act == 'allspam' && $rights>=7)?'allspam':'spam').'&amp;', $start, $total, $kmess);
				echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
			}
		}
		else {
			echo '<div class="rmenu">Входящих сообщений нет!</div>';
		}
		echo '<div class="menu"><a href="'.$home.'/str/pochta.php?act=add">Отправить письмо</a></div>';
		echo '<div class="menu"><a href="'.$home .'/str/pochta.php">Назад</a></div>';
	}
	else if($act == 'out') {
		echo '<div class="phdr"><h3>Исходящие сообщения</h3></div>';
		$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `sys`=1 AND `delete`!='" . $user_id . "'"), 0);
		if($total > 0) {
			$req = mysql_query("SELECT * FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `sys`=1 AND `delete`!='" . $user_id . "' ORDER BY `time` DESC LIMIT $start, $kmess");
			echo '<form action="'.$home.'/str/pochta.php?act=massout" method="post">';
			while($row = mysql_fetch_assoc($req)) {
				$text = '';
				$result = mysql_query('SELECT * FROM `users` WHERE `id` = ' . $row['id_kont']);
				if(mysql_num_rows($result))
					$res = mysql_fetch_assoc($result);
				else {
					$res['name'] = $row['from_out'];
					$res['id'] = $row['id_kont'];
					$res['ip'] = $row['ip'];
					$res['browser'] = $row['ua'];
				}echo ($i % 2) ? '<div class="list2">':'<div class="list1">';
				if($row['read']==1) $text .='Не прочитано!<br />';
				if($row['file']) $text .='+ Вложение<br />';
				$subtext = '<input type="checkbox" name="delmes[]" value="' . $row['id'] . '"/>&nbsp;<a href="'.$home.'/str/pochta.php?act=read&amp;id='.$row['id'].'">Читать</a> | <a href="'.$home.'/str/pochta.php?act=add&amp;id='.$res['id'].'">Написать</a> | <a href="'.$home.'/str/pochta.php?act=del&amp;id='.$row['id'].'">Удалить</a> | <a href="'.$home.'/str/pochta.php?act=history&amp;id='.$res['id'].'">История</a>';
				echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), '[' . date('d.m.o в H:i',$row['time']) . ']', $text, $subtext);
				echo '</div>';
				++$i;
			}
			echo '<div class="rmenu"><input type="submit" value="Удалить отмеченные"/></div>';
			echo '</form>';
			echo '<div class="phdr">Всего: ' . $total . '</div>';
			if ($total > $kmess) {
				echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act=out&amp;', $start, $total, $kmess);
				echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
			}
		}
		else {
			echo '<div class="rmenu">Исходящих сообщений нет!</div>';
		}
		echo '<div class="menu"><a href="'.$home.'/str/pochta.php?act=add">Отправить письмо</a></div>';
		echo '<div class="menu"><a href="'.$home .'/str/pochta.php">Назад</a></div>';
	}
	else if($act == 'contacts') {
		echo '<div class="phdr"><h3>Контакты</h3></div>';
		$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_konts` WHERE `id_user`='" . $user_id . "' AND `type`='1'"), 0);
		if($total > 0) {
			$req = mysql_query("SELECT * FROM `mail_konts` WHERE `id_user`='" . $user_id . "' AND `type`='1' ORDER BY `time` DESC LIMIT $start, $kmess");
			while($row = mysql_fetch_assoc($req)) {
				$result = mysql_query('SELECT * FROM `users` WHERE `id` = ' . $row['id_kont']);
				if(mysql_num_rows($result))
					$res = mysql_fetch_assoc($result);
				else {
					$res['name'] = $row['from_out'];
					$res['id'] = $row['id_kont'];
					$res['ip'] = $row['ip'];
					$res['browser'] = $row['ua'];
				}
				echo ($i % 2) ? '<div class="list2">':'<div class="list1">';
				$subtext = '<a href="'.$home.'/str/pochta.php?act=add&amp;id='.$res['id'].'">Написать</a> | <a href="'.$home.'/str/pochta.php?act=delete&amp;id='.$row['id'].'">Удалить</a>';
				echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), NULL, NULL, $subtext);
				echo '</div>';
				++$i;
			}
			echo '<div class="phdr">Всего: ' . $total . '</div>';
			if ($total > $kmess) {
				echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act=contacts&amp;', $start, $total, $kmess);
				echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
			}
		}
		else {
			echo '<div class="rmenu">Контакт лист пуст!</div>';
		}
		echo '<div class="bmenu"><a href="'.$home .'/index.php?act=cab">Кабинет</a></div>';
	}
	else if($act == 'ignor') {
		echo '<div class="phdr"><h3>В игноре</h3></div>';
		$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_konts` WHERE `id_user`='" . $user_id . "' AND `type`='2'"), 0);
		if($total > 0) {
			$req = mysql_query("SELECT * FROM `mail_konts` WHERE `id_user`='" . $user_id . "' AND `type`='2' ORDER BY `time` DESC LIMIT $start, $kmess");
			while($row = mysql_fetch_assoc($req)) {
				$result = mysql_query('SELECT * FROM `users` WHERE `id` = ' . $row['id_kont']);
				if(mysql_num_rows($result))
					$res = mysql_fetch_assoc($result);
				else {
					$res['name'] = $row['from_out'];
					$res['id'] = $row['id_kont'];
					$res['ip'] = $row['ip'];
					$res['browser'] = $row['ua'];
				}echo ($i % 2) ? '<div class="list2">':'<div class="list1">';
				$subtext = '<a href="'.$home.'/str/pochta.php?act=delete&amp;id='.$row['id'].'">Удалить</a>';
				echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), NULL, NULL, $subtext);
				echo '</div>';
				++$i;
			}
			echo '<div class="phdr">Всего: ' . $total . '</div>';
			if ($total > $kmess) {
				echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act=ignor&amp;', $start, $total, $kmess);
				echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
			}
		}
		else {
			echo '<div class="rmenu">Игнор лист пуст!</div>';
		}
		echo '<div class="bmenu"><a href="'.$home.'/index.php?act=cab">Назад</a></div>';
	}
	else if($act == 'add') {
		echo '<div class="phdr"><h3>Написать сообщение</h3></div>';
		
		$flood = antiflood();
		if($flood){
			echo '<div class="rmenu">Вы не можете так часто добавлять сообщения<br />Пожалуйста, подождите ' . $flood . ' сек.</div>';
			require_once('../incfiles/end.php');
			exit;
		}
		
		if($ban[3]){
			$req = mysql_query("SELECT * FROM `cms_ban_users` WHERE `user_id`='$user_id' AND `ban_type`='3' ORDER BY `ban_while` DESC LIMIT 1");
			if (mysql_num_rows($req)) {
				$res = mysql_fetch_assoc($req);
				echo '<div class="rmenu">Отправка почты заблокирована<br />
				Срок: ' . timecount($res['ban_time'] - $res['ban_while']) . '<br />
				Осталось: ' . timecount($res['ban_time'] - $realtime) . '</div>';
				require_once('../incfiles/end.php');
				exit;
			}
		}
		
		if(!isset($_POST['submit'])) {
			echo '<form enctype="multipart/form-data" method="post" action="' . $home . '/str/pochta.php?act=add' . (!$id?'':'&amp;id='.$id) . '"><div class="menu">';
			if(!$id) {
				echo '<strong>Логин:</strong> (2-15)<br />
				<input type="text" name="login" maxlength="15"/><br />';
			}
			echo '<strong>Сообщение:</strong> (4-1024)<br />
			<textarea rows="4" cols="25" name="text"></textarea><br/>
			Прикрепить файл:<br/>';
			if (!preg_match("~Opera/8.01~", $agent)) {
				echo '<input type="file" name="fail"/><br/>';
			}
			else {
				echo '<input name="fail1" value =""/>&nbsp;<br/><a href="op:fileselect">Выбрать файл</a><br/>';
			}
			echo '<input type="submit" name="submit" value="Написать"/>
			</div></form>';
			echo '<div class="bmenu"><a href="' . $home . '/str/pochta.php">Назад</a></div>';
		}
		else {
			$text = trim($_POST['text']);
			$error = array();
			if ($id) {
				$req = mysql_query("SELECT * FROM `users` WHERE `id`='" . $id . "';");
				if(mysql_num_rows($req) == 0)
					$error[] = 'Пользователя не существует!';
				else {
					$row = mysql_fetch_assoc($req);
				}
			}
			else {
				$name = check($_POST['login']);
			}
			
			if (!$id) {
				$req = mysql_query("SELECT * FROM `users` WHERE `name_lat`='" . mysql_real_escape_string($name) . "';");
				if(mysql_num_rows($req) == 0)
					$error[] = 'Пользователя не существует!';
				else {
					$row = mysql_fetch_assoc($req);
					$id = $row['id'];
				}
			}
			
			if ($id==$user_id)
				$error[] = 'Самому себе писать нельзя';
			
			if (!$text)
				$error[] = 'Вы не ввели сообщение!';
			else if (mb_strlen($text) > 1024)
				$error[] = 'Слишком длинное сообщение! (Максимум 1024 символа).';
			if (mb_strlen($text) < 4)
				$error[] = 'Слишком короткое сообщение! (Минимум 4 символа).';
				
			if(!$error) {
				if(mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_konts` WHERE `id_user`='" . $id . "' AND `id_kont`='" . $user_id . "' AND `type`='2';"), 0)!=0)
					$error[] = 'Вы не можете писать данному пользователю! Пользователь добавил вас в игнор.';
				if(mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_konts` WHERE `id_user`='" . $user_id . "' AND `id_kont`='" . $id . "' AND `type`='2';"), 0)!=0)
					$error[] = 'Вы не можете писать данному пользователю! Он находится у Вас в игноре.';
			}
			
			if (!$error) {
				if($rights == 0) {
					
					$array_spam = array();
					$req = mysql_query("SELECT * FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `read`='1' AND `time`>'" . ($realtime-$spam['block']) . "'");
					
					while($results = mysql_fetch_assoc($req)) {
						$array_spam[] = $results['id_kont'];
					}
					
					if (count(array_count_values($array_spam))>=$spam['msg']) {
						mysql_query("INSERT INTO `cms_ban_users` SET
						`user_id` = '$user_id',
						`ban_time` = '" . ($realtime + $spam['time']*3600) . "',
						`ban_while` = '$realtime',
						`ban_type` = '3',
						`ban_who` = 'Система антиспама',
						`ban_reason` = 'Подозрение на рассылку СПАМа'") or die('error');
						mysql_query("UPDATE `mail_msg` SET
						`spam` = '2' WHERE `id_user`='" . $user_id . "' AND `read`='1' AND `time`>'" . ($realtime-1800) . "'");
						$error[] = 'Подозрение на рассылку СПАМа, отправка почты для Вашей учетной записи заблокирована на '.$spam['time'].' час.<br />
						Информация отправлена администратору';
					}
					
				}
			}
			
			if (!$error) {
				////////////////////////////////////////////////////////////
				// Список расширений файлов, разрешенных к выгрузке       //
				////////////////////////////////////////////////////////////
				// Файлы Windows
				$ext_win = array (
					'exe',
					'msi'
				);
				// Файлы Java
				$ext_java = array (
					'jar',
					'jad'
				);
				// Файлы SIS
				$ext_sis = array (
					'sis',
					'sisx'
				);
				// Файлы документов и тексты
				$ext_doc = array (
					'txt',
					'pdf',
					'doc',
					'rtf',
					'djvu',
					'xls'
				);
				// Файлы картинок
				$ext_pic = array (
					'jpg',
					'jpeg',
					'gif',
					'png',
					'bmp',
					'wmf'
				);
				// Файлы архивов
				$ext_zip = array (
					'zip',
					'rar',
					'7z',
					'tar',
					'gz'
				);
				// Файлы видео
				$ext_video = array (
					'3gp',
					'avi',
					'flv',
					'mpeg',
					'mp4'
				);
				// Звуковые файлы
				$ext_audio = array (
					'mp3',
					'amr'
				);
				// Другие типы файлов (что не перечислены выше)
					
				$ext_other = array ();
					
				$do_file = false;
				$do_file_mini = false;
				if ($_FILES['fail']['size'] > 0) {
					// Проверка загрузки с обычного браузера
					$do_file = true;
					$file_name = strtolower($_FILES['fail']['name']);
					$fsize = $_FILES['fail']['size'];
				}
				elseif (strlen($_POST['fail1']) > 0) {
					// Проверка загрузки с Opera Mini
					$do_file_mini = true;
					$array = explode('file=', $_POST['fail1']);
					$file_name = strtolower($array [0]);
					$filebase64 = $array [1];
					$fsize = strlen(base64_decode($filebase64));
				}
				////////////////////////////////////////////////////////////
				// Обработка файла (если есть)                            //
				////////////////////////////////////////////////////////////
				if ($do_file || $do_file_mini) {
					$file_name = $_FILES['fail']['name'];
					$safe_name = true; //Замена не желательных символов в файле (true-включено, false-выключено)
					$file_auto_rename = true; //Автоматическая подстановка префикса если такой файл уже имеется (true-включено, false-выключено)
					$convert_file_name_type = 1; //Если поставить 0, то префикс автоматической подстановки будит без Copy_
					$convert_script_ext = false; //Если файл является скриптом, то добавляем ему расширение txt (true-включено, false-выключено)
					$max_file_size = 1024 * $flsz;
						
						
					$x = explode( '.', $file_name );
					$ext = end( $x );
						
					if($convert_script_ext) {
						if(preg_match('/(php|pl|py|cgi|asp)$/i', $ext)	 || empty($ext)) {
							$ext = 'txt';
							$file_name = $file_name . '.' . $ext;
						}
					}
					$new_name_file = str_replace('.'.$ext,'',$file_name);
						
					if ($safe_name) {
						$new_name_file = preg_replace('/[^A-Za-z0-9_]/', '_', $new_name_file);
						$new_name_file = preg_replace('/_{2,}/', '_', $new_name_file);
					}
						
					// Список допустимых расширений файлов.
					$al_ext = array_merge($ext_win, $ext_java, $ext_sis, $ext_doc, $ext_pic, $ext_zip, $ext_video, $ext_audio, $ext_other);
						
					// Проверка на допустимый размер файла
					$error = array();
					if ($fsize > $max_file_size)
						$error[] = 'Вес файла превышает ' . formatsize($max_file_size);
						
					if (!@chmod('../files/pochta/', 0777))
						$error[] = 'Директория назначения закрыта для записи. Невозможно продолжить процесс.';
						
					// Проверка файла на наличие только одного расширения
					if (count($x) != 2)
						$error[] = 'Неправильное имя файла!<br />К отправке разрешены только файлы имеющие имя и одно расширение (<b>name.ext</b>). Запрещены файлы не имеющие имени, расширения, или с двойным расширением.<br />';
					// Проверка допустимых расширений файлов
					if (!in_array($ext, $al_ext))
						$error[] = 'Запрещенный тип файла!<br />К отправке разрешены только файлы, имеющие следующее расширение:<br />' . implode(', ', $al_ext);
					// Проверка на длину имени
					if (strlen($new_name_file) > 30)
						$error[] = 'Длина названия файла не должна превышать 30 символов!';
							
					// Проверка на запрещенные символы
					if (preg_match("/[^a-z0-9.()+_-]/", $new_name_file))
						$error[] = 'В названии файла присутствуют недопустимые символы.<br />Разрешены только латинские символы, цифры и некоторые знаки ( .()+_- )<br />Запрещены пробелы.';
					// Проверка наличия файла с таким же именем
					if(!$error) {
						$name_convert = $new_name_file.'.'.$ext;
						if($file_auto_rename) {
							$i = 1;
							while (@file_exists('../files/pochta/'.$name_convert)) {
								$name_convert = ($convert_file_name_type == 1 ? 'Copy_':'').'' . $i . '_' . $new_name_file . '.'.$ext;
								$i++;
							}
						}
						else {
							if (file_exists('../files/pochta/' . $name_convert)) {
								$name_convert = $realtime . $name_convert;
							}
						}
					}
					// Окончательная обработка
					if(!$error) {
						if ($do_file) {
							// Для обычного браузера
							if ((move_uploaded_file($_FILES['fail']['tmp_name'], '../files/pochta/'.$name_convert)) == true) {
								@ chmod($name_convert, 0777);
								@ chmod('../files/pochta/'.$name_convert, 0777);
								$ok_file = '<div class="menu">Файл прикреплен!</div>';
							}
							else {
								$err_file = 'Ошибка прикрепления файла.';
							}
						}
						elseif ($do_file_mini) {
							// Для Opera Mini
							if (strlen($filebase64) > 0) {
								$FileName = '../files/pochta/' . $name_convert;
								$filedata = base64_decode($filebase64);
								$fid = @ fopen($FileName, "wb");
								if ($fid) {
									if (flock($fid, LOCK_EX)) {
										fwrite($fid, $filedata);
										flock($fid, LOCK_UN);
									}
									fclose($fid);
								}
								if (file_exists($FileName) && filesize($FileName) == strlen($filedata)) {
									$ok_file = '<div class="menu">Файл прикреплен!</div>';
								}
								else {
									$err_file = 'Ошибка прикрепления файла.';
								}
							}
						}
					}
					else {
						$err_file = implode('<br/>',$error);
					}
				}
			}
			if (!$error) {
				mysql_query("INSERT INTO `mail_msg` SET
				`id_user`='" . $user_id . "',
				`id_kont`='" . $id . "',
				`time`='" . $realtime . "',
				`from`='" . mysql_real_escape_string($login) . "',
				`from_out`='" . mysql_real_escape_string($row['name']) . "',
				`msg`='" . mysql_real_escape_string($text) . "',
				`file`='" . mysql_real_escape_string($name_convert) . "',
				`ip`='$ipl',
				`ua`='" . mysql_real_escape_string($agn) . "';");
				
				mysql_query("UPDATE `users` SET
				`lastpost` = '" . $realtime . "' WHERE `id` = '" . $user_id . "' LIMIT 1");
					
				if($err_file) {
					echo '<div class="rmenu">Файл не отправлен! '.$err_file.'</div>';
				}
				if($ok_file) {
					echo $ok_file;
				}
				echo '<div class="menu">Сообщение отправлено</div>';
				echo '<div class="bmenu"><a href="'.$home.'/str/pochta.php">Назад</a> | <a href="'.$home.'/str/pochta.php?act=history&amp;id='.$id.'">История</a></div>';
			}
			else {
				echo '<div class="rmenu">'.implode('<br/>',$error).'</div>';
				echo '<div class="bmenu"><a href="'.$home.'/str/pochta.php?act=add' . (!$id?'':'&amp;id='.$id) . '">Назад</a></div>';
			}
		}
	}
	else if($act == 'read') {
		mysql_query("UPDATE `mail_msg` SET `read` = '2' WHERE `id`='" . $id . "' AND `id_kont` = '" . $user_id . "' AND `read` != '2' LIMIT 1");
		$count_msg = @ mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_msg` WHERE `id_kont`=' . $user_id . ' AND `read`=1 AND `spam`=1 AND `delete`!=' . $user_id), 0);
		if($count_msg > 0 && $user_id)
			echo '<div class="menu"><strong><a href="' . $home . '/str/pochta.php?act=new"><span style="color:red;">Новое сообщение [' . $count_msg . ']</span></a></strong></div>';
		echo '<div class="phdr"><h3>Чтение сообщения</h3></div>';
		$result = mysql_query("SELECT * FROM `mail_msg` WHERE `id`='" . $id . "' AND (`id_kont`='" . $user_id . "' OR `id_user`='$user_id') AND `delete`!='" . $user_id . "';");
		$req = mysql_num_rows($result);
		if($req==0)  {
			echo '<div class="rmenu">Сообщения не существует!</div>';
			echo '<div class="bmenu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
		}
		else {
			
			$row = mysql_fetch_assoc($result);
			$result = mysql_query('SELECT * FROM `users` WHERE `id` = ' . $row['id_user']);
			if(mysql_num_rows($result))
				$res = mysql_fetch_assoc($result);
			else {
				$res['name'] = $row['from'];
				$res['id'] = $row['id_user'];
				$res['ip'] = $row['ip'];
				$res['browser'] = $row['ua'];
			}
			echo '<div class="menu">';
			$text  = checkout($row['msg'], 1, 1);
			if ($set_user['smileys'])
				$text = smileys($text, $res['rights'] >= 1 ? 1 : 0);
			if(!empty($row['file']) && file_exists('../files/pochta/'.$row['file'])) {
				$text .='<br /><span class="quote">Файл: <a href="'.$home.'/files/pochta/' . $row['file'] . '">' . $row['file'] . '</a> [' . formatsize(@filesize('../files/pochta/'.$row['file'])) . ']</span>';
			}
			$subtext = ($row['sys']==1 && $user_id!=$row['id_user'] ? '<a href="'.$home.'/str/pochta.php?act=add&amp;id='.$res['id'].'">Ответить</a> | <a href="'.$home.'/str/pochta.php?act=history&amp;id='.$res['id'].'">История</a> | ':'').'<a href="'.$home.'/str/pochta.php?act=del&amp;id='.$row['id'].'">Удалить</a>';
			if($row['sys']==2) {
				echo '<strong>Системное сообщение</strong> [' . date('d.m.o в H:i',$row['time']) . ']<br />
				'.$text.'<br />
				<div class="sub">'.$subtext.'</div>';
			}
			else {
				echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), '[' . date('d.m.o в H:i',$row['time']) . ']', $text, $subtext);
			}
			echo '</div>';
			echo '<div class="menu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
		}
	}
	else if($act == 'systems') {
		echo '<div class="phdr"><h3>Системные сообщения</h3></div>';
		$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_msg` WHERE `id_kont`='" . $user_id . "' AND `sys`=2 AND `delete`!='" . $user_id . "'"), 0);
		if($total > 0) {
			$req = mysql_query("SELECT * FROM `mail_msg` WHERE `id_kont`='" . $user_id . "' AND `sys`=2 AND `delete`!='" . $user_id . "' ORDER BY `time` DESC LIMIT $start, $kmess");
			while($row = mysql_fetch_assoc($req)) {
				echo ($i % 2) ? '<div class="list2">':'<div class="list1">';
				if($row['read']==1)	{
					mysql_query("UPDATE `mail_msg` SET `read` = '2' WHERE `id`='" . $row['id'] . "' AND `id_kont` = '" . $user_id . "' AND `sys`='2' LIMIT 1");
				}
				echo '[' . date('d.m.o в H:i',$row['time']) . ']<br />';
				echo checkout($row['tema'],1,1) . '<br />';
				if($row['read']==1) echo 'Не прочитано!<br />';
				echo '<a href="'.$home.'/str/pochta.php?act=read&amp;id='.$row['id'].'">Читать</a> | <a href="'.$home.'/str/pochta.php?act=del&amp;id='.$row['id'].'">Удалить</a>';
				echo '</div>';
				++$i;
			}
			echo '<div class="phdr">Всего: ' . $total . '</div>';
			if ($total > $kmess) {
				echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act=systems&amp;', $start, $total, $kmess);
				echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
			}
		}
		else {
			echo '<div class="rmenu">Системных сообщений нет!</div>';
		}
		echo '<div class="menu"><a href="'.$home.'/index.php?act=cab">Назад</a></div>';
	}
	else if($act == 'delete' && $id) {
		echo '<div class="phdr"><h3>Удаление контакта</h3></div>';
		if(mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_konts` WHERE `id` = ' . $id . ' AND `id_user` = ' . $user_id), 0)==0){
			echo '<div class="rmenu">Ошибка! Не верный ID контакта.</div>';
		}
		else {
			mysql_query('DELETE FROM `mail_konts` WHERE `id` = ' . $id . ' AND `id_user` = ' . $user_id . ' LIMIT 1;');
			echo '<div class="menu">Контакт удален</div>';
		}
		echo '<div class="menu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
	}
	else if($act == 'del' && $id) {
		echo '<div class="phdr"><h3>Удаление сообщения</h3></div>';
		if (mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_msg` WHERE " . ($rights>=7 ? '':'`id_user` = ' . $user_id . ' AND `id`=' . $id . ' or `id_kont`=' . $user_id . ' AND')." `id`='" . $id . "'"), 0)==0) {
			echo '<div class="rmenu">Сообщения не существует</div>';
			echo '<div class="menu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
		}
		else {
			$row = mysql_fetch_assoc(mysql_query("SELECT * FROM `mail_msg` WHERE ".($rights>=7 ? '':'`id_user`=' . $user_id . ' AND `id`=' . $id . ' or `id_kont`=' . $user_id . ' AND')." `id`='" . $id . "';"));
			if(!isset($_POST['submit'])) {
				echo '<div class="rmenu">Подтвердите удаление</div>';
				echo '<form action="'.$home.'/str/pochta.php?act=del&amp;id=' . $id . '" method="post"><div class="menu">
				<input type="submit" name="submit" value="Удалить"/></div></form>';
				echo '<div class="menu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
			}
			else {
				if($row['spam']==2 && $rights>=7) {
					mysql_query("DELETE FROM `mail_msg` WHERE `spam`='2' AND `id`='".$id."' LIMIT 1;");
					if($row['file'])
						@unlink('../files/pochta/' . $row['file']);
				}
				else {
					if($row['sys']==2) {
						mysql_query("DELETE FROM `mail_msg` WHERE `id_kont`='" . $user_id . "' AND `sys`=2 AND `delete`!='" . $user_id . "' AND `id`='$id' LIMIT 1;");
						if($row['file']) 
							@unlink('../files/pochta/' . $row['file']);
					}
					else if(!empty($row['delete']) && $row['delete'] != $user_id) {
						mysql_query("DELETE FROM `mail_msg` WHERE `id`='".$id."' AND `id_user`='$user_id' OR `id`='$id' AND `id_kont`='" . $user_id . "' LIMIT 1;");
						if($row['file']) 
							@unlink('../files/pochta/' . $row['file']);
					}
					else {
						mysql_query("UPDATE `mail_msg` SET
						`delete`='".$user_id."',
						`read`='".($row['id_user']==$user_id ? 1:2)."'
						WHERE `id`='".$id."' AND `id_user`='$user_id' or `id`='".$id."' AND `id_kont`='" . $user_id . "';");
					}
				}
				echo '<div class="menu">Сообщение удалено</div>';
				echo '<div class="menu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
			}
		}
	}
	else if($act == 'new') {
		echo '<div class="phdr"><h3>Непрочитанные сообщения</h3></div>';
		$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_msg` WHERE `id_kont`='" . $user_id . "' AND `read`='1' AND `spam`='1'"), 0);
		if($total > 0) {
			$req = mysql_query("SELECT * FROM `mail_msg` WHERE `id_kont`='" . $user_id . "' AND `read`='1' AND `spam`='1' ORDER BY `time` DESC LIMIT $start, $kmess");
			while($row = mysql_fetch_assoc($req)) {
				echo ($i % 2) ? '<div class="list2">':'<div class="list1">';
				if($row['file']) $text = '+ Вложение<br />';
				$subtext = '<a href="'.$home.'/str/pochta.php?act=read&amp;id='.$row['id'].'">Читать</a>'.($row['sys'] == 2?'':' | <a href="'.$home.'/str/pochta.php?act=add&amp;id='.$row['id_user'].'">Ответить</a>').' | <a href="'.$home.'/str/pochta.php?act=del&amp;id='.$row['id'].'">Удалить</a>';
				
				if($row['sys'] == 1) {
					$result = mysql_query('SELECT * FROM `users` WHERE `id` = ' . $row['id_user']);
					if(mysql_num_rows($result))
						$res = mysql_fetch_assoc($result);
					else {
						$res['name'] = $row['from'];
						$res['id'] = $row['id_user'];
						$res['ip'] = $row['ip'];
						$res['browser'] = $row['ua'];
					}
					echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), '[' . date('d.m.o в H:i',$row['time']) . ']', $text, $subtext);
				}
				
				if($row['sys'] == 2) {
					echo $row['tema'].' [' . date('d.m.o в H:i',$row['time']) . ']<br />';
					echo 'Системное сообщение<br />';
					echo '<div class="sub">'.$subtext.'</div>';
				}
				
				echo '</div>';
				++$i;
			}
			echo '<div class="phdr">Всего: ' . $total . '</div>';
			if ($total > $kmess) {
				echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act=new&amp;', $start, $total, $kmess);
				echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
			}
		}
		else {
			echo '<div class="rmenu">Новых сообщений нет!</div>';
		}
		echo '<div class="menu"><a href="'.$home.'/str/pochta.php?act=add">Отправить письмо</a></div>';
		echo '<div class="menu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
	}
	else if($act == 'addcont' && $id) {
		echo '<div class="phdr"><h3>Добавление контакта</h3></div>';
		if(mysql_result(mysql_query('SELECT COUNT(*) FROM `users` WHERE `id` = ' . $id), 0)==0){
			echo '<div class="rmenu">Пользователя не существует!</div>';
		}
		else {
			if($id != $user_id) {
				if(mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_konts` WHERE `id_user` = ' . $user_id . ' AND `id_kont`=' . $id . ''), 0)==0){
					mysql_query("INSERT INTO `mail_konts` SET
					`id_user`='$user_id',
					`id_kont`='$id',
					`time`='$realtime'");
					$text = '[url='.$home.'/str/anketa.php?id='.$user_id.']'.$login.'[/url]';
					$site = '[url=http://upcoder.net/]upcoder.net[/url]';
					mysql_query("INSERT INTO `mail_msg` SET
					`id_kont`='" . $id . "',
					`tema`='Добавление в контакты',
					`msg`='Пользователь, $text добавил Вас в контакты\r\nСлужба информации $site!',
					`time`='$realtime',
					`sys`='2'");
					echo '<div class="menu">Пользователь добавлен в контакт лист</div>';
				}
				else {
					mysql_query("UPDATE `users` SET
					`type` = '1'
					WHERE `id_user` = '" . $user_id . "' AND `id_kont`='" . $id . "' LIMIT 1");
					echo '<div class="menu">Пользователь добавлен в контакт лист</div>';
				}
			}
			else {
				echo '<div class="rmenu">Себя нельзя добавить в контакт лист</div>';
			}
		}
		echo '<div class="menu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
	}
	else if($act == 'addignor' && $id) {
		echo '<div class="phdr"><h3>Добавление в игнор-лист</h3></div>';
		$req = mysql_query("SELECT * FROM `users` WHERE `id`='" . $id . "';");
		if(mysql_num_rows($req) == 0) {
			echo '<div class="rmenu">Пользователя не существует!</div>';
		}
		else {
			$row = mysql_fetch_assoc($req);
			if($row['rights']>0) {
				echo '<div class="rmenu">Администрацию нельзя добавлять в игнор!</div>';
			}
			else {
				if($id != $user_id) {
					if(mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_konts` WHERE `id_user` = ' . $user_id . ' AND `id_kont`=' . $id), 0)==0){
						mysql_query("INSERT INTO `mail_konts` SET
						`id_user`='$user_id',
						`id_kont`='$id',
						`time`='$realtime',
						`type`='2'");
						$text = '[url='.$home.'/str/anketa.php?id='.$user_id.']'.$login.'[/url]';
						$site = '[url=http://upcoder.net/]upcoder.net[/url]';
						mysql_query("INSERT INTO `mail_msg` SET
						`id_kont`='" . $id . "',
						`tema`='Добавление в игнор',
						`msg`='Пользователь, $text добавиль Вас в игнор\r\nСлужба информации $site!',
						`time`='$realtime',
						`sys`='2'");
						echo '<div class="menu">Пользователь добавлен в игнор-лист</div>';
					}
					else {
						mysql_query("UPDATE `users` SET
						`type` = '2'
						WHERE `id_user` = '" . $user_id . "' AND `id_kont`='" . $id . "' LIMIT 1");
						echo '<div class="menu">Пользователь добавлен в игнор-лист</div>';
					}
				}
				else {
					echo '<div class="rmenu">Себя нельзя добавить в игнор-лист</div>';
				}
			}
		}
		echo '<div class="menu"><a href="'.$home.'/str/pochta.php">Назад</a></div>';
	}
	else if($act == 'history') {
		$req = mysql_query("SELECT * FROM `users` WHERE `id`='" . $id . "';");
		if(mysql_num_rows($req) == 0) {
			echo '<div class="rmenu">Пользователя не существует!</div>';
		}
		else {
			$row = mysql_fetch_assoc($req);
			echo '<div class="phdr"><h3>История переписки с ' . $row['name'] . '</h3></div>';
			$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `id_kont`='" . $id . "' AND `delete`!='" . $user_id . "' AND `sys`='1' AND `spam`='1' OR `id_user`='" . $id . "' AND `id_kont`='" . $user_id . "' AND `delete`!='" . $user_id . "' AND `sys`='1' AND `spam`='1'"), 0);
			if($total > 0) {
				$req = mysql_query("SELECT * FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `id_kont`='" . $id . "' AND `delete`!='" . $user_id . "' AND `sys`='1' AND `spam`='1' OR `id_user`='" . $id . "' AND `id_kont`='" . $user_id . "' AND `delete`!='" . $user_id . "' AND `sys`='1' AND `spam`='1' ORDER BY `time` DESC LIMIT $start, $kmess");
				while($row = mysql_fetch_assoc($req)) {
					echo ($i % 2) ? '<div class="list2">':'<div class="list1">';
					$result = mysql_query('SELECT * FROM `users` WHERE `id` = ' . $row['id_user']);
					if(mysql_num_rows($result))
						$res = mysql_fetch_assoc($result);
					else {
						$res['name'] = $row['from'];
						$res['id'] = $row['id_user'];
						$res['ip'] = $row['ip'];
						$res['browser'] = $row['ua'];
					}
					$text  = checkout($row['msg'], 1, 1);
					if ($set_user['smileys'])
						$text = smileys($text, $res['rights'] >= 1 ? 1 : 0);
					$subtext = '<a href="'.$home.'/str/pochta.php?act=del&amp;id='.$row['id'].'">Удалить</a>';
					echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), '[' . date('d.m.o в H:i',$row['time']) . ']', $text, $subtext);
					
					if(!empty($row['file']) && file_exists('../files/pochta/'.$row['file'])) {
						echo '<div class="func">Файл: <a href="'.$home.'/files/pochta/' . $row['file'] . '">' . $row['file'] . '</a> [' . formatsize(@filesize('../files/pochta/'.$row['file'])) . ']</div>';
					}
					if($row['id_user']!=$user_id && $row['read']==1)
						mysql_query("UPDATE `mail_msg` SET `read`='2' WHERE `id`='".$row['id']."' AND `id_user`!='$user_id' LIMIT 1");
					echo '</div>';
					++$i;
					
				}
				echo '<div class="phdr">Всего: ' . $total . '</div>';
				if ($total > $kmess) {
					echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act=history&amp;id='.$id.'&amp;', $start, $total, $kmess);
					echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
				}
				echo '<div class="menu"><a href="'.$home.'/str/pochta.php?act=add&amp;id='.$id.'">Написать</a></div>';
			}
			else {
				echo '<div class="rmenu">Сообщений нет!</div>';
			}
			echo '<div class="bmenu"><a href="'.$home.'/index.php?act=cab">Назад</a></div>';
		}
	}
	else if($act == 'file') {
		echo '<div class="phdr"><h3>Файлы из писем</h3></div>';
		$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `sys`=1 AND `delete`!='" . $user_id . "' AND `file`!='' OR `id_kont`='" . $user_id . "' AND `sys`=1 AND `delete`!='" . $user_id . "' AND `file`!=''"), 0);
		if($total > 0) {
			$req = mysql_query("SELECT * FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `sys`=1 AND `delete`!='" . $user_id . "' AND `file`!='' OR `id_kont`='" . $user_id . "' AND `sys`=1 AND `delete`!='" . $user_id . "' AND `file`!='' LIMIT $start, $kmess");
			while($row = mysql_fetch_assoc($req)) {
				echo '<div class="menu">Файл: <a href="'.$home.'/files/pochta/' . $row['file'] . '">' . $row['file'] . '</a> [' . formatsize(filesize('../files/pochta/'.$row['file'])) . ']</div>';
			}
			echo '<div class="phdr">Всего: ' . $total . '</div>';
			if ($total > $kmess) {
				echo '<div class="menu">' . pagenav($home.'/str/pochta.php?act=file&amp;', $start, $total, $kmess);
				echo '<form action="" method="post"><p><input type="text" name="page" size="2"/><input type="submit" value="Перейти"/></p></form></div>';
			}
		}
		else {
			echo '<div class="rmenu">Файлов нет!</div>';
		}
		echo '<div class="bmenu"><a href="'.$home.'/index.php?act=cab">Назад</a></div>';
	}
	else if($act == 'masspam') {
		if (isset ($_GET['yes'])) {
			$dc = $_SESSION['dc'];
			$prd = $_SESSION['prd'];
			foreach ($dc as $delid) {
				$res = mysql_fetch_assoc(mysql_query("SELECT * FROM `mail_msg` WHERE ".($rights>=7?'`spam`=2 AND':'`id_user`='.$user_id.' AND `id`='.$delid.' AND `spam`=2 or `id_kont`='.$user_id.' AND `spam`=2 AND')." `id`='$delid';"));
				if ($rights>=7 || (!empty($res['delete']) && $res['delete']!=$user_id)) {
					mysql_query("DELETE FROM `mail_msg` WHERE ".($rights>=7?'`spam`=2 AND':'`id`='.$res['id'].' AND `id_user`='.$user_id.' AND `spam`=2 OR `id_kont`='.$user_id.' AND `spam`=2 AND')." `id`='{$res['id']}' LIMIT 1;");
					if($res['file'])
						@unlink('../files/pochta/' . $row['file']);
				}
				elseif(empty($res['delete']))
					mysql_query("UPDATE `mail_msg` SET  `delete` = '$user_id' WHERE `id`='{$res['id']}' AND `delete`='' AND `spam`='2' AND `id_user`='$user_id' OR `id`='{$res['id']}' AND `delete`='' AND `spam`='2' AND `id_kont`='$user_id';");
			}
			echo '<div class="menu">Отмеченные письма удалены</div>
			<div class="menu"><a href="' . $prd . '">Назад</a></div>';
			unset($_SESSION['dc']);
		}
		else {
			if (empty ($_POST['delmes'])) {
				echo '<div class="rmenu">Вы ничего не выбрали для удаления<br/>
				<a href="'.$home.'/str/pochta.php?act=spam">Назад</a></div>';
			}
			else {
				foreach ($_POST['delmes'] as $v) {
					$dc[] = abs(intval($v));
				}
				$_SESSION['dc'] = $dc;
				$_SESSION['prd'] = htmlspecialchars(getenv("HTTP_REFERER"));
				echo '<div class="rmenu">Вы уверены в удалении постов?<br/><a href="'.$home.'/str/pochta.php?act=masspam&amp;yes">Да</a> | <a href="'.$home.'/str/pochta.php?act=spam">Нет</a></div>';
			}
		}
	}
	else if($act == 'massout') {
		if (isset ($_GET['yes'])) {
			$dc = $_SESSION['dc'];
			$prd = $_SESSION['prd'];
			foreach ($dc as $delid) {
				$res = mysql_fetch_assoc(mysql_query("SELECT * FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `id`='" . $delid . "' or `id_kont`='" . $user_id . "' AND `id`='" . $delid . "';"));
				if (!empty($res['delete']) && $res['delete']!=$user_id) {
					mysql_query("DELETE FROM `mail_msg` WHERE `id`='".$res['id']."' AND `id_user`='$user_id' OR `id`='{$res['id']}' AND `id_kont`='" . $user_id . "' LIMIT 1;");
					if($res['file'])
						@unlink('../files/pochta/' . $row['file']);
				}
				elseif(empty($res['delete']))
					mysql_query("UPDATE `mail_msg` SET  `delete` = '" . $user_id . "' WHERE `id`='".$res['id']."' AND `delete`='' AND `id_user`='" . $user_id . "' OR `id`='".$res['id']."' AND `delete`='' AND `id_kont`='" . $user_id . "';");
			}
			echo '<div class="menu">Отмеченные письма удалены</div>
			<div class="menu"><a href="' . $prd . '">Назад</a></div>';
			unset($_SESSION['dc']);
		}
		else {
			if (empty ($_POST['delmes'])) {
				echo '<div class="rmenu">Вы ничего не выбрали для удаления<br/>
				<a href="'.$home.'/str/pochta.php?act=out">Назад</a></div>';
			}
			else {
				foreach ($_POST['delmes'] as $v) {
					$dc[] = abs(intval($v));
				}
				$_SESSION['dc'] = $dc;
				$_SESSION['prd'] = htmlspecialchars(getenv("HTTP_REFERER"));
				echo '<div class="rmenu">Вы уверены в удалении постов?<br/><a href="'.$home.'/str/pochta.php?act=massout&amp;yes">Да</a> | <a href="'.$home.'/str/pochta.php?act=out">Нет</a></div>';
			}
		}
	}
	else if($act == 'massin') {
		if (isset ($_GET['yes'])) {
			$dc = $_SESSION['dc'];
			$prd = $_SESSION['prd'];
			foreach ($dc as $delid) {
				$res = mysql_fetch_assoc(mysql_query("SELECT * FROM `mail_msg` WHERE `id_user`='" . $user_id . "' AND `id`='" . $delid . "' or `id_kont`='" . $user_id . "' AND `id`='" . $delid . "';"));
				if (!empty($res['delete']) && $res['delete']!=$user_id) {
					mysql_query("DELETE FROM `mail_msg` WHERE `id`='".$res['id']."' AND `id_user`='$user_id' OR `id`='{$res['id']}' AND `id_kont`='" . $user_id . "' LIMIT 1;");
					if($res['file'])
						@unlink('../files/pochta/' . $row['file']);
				}
				elseif(empty($res['delete']))
					mysql_query("UPDATE `mail_msg` SET `delete` = '" . $user_id . "' WHERE `id`='".$res['id']."' AND `delete`='' AND `id_user`='" . $user_id . "' OR `id`='".$res['id']."' AND `delete`='' AND `id_kont`='" . $user_id . "';");
			}
			echo '<div class="menu">Отмеченные письма удалены</div>
			<div class="menu"><a href="' . $prd . '">Назад</a></div>';
			unset($_SESSION['dc']);
		}
		else {
			if (empty ($_POST['delmes'])) {
				echo '<div class="rmenu">Вы ничего не выбрали для удаления<br/>
				<a href="'.$home.'/str/pochta.php?act=in">Назад</a></div>';
			}
			else {
				foreach ($_POST['delmes'] as $v) {
					$dc[] = abs(intval($v));
				}
				$_SESSION['dc'] = $dc;
				$_SESSION['prd'] = htmlspecialchars(getenv("HTTP_REFERER"));
				echo '<div class="rmenu">Вы уверены в удалении постов?<br/><a href="'.$home.'/str/pochta.php?act=massin&amp;yes">Да</a> | <a href="'.$home.'/str/pochta.php?act=in">Нет</a></div>';
			}
		}
	}
	elseif($act=='sending_out' && $rights == 9) {
		echo '<div class="phdr"><h3>Рассылка сообщений</h3></div>';
		if(!isset($_POST['submit'])) {
			echo '<form action="'.$home.'/str/pochta.php?act=sending_out" method="post"><div class="menu">
			<strong>Сообщение:</strong> (4-1024)<br />
			<textarea rows="4" cols="25" name="text"></textarea><br />
			<input type="radio" value="1" name="whom" checked="checked"/>&nbsp;Всем<br />
			<input type="radio" value="2" name="whom" />&nbsp;Только онлайн<br />
			<input type="submit" name="submit" value="Написать"/>
			</div></form>';
		}
		else {
			$text = isset($_POST['text']) ? trim($_POST['text']) : '';
			$whom = isset($_POST['whom']) && $_POST['whom']==1 ? 1 : 2;
			
			$error = array();
			
			if (!$text)
				$error[] = 'Вы не ввели сообщение!';
			else if (mb_strlen($text) > 1024)
				$error[] = 'Слишком длинное сообщение! (Максимум 1024 символа).';
			if (mb_strlen($text) < 4)
				$error[] = 'Слишком короткое сообщение! (Минимум 4 символа).';
				
			if(!$error) {
				
				$req = mysql_query("SELECT * FROM `users` WHERE `id`!='$user_id'".($whom==2?' AND `lastdate` > '.($realtime-300).'':'')."");
				$site = '[url=http://upcoder.net/]upcoder.net[/url]';
				
				while ($res = mysql_fetch_assoc($req)) {
					mysql_query("INSERT INTO `mail_msg` SET
					`id_kont`='" . $res['id'] . "',
					`tema`='Рассылка сообщений',
					`msg`='$text\r\nСлужба рассылки $site!',
					`time`='$realtime',
					`sys`='2'");
				}
				
				echo '<div class="menu">Сообщение разослано</div>';
				
			}
			else {
				echo '<div class="rmenu">'.implode('<br/>',$error).'</div>';
			}
		}
		echo '<div class="bmenu"><a href="'.$home.'/index.php?act=cab">Назад</a></div>';
	}
	else {
		echo '<div class="list1"><h3><img src="../images/mail.png" width="16" height="16" class="left" />&nbsp;Моя почта</h3><ul>';
		echo '<li><a href="'.$home.'/str/pochta.php?act=in">Входящие</a> [' . mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`!=' . $user_id . ' AND `id_kont`=' . $user_id . '  AND `sys`=1 AND `delete`!=' . $user_id . ' AND `spam`=1;'), 0) .  ']</li>';
		echo '<li><a href="'.$home.'/str/pochta.php?act=out">Исходящие</a> [' . mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`=' . $user_id . ' AND `id_kont`!=' . $user_id . '  AND `sys`=1 AND `delete`!=' . $user_id . ';'), 0) .  ' | ' . mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`=' . $user_id . ' AND `id_kont`!=' . $user_id . '  AND `sys`=1 AND `read`=1 AND `delete`!=' . $user_id . ';'), 0) .  ']</li>';
		echo '<li><a href="'.$home.'/str/pochta.php?act=systems">Системные сообщения</a> [' . mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`!=' . $user_id . ' AND `id_kont`=' . $user_id . ' AND `sys`=2 AND `delete`!=' . $user_id . ';'), 0) .  ']</li>';
		echo '<li><a href="'.$home.'/str/pochta.php?act=spam">Спам</a> [' . mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`!=' . $user_id . ' AND `id_kont`=' . $user_id . ' AND `sys`=1 AND `delete`!=' . $user_id . ' AND `spam`=2 AND `read`=1;'), 0) .  ' | ' . mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_msg` WHERE `id_user`!=' . $user_id . ' AND `id_kont`=' . $user_id . ' AND `sys`=1 AND `delete`!=' . $user_id . ' AND `spam`=2;'), 0) .  ']'.($rights>=7 ? ' | <a href="'.$home.'/str/pochta.php?act=allspam">Все</a> [' . mysql_result(mysql_query('SELECT COUNT(*) FROM `mail_msg` WHERE `spam`=2;'), 0) .  ']':'').'</li>';
		echo '<li><a href="'.$home.'/str/pochta.php?act=add">Отправить письмо</a></li>';
		echo '</ul></div>';
		echo '<div class="menu"><a href="'.$home.'/index.php?act=cab">Назад</a></div>';
	}
	require_once('../incfiles/end.php');
?>