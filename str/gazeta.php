<?php

/*
////////////////////////////////////////////////////////////////////////////////
// JohnCMS                                                                    //
// Официальный сайт сайт проекта:      http://johncms.com                     //
// Дополнительный сайт поддержки:      http://gazenwagen.com                  //
////////////////////////////////////////////////////////////////////////////////
// JohnCMS core team:                                                         //
// Евгений Рябинин aka john77          john77@johncms.com                     //
// Олег Касьянов aka AlkatraZ          alkatraz@johncms.com                   //
//                                                                            //
// Информацию о версиях смотрите в прилагаемом файле version.txt              //
////////////////////////////////////////////////////////////////////////////////
// Автор модуля газеты - Янулов
*/

define('_IN_JOHNCMS', 1);
$headmod = 'paper';
$rootpath = '../';
$textl = 'Газета сайта';

require_once('../incfiles/core.php');
require_once('../incfiles/head.php');
switch ($act) {
    case 'trans': 
        ////////////////////////////////////////////////////
        // Правило странслита                             //
        ////////////////////////////////////////////////////
        include('../pages/trans.$ras_pages');
        echo '<br/><br/><a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Назад</a><br/>';
        break;

    case 'write': 
        ////////////////////////////////////////////////////
        // Добавление статьи                              //
        ////////////////////////////////////////////////////
        if ($rights >= 6) {
            if (isset($_POST['submit'])) {
                $error = array ();
                $zag = mb_substr(trim($_POST['zag']), 0, 100);
                $msg = trim($_POST['msg']);
                if (($_POST['submit']) && empty($_POST['zag']))
                    $error[] = 'Вы не ввели заголовок статьи';
                if (($_POST['submit']) && empty($_POST['msg']))
                    $error[] = 'Вы не ввели текст статьи';
                if ($msg && mb_strlen($msg) < 50)
                    $error[] = 'Общая длина текста статьи должна быть не менее 50 букв';
                if ($_POST['msgtrans'] == 1) {
                    $msg = trans($msg);
                } 
                if (!$error) {
                    // Записываем в базу
                    $sql = "INSERT INTO `paper` SET
                `time` = '$realtime',
                `avtor` = '" . mysql_real_escape_string($login) . "',
                `name` = '" . mysql_real_escape_string($zag) . "',
                `text` = '" . mysql_real_escape_string($msg) . "'";
                    if (mysql_query($sql))
                        $id = mysql_insert_id();
                    else
                        $error[] = 'Невозможно записать в базу'; 
                    // Выгружаем картинку
                    if (!$error && $_FILES['imagefile']['size'] > 0) {
                        require_once('../incfiles/class_upload.php');
                        $handle = new upload($_FILES['imagefile']);
                        if ($handle->uploaded) {
                            // Обрабатываем фото
                            $handle->file_new_name_body = $id;
                            $handle->allowed = array ('image/jpeg',
                                'image/gif',
                                'image/png'
                                );
                            $handle->file_max_size = 1024 * $flsz;
                            $handle->file_overwrite = true;
                            $handle->image_resize = true;
                            $handle->image_x = 120;
                            $handle->image_ratio_y = true;
                            $handle->image_convert = 'jpg';
                            $handle->process('../files/paper/');
                            if ($handle->processed) {
                                // Обрабатываем превьюшку
                                $handle->file_new_name_body = $id . '_preview';
                                $handle->file_overwrite = true;
                                $handle->image_resize = true;
                                $handle->image_x = 50;
                                $handle->image_ratio_y = true;
                                $handle->image_convert = 'jpg';
                                $handle->process('../files/paper/');
                                if (!$handle->processed) {
                                    $error[] = $handle->error;
                                } 
                            } else {
                                $error[] = $handle->error;
                            } 
                            $handle->clean();
                        } 
                    } 
                    if (!$error)
                        echo '<div class="gmenu"><p>Статья успешно выгружена<br /><a href="gazeta.php">Продолжить</a></p></div>';
                } else {
                    echo display_error($error, '<a href="gazeta.php?act=write">Повторить</a>');
                } 
            } else {
                echo '<div class="phdr"><b>Газета</b> | написать статью</div>';
                echo '<form enctype="multipart/form-data" action="gazeta.php?act=write" method="post">';
                echo '<div class="gmenu"><p>Заголовок (max. 100):<br/><input type="text" name="zag" maxlength="100"/><br />';
                echo 'Текст статьи:<br/><textarea cols="20" rows="4" name="msg"></textarea><br />';
                echo 'Картинка:<br /><input type="file" name="imagefile" value="" /><br /><small>Размер файла не должен превышать ' . $flsz . 'кб.</small></p>';
                echo '<input type="hidden" name="MAX_FILE_SIZE" value="' . (1024 * $flsz) . '" />';
                if ($set_user['translit'])
                    echo '<p><input type="checkbox" name="msgtrans" value="1" /> Транслит</p>';
                echo '<p><input type="submit" title="Нажмите для отправки" name="submit" value="Отправить" /></p></div></form>';
                echo '<div class="phdr"><a href="gazeta.php?act=trans">Транслит</a> | <a href="../str/smile.php">Смайлы</a></div>';
                echo '<p><a href="gazeta.php">Назад</a></p>';
            } 
        } 
        break;

    case 'edit': 
        ////////////////////////////////////////////////////
        // Редактирование статьи                          //
        ////////////////////////////////////////////////////
        if ($rights >= 6 && $id) {
            $typ = mysql_query("SELECT * FROM `paper` WHERE `id`='$id'");
            $ms = mysql_fetch_array($typ);
            $zag = mb_substr(trim($_POST['nzag']), 0, 100);
            $msg = trim($_POST['nmsg']);
            $error = array ();
            if (($_POST['submit']) && empty($_POST['nmsg']))
                $error[] = 'Вы не ввели текст статьи';
            if (($_POST['submit']) && empty($_POST['nzag']))
                $error[] = 'Вы не ввели заголовок статьи';
            if ($msg && mb_strlen($msg) < 50)
                $error[] = 'Общая длина текста статьи должна быть не менее 50 букв';
            if (!$error) {
                if (isset($_POST['submit'])) {
                    if ($_POST['msgtrans'] == 1) {
                        $msg = trans($msg);
                    } 
                    mysql_query("UPDATE `paper` SET
                    `name` = '" . mysql_real_escape_string($zag) . "',
                    `text` = '" . mysql_real_escape_string($msg) . "'
                    WHERE `id` = '" . $id . "'");
                    if ($ms['close'] != 1)
                        header("location: gazeta.php");
                    else
                        header("location: gazeta.php?act=unpubl");
                } else {
                    $req = mysql_query("SELECT * FROM `paper` WHERE `id` = '" . $id . "'");
                    $ps = mysql_fetch_array($req);
                    $text = htmlentities($ps['text'], ENT_QUOTES, 'UTF-8');
                    $name = htmlentities($ps['name'], ENT_QUOTES, 'UTF-8');
                    echo '<div class="phdr"><b>Газета</b> | редактировать статью</div>';
                    echo '<div class="rmenu"><form action="gazeta.php?act=edit&amp;id=' . $id . '" method="post">';
                    echo 'Заголовок (max. 100):<br/><input type="text" value="' . $name . '" name="nzag" maxlength="100"/><br/>';
                    echo 'Текст статьи:<br/><textarea rows="3" name="nmsg">' . $text . '</textarea><br/>';
                    if ($set_user['translit'])
                        echo '<input type="checkbox" name="msgtrans" value="1" /> Транслит<br/>';
                    echo '<input type="submit" name="submit" value="Изменить"/><br/></form></div>';
                    echo '<div class="phdr"><a href="gazeta.php?act=trans">Транслит</a> | <a href="../str/smile.php">Смайлы</a></div>';
                    echo '<p>' . ($ms['close'] != 1 ? '<a href="gazeta.php">' : '<a href="gazeta.php?act=unpubl">') . 'Назад</a></p>';
                } 
            } else {
                // Выводим сообщение об ошибке
                echo display_error($error, '<a href="gazeta.php?act=edit&amp;id=' . $id . '">Повторить</a>');
            } 
        } 
        break;

    case 'del': 
        ////////////////////////////////////////////////////
        // Удаление статьи                                //
        ////////////////////////////////////////////////////
        if ($rights >= 6 && $id) {
            $typ = mysql_query("SELECT * FROM `paper` WHERE `id`='$id'");
            $ms = mysql_fetch_array($typ);
            if (isset($_GET['yes'])) {
                $limit_del_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper_komm`  WHERE `paperid`='$id'"), 0);
                $limit_del_rating = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper_rating`  WHERE `paperid`='$id'"), 0);
                mysql_query("DELETE FROM `paper` WHERE `id`='$id' LIMIT 1");
                mysql_query("DELETE FROM `paper_komm` WHERE `paperid`='$id' LIMIT $limit_del_post");
                mysql_query("DELETE FROM `paper_rating` WHERE `paperid`='$id' LIMIT $limit_del_rating"); 
                // Удаляем прикрепленные фотографии (если есть)
                if (file_exists(('../files/paper/' . $id . '.jpg')))
                    @unlink('../files/paper/' . $id . '.jpg');
                if (file_exists(('../files/paper/' . $id . '_preview.jpg')))
                    @unlink('../files/paper/' . $id . '_preview.jpg');
                if ($ms['close'] != 1)
                    header("location: gazeta.php");
                else
                    header("location: gazeta.php?act=unpubl");
            } else {
                echo '<div class="phdr"><b>Газета</b> | удалить статью</div>';
                $link = '';
                if ($ms['close'] != 1) {
                    $link = ' | <a href="gazeta.php">Отмена</a>';
                } else {
                    $link = ' | <a href="gazeta.php?act=unpubl">Отмена</a>';
                } 
                echo '<div class="rmenu"><p>Вы уверены, что хотите удалить статью?<br/><a href="gazeta.php?act=del&amp;id=' . $id . '&amp;yes">Удалить</a>' . $link . '</p></div>';
                echo "<div class='phdr'>&nbsp;</div>";
            } 
        } 
        break;

    case 'clean': 
        ////////////////////////////////////////////////////////////
        // Чистка Газеты                                       //
        ////////////////////////////////////////////////////////////
        if ($rights >= 7) {
            echo "<div class='phdr'><b>Чистка газеты</b></div>";
            if (isset($_POST['submit'])) {
                $cl = isset($_POST['cl']) ? intval($_POST['cl']) : '';
                switch ($cl) {
                    case '1': 
                        // Чистим статьи, старше 1 недели
                        $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper` WHERE `time`<='" . ($realtime - 604800) . "';"), 0);
                        if ($count > 0) {
                            // Узнаем ID статей, старше 1 недели
                            $req = mysql_query("SELECT * FROM `paper` WHERE `time`<='" . ($realtime - 604800) . "';");
                            while ($delete = mysql_fetch_assoc($req)) {
                                // Удаляем прикрепленные фотографии (если есть)
                                if (file_exists(('../files/paper/' . $delete['id'] . '.jpg')))
                                    @unlink('../files/paper/' . $delete['id'] . '.jpg');
                                if (file_exists(('../files/paper/' . $delete['id'] . '_preview.jpg')))
                                    @unlink('../files/paper/' . $delete['id'] . '_preview.jpg'); 
                                // Очищаем комментарии и оценки
                                mysql_query("DELETE FROM `paper_komm` WHERE `paperid` ='" . $delete['id'] . "'");
                                mysql_query("DELETE FROM `paper_rating` WHERE `paperid` ='" . $delete['id'] . "'");
                                ++$i;
                            } 
                            mysql_query("DELETE FROM `paper` WHERE `time`<='" . ($realtime - 604800) . "'");
                            echo '<div class="gmenu"><p>Удалены все статьи, старше 1 недели<br /><a href="gazeta.php">Продолжить</a></p></div>';
                        } else {
                            echo display_error('Статей для удаления нет');
                        } 
                        break;

                    case '2': 
                        // Чистим статьи, старше 1 месяца
                        $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper` WHERE `time`<='" . ($realtime - 2592000) . "';"), 0);
                        if ($count > 0) {
                            // Узнаем ID статей, старше 1 месяца
                            $req = mysql_query("SELECT * FROM `paper` WHERE `time`<='" . ($realtime - 2592000) . "';");
                            while ($delete = mysql_fetch_assoc($req)) {
                                // Удаляем прикрепленные фотографии (если есть)
                                if (file_exists(('../files/paper/' . $delete['id'] . '.jpg')))
                                    @unlink('../files/paper/' . $delete['id'] . '.jpg');
                                if (file_exists(('../files/paper/' . $delete['id'] . '_preview.jpg')))
                                    @unlink('../files/paper/' . $delete['id'] . '_preview.jpg'); 
                                // Очищаем комментарии и оценки
                                mysql_query("DELETE FROM `paper_komm` WHERE `paperid` ='" . $delete['id'] . "'");
                                mysql_query("DELETE FROM `paper_rating` WHERE `paperid` ='" . $delete['id'] . "'");
                                ++$i;
                            } 
                            mysql_query("DELETE FROM `paper` WHERE `time`<='" . ($realtime - 2592000) . "'");
                            echo '<div class="gmenu"><p>Удалены все статьи, старше 1 месяца<br /><a href="gazeta.php">Продолжить</a></p></div>';
                        } else {
                            echo display_error('Статей для удаления нет');
                        } 
                        break;

                    default: 
                        // Проводим полную очистку
                        $count = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper`;"), 0);
                        if ($count > 0) {
                            mysql_query("TRUNCATE TABLE `paper`");
                            mysql_query("TRUNCATE TABLE `paper_komm`");
                            mysql_query("TRUNCATE TABLE `paper_rating`"); 
                            // Если есть фотографии, очищаем папку
                            if (file_exists(('../files/paper/'))) {
                                $pap = '../files/paper/';
                                $dir = opendir($pap);
                                while (false !== ($d = readdir($dir))) {
                                    if (is_file($pap . $d)) {
                                        @chmod($pap . $d, 0777);
                                        unlink($pap . $d);
                                    } 
                                } 
                                closedir($dir);
                            } 
                            echo '<div class="gmenu"><p>Газета полностью очищена<br/><a href="gazeta.php">Продолжить</a></p></div>';
                        } else {
                            echo display_error('Статей для удаления нет');
                        } 
                } 
            } else {
                echo '<div class="gmenu">Удалить статьи более:<form action="gazeta.php?act=clean" method="post">';
                echo '<select name="cl">';
                echo '<option value="1">1 недели назад</option>';
                echo '<option value="2">1 месяца назад</option>';
                echo '<option value="0">Полная очистка</option>';
                echo '</select><br />';
                echo '<input value="Удалить" name="submit" type="submit" /></form></div>';
            } 
            $req = mysql_query("SELECT COUNT(*) FROM `paper`");
            $countp = mysql_result($req, 0);
            echo '<div class="phdr">Статей в газете:&nbsp;' . $countp . '</div>';
            echo '<p>' . ($cl ? '<a href="gazeta.php?act=clean">Изменить время чистки</a><br />' : '') . '<a href="gazeta.php">Вернуться в газету</a></p>';
        } 
        break;

    case 'editpost': 
        ////////////////////////////////////////////////////
        // Редактирование поста                           //
        ////////////////////////////////////////////////////
        if ($rights >= 6) {
            if (empty($_GET['id'])) {
                echo "<p>Ошибка!<br/><a href='gazeta.php'>В газету</a></p>";
                require_once("../incfiles/end.php");
                exit;
            } 
            $req = mysql_query("SELECT * FROM `paper_komm` WHERE `id`='" . $id . "';");
            $array = mysql_fetch_array($req);
            $post = mb_substr(trim($_POST['npost']), 0, 500);
            $error = array ();
            if (($_POST['submit']) && empty($_POST['npost']))
                $error[] = 'Вы не ввели сообщение';
            if ($post && mb_strlen($post) < 4)
                $error[] = 'Слишком короткое сообщение';
            if (!$error) {
                if (isset($_POST['submit'])) {
                    $edit_count = $array['edit_count'] + 1;
                    mysql_query("UPDATE `paper_komm` SET
                    `message` = '" . mysql_real_escape_string($post) . "',
                    `edit_who` = '" . $login . "',
                    `edit_time` = '" . $realtime . "',
                    `edit_count`='" . $edit_count . "'
                    WHERE `id`='" . $id . "'");
                    header("location: gazeta.php?act=komm&id=" . $array['paperid'] . "");
                } else {
                    $paperid = $array['paperid'];
                    $post = htmlentities($array['message'], ENT_QUOTES, 'UTF-8');
                    echo '<div class="phdr"><b>Редактировать пост</b></div>';
                    echo '<div class="gmenu"><form action="gazeta.php?act=editpost&amp;id=' . $id . '" method="post">';
                    echo 'Комментарий(max. 500):<br/><textarea cols="20" rows="2" name="npost">' . $post . '</textarea><br/>';
                    echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/></form></div>";
                    echo '<div class="phdr"><a href="gazeta.php?act=trans">Транслит</a> | <a href="../str/smile.php">Смайлы</a></div>';
                    echo '<p><a href="gazeta.php?act=komm&amp;id=' . $paperid . '">Назад</a></p>';
                } 
            } else {
                // Выводим сообщение об ошибке
                echo display_error($error, '<a href="gazeta.php?act=editpost&amp;id=' . $id . '">Повторить</a>');
            } 
        } else {
            header("location: gazeta.php");
        } 
        break;

    case 'massdel': 
        ////////////////////////////////////////////////////////////
        // Удаление выбранных постов                              //
        ////////////////////////////////////////////////////////////
        if ($rights >= 6) {
            require_once("../incfiles/head.php");
            if (isset($_GET['yes'])) {
                $dc = $_SESSION['dc'];
                $prd = $_SESSION['prd'];
                foreach ($dc as $delid) {
                    mysql_query("DELETE FROM `paper_komm` WHERE `id`='" . intval($delid) . "';");
                } 
                echo "Отмеченные посты удалены<br/><a href='" . $prd . "'>Назад</a><br/>";
            } else {
                if (empty($_POST['delch'])) {
                    echo '<p>Вы ничего не выбрали для удаления<br/><a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Назад</a></p>';
                    require_once("../incfiles/end.php");
                    exit;
                } 
                foreach ($_POST['delch'] as $v) {
                    $dc[] = intval($v);
                } 
                $_SESSION['dc'] = $dc;
                $_SESSION['prd'] = htmlspecialchars(getenv("HTTP_REFERER"));
                echo '<p>Вы уверены в удалении постов?<br/><a href="gazeta.php?act=massdel&amp;yes">Да</a> | <a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Нет</a></p>';
            } 
        } else {
            header("location: gazeta.php");
        } 
        break;

    case 'clpost': 
        ////////////////////////////////////////////////////
        // Чистка постов                                  //
        ////////////////////////////////////////////////////
        if ($rights >= 6 && $id) {
            $typ = mysql_query("SELECT * FROM `paper` WHERE `id`='" . $id . "';");
            $ms = mysql_fetch_array($typ);
            $countp = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper_komm`  WHERE `paperid`= " . $id . ""), 0);
            if ($countp == 0)
                $error[] = 'Комментариев нет';
            if (!$error) {
                if (isset($_GET['yes'])) {
                    mysql_query("DELETE FROM `paper_komm` WHERE `paperid`='" . $id . "';");
                    require_once("../incfiles/head.php");
                    echo '<p>Все комментарии удалены!<br/><a href="gazeta.php?act=komm&amp;id=' . $id . '">Продолжить</a></p>';
                    require_once("../incfiles/end.php");
                    exit;
                } else {
                    echo '<form action="gazeta.php?act=clpost&amp;id=' . $id . '&amp;yes" method="post">';
                    echo '<div class="phdr"><b>Очистить посты</b></div>';
                    echo '<div class="menu"><p>Статья:<br/><b>' . $ms['name'] . '</b></p></div>';
                    echo '<div class="rmenu"><p>Вы действительно хотите очистить все посты?</p><p><input type="submit" value=" Очистить "/></p></div>';
                    echo '<div class="phdr"><a href="gazeta.php?act=komm&amp;id=' . $id . '">Отмена операции</a></div>';
                    echo '<p><a href="gazeta.php?act=komm&amp;id=' . $id . '">К комментариям</a><br/><a href="gazeta.php?act=read&amp;id=' . $id . '">К статье</a></p>';
                    echo '</form>';
                } 
            } else {
                echo display_error($error, '<a href="gazeta.php?act=komm&amp;id=' . $id . '">Назад</a>');
            } 
        } 
        break;

    case 'close': 
        ////////////////////////////////////////////////////////////
        // Снятие с публикации                                    //
        ////////////////////////////////////////////////////////////
        if ($rights >= 6) {
            if (isset($_GET['yes'])) {
                $dc = $_SESSION['dc'];
                $prd = $_SESSION['prd'];
                foreach ($dc as $closeid) {
                    mysql_query("UPDATE `paper` SET  `close` = '1', `close_time` = '$realtime', `close_who` = '$login' WHERE `id`='" . intval($closeid) . "';");
                } 
                echo "Отмеченные статьи сняты с публикации<br/><a href='" . $prd . "'>Назад</a><br/>";
            } else {
                if (empty($_POST['closech'])) {
                    echo '<p>Вы ничего не выбрали для снятия с публикации<br/><a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Назад</a></p>';
                    require_once("../incfiles/end.php");
                    exit;
                } 
                foreach ($_POST['closech'] as $v) {
                    $dc[] = intval($v);
                } 
                $_SESSION['dc'] = $dc;
                $_SESSION['prd'] = htmlspecialchars(getenv("HTTP_REFERER"));
                echo '<p>Вы уверены, что хотите снять с публикации выбранные статьи?<br/><a href="gazeta.php?act=close&amp;yes">Да</a> | <a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Нет</a></p>';
            } 
        } else {
            header("location: gazeta.php");
        } 
        break;

    case 'publication': 
        ////////////////////////////////////////////////////////////
        // Публикация статей                                      //
        ////////////////////////////////////////////////////////////
        if ($rights >= 6) {
            if (isset($_GET['yes'])) {
                $dc = $_SESSION['dc'];
                $prd = $_SESSION['prd'];
                foreach ($dc as $publid) {
                    mysql_query("UPDATE `paper` SET  `close` = '0', `close_who` = null, `close_time` = '0', `avtor` = '$login', `time` = '$realtime' WHERE `id`='" . intval($publid) . "';");
                } 
                echo "Отмеченные статьи опубликованы<br/><a href='" . $prd . "'>Назад</a><br/>";
            } else {
                if (empty($_POST['publch'])) {
                    echo '<p>Вы ничего не выбрали для публикации<br/><a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Назад</a></p>';
                    require_once("../incfiles/end.php");
                    exit;
                } 
                foreach ($_POST['publch'] as $v) {
                    $dc[] = intval($v);
                } 
                $_SESSION['dc'] = $dc;
                $_SESSION['prd'] = htmlspecialchars(getenv("HTTP_REFERER"));
                echo '<p>Вы уверены, что хотите опубликовать выбранные статьи?<br/><a href="gazeta.php?act=publication&amp;yes">Да</a> | <a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Нет</a></p>';
            } 
        } 
        break;

    case 'estimate': 
        ////////////////////////////////////////////////////
        // Оценивание статьи                              //
        ////////////////////////////////////////////////////
        if (!$id) {
            echo "<p>Ошибка!<br/><a href='gazeta.php'>В газету</a></p>";
            require_once("../incfiles/end.php");
            exit;
        } 
        // Закрываем доступ для гостей
        if (!$user_id) {
            echo display_error('Только для зарегистрированных');
            require_once('../incfiles/end.php');
            exit;
        } 
        $typ = mysql_query("SELECT * FROM `paper` WHERE `id`='" . $id . "';");
        $ms = mysql_fetch_array($typ); 
        // Если статья снята с публикации, закрываем доступ
        if ($ms['close'] == 1 && $rights < 7) {
            echo display_error('Статья временно снята с публикации');
            require_once('../incfiles/end.php');
            exit;
        } 
        $ball = intval(check($_GET['ball']));
        $q = @mysql_query("SELECT * FROM `paper_rating` WHERE `user_id` = '" . $user_id . "' AND `paperid` = '" . $id . "';");
        $arr = mysql_num_rows($q);
        $error = false;
        if ($arr != 0)
            $error = 'Вы уже оценивали данную статью';
        if (intval($_GET['ball']) > 5 OR intval($_GET['ball']) <= 0)
            $error = 'Неверная оценка статьи<br />Разрешено от 1 до 5';
        if (!$error) {
            if (isset($_POST['submit'])) {
                $text = trim($_POST['text']);
                $text = mysql_real_escape_string(mb_substr($text, 0, 500));
                mysql_query("INSERT INTO `paper_rating` SET `paperid` = '$id', `time` = '$realtime', `user_id` = '$user_id', `message` = '$text', `ball` = '$ball';");
                echo '<div class="gmenu"><p>Ваша оценка принята<br/><a href="gazeta.php?act=read&amp;id=' . $id . '">Продолжить</a></p></div>';
            } else {
                echo '<div class="phdr"><b>Оценить статью</b></div>';
                echo '<div class="bmenu">Ваш выбор: ' . $ball . '</div>';
                echo '<form action="gazeta.php?act=estimate&amp;id=' . $ms['id'] . '&amp;ball=' . $ball . '" method="post">';
                echo '<div class="gmenu"><b>Комментарий:</b><br /><input name="text" type="text" value=""/><br /><small>максимум 500 символов</small><p><input type="submit" name="submit" value="Подтвердить"/></p></div>';
                echo '<div class="phdr"><a href="gazeta.php?act=read&amp;id=' . $id . '">Назад</a></div>';
                echo '</form>';
            } 
        } else {
            // Выводим сообщения об ошибках
            echo display_error($error);
        } 
        break;

    case 'users': 
        ////////////////////////////////////////////////////
        // Список юзеров                                //
        ////////////////////////////////////////////////////
        if (!$id) {
            echo "<p>Ошибка!<br/><a href='gazeta.php'>В газету</a></p>";
            require_once("../incfiles/end.php");
            exit;
        } 
        // Закрываем доступ для гостей
        if (!$user_id) {
            echo display_error('Только для зарегистрированных');
            require_once('../incfiles/end.php');
            exit;
        } 
        $typ = mysql_query("SELECT * FROM `paper` WHERE `id`='$id'");
        $ms = mysql_fetch_array($typ); 
        // Если статья снята с публикации, закрываем доступ
        if ($ms['close'] == 1 && $rights < 7) {
            echo display_error('Статья временно снята с публикации');
            require_once('../incfiles/end.php');
            exit;
        } 
        echo '<div class="phdr"><b>Рейтинг статьи</b></div>';
        echo '<div class="bmenu">Пользователи оценившие статью</div>';
        $req = mysql_query("SELECT COUNT(*) FROM `paper_rating`  WHERE `paperid`= " . $id . "");
        $total = mysql_result($req, 0);
        if ($total) {
            $req = mysql_query("SELECT * FROM `paper_rating` WHERE `paperid`= " . $id . " ORDER BY `time` DESC LIMIT " . $start . "," . $kmess . ";");
            while ($res = mysql_fetch_array($req)) {
                echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<div class="list1">' : '<div class="list2">';
                $vrp = $res['time'] + $sdvig * 3600;
                $vr = date("(d.m.y / H:i)", $vrp);
                echo ($res['ball'] >= 4 ? '<span class="green">' . $res['ball'] . '</span>' : '<span class="red">' . $res['ball'] . '</span>') . '&nbsp;';
                $uz = @mysql_query("select `name`,`sex`,`id`,`lastdate` from `users` where id='" . $res['user_id'] . "';");
                $user = @mysql_fetch_array($uz);
                if ($user_id != $user['id']) {
                    echo '<a href="' . $home . '/str/anketa.php?id=' . $user['id'] . '"><b>' . $user['name'] . '</b></a> ';
                } else {
                    echo '<b>' . $user['name'] . '</b> ';
                } 
                echo $vr;
                if ($res['message'])
                    echo '<div class="sub">' . $res['message'] . '</div>';
                echo '</div>';
                ++$i;
            } 
        } else {
            echo '<div class="menu"><p>Список пуст</p></div>';
        } 
        echo '<div class="phdr">Всего:&nbsp;' . $total . '</div>';
        if ($total > $kmess) {
            echo '<p>' . pagenav('gazeta.php?act=users&amp;id=' . $id . '&amp;', $start, $total, $kmess) . '</p>';
            echo '<p><form action="gazeta.php" method="get"><input type="hidden" name="act" value="users"/><input type="hidden" name="id" value="' . $id
             . '"/><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        } 
        echo '<p><a href="gazeta.php?act=read&amp;id=' . $id . '">К статье</a></p>';
        break;

    case 'symb': 
        ////////////////////////////////////////////////////
        // Настройки                               //
        ////////////////////////////////////////////////////
        if (isset($_POST['submit'])) {
            if (!empty($_POST['simvol'])) {
                $simvol = intval($_POST['simvol']);
            } 
            $_SESSION['symb'] = $simvol;
            echo "<div class='gmenu'>На время текущей сессии принято $simvol символов<br/><a href='gazeta.php'>В газету</a></div>";
        } else {
            echo "<div class='phdr'><b>Настройки</b></div>";
            echo "<form action='gazeta.php?act=symb' method='post'>";
            echo "<div class='gmenu'>Выберите к-во символов:<br/><select name='simvol'>";
            if (!empty($_SESSION['symb'])) {
                $realr = $_SESSION['symb'];
                echo "<option value='" . $realr . "'>" . $realr . "</option>";
            } 
            echo "<option value='500'>500</option>";
            echo "<option value='1000'>1000</option>";
            echo "<option value='2000'>2000</option>";
            echo "<option value='3000'>3000</option>";
            echo "<option value='4000'>4000</option>";
            echo "</select><br/>";
            echo "<input type='submit' name='submit' value='ok'/></div></form>";
            echo "<div class='phdr'><small>Настройка количества символов на страницу действительна на время текущей сессии</small></div>";
            echo '<p><a href="gazeta.php">В газету</a></p>';
        } 
        break;

    case 'read': 
        ////////////////////////////////////////////////////
        // Вывод статьи                                 //
        ////////////////////////////////////////////////////
        if (empty($_GET['id'])) {
            echo "<p>Ошибка!<br/><a href='gazeta.php'>В газету</a></p>";
            require_once("../incfiles/end.php");
            exit;
        } 
        // Запрос имени статьи
        $req = mysql_query("SELECT `name` FROM `paper` WHERE `id` = '" . $id . "' LIMIT 1"); 
        // Если статья не существует, останавливаем скрипт
        if (mysql_num_rows($req) != 1) {
            require_once("../incfiles/head.php");
            echo display_error('Не выбрана статья', '<a href="gazeta.php">В газету</a>');
            require_once ('../incfiles/end.php');
            exit;
        } 
        $typ = mysql_query("SELECT * FROM `paper` WHERE `id`='" . $id . "';");
        $ms = mysql_fetch_array($typ);
        $countp = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper_komm`  where `paperid`= " . $id . ""), 0); 
        // Если статья снята с публикации, закрываем доступ
        if ($ms['close'] == 1 && $rights < 7) {
            echo display_error('Статья временно снята с публикации');
            require_once('../incfiles/end.php');
            exit;
        } 
        $month[1] = "Январ";
        $month[2] = "Феврал";
        $month[3] = "Март";
        $month[4] = "Апрел";
        $month[5] = "Ма";
        $month[6] = "Июн";
        $month[7] = "Июл";
        $month[8] = "Август";
        $month[9] = "Сентябр";
        $month[10] = "Октябр";
        $month[11] = "Декабр";
        $month[12] = "Январ";
        $time = $ms['time'] + $sdvig * 3600;
        $mnum = date("n", $time);
        $daym = date("d", $time);
        $year = date("Y", $time);
        $monthm = $month[$mnum];
        if ($mnum == 3 || $mnum == 8) {
            $k = "а";
        } else {
            $k = "я";
        } 
        echo '<div class="phdr"><b>Газета от ' . $daym . '&nbsp;' . $monthm . '' . $k . '&nbsp;' . $year . ' года</b></div>';
        echo '<div class="menu"><td>';
        echo '<p><h3>' . $ms['name'] . '</h3></p>';
        if (file_exists(('../files/paper/' . $id . '.jpg')))
            echo '<img src="../files/paper/' . $id . '.jpg" align="left" hspace="6" vspace="6" alt="photo" />';
        if (!empty($_SESSION['symb'])) {
            $simvol = $_SESSION['symb'];
        } else {
            // Число символов на страницу по умолчанию
            $simvol = 1000;
        } 
        // Счетчик прочтений
        if ($_SESSION['paper'] != $id) {
            $_SESSION['paper'] = $id;
            $colm = intval($ms['count']) + 1;
            mysql_query("UPDATE `paper` SET  `count` = '" . $colm . "' WHERE `id` = '" . $id . "'");
        } 
        $tx = $ms['text'];
        $strrpos = mb_strrpos($tx, " ");
        $pages = 1; 
        // Вычисляем номер страницы
        if (isset($_GET['page'])) {
            $page = abs(intval($_GET['page']));
            if ($page == 0)
                $page = 1;
            $start = $page - 1;
        } else {
            $page = $start + 1;
        } 
        $t_si = 0;
        if ($strrpos) {
            while ($t_si < $strrpos) {
                $string = mb_substr($tx, $t_si, $simvol);
                $t_ki = mb_strrpos($string, " ");
                $m_sim = $t_ki;
                $strings[$pages] = $string;
                $t_si = $t_ki + $t_si;
                if ($page == $pages) {
                    $page_text = $strings[$pages];
                } 
                if ($strings[$pages] == "") {
                    $t_si = $strrpos++;
                } else {
                    $pages++;
                } 
            } 
            if ($page >= $pages) {
                $page = $pages - 1;
                $page_text = $strings[$page];
            } 
            $pages = $pages - 1;
            if ($page != $pages) {
                $prb = mb_strrpos($page_text, " ");
                $page_text = mb_substr($page_text, 0, $prb);
            } 
        } else {
            $page_text = $tx;
        } 
        $page_text = htmlentities($page_text, ENT_QUOTES, 'UTF-8');
        $page_text = tags($page_text);
        $page_text = str_replace("\r\n", "<br />", $page_text);
        $page_text = smileys($page_text);
        echo nl2br($page_text);
        echo '</td></div>';

        $id = $ms['id'];
        $zapros_vsego = mysql_query("SELECT COUNT(ball) FROM `paper_rating` WHERE `paperid` = '" . $id . "';");
        $vsego = mysql_result($zapros_vsego, 0);
        $zapros_summ = mysql_query("SELECT SUM(ball) FROM `paper_rating` WHERE `paperid` = '" . $id . "';");
        $summ = mysql_result($zapros_summ, 0);
        if ($summ > 0) {
            $sredn = $summ / $vsego;
            echo '<div class="gmenu">Рейтинг статьи: ' . $sredn . '<br />Оценили: ' . $vsego . ' раз(а)</div>';
        } else {
            echo '<div class="gmenu">Статья не оценена</div>';
        } 
        $q = @mysql_query("SELECT * FROM `paper_rating` WHERE `user_id` = '" . $user_id . "' AND `paperid` = '" . $ms['id'] . "';");
        $arr = mysql_num_rows($q);
        if ($_SESSION['uid'] && $arr == 0) {
            echo '<div class="rmenu">Оценить: <a href="gazeta.php?act=estimate&amp;id=' . $ms['id'] . '&amp;ball=1">1</a> | <a href="gazeta.php?act=estimate&amp;id=' . $ms['id']
             . '&amp;ball=2">2</a> |<a href="gazeta.php?act=estimate&amp;id=' . $ms['id'] . '&amp;ball=3">3</a> | <a href="gazeta.php?act=estimate&amp;id=' . $ms['id'] . '&amp;ball=4">4</a> | <a href="gazeta.php?act=estimate&amp;id='
             . $ms['id'] . '&amp;ball=5">5</a></div>';
        } else {
            if (!empty($user_id)) {
                $usr_summ = mysql_query("SELECT SUM(ball) FROM `paper_rating` WHERE `paperid` = '" . $id . "' AND `user_id` = '" . $user_id . "';");
                $usr_ball = mysql_result($usr_summ, 0);
                echo '<div class="rmenu">Ваша оценка: <a href="gazeta.php?act=users&amp;id=' . $id . '">' . $usr_ball . '</a></div>';
            } 
        } 
        echo '<div class="phdr"><a href="gazeta.php?act=komm&amp;id=' . $id . '">Комментарии</a>  (' . $countp . ')</div>';
        if ($pages > 1) {
            echo '<p>' . pagenav('gazeta.php?act=read&amp;id=' . $ms['id'] . '&amp;', $start, $pages, 1) . '</p>';
            echo '<p><form action="gazeta.php" method="get"><input type="hidden" name="act" value="read"/><input type="hidden" name="id" value="' . $id . '"/><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        } 
        echo '<p><a href="gazeta.php?act=link&amp;id=' . $id . '">Ссылка на статью</a><br /><a href="gazeta.php">Все статьи</a></p>';
        break;

    case 'say': 
        ////////////////////////////////////////////////////
        // Добавление сообщения                                //
        ////////////////////////////////////////////////////
        $id = intval($_GET['id']); 
        // Закрываем доступ для гостей
        if (!$user_id) {
            echo display_error('Только для зарегистрированных');
            require_once('../incfiles/end.php');
            exit;
        } 
        $post = mb_substr(trim($_POST['post']), 0, 500);
        $trans = isset($_POST['msgtrans']) ? 1 : 0; 
        // Транслит сообщения
        if ($trans)
            $post = trans($post);
        $error = array ();
        if (empty($_POST['post']))
            $error[] = 'Вы не ввели сообщение';
        if ($post && mb_strlen($post) < 4)
            $error[] = 'Слишком короткое сообщение';
        if (!$error) {
            // Проверка на одинаковые сообщения
            $req = mysql_query("SELECT * FROM `paper_komm` WHERE `user_id` = '$user_id' ORDER BY `time` DESC");
            $res = mysql_fetch_array($req);
            if ($res['message'] == $post) {
                header("location: gazeta.php?act=komm&id=" . $id . "");
                exit;
            } 
        } 
        if (!$error) {
            // Вставляем сообщение в базу
            mysql_query("insert into `paper_komm` set
                `time` = '" . $realtime . "',
                `paperid` = '" . $id . "',
                `user_id` = '" . $user_id . "',
                 `ip` = '" . $ipl . "',
                 `browser` = '" . $agn . "',
                `message` = '" . mysql_real_escape_string($post) . "';");
            $plus = $datauser['komm'] + 1;
            mysql_query("update `users` set
                `komm` = '" . $plus . "' WHERE `id` = '" . $user_id . "'");
            header("location: gazeta.php?act=komm&id=" . $id . "");
        } else {
            // Выводим сообщение об ошибке
            require_once("../incfiles/head.php");
            echo display_error($error, '<a href="gazeta.php?act=komm&amp;id=' . $id . '">Назад</a>');
            require_once("../incfiles/end.php");
            exit;
        } 
        break;

    case 'komm': 
        ////////////////////////////////////////////////////
        // Комметарии                                //
        ////////////////////////////////////////////////////
        if (empty($_GET['id'])) {
            require_once("../incfiles/head.php");
            echo "<p>Ошибка!<br/><a href='gazeta.php'>В газету</a></p>";
            require_once("../incfiles/end.php");
            exit;
        } 
        // Запрос имени статьи
        $req = mysql_query("SELECT `name` FROM `paper` WHERE `id` = '" . $id . "' LIMIT 1"); 
        // Если статья не существует, останавливаем скрипт
        if (mysql_num_rows($req) != 1) {
            require_once("../incfiles/head.php");
            echo display_error('Не выбрана статья', '<a href="gazeta.php">В газету</a>');
            require_once ('../incfiles/end.php');
            exit;
        } 
        $typ = mysql_query("SELECT * FROM `paper` WHERE `id`='" . $id . "';");
        $ms = mysql_fetch_array($typ); 
        // Если статья снята с публикации, закрываем доступ
        if ($ms['close'] == 1 && $rights < 7) {
            echo display_error('Статья временно снята с публикации');
            require_once('../incfiles/end.php');
            exit;
        } 
        echo '<div class="phdr">Комментируем статью: <b>' . $ms['name'] . '</b></div>';
        if (!empty($user_id)) {
            echo '<div class="gmenu"><form action="gazeta.php?act=say&amp;id=' . $id . '" method="post">';
            echo 'Комментарий(max. 500):<br/><textarea cols="20" rows="2" name="post"></textarea><br/>';
            if ($set_user['translit'])
                echo '<input type="checkbox" name="msgtrans" value="1" /> Транслит сообщения<br/>';
            echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/></form></div>";
        } else {
            echo '<div class="rmenu">Оставлять комментарии могут только <a href="' . $home . '/login.php">авторизованные</a> пользователи</div>';
        } 
        $req = mysql_query("SELECT COUNT(*) FROM `paper_komm`  WHERE `paperid`= " . $id . "");
        $total = mysql_result($req, 0);
        if ($total) {
            $req = mysql_query("SELECT `paper_komm`.*, `paper_komm`.`id` AS `mid`, `users`.`rights`, `users`.`name`, `users`.`lastdate`, `users`.`sex`, `users`.`status`, `users`.`datereg`, `users`.`id`
			FROM `paper_komm` LEFT JOIN `users` ON `paper_komm`.`user_id` = `users`.`id` WHERE `paper_komm`.`paperid`='$id' ORDER BY `paper_komm`.`time` DESC LIMIT $start, $kmess");
            if ($rights >= 6)
                echo '<form action="gazeta.php?act=massdel" method="post">';
            while ($res = mysql_fetch_assoc($req)) {
                $text = '';
                echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
                $text = ' <span class="gray">(' . date("d.m.y / H:i", $res['time'] + $set_user['sdvig'] * 3600) . ')</span>';
                $post = checkout($res['message'], 1, 1);
                if ($set_user['smileys'])
                    $post = smileys($post, $res['rights'] >= 1 ? 1 : 0);
                if ($res['edit_count']) {
                    // Если пост редактировался, показываем кем и когда
                    $dizm = date("d.m /H:i", $res['edit_time'] + $set_user['sdvig'] * 3600);
                    $post .= '<br /><span class="gray"><small>Изм. <b>' . $res['edit_who'] . '</b> (' . $dizm . ') <b>[' . $res['edit_count'] . ']</b></small></span>';
                } 
                $subtext = '<input type="checkbox" name="delch[]" value="' . $res['mid'] . '"/>&nbsp;<a href="gazeta.php?act=editpost&amp;id=' . $res['mid'] . '">Изменить</a> | <a href="gazeta.php?act=delpost&amp;id=' . $res['mid'] . '">Удалить</a>';
                echo show_user($res, 1, ($rights >= 6 && $rights >= $res['rights'] ? 1 : 0), $text, $post, ($rights >= 6 ? $subtext : ''));
                echo '</div>';
                ++$i;
            } 
            if ($rights >= 6) {
                echo '<div class="rmenu"><input type="submit" value=" Удалить "/></div>';
                echo '</form>';
            } 
        } else {
            echo '<div class="menu"><p>Комментариев нет</p></div>';
        } 
        echo '<div class="phdr">Всего:&nbsp;' . $total . '</div>';
        if ($total && $rights >= 6)
            echo '<p><div class="func"><a href="gazeta.php?act=clpost&amp;id=' . $ms['id'] . '">Очистить все посты</a></div></p>';
        if ($total > $kmess) {
            echo '<p>' . pagenav('gazeta.php?act=komm&amp;id=' . $id . '&amp;', $start, $total, $kmess) . '</p>';
            echo '<p><form action="gazeta.php" method="get"><input type="hidden" name="act" value="komm"/><input type="hidden" name="id" value="' . $id
             . '"/><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        } 
        echo '<p><a href="gazeta.php?act=read&amp;id=' . $id . '">Вернуться к статье</a><br /><a href="gazeta.php">В газету</a></p>';
        break;

    case 'delpost': 
        ////////////////////////////////////////////////////
        // Удаление поста                                //
        ////////////////////////////////////////////////////
        if ($rights >= 6 && $id) {
            $id = intval($_GET['id']);
            $typ = mysql_query("SELECT * FROM `paper_komm` WHERE `id`='$id'");
            $ms = mysql_fetch_array($typ);
            $paperid = $ms['paperid'];
            if (isset($_GET['yes'])) {
                mysql_query("DELETE FROM `paper_komm` WHERE `id`='$id' LIMIT 1");
                header("location: gazeta.php?act=komm&id=$paperid");
            } else {
                echo '<div class="phdr"><b>Удалить пост</b></div>';
                echo '<div class="rmenu"><p>Вы уверены в удалении комментария?<br/><a href="gazeta.php?act=delpost&amp;id=' . $id . '&amp;yes">Удалить</a> | <a href="gazeta.php?act=komm&amp;id=' . $paperid . '">Отмена</a></p></div>';
                echo '<div class="phdr"><small>В случае удаления, из счетчика комментариев будет вычтен один балл</small></div>';
            } 
        } 
        break;

    case "link": 
        ////////////////////////////////////////////////////
        // Ссылка на статью                                  //
        ////////////////////////////////////////////////////
        if (empty($_GET['id'])) {
            echo "<p>Ошибка!<br/><a href='gazeta.php'>В газету</a></p>";
            require_once("../incfiles/end.php");
            exit;
        } 
        $id = intval($_GET['id']);
        $req = mysql_query("SELECT * FROM `paper` WHERE `id`='" . $id . "';");
        $res = mysql_fetch_array($req);
        $link_forum = "[url=$home/gazeta.php?act=read&amp;id=$id]" . $res[name] . "[/url]";
        $link_forum = htmlspecialchars($link_forum);
        echo '<div class="phdr"><b>Ссылка на статью</b></div>';
        echo '<div class="gmenu"><p>Обычная ссылка:<br /><input type="text" value="' . $home . '/gazeta.php?act=read&amp;id=' . $id . '"/></p></div>';
        echo '<div class="menu"><p>Ссылка для форума:<br /><input type="text" value="' . $link_forum . '"/></p></div>';
        echo '<div class="phdr"><small>Вы можете скопировать ссылку на статью для Своих друзей</small></div>';
        echo '<p><a href="gazeta.php?act=read&amp;id=' . $id . '">К статье</a></p>';
        break;

    case "unpubl": 
        ////////////////////////////////////////////////////
        // Список неопубликованных статей                                //
        ////////////////////////////////////////////////////
        if ($rights >= 6) {
            echo '<div class="phdr"><b>Газета</b></div>';
            echo '<div class="bmenu">Скрытые статьи</div>';
            $req = mysql_query("SELECT COUNT(*) FROM `paper` WHERE `close` = '1'");
            $total = mysql_result($req, 0);
            if ($total) {
                $req = mysql_query("SELECT * FROM `paper` WHERE `close` = '1' ORDER BY `time` DESC LIMIT " . $start . "," . $kmess . ";");
                echo '<form action="gazeta.php?act=publication" method="post">';
                while ($res = mysql_fetch_array($req)) {
                    echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<div class="list1">' : '<div class="list2">';
                    $vrp = $res['close_time'] + $sdvig * 3600;
                    $vr1 = date("d.m.y", $vrp);
                    $vr2 = date("H:i", $vrp);
                    $countp = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper_komm`  WHERE `paperid`= " . $res['id'] . ""), 0);
                    echo '<td><p><h3>' . $res['name'] . '</h3>';
                    echo '<div class="gray"><small>Снял с публикации: <b>' . $res['close_who'] . '</b>&nbsp;' . $vr1 . '&nbsp;[' . $vr2 . ']</small></div></p>';
                    if (file_exists(('../files/paper/' . $res['id'] . '_preview.jpg')))
                        echo '<img src="../files/paper/' . $res['id'] . '_preview.jpg" align="left" hspace="6" vspace="6" alt="photo" />';
                    $text = $res['text'];
                    if (mb_strlen($text) > 1000) {
                        $text = mb_substr($text, 0, 1000);
                        $text = checkout($text, 1, 0);
                        echo $text . '...<br /><a href="gazeta.php?act=read&amp;id=' . $res['id'] . '">Читать статью &gt;&gt;</a>';
                    } else {
                        // Или, обрабатываем тэги и выводим весь текст
                        $text = checkout($text, 1, 1);
                        if ($set_user['smileys'])
                            $text = smileys($text, 1);
                        echo $text . '<br /><a href="gazeta.php?act=read&amp;id=' . $res['id'] . '">Читать статью &gt;&gt;</a>';
                    } 
                    echo '</td><div class="sub">Комментарии: ' . $countp . ' · Прочтений: ' . $res['count'];
                    echo '<br/><input type="checkbox" name="publch[]" value="' . $res['id'] . '"/>&nbsp;<a href="gazeta.php?act=edit&amp;id=' . $res['id'] . '">Изменить</a> | <a href="gazeta.php?act=del&amp;id=' . $res['id']
                     . '">Удалить</a>';
                    echo '</div></div>';
                    ++$i;
                } 
                echo '<div class="gmenu"><input type="submit" value=" Опубликовать "/></div>';
                echo '</form>';
            } else {
                echo '<div class="menu"><p>Неопубликованных статей нет</p></div>';
            } 
            echo '<div class="phdr">Всего:&nbsp;' . $total . '</div>';
            if ($total > $kmess) {
                echo '<p>' . pagenav('gazeta.php?act=unpubl&amp;', $start, $total, $kmess) . '</p>';
                echo '<p><form action="gazeta.php" method="get"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
            } 
            echo '<p><a href="gazeta.php">В газету</a></p>';
        } else {
            header("location: gazeta.php");
        } 
        break;

    default: 
        ////////////////////////////////////////////////////
        // Вывод списка статей                                  //
        ////////////////////////////////////////////////////
        echo '<div class="phdr"><b>Газета</b></div>';
        $total = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper` WHERE `close` != '1'"), 0);
        if ($total) {
            $req = mysql_query("SELECT * FROM `paper` WHERE `close` != '1' ORDER BY `time` DESC LIMIT $start,$kmess");
            if ($rights >= 6)
                echo '<form action="gazeta.php?act=close" method="post">';
            while ($res = mysql_fetch_array($req)) {
                echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<div class="list1">' : '<div class="list2">';
                $vrp = $res['time'] + $sdvig * 3600;
                $vr1 = date("d.m.y", $vrp);
                $vr2 = date("H:i", $vrp);
                $countp = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper_komm`  WHERE `paperid`= " . $res['id'] . ""), 0);
                echo '<td><p><h3>' . $res['name'] . '</h3>';
                echo '<div class="gray"><small>Опубликовал: <b>' . $res['avtor'] . '</b>&nbsp;' . $vr1 . '&nbsp;[' . $vr2 . ']</small></div></p>';
                if (file_exists(('../files/paper/' . $res['id'] . '_preview.jpg')))
                    echo '<img src="../files/paper/' . $res['id'] . '_preview.jpg" align="left" hspace="6" vspace="6" alt="photo" />';
                $text = $res['text'];
                if (mb_strlen($text) > 1000) {
                    $text = mb_substr($text, 0, 1000);
                    $text = checkout($text, 1, 0);
                    echo $text . '...<br /><a href="gazeta.php?act=read&amp;id=' . $res['id'] . '">Читать статью &gt;&gt;</a>';
                } else {
                    // Или, обрабатываем тэги и выводим весь текст
                    $text = checkout($text, 1, 1);
                    if ($set_user['smileys'])
                        $text = smileys($text, 1);
                    echo $text . '<br /><a href="gazeta.php?act=read&amp;id=' . $res['id'] . '">Читать статью &gt;&gt;</a>';
                } 
                echo '</td><div class="sub">Комментарии: ' . $countp . ' · Прочтений: ' . $res['count'];
                if ($rights >= 6)
                    echo '<br/><input type="checkbox" name="closech[]" value="' . $res['id'] . '"/>&nbsp;<a href="gazeta.php?act=edit&amp;id=' . $res['id'] . '">Изменить</a> | <a href="gazeta.php?act=del&amp;id=' . $res['id']
                     . '">Удалить</a>';
                echo '</div></div>';
                ++$i;
            } 
            if ($rights >= 6) {
                echo '<div class="rmenu"><input type="submit" value=" Снять с публикации "/></div>';
                echo '</form>';
            } 
        } else {
            echo '<div class="menu"><p>Статей нет</p></div>';
        } 
        echo '<div class="gmenu"><a href="gazeta.php?act=symb">Настройки</a></div>';
        echo '<div class="phdr">Всего:&nbsp;' . $total . '</div>';
        if ($total > $kmess) {
            echo '<p>' . pagenav('gazeta.php?', $start, $total, $kmess) . '</p>';
            echo '<p><form action="gazeta.php" method="get"><input type="text" name="page" size="2"/><input type="submit" value="К странице &gt;&gt;"/></form></p>';
        } 
        if ($rights >= 6) {
            $total_unpubl = mysql_result(mysql_query("SELECT COUNT(*) FROM `paper`  WHERE `close`= '1'"), 0);
            echo '<p><a href="gazeta.php?act=unpubl">Скрытые статьи</a> (' . $total_unpubl . ')</p>';
            echo '<p><a href="gazeta.php?act=write">Написать статью</a>';
            if ($rights >= 7)
                echo '<br/><a href="gazeta.php?act=clean">Чистка газеты</a>';
            echo '</p>';
        } 
        break;
} 

require_once('../incfiles/end.php');

?>