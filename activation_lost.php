<?php 
$secure_lvl = 0;
$header_titre = "Rappel d'activation";
require "lib/phpmailer/class.phpmailer.php";
require "include/template/header_cadres.php";
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
<h2>Rappel de mot de passe</h2>
<?php
if ($_POST ["username_perdu"]) {
	$demande_username = mysql_escape_string ( $_POST ["username_perdu"]);
		
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$sql_check_compte = mysql_query("SELECT activation,key_activation,email FROM accounts WHERE username='".$demande_username."'");
	
	if (mysql_num_rows($sql_check_compte)==1) {
		$row = mysql_fetch_array($sql_check_compte); 
		if ($row['activation']==0) {
			$token = $row['key_activation'];
			$subject = "Inscription sur le serveur Odyssée Serveur";
			// message
			$message = '<h2>Email de confirmation</h2><p>Bonjour</p><p>Vous avez demandé à vous inscrire sur le serveur privé Odyssée-Serveur, pour confirmer votre demande et pouvoir jouer vous devez suivre ce <a href="'.$url_site.'/activation.php?code='.$token.'">lien</a> vers notre page de confirmation.</p> <p>Merci.</p>';

			$mail = new PHPmailer();
			$mail->IsSMTP();
			$mail->Host='127.0.0.1';
			$mail->CharSet = "UTF-8";
			$mail->IsHTML(true);
			$mail->From='site@odyssee-serveur.com';
			$mail->FromName="Odyssée Serveur";
			$mail->AddAddress($row['email']);
			$mail->AddReplyTo('site@odyssee-serveur.com');	
			$mail->Subject=$subject;
			$mail->Body=$message;
			if($mail->Send()){ //Teste le return code de la fonction
			    echo '<div style="margin-left:20px;"><br> Votre mail de confirmation a bien été renvoyé. Il vous suffira de cliquer sur le lien dans le mail de confirmation pour activer le compte.</br></div>';
				echo '</div></div></div></div><div class="encadrepage-bas">
				</div>';
				include'include/template/footer_cadres.php';
				exit;
			} else {
				echo '<div style="margin-left:20px;"><br> Votre mail de confirmation n\'a pas été renvoyé. Veuillez consulter la section login du support sur le site</br></div>';
				echo '</div></div></div></div><div class="encadrepage-bas">
				</div>';
				include'include/template/footer_cadres.php';
				exit;
			}
		} else {
			$message = "Vous avez déjà activé votre compte.";
		}
	} else {
		$message = "Le nom de compte ne semble pas exister.";
	}
}
?>

<?php echo '<p style="color:red;">'.@$message.'</p>'; ?>
<p>Nous pouvez vous renvoyer le lien d'activation par email pour votre compte. Il suffit de remplir le formulaire</p>
	<form action="activation_lost.php" method="post" name="form" id="form">
	<div style="margin-left:20px;">
		<br />
	    <label style="width: 215px;font-weight: normal;"> Nom de compte : </label>
	    <input name="username_perdu" type="text" id="username_persu" size="20" /> <br />

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