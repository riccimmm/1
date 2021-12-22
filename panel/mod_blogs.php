<?php
defined('_IN_JOHNADM') or die('Error: restricted access');

if ($rights < 7)
    die('Error: restricted access');

echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | Управление Блогами</div>';
switch ($mod)
{
    case 'del' :
        if (empty ($_GET['id']))
		{
            echo '<div class="rmenu">Ощибка!</div>';
			echo '<div class="phdr"><a href="?act=mod_blogs">Назад</a></div>';
            require_once ("../incfiles/end.php");
            exit;
        }
        $req = mysql_query("SELECT * FROM `blogs_cat` WHERE `id`='" . $id . "';");
        if (mysql_num_rows($req) == 0)
		{
			echo '<div class="phdr"><a href="?act=mod_blogs">Назад</a></div>';
		}
		$res = mysql_fetch_assoc($req);
		
		if(!isset($_GET['ok']))
		{
			echo '<div class="menu">Подтвердите удаление</div>';
			echo '<div class="menu"><a href="?act=mod_blogs">Отмена</a> | <a href="?act=mod_blogs&amp;mod=del&amp;id=' . $id . '&amp;ok">Удалить</a></div>';
		}
		else
		{
			mysql_query("DELETE FROM `blogs` WHERE `ref` = '" . $id . "';");
			mysql_query("DELETE FROM `blogs_komm` WHERE `refid` = '" . $row['id'] . "';");
			mysql_query("DELETE FROM `blogs_cat` WHERE `id` = '" . $id . "' LIMIT 1;");
			//Удаляем файлы
			$req_f = mysql_query('SELECT * FROM `blogs_files` WHERE `ref` = '.$id);
			while ($res_f = mysql_fetch_assoc($req_f))
			{
				unlink('../blogs/files/' . $res_f['name']);
			}
			mysql_query("DELETE FROM `blogs_files` WHERE `ref` = '" . $row['id'] . "';");
			echo '<div class="menu">Категория удалена</div>';
		}
        break;

    case 'add' :
		echo '<div class="gmenu">Добавление раздела</div>';
		if(!$_POST)
		{
			echo '<form class="list2" action="?act=mod_blogs&amp;mod=add" method="post">';
			echo 'Название категории:<br />
			<input type="text" name="name" maxlength="150"/><b style="background-color : #d5d5d5;border : 1px solid silver;padding : 0px 3px 0px 3px;">max. 60</b><br />';
			echo 'Описание:<br />
			<textarea name="text" value=""></textarea><b style="background-color : #d5d5d5;border : 1px solid silver;padding : 0px 3px 0px 3px;">max. 100</b><br />';
			echo '<input type="submit" name="submit" value="Создать"/></form>';
			echo '<div class="gmenu"><a href="admin.php">Админка</a></div>';
		}
		else
		{
			$name = check(trim($_POST['name']));
			$text = check(trim($_POST['text']));
			
			$error = array();
			
			if (empty($name))
				$error[] = 'Не введёно название категории!<br />';
			elseif (mb_strlen($name) < 2 || mb_strlen($name) > 60)
				$error[] = 'Недопустимая длина названия категории!<br />';
			if (mb_strlen($text) > 100)
				$error[] = 'Недопустимая длина описания!<br />';

			if (!$error)
			{
				if(mysql_result(mysql_query("SELECT COUNT(*) FROM `blogs_cat` WHERE `name`='" . mysql_real_escape_string($name) . "';"), 0)!=0)
				{
					$error[] = 'Такая категория уже существует.<br />';
				}
			}
			if (!$error)
			{
				mysql_query("INSERT INTO `blogs_cat` SET
				`name`='" . mysql_real_escape_string($name) . "',
				`text`='" . mysql_real_escape_string($text) . "';");
				$id = mysql_insert_id();
				mysql_query("UPDATE `blogs_cat` SET
                `realid` = '$id' WHERE `id`='$id'");
				echo '<div class="menu">Категория создана!</div>';
			}
			else
			{
				echo display_error($error);
			}
		}
	break;

    case 'edit' :
        if (empty ($_GET['id']))
		{
			echo '<div class="rmenu">Ощибка!</div>';
			echo '<div class="phdr"><a href="./">Назад</a></div>';
			require_once ("../incfiles/end.php");
			exit;
		}
		$req = mysql_query("SELECT * FROM `blogs_cat` WHERE `id`='" . $id . "';");
		if (mysql_num_rows($req) == 0)
		{
			echo '<div class="rmenu">Ощибка!</div>';
			echo '<div class="phdr"><a href="./">Назад</a></div>';
			require_once ("../incfiles/end.php");
			exit;
		}
		$row = mysql_fetch_assoc($req);
		
		if(!$_POST)
		{
			echo '<form class="list2" action="?act=mod_blogs&amp;mod=edit&amp;id='.$id.'" method="post">';
			echo 'Название категории:<br />
			<input type="text" name="name" maxlength="60" value="' . $row['name'] . '"/><b style="background-color : #d5d5d5;border : 1px solid silver;padding : 0px 3px 0px 3px;">max. 60</b><br />';
			echo 'Описание:<br />
			<textarea name="text">' . $row['text'] . '</textarea><b style="background-color : #d5d5d5;border : 1px solid silver;padding : 0px 3px 0px 3px;">max. 100</b><br />';
			echo '<input type="submit" name="submit" value="Изменить"/></form>';
		}
		else
		{
			$name = check(trim($_POST['name']));
			$text = check(trim($_POST['text']));
			
			$error = array();
			
			if (empty($name))
				$error[] = 'Не введёно название категории!<br />';
			elseif (mb_strlen($name) < 2 || mb_strlen($name) > 60)
				$error[] = 'Недопустимая длина названия категории!<br />';
			if (mb_strlen($text) > 100)
				$error[] = 'Недопустимая длина описания!<br />';

			if (!$error)
			{
				if($row['name']!=$name)
				{
					if(mysql_result(mysql_query("SELECT COUNT(*) FROM `blogs_cat` WHERE `name`='" . mysql_real_escape_string($name) . "';"), 0)!=0)
					{
						$error[] = 'Такая категория уже существует.<br />';
					}
				}
			}
			if (!$error)
			{
				mysql_query("UPDATE `blogs_cat` SET
				`name`='" . mysql_real_escape_string($name) . "',
				`text`='" . mysql_real_escape_string($text) . "' WHERE `id`='" . $id . "';");
				echo '<div class="menu">Категория создана!</div>';
			}
			else
			{
				echo display_error($error);
			}
		}
		
	break;
		
    case 'up' :
        ////////////////////////////////////////////////////////////
        // Перемещение комнаты на одну позицию вверх              //
        ////////////////////////////////////////////////////////////
        if ($id) {
            $req = mysql_query("SELECT `realid` FROM `blogs_cat` WHERE `id` = '$id' LIMIT 1");
            if (mysql_num_rows($req)) {
                $res = mysql_fetch_assoc($req);
                $sort = $res['realid'];
                $req = mysql_query("SELECT * FROM `blogs_cat` WHERE `realid` < '$sort' ORDER BY `realid` DESC LIMIT 1");
                if (mysql_num_rows($req)) {
                    $res = mysql_fetch_assoc($req);
                    $id2 = $res['id'];
                    $sort2 = $res['realid'];
                    mysql_query("UPDATE `blogs_cat` SET `realid` = '$sort2' WHERE `id` = '$id'");
                    mysql_query("UPDATE `blogs_cat` SET `realid` = '$sort' WHERE `id` = '$id2'");
                }
            }
        }
        header('Location: index.php?act=mod_blogs');
        break;

    case 'down' :
       ////////////////////////////////////////////////////////////
        // Перемещение комнаты на одну позицию вниз               //
        ////////////////////////////////////////////////////////////
        if ($id) {
            $req = mysql_query("SELECT `realid` FROM `blogs_cat` WHERE `id` = '$id' LIMIT 1");
            if (mysql_num_rows($req)) {
                $res = mysql_fetch_assoc($req);
                $sort = $res['realid'];
                $req = mysql_query("SELECT * FROM `blogs_cat` WHERE `realid` > '$sort' ORDER BY `realid` ASC LIMIT 1");
                if (mysql_num_rows($req)) {
                    $res = mysql_fetch_assoc($req);
                    $id2 = $res['id'];
                    $sort2 = $res['realid'];
                    mysql_query("UPDATE `blogs_cat` SET `realid` = '$sort2' WHERE `id` = '$id'");
                    mysql_query("UPDATE `blogs_cat` SET `realid` = '$sort' WHERE `id` = '$id2'");
                }
            }
        }
        header('Location: index.php?act=mod_blogs');
        break;
		
	case 'setting':
		$set_blogs = unserialize($set['blogs']);
		if(empty($set_blogs)) {
			$set_blogs = array(
			'load_closed'=>'0',
			'mod'=>'0',
			'screen_closed'=>'0',
			'max_screen'=>'20',
			'max_prev'=>'20',
			'max_file_size'=>'2048',
			'blog_ext'=>'zip');
		}
		echo '<div class="phdr">Настройки блогов</div>';
		if($_POST)
		{
			$error = array();
			$set_blogs['load_closed'] = isset($_POST['load_closed']) && $_POST['load_closed'] == 1 ? 1 : 0;
			$set_blogs['mod'] = isset($_POST['mod']) && $_POST['mod'] == 1 ? 1 : 0;
			$set_blogs['screen_closed'] = isset($_POST['screen_closed']) && $_POST['screen_closed'] == 1 ? 1 : 0;
			$set_blogs['max_screen'] = isset($_POST['max_screen']) ? intval(trim($_POST['max_screen'])) : '';
			$set_blogs['max_prev'] = isset($_POST['max_prev']) ? intval(trim($_POST['max_prev'])) : '';
			$set_blogs['max_file_size'] = isset($_POST['max_file_size']) ? intval(trim($_POST['max_file_size'])) : '';
			$set_blogs['blog_ext'] = isset($_POST['blog_ext']) ? mb_strtolower($_POST['blog_ext']) : '';
			if (preg_match("/[^0-9a-z, ]+/", mb_strtolower($set_blogs['blog_ext'])))
				$error[] = 'Недопустимые символы в расширении файлов<br/>';
			$set_blogs['blog_ext'] = preg_replace('/ {1,}/', '', $set_blogs['blog_ext']);
			$set_blogs['blog_ext'] = preg_replace('/,{2,}/', ',', $set_blogs['blog_ext']);
			if (!$error) {
				mysql_query("UPDATE `cms_settings` SET `val`='" . mysql_real_escape_string(serialize($set_blogs)) . "' WHERE `key` = 'blogs';");
				echo '<div class="rmenu">Настройки изменены</div>';
			}
			else {
				echo display_error($error);
			}
		}
		echo '<div class="menu">';
		echo '<form action="index.php?act=mod_blogs&amp;mod=setting" method="POST">';
		echo '<li>Запрет добавления файла:<br />';
		echo '<input type="radio" value="0" name="load_closed" ' . ($set_blogs['load_closed'] == '0' ? 'checked="checked"' : '') . '/>&nbsp;Выкл ';
		echo '<input type="radio" value="1" name="load_closed" ' . ($set_blogs['load_closed'] == '1' ? 'checked="checked"' : '') . '/>&nbsp;Вкл</li>';
		echo '<li>Запрет добавления скриншота:<br />';
		echo '<input type="radio" value="0" name="screen_closed" ' . ($set_blogs['screen_closed'] == '0' ? 'checked="checked"' : '') . '/>&nbsp;Выкл ';
		echo '<input type="radio" value="1" name="screen_closed" ' . ($set_blogs['screen_closed'] == '1' ? 'checked="checked"' : '') . '/>&nbsp;Вкл</li>';
		echo '<li><span class="gray">Максимальный размер скриншота:</span>(20-320px)<br /><input type="text" value="' . $set_blogs['max_screen'] . '" name="max_screen" size="3" maxlength="3" /> px</li>';
		echo '<li><span class="gray">Максимальный размер превью файла:</span>(20-320px)<br /><input type="text" value="' . $set_blogs['max_prev'] . '" name="max_prev" size="3" maxlength="3" /> px</li>';
		echo '<li><span class="gray">Максимальный размер файла:</span><br /><input type="text" value="' . $set_blogs['max_file_size'] . '" name="max_file_size" size="5" maxlength="5" /> Kb</li>';
		echo '<li><span class="gray">Допустимые расширения файла, через запятую:</span><br /><textarea rows="4" name="blog_ext" style="width: 60%;">' . $set_blogs['blog_ext'] . '</textarea></li>';
		echo '<li>Модерация статей:<br />';
		echo '<input type="radio" value="0" name="mod" ' . ($set_blogs['mod'] == '0' ? 'checked="checked"' : '') . '/>&nbsp;Выкл ';
		echo '<input type="radio" value="1" name="mod" ' . ($set_blogs['mod'] == '1' ? 'checked="checked"' : '') . '/>&nbsp;Вкл</li>';
		echo '<input type="submit" value="Изменить" name="submit" /></form>';
		echo '</div>';
	break;
	
	case 'moderate':
		if($do == 'ok')
		{
			mysql_query("UPDATE `" . $set['prefblog'] . "blogs` SET `mod`='0' WHERE `id` = '$id';");
			echo '<div  class="menu">Статья добавлена</div>';
		}
		elseif($do == 'del')
		{
			if (empty ($_GET['id']))
			{
				echo '<div class="rmenu">Ощибка!</div>';
				echo '<div class="phdr"><a href="?act=mod_blogs">Назад</a></div>';
				require_once ("../incfiles/end.php");
				exit;
			}
			$req = mysql_query("SELECT * FROM `blogs` WHERE `id`='" . $id . "';");
			if (mysql_num_rows($req) == 0)
			{
				echo '<div class="rmenu">Ощибка!</div>';
				echo '<div class="phdr"><a href="?act=mod_blogs">Назад</a></div>';
				require_once ("../incfiles/end.php");
				exit;
			}
			//$res = mysql_fetch_assoc($req);
			
			if(!isset($_GET['ok']))
			{
				echo '<div class="menu">Подтвердите удаление</div>';
				echo '<div class="menu"><a href="?act=mod_blogs">Отмена</a> | <a href="index.php?act=mod_blogs&amp;mod=moderate&amp;do=del&amp;id='.$id.'&amp;ok">Удалить</a></div>';
			}
			else
			{
				mysql_query("DELETE FROM `blogs` WHERE `id` = '" . $id . "';");
				$req_f = mysql_fetch_assoc(mysql_query('SELECT * FROM `blogs_files` WHERE `post` = '.$id));
				@ unlink('../blogs/files/' . $req_f['name']);
				@ unlink('../blogs/screen/' . $id . '.png');
				mysql_query("DELETE FROM `blogs_komm` WHERE `ref` = '" . $id . "';");
				mysql_query("DELETE FROM `blogs_files` WHERE `post` = '" . $id . "';");
				mysql_query("DELETE FROM `blogs_rat` WHERE `ref` = '" . $id . "';");
				mysql_query("DELETE FROM `blogs_rdm` WHERE `topic_id` = '" . $id . "';");
				echo '<div class="menu">Статья удалена</div>';
			}
		}
		elseif($do == 'edit')
		{
			if (empty ($_GET['id']))
			{
				echo '<div class="rmenu">Ощибка!</div>';
				echo '<div class="phdr"><a href="?act=mod_blogs">Назад</a></div>';
				require_once ("../incfiles/end.php");
				exit;
			}
			$req = mysql_query("SELECT * FROM `blogs` WHERE `id`='" . $id . "';");
			if (mysql_num_rows($req) == 0)
			{
				echo '<div class="rmenu">Ощибка!</div>';
				echo '<div class="phdr"><a href="?act=mod_blogs">Назад</a></div>';
				require_once ("../incfiles/end.php");
				exit;
			}
			$row = mysql_fetch_assoc($req);
			
			if(!$_POST)
			{
				echo '<form class="list2" action="index.php?act=mod_blogs&amp;mod=moderate&amp;do=edit&amp;id='.$id.'" method="post">';
				echo 'Название категории:<br />
				<input type="text" name="name" maxlength="150" value="'.$row['name'].'"/><b style="background-color : #d5d5d5;border : 1px solid silver;padding : 0px 3px 0px 3px;">max. 60</b><br />';
				echo 'Описание:<br />
				<textarea rows="4" name="text" style="width: 60%;">'.htmlentities($row['text'], ENT_QUOTES, 'UTF-8').'</textarea><b style="background-color : #d5d5d5;border : 1px solid silver;padding : 0px 3px 0px 3px;">max. 100</b><br />';
				$res = mysql_query('SELECT * FROM `' .$set['prefblog'] . 'blogs_cat`;');
				echo 'Категория:<br />
				<select name="cat">';
				while($req = mysql_fetch_assoc($res))
				{
					echo '<option' . ($row['ref'] == $req['id'] ? ' value="'.$req['id'].'" selected="selected">' : ' value="'.$req['id'].'">') . $req['name'] . '</option>';
				}
				echo '</select><br />';
				echo 'Не коментировать: <input type="checkbox" name="komm" value="1" ' . ($row['komm'] ? 'checked="checked"' : '') . ' /><br />';
				echo '<input type="submit" name="submit" value="Изменить"/></form>';
				echo '<div class="gmenu"><a href="admin.php">Админка</a></div>';
			}
			else
			{
				$name = check(trim($_POST['name']));
				$text = trim($_POST['text']);
				$cat = intval(trim($_POST['cat']));
				$komm = intval(trim($_POST['komm']));
				
				$error = false;
				
				if (empty($name))
					$error = $error . 'Не введёно название статьи!<br />';
				elseif (mb_strlen($name) < 2 || mb_strlen($name) > 60)
					$error = $error . 'Недопустимая длина названия статьи!<br />';
				if (empty($text))
					$error = $error . 'Не введён текст статьи!<br />';
				elseif (mb_strlen($text) < 2 || mb_strlen($text) > 20000)
					$error = $error . 'Недопустимая длина статьи!<br />';
				if (empty($cat))
					$error = $error . 'Выберите категорию!<br />';
					
				if (empty($error))
				{
					mysql_query("UPDATE `" . $set['prefblog'] . "blogs` SET
					`ref`='" . $cat . "',
					`name`='" . mysql_real_escape_string($name) . "',
					`text`='" . mysql_real_escape_string($text) . "',
					`komm`='" . $komm . "' WHERE `id`='" . $id . "';");
					echo '<div class="menu">Статья измена!</div>';
					echo '<div class="gmenu"><a href="index.php?act=mod_blogs">В админку</a></div>';
				}
				else
				{
					echo '<div class="menu"><b>ОШИБКА!</b><br />' . $error;
					echo '</div>';
				}
			}
		}
		else
		{
			$count = mysql_result(mysql_query('SELECT COUNT(*) FROM `blogs` WHERE `mod`=1'), 0);
			if($count>0)
			{
				$req = mysql_query("SELECT * FROM `" . $set['prefblog'] . "blogs` WHERE `mod`='1' ORDER BY `time` DESC LIMIT " . $start . "," . $kmess);
				while ($row = mysql_fetch_assoc($req))
				{
					echo ($i % 2) ? '<div class="list2"><img src="../blogs/img/b2.png" alt="&raquo;" width="14" height="14" /> ' : '<div class="list1"><img src="../blogs/img/b1.png" alt="&raquo;" width="14" height="14" /> ';
					echo '<a href="../blogs/?act=view&amp;id='.$row['id'].'">'.$row['name'].'</a>';
					if(!empty($row['text']))
					{
						$text = $row['text'];
						if (mb_strlen($text) > 150)
						{
							$text = mb_substr($text, 0, 150);
							$text = checkout($text, 0, 2);
							$out .= '<div class="sub">'.$text.'...</div>';
						}
						else
						{
							$out .= '<div class="sub">'.checkout($text, 0, 2).'</div>';
						}
					}
					echo $out;
					echo '<div class="func">';
					echo 'Автор: '.$row['from'].'<br />';
					echo '<a href="index.php?act=mod_blogs&amp;mod=moderate&amp;do=ok&amp;id='.$row['id'].'">Добавить</a> | <a href="index.php?act=mod_blogs&amp;mod=moderate&amp;do=edit&amp;id='.$row['id'].'">Изменить</a> | <a href="index.php?act=mod_blogs&amp;mod=moderate&amp;do=del&amp;id='.$row['id'].'">Удалить</a>
					</div></div>';
					++$i;
				}
				if ($count > $kmess)
				{
					echo '<p class="menu">' . pagenav('index.php?act=mod_blogs&amp;mod=moderate&amp;', $start, $count, $kmess) . '<br/>';
					echo '<form action="" method="POST">
					<input type="text" name="page" size="2"/><input type="submit" value="GO"/></form></p>';
				}
			}
			else
			{
				echo '<div class="menu">Статей нет</div>';
			}
		}
		
	break;
	
	case 'all':
		$count = mysql_result(mysql_query('SELECT COUNT(*) FROM `blogs`'), 0);
		if($count>0) {
			$req = mysql_query("SELECT * FROM `" . $set['prefblog'] . "blogs` ORDER BY `time` DESC LIMIT " . $start . "," . $kmess);
			while ($row = mysql_fetch_assoc($req)) {
				echo ($i % 2) ? '<div class="list2"><img src="../blogs/img/b2.png" alt="&raquo;" width="14" height="14" /> ' : '<div class="list1"><img src="../blogs/img/b1.png" alt="&raquo;" width="14" height="14" /> ';
				echo '<a href="../blogs/?act=view&amp;id='.$row['id'].'">'.$row['name'].'</a>';
				if(!empty($row['text'])) {
					if (mb_strlen($row['text']) > 150) {
						$text = mb_substr($row['text'], 0, 150);
						$text = checkout($text, 0, 2);
						echo '<div class="sub">'.$text.'...</div>';
					} else {
						echo '<div class="sub">'.checkout($row['text'], 0, 2).'</div>';
					}
				}
				echo '<div class="func">';
				echo 'Автор: '.$row['from'].'<br />';
				echo '<a href="index.php?act=mod_blogs&amp;mod=moderate&amp;do=edit&amp;id='.$row['id'].'">Изменить</a> | <a href="index.php?act=mod_blogs&amp;mod=moderate&amp;do=del&amp;id='.$row['id'].'">Удалить</a>
				</div></div>';
				++$i;
			}
			if ($count > $kmess)
			{
				echo '<p class="menu">' . pagenav('index.php?act=mod_blogs&amp;mod=moderate&amp;', $start, $count, $kmess) . '<br/>';
				echo '<form action="" method="POST">
				<input type="text" name="page" size="2"/><input type="submit" value="GO"/></form></p>';
			}
		}
		else
		{
			echo '<div class="menu">Статей нет</div>';
		}
	break;
	
	case 'delkomm':
		$res = mysql_query("SELECT * FROM `blogs_komm` WHERE `id`='" . $id . "';");
		$req = mysql_num_rows($res);
		if($req==0) {
			echo '<div class="rmenu">Сообщения не существует!</div>';
			echo '<div class="menu"><a href="index.php?act=mod_blogs&amp;mod=komm">Назад</a></div>';
			require_once ('../systems/footer.php');
			exit;
		}
		$row = mysql_fetch_assoc($res);
		echo '<div class="menu">Блоги | Удаление комментариев</div>';
		if(!$_POST) {
			echo '<div class="rmenu">Подтвердите удаление сообщения</div>';
			echo '<div class="list1">';
			echo '<form action="" method="POST">';
			echo '<input type="checkbox" name="all" value="1"/> Удалить все коментарии данного пользователя<br/>';
			echo '<input type="submit" name="submit" value="Удалить"/>';
			echo '</form>';
			echo '</div>';
			echo '<div class="menu"><a href="index.php?act=mod_blogs&amp;mod=komm">Назад</a></div>';
		} else {
			$all = abs(intval($_POST['all']));
			if($all == 1) {
				echo '<div class="menu">Все сообщения данного пользователя удалены</div>';
				mysql_query("DELETE FROM `blogs_komm` WHERE `uid` = '" . $row['uid'] . "';");
				echo '<div class="menu"><a href="index.php?act=mod_blogs&amp;mod=komm">Назад</a></div>';
			} else {
				echo '<div class="menu">Сообщение удалено</div>';
				mysql_query("DELETE FROM `blogs_komm` WHERE `id` = '" . $id . "' LIMIT 1;");
				echo '<div class="menu"><a href="index.php?act=mod_blogs&amp;mod=komm">Назад</a></div>';
			}
		}
	break;
	
	case 'komm':
		$count = mysql_result(mysql_query("SELECT COUNT(*) FROM `blogs_komm`;"), 0);
		if($count>0) {
			$res1 = mysql_query("SELECT * FROM `blogs_komm` ORDER BY `time` DESC LIMIT " . $start . "," . $kmess);
			while ($row = mysql_fetch_assoc($res1))	{
				$req = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id`='" . $row['uid'] . "';"));
				echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
				if($res['uid']==$user_id)$sub = '<a href="?act=komm&amp;do=del&amp;id=' . $row['id'] . '">Удалить</a>';
				echo show_user($req,1,NULL,NULL,$row['text']);
				echo '<a href="../blogs/index.php?act=view&amp;id='.$row['ref'].'">К статье &raquo;</a> | <a href="../blogs/index.php?act=komm&amp;id='.$row['ref'].'">К комментариям &raquo;</a> | <a href="index.php?act=mod_blogs&amp;mod=delkomm&amp;id='.$row['id'].'">Удалить</a>';
				echo '</div>';
				++$i;
			}
			if ($count > $kmess) {
				echo '<p class="menu">' . pagenav('index.php?act=mod_blogs&amp;mod=komm&amp;', $start, $count, $kmess) . '<br/>';
				echo '<form action="" method="POST">
				<input type="text" name="page" size="2"/> <input type="submit" value="GO"/></form></p>';
			}
		}
		else {
			echo '<div class="menu">Комментариев нет</div>';
		}
	break;
	
	
    default :
        $req = mysql_query('SELECT * FROM `blogs_cat` ORDER BY `realid`');
        while ($res = mysql_fetch_assoc($req)) {
            $ri = mysql_query("SELECT * FROM `blogs_cat` WHERE `realid`>'" . $res['realid'] . "';");
			$rei = mysql_num_rows($ri);
			$ri1 = mysql_query("SELECT * FROM `blogs_cat` WHERE `realid`<'" . $res['realid'] . "';");
			$rei1 = mysql_num_rows($ri1);
			echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
            echo '<b>' . $res['name'] . '</b>';
			if($res['text'])echo '<div class="sub">' . $res['text'] . '</div>';
            echo '<div class="sub">';
			if ($rei1 != 0)
			{
				echo '<a href="index.php?act=mod_blogs&amp;mod=up&amp;id=' . $res['id'] . '">Вверх</a> | ';
			}
			if ($rei != 0)
			{
				echo '<a href="index.php?act=mod_blogs&amp;mod=down&amp;id=' . $res['id'] . '">Вниз</a> | ';
			}
            echo '<a href="index.php?act=mod_blogs&amp;mod=edit&amp;id=' . $res['id'] . '">Изм.</a> | ';
            echo '<a href="index.php?act=mod_blogs&amp;mod=del&amp;id=' . $res['id'] . '">Удалить</a></div></div>';
            ++$i;
        }
        echo '<div class="gmenu"><form action="index.php?act=mod_blogs&amp;mod=add" method="post"><input type="submit" value="Добавить раздел" /></form></div>';
        echo '<div class="phdr"><a href="index.php?act=mod_blogs&amp;mod=setting">Настройки</a></div>';
		echo '<div class="phdr"><a href="index.php?act=mod_blogs&amp;mod=komm">Коментарии</a> ['.mysql_result(mysql_query('SELECT COUNT(*) FROM `blogs_komm`'), 0).']</div>';
		echo '<div class="phdr"><a href="index.php?act=mod_blogs&amp;mod=all">Все статьи</a> ['.mysql_result(mysql_query('SELECT COUNT(*) FROM `blogs`'), 0).']</div>';
		echo '<div class="phdr"><a href="index.php?act=mod_blogs&amp;mod=moderate">На модерации</a> ['.mysql_result(mysql_query('SELECT COUNT(*) FROM `blogs` WHERE `mod`=1'), 0).']</div>';
		echo '<div class="phdr"><a href="../blogs/index.php">В блоги</a></div>';
}

echo '<p class="bmenu">' . ($mod ? '<a href="index.php?act=mod_blogs">Управление Блогами</a><br />' : '') . '<a href="index.php">Админ панель</a></p>';

?>