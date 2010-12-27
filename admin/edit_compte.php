<?php
$secure_lvl=2;
include '../secure.php';
if($_SESSION['gm']==4 || $_SESSION['gm']==3){
	echo "<h1>juste pour les admins et resp, dsl</h1>";
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Détails du compte</title>
</head>
<body>
<div id="dt_example">
<?php include "navbar.php"; ?>
	<?php
	include 'config/config.php';
	
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");	
	$id_compte_edit = mysql_escape_string($_GET['id']);
	$nbr_points = mysql_escape_string($_POST['points']);
	if (isset($_POST['email'])) {
		$email_edit_compte = mysql_escape_string ( $_POST ["email"]);
		if ( $_POST ["password2"]=='' && $_POST ["password1"]=='') {
			$extension = mysql_escape_string ( $_POST ["extension"]);
			mysql_close();
			// connexion serveur wow pour changement d'extension
			$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
			mysql_select_db($wow_realmd ,$connexion);
			$resReqWow = mysql_query ( "UPDATE account SET expansion = '".$extension."'  WHERE id='" . $id_compte_edit . "' LIMIT 1" ) or die ( mysql_error () );
			
			//retour sur le serveur site
			mysql_close();					
			$connexion = mysql_connect($host_site, $user_site , $pass_site);
			mysql_select_db($site_database ,$connexion);
			$resReqSite = mysql_query ( "UPDATE accounts SET extension = '".$extension."', email = '".$email_edit_compte."', points= '".$nbr_points."' WHERE id='" . $id_compte_edit . "' LIMIT 1" ) or die ( mysql_error () );
							
			if ($resReqSite && $resReqWow) {
				echo '<p style="color:green;">Vous avez bien fait le changement sur le compte</p>';
			} else {
				echo '<p style="color:red;">Erreur dans le changement sur le compte</p>';
			}
		} else {
			if ($_POST ["password2"]==$_POST ["password1"] && strlen($_POST ["password2"])>5 ) {
				$hash_old_nouveau_password = sha1(strtoupper($_SESSION['login']).':'.strtoupper($_POST ["password1"]));
				$hash_new_nouveau_password = sha1($_POST ["password1"]);
				
				//serveur wow connexion ici
				mysql_close();
				$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
				mysql_select_db($wow_realmd ,$connexion);
				
				$extension = mysql_escape_string ( $_POST ["extension"]);
				$resReqSite = mysql_query ( "UPDATE account SET sha_pass_hash='" . $hash_old_nouveau_password . "', expansion = '".$extension."',v='',s='',sessionkey=''  WHERE id='" . $id_compte_edit . "' LIMIT 1" ) or die ( mysql_error () );
				
				//retour sur le serveur site
				mysql_close();					
				$connexion = mysql_connect($host_site, $user_site , $pass_site);
				mysql_select_db($site_database ,$connexion);
				$resReqWow = mysql_query ( "UPDATE accounts SET password='" . $hash_new_nouveau_password . "', password_old='', extension = '".$extension."', email = '".$email_edit_compte."', points= '".$nbr_points."' WHERE id='" . $id_compte_edit . "' LIMIT 1" ) or die ( mysql_error () );
			
				mysql_query("UPDATE redmine.users SET hashed_password='".$hash_new_nouveau_password ."' WHERE login='".$id_compte_edit."' LIMIT 1");
				// je change le passwd de la session pour pas deco la personne du site
				$_SESSION ['password'] = $hash_new_nouveau_password;
				if ($resReqSite && $resReqWow) {
					echo '<p style="color:green;">Vous avez bien fait le changement sur le compte</p>';
				} else {
					echo '<p style="color:red;">Erreur dans le changement sur le compte</p>';
				}
			} else {
				echo '<p style="color:red;">Nouveaux mots de passe différents. ou trop court (5 caractères minimum)</p>';
			}
		}
	}
	
	$resultat = mysql_query("SELECT * FROM accounts WHERE id = '".$id_compte_edit."'");
	$compte_edit = mysql_fetch_array($resultat);

	if (mysql_num_rows($resultat)==0) {
		echo '<p style="color:red;">Id demande du compte invalide on trouvé</p>';
		exit();
	}
	?>
<form id="form" name="form" method="post" action="edit_compte.php?id=<?php echo $id_compte_edit; ?>">

	<br />
	<label> Id du compte : </label><?php echo $id_compte_edit ?> <br />

	<br />
	<label> Nom de compte: </label>
	<input name="username" type="text" id="username" size="20" READONLY value="<?php echo $compte_edit['username']; ?>"/> <br />

	<br />
	<label> Adresse email: </label>
	<input name="email" type="text" id="email" size="20" value="<?php echo $compte_edit['email']; ?>"/> <br />
	<br />

	<label> Nombre de points : </label>
	<input name="points" type="text" id="points" size="20" value="<?php echo $compte_edit['points']; ?>"/> <br />
	<br />
	
	<label> Nouveau mot de passe : </label>
	<input name="password1" type="password" id="password1" size="20"/> <br />

	<br />
	<label> Nouveau mot de passe confirmation: </label>
	<input name="password2" type="password" id="password2" size="20"/> <br />

	<label> Extension : </label>
		<SELECT name="extension"><?php
	if ($compte_edit['extension']==0) {
		echo '<OPTION selected VALUE="0">Normal</OPTION>';
	}else {
		echo '<OPTION VALUE="0">Normal</OPTION>';
	}	
	if ($compte_edit['extension']==1) {
		echo '<OPTION selected VALUE="1">BC</OPTION>';
	}else {
		echo '<OPTION VALUE="1">BC</OPTION>';
	}
	if ($compte_edit['extension']==2) {
		echo '<OPTION selected VALUE="2">Wotlk</OPTION>';
	}else {
		echo '<OPTION VALUE="2">Wotlk</OPTION>';
	}
	?></SELECT><br />

<input name="new_valid" id="new_valid" type="submit" value="Valider" /><br />
</form>

</body>
</html>
