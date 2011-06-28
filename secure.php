<?php
session_start() or die("Impossible de créer la sessions!!");
require('config/config.php');
require('include/php/fonctions.php');

if (isset($_GET['type'])&&$_GET['type']=="logout") {

	destroy_session();
	header("Location:".$url_site."/index.php");
	exit();
}
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$resultat  = mysql_query("SELECT valeur FROM configuration WHERE nom='mode_maintenance'");
$maintenance = mysql_fetch_array($resultat);
$maintenance = $maintenance[0];
if (strtoupper($maintenance)=='OUI' && $_SESSION['gm'] > 1) {
	if($secure_lvl <> -1) {
		header("Location:".$url_site."/maintenance.php");
		exit();
	}	
} else {

	if (isset($_COOKIE['login'])) {

		$_SESSION['login']=$_COOKIE['login'];
		$_SESSION['password']=$_COOKIE['password'];
	}

	if (!isset($_SESSION['login'])) {
		if ($secure_lvl > 0) {
			header("Location:".$url_site."/login.php");
			exit();
		}else {
			$secure_passe_controles = 1;
		}
	}
	if ($secure_passe_controles <> 1) {
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");

		$login=mysql_escape_string($_SESSION['login']);
		$pass=$_SESSION['password']; 

		//now validating the username and password

		$sql="SELECT password,next_vote_date,points,extension,id,gm,email FROM accounts WHERE username='".$login."' AND password = '".$pass."' AND activation=1";
		$result=mysql_query($sql);
		//j'update l'ip et je recup les points pour les autres pages
		//if username exists
		if(mysql_num_rows($result)==0)
		{
			destroy_session();
			header("Location:".$url_site."/login.php");
			exit();
		} else {
			$compte = mysql_fetch_array($result);
			$_SESSION['next_vote_date'] = $compte['next_vote_date'];
			$_SESSION['points'] =  $compte['points'];
			$_SESSION['extension'] =  $compte['extension'];
			$_SESSION['id'] =  $compte['id'];
			$_SESSION['email'] =  $compte['email'];
			$_SESSION['gm'] =  $compte['gm'];

			$sql="UPDATE accounts SET last_ip = '".get_ip()."', last_activite=NOW() WHERE username='".$login."'";
			$result=mysql_query($sql);
			if($secure_lvl==2&&$_SESSION['gm']<1) {
				header("Location:".$url_site."/not_allow.php");
				exit();
			}
		}	
	}
}
function destroy_session(){
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	if(isset($_COOKIE['login'])) {
		// Set expiration time to -1hr (will cause browser deletion)
		setcookie("login", false, time() - 3600);
		// Unset key
		unset($_COOKIE["login"]);
	}
	if(isset($_COOKIE['password'])) {
		// Set expiration time to -1hr (will cause browser deletion)
		setcookie("password", false, time() - 3600);
		// Unset key
		unset($_COOKIE["password"]);
	}

	$_SESSION = array();
	session_destroy();
}
?>
