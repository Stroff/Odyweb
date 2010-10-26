
<?php
$connexion = mysql_connect('localhost','seidezeus' , 'ursmodja');
mysql_select_db('site' ,$connexion);
mysql_query("SET NAMES 'utf8'");
$pseudo_clean = mysql_escape_string ( $_POST ["pseudo"]);
$texte_clean = mysql_escape_string ( $_POST ["texte"]);
mysql_query("UPDATE `configuration` SET `valeur`='$texte_clean' WHERE (`nom`='bloc_note')");
echo mysql_error();

 
  
header('Location: index.php');   
?>