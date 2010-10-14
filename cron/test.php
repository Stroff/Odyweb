<?php
exit();
$connexion = mysql_connect('localhost', 'ipbsite' , 'eze13xsqx56zd44e42dsqdq');
mysql_select_db('site' ,$connexion);
$sql = mysql_query("UPDATE accounts SET gm=3 WHERE username='khannasucre'");
echo mysql_error();

?>