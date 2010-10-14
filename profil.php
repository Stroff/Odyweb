<?php 
$secure_lvl = 1;
$header_titre = "Profil";
require "lib/phpmailer/class.phpmailer.php";
include "include/template/header_cadres.php"; 
?>

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
<h2>Profil</h2>
<?php
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	

	if ($_POST ["password_actuel"]) {
		
		$hash_actuel = sha1($_POST ["password_actuel"]);
		if ($hash_actuel == $_SESSION['password']) {
			if($_POST ["email"]<>$_SESSION['email']){
				
				$token = md5(uniqid(rand(), true));
				$email_new = mysql_escape_string ( $_POST ["email"]);
				
				mysql_query("INSERT INTO accounts_changement_email SET id_compte = '".$compte_id."', ip = '".get_ip()."', ancienne_email='".$_SESSION['email']."', nouvelle_email='".$email_new."', token_rollback='".$token."',date=NOW(), refuser = 0");
					$mail = new PHPmailer();
					$mail->IsSMTP();
					$mail->Host='127.0.0.1';
					$mail->CharSet	=	"UTF-8";
					$mail->IsHTML(true);
					$mail->FromName="Odyssée Serveur";
					$mail->From='site@odyssee-serveur.com';
					$mail->AddAddress($_SESSION['email']);
					$mail->AddReplyTo('site@odyssee-serveur.com');	
					$mail->Subject="Changement d'email";
					$mail->Body="<p>Odyssée vous informe que l'adresse email de votre compte ".$_SESSION['login']." a été changé. La nouvelle adresse est maintenant ".$_POST ["email"].". Si ce n'est pas votre email vous pouvez retrouvé l'ancienne email avec ce lien : <a href='".$url_site."/rollback_email.php?code=".$token."'>".$url_site."/rollback_email.php?code=".$token."</a><p> <p>Merci.</p>";
					$mail->Send();
					
					$req_email = mysql_query ( "UPDATE accounts SET email = '".$email_new."' WHERE id='" . $compte_id . "' LIMIT 1" ) or die ( mysql_error () );
					$_SESSION['email'] = $_POST ["email"];
			}
			
			if ( $_POST ["password2"]=='' && $_POST ["password1"]=='') {
				$extension = mysql_escape_string ( $_POST ["extension"]);
				
				mysql_close();
				// connexion serveur wow pour changement d'extension
				$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
				mysql_select_db($wow_realmd ,$connexion);
				$resReqWow = mysql_query ( "UPDATE account SET expansion = '".$extension."'  WHERE id='" . $compte_id . "' LIMIT 1" ) or die ( mysql_error () );
				
				//retour sur le serveur site
				mysql_close();					
				$connexion = mysql_connect($host_site, $user_site , $pass_site);
				mysql_select_db($site_database ,$connexion);
				$resReqSite = mysql_query ( "UPDATE accounts SET extension = '".$extension."' WHERE id='" . $compte_id . "' LIMIT 1" ) or die ( mysql_error () );
								
				if ($resReqSite && $resReqWow) {
					echo '<div style="margin-left:20px;"><p> Votre compte a bien été modifié, vous avez changé d\'extension</p>';
					echo '</div></div></div></div><div class="encadrepage-bas">
					</div>';
					include'include/template/footer_cadres.php';
					exit;
				} else {
					echo '<div style="margin-left:20px;"> Erreur dans la modification du compte</br></div>';
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
					$resReqSite = mysql_query ( "UPDATE account SET sha_pass_hash='" . $hash_old_nouveau_password . "', expansion = '".$extension."',v='',s='',sessionkey=''  WHERE id='" . $compte_id . "' LIMIT 1" ) or die ( mysql_error () );
					
					//retour sur le serveur site
					mysql_close();					
					$connexion = mysql_connect($host_site, $user_site , $pass_site);
					mysql_select_db($site_database ,$connexion);
					$resReqWow = mysql_query ( "UPDATE accounts SET password='" . $hash_new_nouveau_password . "', password_old='', extension = '".$extension."' WHERE id='" . $compte_id . "' LIMIT 1" ) or die ( mysql_error () );
				
					mysql_query("UPDATE redmine.users SET hashed_password='".$hash_new_nouveau_password ."' WHERE login='".$_SESSION['login']."' LIMIT 1");
				
					// je change le passwd de la session pour pas deco la personne du site
					$_SESSION ['password'] = $hash_new_nouveau_password;
					if ($resReqSite && $resReqWow) {
						echo '<div style="margin-left:20px;"><p> Votre compte a bien été modifié</p>';
						echo '</div></div></div></div><div class="encadrepage-bas">
						</div>';
						include'include/template/footer_cadres.php';
						exit;
					} else {
						$erreur =  'Erreur dans la modification du compte';
					}
				} else {
					$erreur = "Nouveaux mots de passe différents. ou trop court (5 caractères minimum)";
				}
			}
		}else {
			$erreur = "Mot de passe actuel incorrect.";
		}

	}
	$extension = $_SESSION ['extension'];
?>

		<form action="profil.php" method="post" name="profil" id="form">
		<div style="margin-left:20px;">
		<p>Vous devez mettre votre mot de passe actuel pour faire une modification</p>
		<?php echo '<p style="color:red;">'.@$erreur.'</p>'; ?>
			<br />
	    	<label style="width: 215px;"> Nom de compte : </label>
	    	<input name="username" type="text" READONLY id="username" size="20" value="<?php echo $_SESSION['login']; ?>"/> <br />

			<br />
	    	<label style="width: 215px;"> Email : </label>
	    	<input name="email" type="text" id="email" size="20" value="<?php echo $_SESSION['email']; ?>"/> <br />
	
			<br />
	  		<label style="width: 215px;"> Mot de passe actuel : </label>
	   		<input name="password_actuel" type="password" id="password_actuel" size="20"/> <br />

			<br />
	  		<label style="width: 215px"> Nouveau mot de passe : </label>
	   		<input name="password1" type="password" id="password1" size="20"/> <br />

			<br />
	  		<label style="width: 215px"> Confirmation de mot de passe : </label>
	   		<input name="password2" type="password" id="password2" size="20"/> <br />

			<br />
	  		<label style="width: 215px"> Extension : </label>
	   			<SELECT name="extension"><?php
			if ($extension==0) {
				echo '<OPTION selected VALUE="0">Normal</OPTION>';
			}else {
				echo '<OPTION VALUE="0">Normal</OPTION>';
			}	
			if ($extension==1) {
				echo '<OPTION selected VALUE="1">BC</OPTION>';
			}else {
				echo '<OPTION VALUE="1">BC</OPTION>';
			}
			if ($extension==2) {
				echo '<OPTION selected VALUE="2">Wotlk</OPTION>';
			}else {
				echo '<OPTION VALUE="2">Wotlk</OPTION>';
			}
			?></SELECT><br />

			<br />
			<input style="margin-left: 213px;" type="submit" value="Envoyer" />
		</div>
	</form>
<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>