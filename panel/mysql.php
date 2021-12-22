<?php

/*
////////////////////////////////////////////////////////////////////////////////
// JohnCMS                             Content Management System              //
// Официальный сайт сайт проекта:      http://johncms.com                     //
// Дополнительный сайт поддержки:      http://gazenwagen.com                  //
////////////////////////////////////////////////////////////////////////////////
// JohnCMS core team:                                                         //
// Евгений Рябинин aka john77          john77@gazenwagen.com                  //
// Олег Касьянов aka AlkatraZ          alkatraz@gazenwagen.com                //
//                                                                            //
// Информацию о версиях смотрите в прилагаемом файле version.txt              //
////////////////////////////////////////////////////////////////////////////////
By FlySelf
*/

defined('_IN_JOHNADM') or die('Error: restricted access');

require_once ('../incfiles/ban.php');
if ($rights == 9)
{
    if ($_FILES['fail']['size'] > 0)
    {
        $file = strtolower($_FILES['fail']['name']);
        $al_ext = array('txt', 'sql');
        $ext = explode(".", $file);
        if (count($ext) != 2 || !in_array($ext[1], $al_ext))
        {
            echo display_error('К отправке разрешены только файлы имеющие имя и одно расширение (<b>name.ext</b>) и расширение должно быть txt или же sql');
        } else
        {
            $file = $realtime . '.' . $ext[1];
            if ((move_uploaded_file($_FILES["fail"]["tmp_name"], "sql/$file")) == true)
            {
                @chmod("$fname", 0777);
                @chmod("files/$fname", 0777);
                $sql = file_get_contents('sql/' . $file);
                $sql = str_replace("\'", "'", trim($sql));
                $sql = split(";(\n|\r)*", $sql);
                $total_sql = 0;
                $total_sqk_ok = 0;
                for ($i = 0; $i < count($sql); $i++)
                {
                    if ($sql[$i] != '')
                    {
                        ++$total_sql;
                        if (mysql_query($sql[$i]))
                        {
                            ++$total_sql_ok;
                        }
                    }
                }
                if ($total_sql)
                    echo '<div class="gmenu">' . (($total_sql_ok == 1 && $total_sql = 1) ? 'Запрос успешно выполнен' : 'Выполнено ' . $total_sql_ok . ' запросов из ' . $total_sql) . '</div>';
                else
                    echo '<div class="rmenu">Ошибка</div>';

                unlink("sql/$file");
            } else
                echo display_error('Ошибка при ВРЕМЕННОМ сохранени файла');
            echo '<div class="b"><a href="index.php?act=mysql">Повторить</a></div>';
            echo '<p><a href="index.php">Админка</a></p>';
        }
    } else
        if (isset($_POST['submit']) && $_POST['sql'])
        {
            $sql = str_replace("\'", "'", trim($_POST['sql']));
            $sql = split(";(\n|\r)*", $sql);
            $total_sql = 0;
            $total_sqk_ok = 0;
            for ($i = 0; $i < count($sql); $i++)
            {
                if ($sql[$i] != '')
                {
                    ++$total_sql;
                    if (mysql_query($sql[$i]))
                    {
                        ++$total_sql_ok;
                    }
                }
            }
            if ($total_sql)
                echo '<div class="gmenu">' . (($total_sql_ok == 1 && $total_sql = 1) ? 'Запрос успешно выполнен' : 'Выполнено ' . $total_sql_ok . ' запросов из ' . $total_sql) . '</div>';
            else
                echo '<div class="rmenu">Ошибка</div>';
            echo '<div class="b"><a href="index.php?act=mysql">Повторить</a></div>';
            echo '<p><a href="index.php">Админка</a></p>';
        } else
        {
            echo '<div class="phdr"><b>MySQL запросы</b></div>';
            echo '<div class="rmenu"><form action="index.php?act=mysql" method="post" enctype="multipart/form-data"><b>Запросы:</b><br />
      <textarea rows="3" name="sql"></textarea><br /><b>Импорт:</b><br/><input type="file" name="fail"/><br /><input type="submit" name="submit" value="Выполнить"/></form></div><div class="phdr">Файл должен быть в кодировке UTF-8 и иметь расширение txt или же sql</div>';
            echo '<p><a href="index.php">Назад</a></p>';
        }

} else
{
    header('Location: ../?err');
}

require_once ("../incfiles/end.php");

?>