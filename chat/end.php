<?php

defined('_IN_JOHNCMS') or die('Error: restricted access');



// Рекламный блок MOBILEADS.RU
$mad_siteid = 0;
if ($mad_siteid) {
    if (isset ($_SESSION['mad_links']) && $_SESSION['mad_time'] > ($realtime - 60 * 15))
        echo '<div class="gmenu">' . $_SESSION['mad_links'] . '</div>';
    else
        echo '<div class="gmenu">' . mobileads($mad_siteid) . '</div>';
}


echo '</div><div class="fmenu">';
echo '<a href=http://futmen.net/index.php>На главную</a><br/></div>';

// Рекламный блок сайта
if (!empty ($cms_ads[2]))
echo '<div class="gmenu">' . $cms_ads[2] . '</div>';

// Счетчик посетителей онлайн
echo '</div><div class="footer"><center>' . usersonline() . '</center>';

// Меню быстрого перехода
if ($set_user['quick_go']) {
    echo '<form action="' . $home . '/go.php" method="post">';
    echo '<div><select name="adres" style="font-size:x-small">
	<option value="chat">Чат</option>
	<option value="guest">Гостевая</option>
	<option value="forum">Форум</option>
<option value="blog">Блог</option>
    </select><input type="submit" value="Go!" style="font-size:x-small"/>';
    echo '</div></form>';
}

////////////////////////////////////////////////////////////
// Выводим информацию внизу страницы                      //
////////////////////////////////////////////////////////////
echo '<div style="text-align:center">';


// Рекламный блок сайта
if (!empty ($cms_ads[3]))
    echo $cms_ads[3];

echo '<a href="http://waplog.net/c.shtml?479078"><img src="http://c.waplog.net/479078.cnt" alt="waplog" /></a>';
echo '<script type="text/javascript" src="http://mobtop.ru/c/63740.js"></script><noscript><a href="http://mobtop.ru/in/63740"><img src="http://mobtop.ru/63740.gif" alt="MobTop.Ru - рейтинг мобильных сайтов"/></a></noscript>';
echo '</div></div></body></html>';

?>