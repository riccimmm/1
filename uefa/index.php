<?php
################################################
###### EMAKS.H2M.RU | Emaks | Ukraine | Tetyiv
################################################
define('_IN_JOHNCMS', 1);
$headmod ="uefa";
$textl = 'Рейтинг UEFA';
require_once ("../incfiles/core.php");
require_once ("../incfiles/head.php");
header("Content-type:text/html; charset=utf-8");

$id = $_GET['id'];
$f = file_get_contents("http://m.sport-express.ru/football/eurocups/uefarates.wtm".$_SERVER['QUERY_STRING']."");
$f = preg_replace('|<head>(.*?)<div style="margin-bottom:1px;" id="wap_top_banner"><br />|si','',$f);
$f = preg_replace('|<h2 class="section_header"><a href="../">(.*?)</body>|si','',$f);

$f = preg_replace('|<div style="border-width: 0px; height: 64px; width: 305px">(.*?)</a><br/></div></div>|si','',$f);
echo $f.(!empty($id)?$id:'');


require('../incfiles/end.php');
?>
