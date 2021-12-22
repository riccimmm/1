<?php

define('_IN_JOHNCMS', 1);
$headmod = 'online_consultants';
$textl = 'Онлайн-консультанты';
require_once('../incfiles/core.php');
require_once('../incfiles/head.php');
echo '<div class="phdr"><b>OnLine-консультанты</b></div>';
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `online_consultant` = 'yes'"), 0);
if ($total) {
    $req = mysql_query("SELECT * FROM `users` WHERE `online_consultant` = 'yes' ORDER BY `id` ASC LIMIT $start,$kmess");
    while ($res = mysql_fetch_assoc($req)) {
        echo ($i % 2) ? '<div class="list2">' : '<div class="list1">';
                    if ($set_user['avatar']) {
                        echo '<table cellpadding="0" cellspacing="0"><tr><td>';
                        if (file_exists(('../files/avatar/' . $res['id'] . '.png')))
                            echo '<img src="../files/avatar/' . $res['id'] . '.png" width="32" height="32" alt="' . $res['name'] . '" />&nbsp;';
                        else
                            echo '<img src="../images/empty.png" width="32" height="32" alt="' . $res['id'] . '" />&nbsp;';
                        echo '</td><td>';
                    }
                    if ($res['sex'])
                        echo '<img src="../theme/' . $set_user['skin'] . '/images/' . ($res['sex'] == 'm' ? 'm' : 'w') . ($res['datereg'] > $realtime - 86400 ? '_new' : '') . '.png" width="16" height="16" align="middle" />&nbsp;';
                    else
                        echo '<img src="../images/del.png" width="12" height="12" align="middle" />&nbsp;';
                    // Ник юзера и ссылка на его анкету
                    if ($user_id && $user_id != $res['id']) 
                        echo '<a href="../str/anketa.php?id=' . $res['id'] . '"><b>' . $res['name'] . '</b></a> ';
                    else 
                        echo '<b>' . $res['name'] . '</b> ';
                    
                    // Метка должности
                    $user_rights = array (
                        3 => '(FMod)',
                        6 => '(Smd)',
                        7 => '(Adm)',
                        9 => '(Adm)'
                    );
                    echo $user_rights[$res['rights']];
                   // Метка Онлайн / Офлайн
                    echo ($realtime > $res['lastdate'] + 600 ? ' <span style="color:red;">Offline</span> ' : ' <span style="color:green;">OnLine</span> ');
                    if (!empty($res['status']))
                        echo '<div class="status"><img src="../theme/' . $set_user['skin'] . '/images/label.png" alt="" align="middle"/>&nbsp;' . $res['status'] . '</div>';
                    if ($set_user['avatar'])
                        echo '</td></tr></table>';
echo '<a href="online_consultant.php?id=' . $res['id'] . '"><b>Информация о консультанте</b></a>';
        echo '</div>';
        ++$i;
    }
} else {
    echo '<div class="menu"><p>Никого нет</p></div>';
}
echo '<div class="phdr">Всего: ' . $total . '</div>';
if ($total > 10) {
    echo '<p>' . pagenav('online_consultants.php?', $start, $total, $kmess) . '</p>';
    echo '<p><form action="online.php" method="get"><input type="text" name="page" size="2"/>
        <input type="submit" value="К странице &gt;&gt;"/></form></p>';
}
echo '<div class="phdr">by MyZik</div>';
require_once('../incfiles/end.php');
?>