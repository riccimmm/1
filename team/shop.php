<?php

    define('_IN_JOHNCMS', 1);
    require('../incfiles/core.php');


    // Блокируем гостей
    if (!$user_id) {
        require('../incfiles/head.php');
        echo display_error('Только для зарегистрированный посетителей!');
        require('../incfiles/end.php');
        exit();
    }
    // Проверка клуба
    $t_arr = mysql_query("SELECT * FROM `team_2` WHERE `id` = '" . $datauser['manager2'] . "';");
      if (!mysql_num_rows($t_arr)) {
        require('../incfiles/head.php');
        echo display_error('У вас нет клуба!');
        require('../incfiles/end.php');
        exit();
      }
    // Получаем массив клуба
    $t_arr = mysql_fetch_array($t_arr);

    // Переключатель режимов работы модуля
    switch ($act) {
        case 'player':
			$textl = "Меню игрока";
            require('../incfiles/head.php');
            require_once ("../incfiles/manag2.php"); 
            $rss = mysql_query("SELECT * FROM `player_real_2` WHERE `id` = '$id' LIMIT 1;");
              if (mysql_num_rows($rss)) {
                $arr = mysql_fetch_array($rss);
                echo '<div class="c"><p><center><img src="../images/real_players/' . $arr['photo'] . '_big.png" alt="" /></center></p></div>';
                echo '<div class="c"><table border="0">';
                echo '<tr><td width="90px"><b>Мастерство:</b></td><td><b>' . $arr[mas] . '</b></td></tr>';
                echo '<tr><td><div class="grey">Отбор:</div></td><td>' . $arr[otbor] . '</td></tr>';
                echo '<tr><td><div class="grey">Опека:</div></td><td>' . $arr[opeka] . '</td></tr>';
                echo '<tr><td><div class="grey">Дриблинг:</div></td><td>' . $arr[drib] . '</td></tr>';
                echo '<tr><td><div class="grey">Прием мяча:</div></td><td>' . $arr[priem] . '</td></tr>';
                echo '<tr><td><div class="grey">Выносливость:</div></td><td>' . $arr[vonos] . '</td></tr>';
                echo '<tr><td><div class="grey">Пас:</div></td><td>' . $arr[pas] . '</td></tr>';
                echo '<tr><td><div class="grey">Сила удара:</div></td><td>' . $arr[sila] . '</td></tr>';
                echo '<tr><td><div class="grey">Точность удара:</div></td><td>' . $arr[tocnost] . '</td></tr>';
                echo '</table>';
                echo '</div><div class="c">';

                echo '<table border="0">';
                echo '<tr><td width="90px"><b>Характеристики</b></td><td></td></tr>';
                echo '<tr><td><div class="grey">Имя:</div></td><td>' . $arr[name] . '</td></tr>';
                echo '<tr><td><div class="grey">Страна:</div></td><td><img src="/flag/'.$arr[strana].'.png" alt=""/></td></tr>';
                echo '<tr><td><div class="grey">Возраст:</div></td><td>' . $arr[voz] . '</td></tr>';
                echo '<tr><td><div class="grey">Позиция:</div></td><td>' . $arr[poz] . '</td></tr>';
                echo '<tr><td><div class="grey">Физготовность:</div></td><td>100%</td></tr>';
                echo '<tr><td><div class="grey">Талант:</div></td><td>' . $arr[tal] . '</td></tr>';
                echo '<tr><td><div class="grey">Цена:</div></td><td><font color="red"><b>' . $arr[price] . ' буцеров</b></font></td></tr>';
                echo '</table></div>';

                echo '<div class="menu"><a href="shop.php" class="button">назад</a>  <a href="shop.php?act=sale&amp;id=' . $arr['id'] . '" class="redbutton">Купить</a></div>';
              } else {
                echo display_error('Такого игрока не существует!');
                require('../incfiles/end.php');
                exit();
              }
        break;
        
        default:
            $textl = "Покупка игроков";
            require('../incfiles/head.php');
            require_once ("../incfiles/manag2.php"); 
            echo '<div class="phdr"><b>Магазин Реальных игроков</b></div>';
              $cny = mysql_result(mysql_query("SELECT COUNT(*) FROM `player_real_2`;"), 0);
              $rq = mysql_query("SELECT * FROM `player_real_2` ORDER BY `id` ASC LIMIT $start, $kmess;");
              if (mysql_num_rows($rq)) {
                echo '<div class="c">';
                echo '<table id="example">';
                echo '<tr bgcolor="40B832" align="center" class="whiteheader">
                      <td><b>Фото</b></td>
                      <td><b>Игрок</b></td>
                      <td><b>Гр</b></td>
                      <td><b>Поз</b></td>
                      <td><b>Воз</b></td>
                      <td><b>Тал</b></td>
                      <td><b>Мас</b></td>
                      <td><b>Цена</b></td>
                      </tr>';
               while ($arr = mysql_fetch_array($rq)) {
                   echo is_integer($i / 2) ? '<tr class="oddrows">' : '<tr class="evenrows">';
                   echo '<td align="center"><img src="../images/real_players/' . $arr['photo'] . '_small.png" alt="" /></td>';
                   echo '<td><a href="shop.php?act=player&amp;id=' . $arr['id'] . '">' . $arr['name'] . '</a></td>';
                   echo '<td align="center"><img src="../flag/' . $arr['strana'] . '.png" alt=""/></td>
                         <td align="center">' . $arr['poz'] . '</td>
                         <td align="center">' . $arr['voz'] . '</td>
                         <td align="center">' . $arr['tal'] . '</td>
                         <td align="center">' . $arr['mas'] . '</td>
                         <td align="center"><font color="green"><b>' . $arr['price'] . '</b></font></td>';		
                   echo '</tr>';
	               ++$i;
               }
               echo '</table>';
               echo '</div>';
               if ($cny > $kmess)
                 echo '<p>' . pagenav('shop.php?', $start, $cny, $kmess) . '</p>'; 
			   echo '<div class="gmenu">В этом магазине вы можете купить Реальных Игроков для своей команды. Вы не можете иметь более 10 реальных игроков в команде. Игроки покупаются только за буцеры, подробнее о буцерах вы можете прочитать по этой ссылке:<br/>
			   <a href="/pay.php">Всё о буцерах</a><br/>
			   Запрещено просить игроков у администраторов! Если вы хотите увидеть какого-то игрока, которого еще нет в менеджере и в магазине, то напишите <a href="/forum/index.php?id=3491">здесь</a>. Но перед тем как писать об этом убедитесь, что этого игрока еще нет в менеджере. Узнать об этом можно по этой ссылке:<br/>
			   <a href="/search.php">Поиск игроков</a>
			   </div>';
              } else {
                echo display_error('Нет игроков выставленных на продажу!');
                require('../incfiles/end.php');
                exit();
              }
        break;
        
        case 'sale':
            // проверяем количество реальных игроков в команде
            $p_count = mysql_result(mysql_query("SELECT COUNT(*) FROM `player_2` WHERE `kom` = '" . $datauser['manager2'] . "' AND `photo` = 'yes';"), 0);
            if ($p_count >= 10) {
                require('../incfiles/head.php');
                echo display_error('В команде может быть только 10 реальных игроков!');
                require('../incfiles/end.php');
                exit();
            }
            // Получаем массив с данными игрока
            $pl = mysql_query("SELECT * FROM `player_real_2` WHERE `id` = '$id';");
            if (!mysql_num_rows($pl)) {
                require('../incfiles/head.php');
                echo display_error('Игрок не найден!');
                require('../incfiles/end.php');
                exit();
            }
            $pl = mysql_fetch_array($pl);
            // Проверяем количество буцеров
            if ($t_arr['butcer'] < $pl['price']) {
                require('../incfiles/head.php');
                echo display_error('У вас не достаточно буцеров для покупки данного игрока!');
                require('../incfiles/end.php');
                exit();
            }
            
            // Если всё норм то едем дальше
            
            // Вычисляем номер нового игрока
            $nm = mysql_query("SELECT `nomer` FROM `player_2` WHERE `kom` = '" . $datauser['manager2'] . "' ORDER BY `nomer` DESC LIMIT 1;");
            $nm = mysql_fetch_array($nm);
            $nomer = (int) $nm['nomer'];
            $nomer = $nomer + 1;
            // Создаём игрока
            mysql_query("INSERT INTO `player_2` SET
                `name` = '" . $pl['name'] . "',
                `strana` = '" . $pl['strana'] . "',
                `kom` = '" . $datauser['manager2'] . "',
                `nomer` = '$nomer',
                `poz` = '" . $pl['poz'] . "',
                `line` = '" . $pl['line'] . "',
                `voz` = '" . $pl['voz'] . "',
                `tal` = '" . $pl['tal'] . "',
                `mas` = '" . $pl['mas'] . "',
                `rm` = '" . $pl['rm'] . "',
                `otbor` = '" . $pl['otbor'] . "',
                `opeka` = '" . $pl['opeka'] . "',
                `drib` = '" . $pl['drib'] . "',
                `priem` = '" . $pl['priem'] . "',
                `vonos` = '" . $pl['vonos'] . "',
                `pas` = '" . $pl['pas'] . "',
                `sila` = '" . $pl['sila'] . "',
                `tocnost` = '" . $pl['tocnost'] . "',
                `photo` = 'yes';");
            // Копируем фото игрока
            $newid = mysql_insert_id();
            copy('../images/real_players/' . $pl['photo'] . '_big.png', '../images/players/' . $newid . '_big.png');     
            copy('../images/real_players/' . $pl['photo'] . '_small.png', '../images/players/' . $newid . '_small.png');
            // Отнимаем буцеры за покупку
            $bcr = $t_arr['butcer'] - $pl['price'];
            mysql_query("UPDATE `team_2` SET `butcer` = '$bcr' WHERE `id` = '" . $datauser['manager2'] . "';");
            // Удаляем нунужные данные и файлы
            mysql_query("DELETE FROM `player_real_2` WHERE `id` = '" . $pl['id'] . "' LIMIT 1;");
            unlink('../images/real_players/' . $pl['photo'] . '_small.png');
            unlink('../images/real_players/' . $pl['photo'] . '_big.png');
            require('../incfiles/head.php');
            echo '<div class="gmenu"><b>Игрок успешно куплен!</b><p><a href="shop.php">Купить еще</a></p></div>';
        break;
/**
 * Admin panel for creating players. access only for site admin
 */        
        case 'admin':

 if($rights == 9){

            $textl = "Создание игрока";
            require('../incfiles/head.php');
            // Ограничиваем доступ
         if ($rights >= 10) {
         if ($rights == 8)
                echo display_error('У вас не достаточно прав для доступа на данную страницу!');
                require('../incfiles/end.php');
                exit();
            }
            if (isset($_POST['submit'])) {
                // Принимаем переменные
                $name = isset($_POST['name']) ? mysql_real_escape_string(trim($_POST['name'])) : '';
                $strana = isset($_POST['strana']) ? mysql_real_escape_string(trim($_POST['strana'])) : '';
                $poz = isset($_POST['poz']) ? mysql_real_escape_string(trim($_POST['poz'])) : '';
                $line = isset($_POST['line']) ? intval($_POST['line']) : 0;
                $voz = isset($_POST['voz']) ? intval($_POST['voz']) : 0;
                $tal = isset($_POST['tal']) ? intval($_POST['tal']) : 0;
                $mas = isset($_POST['mas']) ? intval($_POST['mas']) : 0;
                $rm = isset($_POST['rm']) ? intval($_POST['rm']) : 0;
                $otbor = isset($_POST['otbor']) ? intval($_POST['otbor']) : 0;
                $opeka = isset($_POST['opeka']) ? intval($_POST['opeka']) : 0;
                $drib = isset($_POST['drib']) ? intval($_POST['drib']) : 0;
                $priem = isset($_POST['priem']) ? intval($_POST['priem']) : 0;
                $vonos = isset($_POST['vonos']) ? intval($_POST['vonos']) : 0;
                $pas = isset($_POST['pas']) ? intval($_POST['pas']) : 0;
                $sila = isset($_POST['sila']) ? intval($_POST['sila']) : 0;
                $tocnost = isset($_POST['tocnost']) ? intval($_POST['tocnost']) : 0;
                $price = isset($_POST['price']) ? intval($_POST['price']) : 0;
                // Выгрузка фотки
                $img = $realtime;
                require_once ('../incfiles/class_upload.php');
                $handle = new upload($_FILES['photo']);
            if ($handle->uploaded) {
                // Обрабатываем крупную картинку
                $handle->file_new_name_body = $img . '_big';
                $handle->allowed = array('image/jpeg', 'image/gif', 'image/png');
                $handle->file_max_size = 1024 * $flsz;
                $handle->file_overwrite = true;
                $handle->image_resize = true;
                $handle->image_x = 100;
                $handle->image_y = 130;
                $handle->image_convert = 'png';
                $handle->process('../images/real_players/');
                if ($handle->processed) {
                    // Обрабатываем мелкую картинку
                    $handle->file_new_name_body = $img . '_small';
                    $handle->file_overwrite = true;
                    $handle->image_resize = true;
                    $handle->image_x = 20;
                    $handle->image_y = 25;
                    $handle->image_convert = 'png';
                    $handle->process('../images/real_players/');
                    if ($handle->processed) {
                    } else {
                        $img = FALSE;
                    }
                } else {
                    $img = FALSE;
                }
                $handle->clean();
            } else {
                $img = FALSE;
            }
            if (!$img) {
                echo display_error('Произошла ошибка при загрузке фотографии!');
                require('../incfiles/end.php');
                exit();
            }
            mysql_query("INSERT INTO `player_real_2` SET
                `name` = '$name',
                `strana` = '$strana',
                `poz` = '$poz',
                `line` = '$line',
                `voz` = '$voz',
                `tal` = '$tal',
                `mas` = '$mas',
                `rm` = '$rm',
                `otbor` = '$otbor',
                `opeka` = '$opeka',
                `drib` = '$drib',
                `priem` = '$priem',
                `vonos` = '$vonos',
                `pas` = '$pas',
                `sila` = '$sila',
                `tocnost` = '$tocnost',
                `photo` = '$img',
                `price` = '$price';
                ");
            echo '<div class="gmenu">' .
                 '<p><img src="../images/real_players/' . $img . '_big.png" alt="" /></p>' .
                 '<b>Игрок успешно создан!</b><p><a href="shop.php?act=admin">Создать еще</a></p>' .
                 '</div>';    
            
            
            } else {
                $arres = array('name', 'strana', 'poz', 'line', 'voz', 'tal', 'mas', 'rm', 'otbor', 'opeka', 'drib', 'priem', 'vonos', 'pas', 'sila', 'tocnost', 'photo');
                echo '<div class="gmenu"><b>' . $textl . '</b></div>' .
                     '<form action="shop.php?act=admin" method="POST" enctype="multipart/form-data">';
                  foreach ($arres AS $val) {
                    echo is_integer($i / 2) ? '<div class="c">' : '<div class="c">';
                    echo $val . ':<br /><input type="' . ($val == 'photo' ? 'file' : 'text') . '" name="' . $val . '" />';
                    echo '</div>';
                    ++$i;
                  }
                  echo '<input type="hidden" name="MAX_FILE_SIZE" value="' . (1024 * $flsz) . '" />';
                  echo '<div class="gmenu">Цена:<br /><input name="price" type="text" /></div>';
                  echo '<div class="rmenu"><input name="submit" type="submit" value="Создать" /></div>';
                  echo '</form>';   
            }

 }else{
  header('Location: '.$home);
 }
        break;    
    }
        require('../incfiles/end.php');
?>