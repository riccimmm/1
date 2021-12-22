<?

/**
 * @author _Jane_
 * @copyright 2011
 * icq: 355-350-450
 */


define('_IN_JOHNCMS', 1);
require_once ('../incfiles/core.php');
require_once ('../incfiles/head.php');
if ($rights = 7) {

if ($id && $id != $user_id) {
   
    $req = mysql_query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        
    }
    else {
        require_once ('../incfiles/head.php');
        echo display_error('Такого пользователя не существует');
        require_once ('../incfiles/end.php');
        exit;
    }
}

$kmess = 20;
switch ($act) {

default:
break;

///////////////////////////// ВСЕ ПИСЬМА////////////////////////////////                     
case 'get':
echo '<div class="phdr">Все письма</div>';           
    $messages = mysql_query("select * from `privat`");
    $count = mysql_num_rows($messages);

if($count>0) {
    $vhod_pisma = mysql_query("select * from `privat` where type='in' ORDER BY `time` DESC LIMIT $start,$kmess;"); 
         while ($mass = mysql_fetch_array($vhod_pisma)){
		$req = mysql_query("select * from `users` where `name`='".$mass['author']."';");       
		$res = mysql_fetch_assoc($req);
		echo '<li> <a href="spy.php?act=get_p&amp;id_p=' .$mass['id']. '">'.$mass['author'].'</a> -> '.$mass['user'].' ('.date("d.m.y/H:i", $mass['time']).')</li>'; }
}else{
	echo '<div class="rmenu">НЕТ ВХОДЯЩИХ У '.$user['name'].'!</div>'; }
	echo '<br/><div class="phdr">Всего: '.$count.'</div>';
	if ($count > $kmess) {
		echo '<br/>' . pagenav('spy.php?act=get&amp;id=' . $user['id'] . '&amp;', $start, $count, $kmess) . '';}
		echo '<br/><a href="index.php?">В админку</a>';
break;

   
/////////////////////////////ЧИТАЕМ ПИСЬМО///////////////////////////////////
case 'get_p':



require_once ("../incfiles/head.php");
            $id = intval($_GET['id']);
	         $id_p = intval($_GET['id_p']);
            $messages1 = mysql_query("select * from `privat` where id='" .$id_p. "';");
            $massiv1 = mysql_fetch_array($messages1);
            if ($massiv1['chit'] == "no") {
                mysql_query("update `privat` set `chit`='yes' where `id`='" . $massiv1['id'] . "';");
            }

            $mass = mysql_fetch_array(@ mysql_query("select * from `users` where `name`='" . $massiv1['author'] . "';"));
            $text = $massiv1['text'];
            $text = tags($text);
            if ($set_user['smileys'])
                $text = smileys($text, ($massiv1['from'] == $nickadmina || $massiv1['from'] == $nickadmina2 || $massiv11['rights'] >= 1) ? 1 : 0);
            echo "<p>От <a href='../str/anketa.php?id=" . $mass['id'] . "'>$massiv1[author]</a><br/>";
			echo 'Кому '.$massiv1[user].'<br/>';
            $vrp = $massiv1['time'] + $set_user['sdvig'] * 3600;
            echo "(" . date("d.m.y H:i", $vrp) . ")</p><p><div class='b'>Тема: $massiv1[temka]<br/></div>Текст: $text</p>";
            if (!empty ($massiv1['attach'])) {
                echo "<p>Прикреплённый файл: <a href='spy.php?act=load&amp;id_p=" . $id_p . "'>$massiv1[attach]</a></p>";
            }
           echo "<hr /><p><a href='spy.php?act=delmess&amp;del=" . $id_p . "'>Удалить</a></p>";
		   echo '<a href="spy.php?act=get">В шпион '.$user['name'].'</a>';
	            $mas2 = mysql_fetch_array(@ mysql_query("select * from `privat` where `time`='$massiv1[time]' and author='$massiv1[author]' and type='out';"));
            if ($mas2['chit'] == "no") {
                mysql_query("update `privat` set `chit`='yes' where `id`='" . $mas2['id'] . "';");
            }
            if ($massiv1['chit'] == "no") {
                mysql_query("update `privat` set `chit`='yes' where `id`='" . $massiv1['id'] . "';");
            }
            break;


///////////////////// Удаление отдельного сообщения /////////////////////////////////

case 'delmess' :
 
 require_once ('../incfiles/head.php');
			$del = intval($_GET['del']);
            $mess1 = mysql_query("SELECT * FROM `privat` WHERE `id` = '$del' LIMIT 1");
            $mas1 = mysql_fetch_array($mess1);
            $delfile = $mas1['attach'];
            if (!empty ($delfile)) {
                if (file_exists("../pratt/$delfile")) {
                    unlink("../pratt/$delfile");
                }
            }
            mysql_query("DELETE FROM `privat` WHERE `id` = '" . $del . "' LIMIT 1");
			$del_o=$del+1;
			mysql_query("DELETE FROM `privat` WHERE `id` = '" . $del_o . "' LIMIT 1");
            echo 'Сообщение удалено!<br/>';
            break;

case 'load' :
///////////////////// Скачивание файла /////////////////////////////////

            $id_p = intval($_GET['id_p']);
            $fil = mysql_query("select * from `privat` where id='" . $id_p . "';");
            $mas = mysql_fetch_array($fil);
            $att = $mas['attach'];
            if (!empty ($att)) {
                $tfl = strtolower(format(trim($att)));
                $df = array("asp", "aspx", "shtml", "htd", "php", "php3", "php4", "php5", "phtml", "htt", "cfm", "tpl", "dtd", "hta", "pl", "js", "jsp");
                if (in_array($tfl, $df)) {
                    require_once ("../incfiles/head.php");
                    echo "Ошибка!<br/>&#187;<a href='pradd.php'>В приват</a><br/>";
                    require_once ("../incfiles/end.php");
                    exit;
                }
                if (file_exists("../pratt/$att")) {
                    header("location: ../pratt/$att");
                }
            }
            break;
}
echo '<br/>';

}else {
        require_once ('../incfiles/head.php');
        header('location: ../?err');
        require_once ('../incfiles/end.php');
        exit;
    }


require_once ('../incfiles/end.php');
?>