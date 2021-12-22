<?

defined('_IN_JOHNCMS') or die('Error: restricted access');

////////////////////////////////////////////////////////////
// Главное меню сайта                                     //
////////////////////////////////////////////////////////////
require_once ('incfiles/class_mainpage.php');
$mp = new mainpage();
 // -> Лидеры дня
$req = mysql_query("SELECT * FROM `users` WHERE `vip` != '0'  ORDER BY RAND() LIMIT 0,9");
$res = mysql_fetch_assoc($req);
    echo '<div class="menu">';
echo '<img src="../vip/lid.gif" alt=""/><a href="../vip/index.php">Лучший менеджер</a>';
                        echo '<table cellpadding="0" cellspacing="0"><tr><td>';
                        if (file_exists(('../files/avatar/' . $res['id'] . '.png')))
                            echo '<img src="../files/avatar/' . $res['id'] . '.png" width="32" height="32" alt="' . $res['name'] . '" />&nbsp;';
                        else
                            echo '<img src="../images/empty.png" width="32" height="32" alt="' . $res['name'] . '" />&nbsp;';
                        echo '</td><td>';
                    
                    if ($res['sex'])
                        echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($res['sex'] == 'm' ? 'm' : 'w') . ($res['datereg'] > $realtime - 86400 ? '_new' : '') . '.png" width="16" height="16" align="middle" />&nbsp;';
                    else
                        echo '<img src="../images/del.png" width="12" height="12" align="middle" />&nbsp;';
                    // Ник юзера и ссылка на его анкету
                    if ($user_id && $user_id != $res['user_id']) {
                        echo '<a href="../str/anketa.php?id=' . $res['id'] . '"><b>' . $res['name'] . '</b></a> ';
                    } else {
                        echo '<b>' . $res['name'] . '</b> ';
                    }
                    // Метка должности
                    $user_rights = array (
                        3 => '(FMod)',
                        6 => '(Smd)',
                        7 => '(Adm)',
                        9 => '(Создатель)'
                    );
                    echo $user_rights[$res['rights']];
                    // Метка Онлайн / Офлайн
                    echo ($realtime > $res['lastdate'] + 300 ? '<span class="red"> [Off]</span> ' : '<span class="green"> [ON]</span> ');


echo '<div class="status">'.$res['text_vip'].'</div>';
echo '</td></tr></table>';
echo '</div>';
// <- Лидеры дня
// Блок новостей
echo $mp->news;
echo '<div class="phdr"><b>Информация</b></div>';
echo '<div class="menu"><a href="str/news.php">Архив новостей</a> (' . $mp->newscount . ')</div>';
echo '<div class="menu"><a href="index.php?act=info">Доп. информация</a></div>';
echo '<div class="menu"><a href="index.php?act=users">Актив Сайта</a></div>';
echo '<div class="phdr"><b>Общение</b></div>';
require_once('blogs/count.php');
echo '<div class="menu"><a href="blogs/">Блоги</a> [' . blog_count() . ']</div>';
echo '<div class="menu"><a href="str/guest.php">Гостевая</a> (' . gbook() . ')</div>';
echo '<div class="menu"><a href="forum/">Форум</a> (' . wfrm() . ')</div>';
echo '<div class="menu"><a href="chat/">Чат</a> (' . wch(0, 2) . ')</div>';
echo '<div class="phdr"><b>Спортивное инфо</b></div>';
echo '<div class="menu"><a href="http://m.futmen.net">Футбольный менеджер</a></div>';
echo '<div class="menu"><a href="info/">Чемпионаты</a> </div>';
echo '<div class="menu"><a href="/live/f.php">LIVE - результаты</a></div>';
echo '<div class="menu"><a href="/football_news">Новости спорта</a></div>';
?>