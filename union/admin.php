<?php
define('_IN_JOHNCMS', 1);
$headmod = 'union';
$textl = 'Админка союза';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");
if ($rights == 9) {
    switch ($act) {
/////////////////////////////////////////////////////////////////////////////////////
      case 'soz':
	  
            $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $news = htmlspecialchars($_POST['news'], ENT_QUOTES, 'UTF-8');
            $info = htmlspecialchars($_POST['info'], ENT_QUOTES, 'UTF-8');
            $slava = htmlspecialchars($_POST['slava'], ENT_QUOTES, 'UTF-8');
            $players = htmlspecialchars($_POST['players'], ENT_QUOTES, 'UTF-8');
            $money = htmlspecialchars($_POST['money'], ENT_QUOTES, 'UTF-8');
            $id_prez = htmlspecialchars($_POST['id_prez'], ENT_QUOTES, 'UTF-8');

            $name_prez = htmlspecialchars($_POST['name_prez'], ENT_QUOTES, 'UTF-8');
            $union_mod = htmlspecialchars($_POST['union_mod'], ENT_QUOTES, 'UTF-8');
            $access_level = htmlspecialchars($_POST['access_level'], ENT_QUOTES, 'UTF-8');
            $unionlogo = htmlspecialchars($_POST['unionlogo'], ENT_QUOTES, 'UTF-8');
			
$error = false;
            if (empty($_POST['id']) || empty($_POST['name']) || empty($_POST['news']) ||
                empty($_POST['info']) || empty($_POST['slava']) || empty($_POST['players']) || empty
                ($_POST['money']) || empty($_POST['id_prez']) || empty($_POST['name_prez']) || empty($_POST['union_mod']) ||
                empty($_POST['access_level']) || empty($_POST['unionlogo']))
                $error = 'Какое-то поле  не заполнено<br />';
	  if (!$error) {
$result = mysql_query("insert into `union` set 
`id`='" . $id . "', 
`name`='" . $name . "', 
`news`='" . $news . "', 
`info`='" . $info . "', 
`slava`='" . $slava . "', 
`players`='" . $players . "', 
`money`='" . $money . "', 
`id_prez`='" . $id_prez . "', 
`name_prez`='" . $name_prez . "', 
`union_mod`='" . $union_mod . "', 
`access_level`='" . $access_level . "', 
`unionlogo`='" . $unionlogo . "';");

		if (isset($result)) { 
					echo "<div class='rmenu'>Союз <b>$name</b> успешно создано!</div>
						  <div class='menu'><a href='admin.php' class='button'>Назад</a></div>";
					require_once ("../incfiles/end.php");
					exit;
					}
		
} else {
                echo '<div class="rmenu"><p>ОШИБКА!<br />' . $error .
                    '<a href="admin.php?act=add">Повторить</a></p></div>';
					require_once ("../incfiles/end.php");
					exit;
            }
break;
//////////////////////////////////////////////////////////////////////////////////////////////
		case 'add':


echo '
<div class="c">
<table id="example">
<form name="uadmin" action="admin.php?act=soz" method="post">

<tr>
 <td>ID:</td> <td><input type="text" name="id" /></td>
</tr> 

 <tr>
<td>Названия союза:</td> <td><input type="text" name="name" /></td>
 </tr>
 
 <tr>
 <td>Новости союза:</td> <td><input type="text" name="news" /></td>
 </tr>
 
 <tr>
<td>Информация союза:</td> <td><input type="text" name="info" /></td>
 </tr>
 
 <tr>
<td>Зал славы:</td> <td><input type="text" name="slava" /></td>
 </tr>
 
 <tr>
<td>Кол-во игроков:</td> <td><input type="text" name="players" value="1" /></td>
 </tr>
 
 <tr>
<td>Кол-во денег в союзе:</td> <td><input type="text" name="money" /></td>
 </tr>
 
 <tr>
<td>ID президента:</td> <td><input type="text" name="id_prez" /></td>
 </tr>
 
 <tr>
<td>Имя президента:</td> <td><input type="text" name="name_prez" /></td>
 </tr>
 
 <tr>
<td>union_mod:</td> <td><input type="text" name="union_mod" /></td>
 </tr>
 
 <tr>
<td>access_level:</td> <td><input type="text" name="access_level" /></td>
 </tr>
 
 <tr>
<td>Логотип союза:</td> <td><input type="text" name="unionlogo" /></td>
 </tr>
 
  <tr>
<td><input type="submit" name="ok" value="Создать союз" /></td>
  </tr>
 
</form>
</table>
<div class="tmn">*union_mod - Тип союза, указав 0 - в союз можно вступить только когда твою заявку примет президент, 1 - свободное вступление без заявок</div>
<div class="tmn">*access_level - С какого уровня можно вступать в союз</div>
</div>';
echo "<div class='menu'><a href='admin.php' class='button'>Назад</a></div>";
break;
///////////////////////////////////////////////////////////////////////////////
		case 'spisok':

		                echo '<div class="phdr">Управление союзами</div>';
                $x = mysql_query("SELECT * FROM `union`;");
                
                if (!mysql_num_rows($x)) {
                    echo 'Нет союзов';
                } else {
                    while ($row = mysql_fetch_assoc($x)) {
                        echo ($i % 2) ? '<div class="menu">' : '<div class="menu">';
                        echo 'Название[id]: <b>' . $row['name'] . '[' . $row['id'] . ']</b><br/> ';
						echo 'Президент[id]: <b>' . $row['name_prez'] . '[' . $row['id_prez'] . ']</b><br/>';
                        echo 'Кол-во игроков:  <b>' . $row['players'] . '</b><br/>';
                        echo 'Баланс: <b>' . $row['money'] . ' €</b><br/>';
                        ++$i;
						 echo '<a style="float:right;" class="redbutton" href="admin.php?act=del&amp;id=' . $row['id'] .'">Удалить</a>';
						echo '<a style="float:right;" class="button" href="admin.php?act=izmen&amp;id=' . $row['id'] .'">Изменить</a>';
						echo '<a style="float:right;" class="button" href="../union/group.php?id=' . $row['id'] .
                            '">В союз</a>';
						echo '<br/>';
						echo '<hr />';
                        echo '</div>';
                    }

                }
echo "<div class='menu'><a href='admin.php' class='button'>Назад</a></div>";
		break;
//////////////////////////////////////////////////////////////////////////////
case 'del':	

$reqq = mysql_query("SELECT * FROM `union` WHERE `id`='" . $id . "' LIMIT 1;");
$roww = mysql_fetch_array($reqq);

   if (!$id) {
                echo display_error('Пустые параметры!');
                echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
                require_once ("../incfiles/end.php");
                exit;
            }
			
echo '<div class="rmenu">Действительно хотите удалить союз?</div>';
echo '<div class="menu" style="text-align:center;"><a class="redbutton" href="admin.php?act=dell&amp;id=' . $roww['id'] .'">Да</a> <a class="button" href="admin.php?act=spisok">Нет</a></div>';

break;
///////////////////////////////////////////////////////////////////////////
		case 'dell':		
		            if (!$id) {
                echo display_error('Пустые параметры!');
                echo '<div class="phdr"><a href="admin.php">В Админ Панель</a></div>';
                require_once ("../incfiles/end.php");
                exit;
            }

            mysql_query("DELETE FROM `union` WHERE `id`='$id'");
            header("Location: admin.php?act=spisok");
		
		
		
		
		break;
//////////////////////////////////////////////////////////////////////////////
		case 'izmen':

            $req = mysql_query("SELECT * FROM `union` WHERE `id`='" . $id . "' LIMIT 1;");
            if (!mysql_num_rows($req)) {
                header("Location: admin.php");
                exit;
            }

            $res = mysql_fetch_array($req);


		
if (isset($_POST['submit'])) {


					  if (!$error) {
$resultat = mysql_query("UPDATE `union` set 
`id`='" . $_POST['id'] . "', 
`name`='" . $_POST['name'] . "', 
`news`='" . $_POST['news'] . "', 
`info`='" . $_POST['info'] . "', 
`slava`='" . $_POST['slava'] . "', 
`players`='" . $_POST['players'] . "', 
`money`='" . $_POST['money'] . "', 
`id_prez`='" . $_POST['id_prez'] . "', 
`name_prez`='" . $_POST['name_prez'] . "', 
`union_mod`='" . $_POST['union_mod'] . "', 
`access_level`='" . $_POST['access_level'] . "'
WHERE `id`='" . $res['id'] ."';");
	header('Location: admin.php?act=spisok');
}else {
                    echo '<div class="rmenu"><p>ОШИБКА!<br />' . $error .
                        '<a href="admin.php?act=izmen&amp;id=' . $res['id'] .'">Повторить</a></p></div>';
                }
            }else {
			echo '
<div class="c">
<table id="example">
<form name="iadmin" action="admin.php?act=izmen&amp;id=' . $res['id'] .'" method="post">

<tr>
 <td>ID:</td> <td><input type="text" name="id" value="' . $res['id'] .'" /></td>
</tr> 

 <tr>
<td>Названия союза:</td> <td><input type="text" name="name" value="' . $res['name'] .'" /></td>
 </tr>
 
 <tr>
 <td>Новости союза:</td> <td><input type="text" name="news" value="' . $res['news'] .'" /></td>
 </tr>
 
 <tr>
<td>Информация союза:</td> <td><input type="text" name="info" value="' . $res['info'] .'" /></td>
 </tr>
 
 <tr>
<td>Зал славы:</td> <td><input type="text" name="slava" value="' . $res['slava'] .'" /></td>
 </tr>
 
 <tr>
<td>Кол-во игроков:</td> <td><input type="text" name="players" value="' . $res['players'] .'" /></td>
 </tr>
 
 <tr>
<td>Кол-во денег в союзе:</td> <td><input type="text" name="money" value="' . $res['money'] .'" /></td>
 </tr>
 
 <tr>
<td>ID президента:</td> <td><input type="text" name="id_prez" value="' . $res['id_prez'] .'" /></td>
 </tr>
 
 <tr>
<td>Имя президента:</td> <td><input type="text" name="name_prez" value="' . $res['name_prez'] .'" /></td>
 </tr>
 
 <tr>
<td>union_mod:</td> <td><input type="text" name="union_mod" value="' . $res['union_mod'] .'" /></td>
 </tr>
 
 <tr>
<td>access_level:</td> <td><input type="text" name="access_level" value="' . $res['access_level'] .'" /></td>
 </tr>
 
 <tr>
<td>Логотип союза:</td> <td><input type="text" name="unionlogo" value="' . $res['unionlogo'] .'" /></td>
 </tr>
 
  <tr>
<td><input type="submit" name="submit" value="Изменить" /></td>
  </tr>
 
</form>
</table>
<div class="tmn">*union_mod - Тип союза, указав 0 - в союз можно вступить только когда твою заявку примет президент, 1 - свободное вступление без заявок</div>
<div class="tmn">*access_level - С какого уровня можно вступать в союз</div>
</div>';
			
			
            }
		break;
//////////////////////////////////////////////////////////////////////////////
		default: 
			echo '<div class="phdr">Админка союза</div>';
			echo '<table id="example">';
			echo '<tr>';
			echo '<td><div class="menu"><img src="../images/add.gif" /> <a href="admin.php?act=add">Создать союз</a></div></td>';
			echo '<td><div class="menu"><img src="../images/green.gif" /> <a href="admin.php?act=spisok">Список союзов</a></div></td>';
			echo '</tr>';
			echo '</table>';
			echo "<div class='menu'><a href='../admin.php' class='button'>Назад</a></div>";
			break;
}
}else{echo '<div class="rmenu"><h2>У вас нет прав!</h2></div>';}
require_once ("../incfiles/end.php");
?>