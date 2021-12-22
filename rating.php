<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');
require_once ("incfiles/manag2.php");
// Ограничиваем доступ к Менеджеру
$error = '';
if (!$set['mod_manager'] && !$rights < 7)
    $error = 'Менеджер закрыт';
elseif ($ban['1'] || $ban['8'])
    $error = 'Для Вас доступ в менеджер закрыт';
elseif (!$user_id)
    $error = 'Доступ в менеджер открыт только <a href="login.php">авторизованным</a> посетителям';
if ($error) {
    echo '<div class="rmenu"><p>' . $error . '</p></div>';
	require_once ("incfiles/end.php");
    exit;
}
if (mysql_num_rows($manager) == 0)
{
echo "Команды не существует<br/>";
require_once ("incfiles/end.php");
exit;
}

echo '<div class="gmenu"><b>Рейтинг</b></div>';
//echo '<div class="c"><a href="rating.php">Опыт</a> | <a href="rating.php?act=slava">Кубки</a> | <a href="rating.php?act=slava">Слава</a> | <a href="rating.php?act=fans">Фаны</a> | <a href="rating.php?act=stadium">Стадион</a></div>';


// СЛАВА
if ($act == "cup")
{
$req = mysql_query("SELECT COUNT(*) FROM priz_2` GROUP by `win`");
$colmes = mysql_result($req, 0);

$q1 = mysql_query("SELECT * FROM `priz_2` GROUP BY `win` ORDER by count(win) DESC ;");

$mesto = $start + 1;

echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Команда</b></td>
<td><b>Кубков</b></td>
</tr>
';


while ($res = mysql_fetch_array($q1))
{
//echo "$res[win]";
$q12 = mysql_query("SELECT * FROM `team_2` WHERE `id`='$res[win]';");
$com = mysql_fetch_array($q12);

$req22 = mysql_query("SELECT COUNT(*) FROM `priz_2` WHERE `win`='$res[win]'");
$colcup = mysql_result($req22, 0);


if (!empty($_SESSION['uid']) && $user_id == $res[id_admin])
{
echo '<tr class="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '<td width="5%" align="center">'.$mesto.'</td><td>';

if (!empty($com[logo]))
{
echo '<img src="logo/small' . $com[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/> ';
}

echo '<a href="team.php?id=' . $com['id'] . '">'.$com[name].'</a> ['.$com[lvl].']</td>
<td width="10%" align="center"><font color="green"><b>'.$colcup.'</b></font></td>';	
echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';

if ($colmes > 30)
{
echo '<div class="c">' . pagenav('rating.php?act=cup&amp;', $start, $colmes, 30) . '</div>';
}

echo '<div class="c">Всего: '.$colmes.'</div>';

echo'[<a href="index.php">В панель управления</a>]<br/>';
require_once ("incfiles/end.php");
exit;
}








// СЛАВА
if ($act == "slava")
{
$req = mysql_query("SELECT COUNT(*) FROM m_team`");
$colmes = mysql_result($req, 0);

$q1 = mysql_query("SELECT * FROM `m2_team` ORDER BY `slava` DESC LIMIT " . $start . ", 30;");

$mesto = $start + 1;



echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Команда</b></td>
<td><b>Слава</b></td>
</tr>
';

while ($res = mysql_fetch_array($q1))
{

if (!empty($_SESSION['uid']) && $user_id == $res[id_admin])
{
echo '<tr class="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '<td width="5%" align="center">'.$mesto.'</td><td>';

if (!empty($res[logo]))
{
echo '<img src="logo/small' . $res[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/> ';
}

echo '<a href="team.php?id=' . $res['id'] . '">'.$res[name].'</a> ['.$res[lvl].']</td>
<td width="10%" align="center"><font color="green"><b>'.$res[slava].'</b></font></td>';	
echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';

if ($colmes > 30)
{
echo '<div class="c">' . pagenav('rating.php?act=slava&amp;', $start, $colmes, 30) . '</div>';
}

echo '<div class="c">Всего: '.$colmes.'</div>';

echo'<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
exit;
}



// ФАНЫ
if ($act == "fans")
{
$req = mysql_query("SELECT COUNT(*) FROM team_2`");
$colmes = mysql_result($req, 0);

$q1 = mysql_query("SELECT * FROM `team_2` ORDER BY `fan` DESC LIMIT " . $start . ", 30;");

$mesto = $start + 1;



echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Команда</b></td>
<td><b>Фаны</b></td>
</tr>
';

while ($res = mysql_fetch_array($q1))
{

if (!empty($_SESSION['uid']) && $user_id == $res[id_admin])
{
echo '<tr class="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '<td width="5%" align="center">'.$mesto.'</td><td>';

if (!empty($res[logo]))
{
echo '<img src="logo/small' . $res[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/> ';
}

echo '<a href="team.php?id=' . $res['id'] . '">'.$res[name].'</a> ['.$res[lvl].']</td>
<td width="10%" align="center"><font color="green"><b>'.$res[fan].'</b></font></td>';	
echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';

if ($colmes > 30)
{
echo '<div class="c">' . pagenav('rating.php?act=fans&amp;', $start, $colmes, 30) . '</div>';
}

echo '<div class="c">Всего: '.$colmes.'</div>';

echo'<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
exit;
}

// СТАДИОН
if ($act == "stadium")
{
$req = mysql_query("SELECT COUNT(*) FROM team_2`");
$colmes = mysql_result($req, 0);

$q1 = mysql_query("SELECT * FROM `team_2` ORDER BY `mest` DESC LIMIT " . $start . ", 30;");

$mesto = $start + 1;



echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Команда</b></td>
<td><b>Стадион</b></td>
</tr>
';

while ($res = mysql_fetch_array($q1))
{

if (!empty($_SESSION['uid']) && $user_id == $res[id_admin])
{
echo '<tr class="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '<td width="5%" align="center">'.$mesto.'</td><td>';

if (!empty($res[logo]))
{
echo '<img src="logo/small' . $res[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/> ';
}

echo '<a href="/team.php?id=' . $res['id'] . '">'.$res[name].'</a> ['.$res[lvl].']</td>
<td width="10%" align="center"><font color="green"><b>'.$res[mest].'</b></font></td>';	
echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';

if ($colmes > 30)
{
echo '<div class="c">' . pagenav('rating.php?act=stadium&amp;', $start, $colmes, 30) . '</div>';
}

echo '<div class="c">Всего: '.$colmes.'</div>';

echo'<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
exit;
}













$req = mysql_query("SELECT COUNT(*) FROM team_2`");
$colmes = mysql_result($req, 0);

$q1 = mysql_query("SELECT * FROM `team_2` ORDER BY `rate` DESC LIMIT " . $start . ", 30;");

$mesto = $start + 1;



echo '
<table border="0" width="100%" id="example" cellspacing="1" cellpadding="4">
<tr bgcolor="dddddd" align="center" class="whiteheader">
<td><b>№</b></td>
<td><b>Команда</b></td>
<td><b>Опыт</b></td>
</tr>
';

while ($res = mysql_fetch_array($q1))
{

if (!empty($_SESSION['uid']) && $user_id == $res[id_admin])
{
echo '<tr class="e9ccd2">';
}
else
{
echo ceil(ceil($i / 2) - ($i / 2)) == 0 ? '<tr bgcolor="ffffff">' : '<tr bgcolor="f3f3f3">';
}

echo '<td width="5%" align="center">'.$mesto.'</td><td>';

if (!empty($res[logo]))
{
echo '<img src="logo/small' . $res[logo] . '" alt=""/> ';
}
else
{
echo '<img src="logo/smallnologo.jpg" alt=""/> ';
}

echo '<a href="team.php?id=' . $res['id'] . '">'.$res[name].'</a> ['.$res[lvl].']</td>
<td width="10%" align="center"><font color="green"><b>'.$res[rate].'</b></font></td>';	
echo '</tr>';


++$mesto;
++$i;
}

echo '</table>';

if ($colmes > 30)
{
echo '<div class="c">' . pagenav('rating.php?', $start, $colmes, 30) . '</div>';
}

echo '<div class="c">Всего: '.$colmes.'</div>';



echo'<a href="index.php">Вернуться</a><br/>';
require_once ("incfiles/end.php");
?>
