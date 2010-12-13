<?php
exit();
$connexion = mysql_connect('localhost', 'ipbsite' , 'eze13xsqx56zd44e42dsqdq');
$sql = mysql_query("SELECT username, pp,points FROM site.accounts");
// pour tous les comptes
while($un_compte = mysql_fetch_array($sql)) {
	$new_points = $un_compte['points']+round($un_compte['pp']/250,2);
	$sql_maj = "UPDATE site.accounts SET pp = 0, points = $new_points WHERE username='".$un_compte['username']."'";
	echo $sql_maj;
	mysql_query($sql_maj);
}

?>