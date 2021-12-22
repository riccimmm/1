<?php
define('_IN_JOHNCMS', 1);
$headmod = 'tournament';
$textl = 'Кубковые турниры';
$rootpath = '../../';
require_once ("../../incfiles/core.php");
require_once ("../../incfiles/head.php");

$union = abs(intval($_GET['union']));

$q = mysql_query("select * from `union` where id='" . $union . "' LIMIT 1;");
$arr = mysql_fetch_array($q);

if (mysql_num_rows($q) == 0)
{
echo '<div class="c">Союза не существует</div>';
require_once ("../../incfiles/end.php");
exit;
}

if ($arr['id_prez'] == $user_id or $rights == 9) {
$b = mysql_query("SELECT * FROM  `r_union_cup` WHERE `id_union` = '".$union."' AND `status` !=  'yes' order by time desc;");
$total = mysql_num_rows($b); if($total > 0){
echo '<div class="c">В союзе есть активный кубок.</div>';
} else {

if(!empty($_POST['ot']) && !empty($_POST['do']) && !empty($_POST['name'])){
$ot = abs(intval($_POST['ot'])); $do = abs(intval($_POST['do']));
$name = check($_POST['name']); $type = ($_POST['type'] == 2) ? 2 : 1;
$priz = ($type == 2) ? 800 : 1500; $time = time()+10*60;

mysql_query("insert into `r_union_cup` set `time`='".$time."',
`name`='".$name."', `priz`='".$priz."', `id_union`='".$union."',
`ot` = '".$ot."', `do` = '".$do."', `type` = '".$type."';");

echo '<div class="c">Добалено.</div>';
} else {
echo '<form action="?union='.$union.'" method="post"><div class="c">';
echo 'Название кубка:<br/><input type="text" name="name" size="50" /><br/>';
echo 'Играет:<select name="type"><option value="1">16</option><option value="2">8</option></select><br/>';
echo 'Требуемый уровень:<br/> От:<select name="ot"><option value="1">1</option>
<option value="2">2</option><option value="3">3</option><option value="4">4</option>
<option value="5">5</option><option value="6">6</option><option value="7">7</option>
<option value="8">8</option><option value="9">9</option></select><br/>';
echo 'До:<select name="do"><option value="1">1</option>
<option value="2">2</option><option value="3">3</option><option value="4">4</option>
<option value="5">5</option><option value="6">6</option><option value="7">7</option>
<option value="8">8</option><option value="9">9</option></select><br/>';

echo '<input type="submit" value="Добавить"/></div></form>';


} } } else { echo '<div class="c">WTF?!</div>'; }


require_once ("../../incfiles/end.php");
?>
