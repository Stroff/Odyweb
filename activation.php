<?php 
$secure_lvl = 0;
$header_titre = "Activation du compte";
require "include/template/header_cadres.php"  
?>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<script src="js/jquery.validationEngine-fr.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>

<script type="text/javascript">
//Make sure the document is loaded
$(document).ready(function(){
	
	$("#form").validationEngine({
	inlineValidation: true,
	success :  true,
	failure : false
	})
 });
</script>


<div id="msgbox"></div>
<div class="encadrepage-haut">
	<div class="encadrepage-titre">
            <br/>
            <br/>
            <img src="medias/images/titre/serveur.gif" >
        
	</div>
</div>
	<div class="blocpage">
    	<div class="blocpage-haut">
        </div>
        <div class="blocpage-bas">
        	<div class="blocpage-texte">
<h2>Inscription</h2>
<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");

$code = trim(mysql_real_escape_string($_GET['code']));
if ($code <> '') {
	//le serveur site			
	$sql = "SELECT password,username,password_old FROM accounts WHERE key_activation = '".$code."'";
	$result = mysql_query($sql);
    if (mysql_num_rows($result)==1) {
		$row= mysql_fetch_array($result);
		$old_password =$row['password_old'];
		$resReqSite = mysql_query("UPDATE accounts SET key_activation='',password_old='',activation=1 WHERE key_activation = '".$code."'");
		
		//serveur wow connexion ici
		mysql_close();
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_realmd ,$connexion);
		$resReqWow = mysql_query ( "UPDATE account SET sha_pass_hash='".$old_password."' WHERE username='" . $row['username'] . "'" ) or die ( mysql_error () );

		if ($resReqWow && $resReqSite) {
			$message = 'Votre activation c\'est bien déroulée. Vous pouvez maintenant vous amuser sur le serveur. Dans le realmlist : set realmlist serveur.odyssee-serveur.com';
		} else {
			$message = 'Erreur dans l\'activation de votre compte. Contactez un développeur';	
		}
	} else {
		$message = 'Le code de vérification ne semble pas correct.';
	}
}else {
	$message = 'Vous devez suivre le lien du mail';
}

	echo '<p>'.$message.'</p>';
?>
</div>
</div>
</div>
<div class="encadrepage-bas">
</div>
<?php require "include/template/footer_cadres.php"?>
