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


if ($rights >= !$user_id)
{echo ($headmod != "mainpage" || ($headmod == 'mainpage' && $act)) ? '<div class="fmenu"><div style="text-align:center"><a href="'.$home.'">На главную</a></div></div>'  : '<div class="fmenu"><div style="text-align:center"><a href="http://futmen.net">Соц. сеть</a> | <a href="../sostav.php?id=' . $kom['id'] .'">Состав</a> | <a href="../team.php?id=' . $kom['id'] .'">Команда</a></div></div>';
}else{
echo ($headmod != "mainpage" || ($headmod == 'mainpage' && $act)) ? '<div class="fmenu"><div style="text-align:center"><a href="'.$home.'">На главную</a></div></div>'  : '<div class="fmenu"><div style="text-align:center"><a href="' . $home . '">FUTMEN.NET</a></div></div>';
}


echo '<div class="footer">
<ul class="footer_menu">
<li>' . usersonline() . '</li>
<li><a href="' . $home . '/forum/index.php?id=1">Помощь</a></li>
<li><a href="' . $home . '/butc.php">Буцеры</a></li>';
echo $user_id ? '<li><a href="../exit.php">Выход</a></li>' : '<li><a href="../login.php">Вход</a></li>';
echo '</ul>
</div>';


// Рекламный блок сайта
if (!empty ($cms_ads[2]))
echo '<div class="gmenu">' . $cms_ads[2] . '</div>';

echo '</div>';


////////////////////////////////////////////////////////////
// Выводим информацию внизу страницы                      //
////////////////////////////////////////////////////////////


// Рекламный блок сайта
if (!empty ($cms_ads[3]))
    echo $cms_ads[3];


echo '</div></div></div></body></html>';
?>