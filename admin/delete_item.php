<?php
$secure_lvl=2;
include '../secure.php';
include 'config/config.php';
	if (isset($_GET['id'])) {
		$sql = "DELETE FROM items_boutique WHERE id= '".$_GET['id']."'";
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		mysql_query($sql);
		if($sql) {
			echo "Suppresion de l'item Ok";
		} else {
			echo 'Erreur dans la suppresion';
		}
	}
?>