<?php 
$secure_lvl = 0;
$header_titre = "Mot de passe perdu";
include "include/template/header_cadres.php";
require "lib/phpmailer/class.phpmailer.php";
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
if ($_GET ["code"]) {	
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	$demande_code = mysql_escape_string ( $_GET["code"]);
	
	$sql_check_compte = mysql_query("SELECT username FROM accounts2 WHERE key_activation = '".$demande_code."'");
	
	if (mysql_num_rows($sql_check_compte)==1) {
		$row = mysql_fetch_array($sql_check_compte); 
		
		$nouveau_mdp_clair=genere_password(8);
		$nouveau_mdp= sha1($nouveau_mdp_clair);
		$old_nouveau_mdp = sha1(strtoupper($row['username']).':'.strtoupper($nouveau_mdp_clair));
		
		$resReqSite = mysql_query("UPDATE accounts2 SET key_activation = '',password='".$nouveau_mdp."' WHERE key_activation = '".$demande_code."'");
		
		//serveur wow connexion ici
		mysql_close();
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_realmd ,$connexion);
		$resReqWow = mysql_query ( "UPDATE account SET sha_pass_hash='".$old_nouveau_mdp."',v='',s='',sessionkey='' WHERE username='" . $row['username'] . "'" ) or die ( mysql_error () );
		
		if ($resReqSite && $resReqWow) {
			echo '<div style="margin-left:20px;"><br> Votre nouveau mot de passe est maintenant : <b>'.$nouveau_mdp_clair.'</b></br></div>';
			echo '</div></div></div></div><div class="encadrepage-bas">
			</div>';
			include'include/template/footer_cadres.php';
			exit;
		}else {
			echo '<div style="margin-left:20px;"><br> Problémes dans le changement du mot de passe. Vous pouvez essayez ce mot de passe : <b>'.$nouveau_mdp_clair.'</b> Contactez un développeur sur le forum pour résoudre ce probléme.</br></div>';
			echo '</div></div></div></div><div class="encadrepage-bas">
			</div>';
			include'include/template/footer_cadres.php';
			exit;
		}
	} else {
		$message = 'Le code ne semble pas valide';
	}

} else if ($_POST ["username_perdu"]) {
	$demande_username = mysql_escape_string ( $_POST ["username_perdu"]);
		
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$sql_check_compte = mysql_query("SELECT activation,email FROM accounts2 WHERE username='".$demande_username."'");
	
	if (mysql_num_rows($sql_check_compte)==1) {
		$row = mysql_fetch_array($sql_check_compte); 
		if ($row['activation']==0) {
			$message = "Vous n'avez pas activé votre compte. Vous avez dèjà recu un email avec le lien. Si vous l'avez perdu rendez vous sur ce <a href='".$url_site."/activation_lost.php'>lien</a>";
		} else {
			$token = md5(uniqid(rand(), true));
			$resReqSite = mysql_query ( "UPDATE accounts2 SET key_activation = '".$token."' WHERE username='" . $demande_username. "'" ) or die ( mysql_error () );
			
			if ($resReqSite) {
				
				$subject = "Rappel de mot de passe Odyssée Serveur";
				// message
				$message = '<h2>Email de rappel de mot de passe</h2><p>Bonjour</p><p>Vous avez demandé un rappel de mot de passe, pour confirmer votre demande vous devez suivre ce <a href="'.$url_site.'/password_lost.php?code='.$token.'">lien</a> vers notre page de confirmation.</p> <p>Merci.</p>';

				$mail = new PHPmailer();
				$mail->IsSMTP();
				$mail->Host='127.0.0.1';
				$mail->CharSet	=	"UTF-8";
				$mail->IsHTML(true);
				$mail->FromName="Odyssée Serveur";
				$mail->From='site@odyssee-serveur.com';
				$mail->AddAddress($row['email']);
				$mail->AddReplyTo('site@odyssee-serveur.com');	
				$mail->Subject=$subject;
				$mail->Body=$message;
				
				if($mail->Send()){ //Teste le return code de la fonction
				    echo '<div style="margin-left:20px;"><br> Votre demande a bien été prise en compte. Il vous suffira de cliquer sur le lien dans le mail de confirmation pour avoir un nouveau mot de passe.</br></div>';
					echo '</div></div></div></div><div class="encadrepage-bas">
					</div>';
					include'include/template/footer_cadres.php';
					exit;
				} else {
					echo '<div style="margin-left:20px;"><br> Votre demande a bien été prise en compte mais le mail de confirmation n\'a pas été envoyé. Veuillez contacté un développeur sur le forum.</br></div>';
					echo '</div></div></div></div><div class="encadrepage-bas">
					</div>';
					include'include/template/footer_cadres.php';
					exit;
				}
				
			} else {
				$message = 'Erreur dans la création de la demande sur notre serveur de base de données';
			}
		}
	} else {
		$message = "L'email et le nom de compte ne sembles pas présent sur le serveur. Peut etre un mauvais nom de compte ou une erreur dans l'email?";
	}
}
?>

<?php echo '<p style="color:red;">'.@$message.'</p>'; ?>
	<form action="password_lost.php" method="post" name="form" id="form">
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