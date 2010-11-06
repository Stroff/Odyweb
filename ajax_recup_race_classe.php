<?php
$secure_lvl = 1;
include "secure.php";

switch ($_POST['type']) {
	case 'classe_race':
	// connexion pour faire les mysql_escape_string
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$guid_perso = mysql_escape_string ($_POST ["valeur"]);
	$guid_perso="38760";
	$persos = mysql_query("SELECT class as classe,race FROM characters WHERE guid = '".$guid_perso."' AND account='".$_SESSION['id']."'");
	if (mysql_num_rows($persos) == 1) {
		$perso = mysql_fetch_array($persos);
		print json_encode($perso);
	}
	break;
}
?>