<?php

define('_IN_JOHNCMS', 1);
$headmod = 'online_consultant';
require_once('../incfiles/core.php');
if (!$user_id) {
    require_once('../incfiles/head.php');
    echo display_error('Только для зарегистрированных посетителей');
    require_once('../incfiles/end.php');
    exit;
}
if ($id && $id != $user_id) {
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        $textl = 'OnLine-консультанты';
    } else {
        require_once('../incfiles/head.php');
        echo display_error('Такого пользователя не существует');
        require_once("../incfiles/end.php");
        exit;
    }
} else {
    $id = false;
    $textl = 'OnLine-консультанты';
    $user = $datauser;
}

require_once('../incfiles/head.php');

echo '<div class="phdr"><b>' . ($id ? 'OnLine-консультант ' . $user['name'] . '' : 'OnLine-консультант ' . $user['name'] . '') . '</b></div>';

echo "<div class='menu'>
<ul>
<li>Ник: " . $user['name'] . "</li>
<li>Имя:  " . $user['imname'] . "</li>
<li>ICQ:  " . $user['icq'] . "</li>
<li><span style='color:red;'>Рассматриваемые вопросы</span>: " . $user['online_consultant_text'] . "</li>
</ul>";
if ($user_id != $user['id'])
{
echo "<hr />
<ul>
<li><a href='".$home."/str/pochta.php?act=add&amp;id=".$user['id']."'>Приватное сообщение</a></li>
</ul>";
}
echo "</div>";
if (!$user['online_consultant'] == 'no') {
    require_once('../incfiles/head.php');
    echo display_error('Этот пользователь не является OnLine-консультантом');
    require_once('../incfiles/end.php');
    exit;
}
echo '<div class="phdr">by MyZik</div>';
require_once('../incfiles/end.php');
?>