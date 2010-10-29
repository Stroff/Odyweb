<?php
include 'config/config.php';
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$texte_clean = mysql_escape_string ( $_POST ["texte"]);
mysql_query("UPDATE `configuration` SET `valeur`='$texte_clean' WHERE (`nom`='bloc_note')");
echo mysql_error();  
header('Location: index.php');   
?>