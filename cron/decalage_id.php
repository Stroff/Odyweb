<?php
exit();
$connexion = mysql_connect('localhost', 'ipbsite' , 'eze13xsqx56zd44e42dsqdq');
//252811 
$sql = mysql_query("SELECT username, id FROM site.accounts WHERE id > 259174");
// pour tous les comptes
while($un_compte = mysql_fetch_array($sql)) {
	$old_id =$un_compte['id'];
	$new_id = $old_id-1;
	echo "UPDATE site.accounts SET id=$new_id WHERE id=$old_id"."<br />";
	mysql_query("UPDATE site.accounts SET id=$new_id WHERE id=$old_id");
	//mysql_query("INSERT INTO redmine.users SET login='".$un_compte['username']."', hashed_password='".$un_compte['password']."', mail='".$un_compte['email']."', language='fr', status=1,type='User'");
}
/*

$connexion = mysql_connect('localhost', 'ipbsite' , 'eze13xsqx56zd44e42dsqdq');
$sql = mysql_query("SELECT id, login FROM redmine.users");
// pour tous les comptes
while($un_compte = mysql_fetch_array($sql)) {
		mysql_query("UPDATE redmine.users SET firstname='".$un_compte['login']."' WHERE id='".$un_compte['id']."'");
}
*/
?>