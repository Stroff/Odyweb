
<?php
include 'config/config.php';
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$sql = "SELECT username FROM accounts2 where username = '".$_POST['validateValue']."'";
$rs = mysql_query($sql);

if (mysql_num_rows($rs)==1){
	$arr = array ('jsonValidateReturn'=>array ('nom','ajaxUser','false'));
} else {
	$arr = array ('jsonValidateReturn'=>array ('nom','ajaxUser','true'));
}

print json_encode($arr);
?>