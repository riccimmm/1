<?
$player = trim($_POST['player']);
header('location: player.php?id=' . $player . '');

?>