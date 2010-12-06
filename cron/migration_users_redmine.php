<?php
exit();
/*$connexion = mysql_connect('localhost', 'ipbsite' , 'eze13xsqx56zd44e42dsqdq');
$sql = mysql_query("SELECT username, password, email FROM site.accounts2");
// pour tous les comptes
while($un_compte = mysql_fetch_array($sql)) {
	if($un_compte['password']<>''){
		mysql_query("INSERT INTO redmine.users SET login='".$un_compte['username']."', hashed_password='".$un_compte['password']."', mail='".$un_compte['email']."', language='fr', status=1,type='User'");
	}else {
		echo 'pas de mot de passe'."<br />";
	}
}
*/
$connexion = mysql_connect('localhost', 'ipbsite' , 'eze13xsqx56zd44e42dsqdq');
$sql = mysql_query("SELECT id, login FROM redmine.users");
// pour tous les comptes
while($un_compte = mysql_fetch_array($sql)) {
		mysql_query("UPDATE redmine.users SET firstname='".$un_compte['login']."' WHERE id='".$un_compte['id']."'");
}
?>