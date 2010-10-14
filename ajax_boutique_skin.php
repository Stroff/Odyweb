<?php
$secure_lvl = 1;
include "secure.php";

switch ($_POST['type']) {
	case 'changement_skin':
	
	$prix_points = 2;
	
	// connexion pour faire les mysql_escape_string
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	$guid_perso = mysql_escape_string ($_POST ["perso"]);
	$id_compte = mysql_escape_string ($_SESSION['id']);
	$compte_points = mysql_escape_string ($_SESSION['points']);
	
	if ($guid_perso =='') {
		echo '<div class="error_message">Vous devez choisir un personnage hors ligne et sans demandes de modifications en attente dessus.</div>';
	} else {
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$persos = mysql_query("SELECT name FROM characters WHERE guid = '".$guid_perso."' AND account='".$id_compte."'");
		if (mysql_num_rows($persos) == 1) {
				$perso = mysql_fetch_array($persos);
				if ($compte_points >=$prix_points) {
					$resReqWow =mysql_query("UPDATE characters SET at_login=8 WHERE guid = '".$guid_perso."'");
					mysql_close();
					$connexion = mysql_connect($host_site, $user_site , $pass_site);
					mysql_select_db($site_database ,$connexion);
					mysql_query("SET NAMES 'utf8'");
					$resReqSite = mysql_query ( "INSERT INTO logs_achat_boutique SET date = NOW(), account_id = '".$id_compte."', objet_id='Changement de skin', perso_id ='" . $guid_perso . "',perso_nom='".$perso['name']."'" ) or die ( mysql_error () );
					$resReqSite2 = mysql_query ( "UPDATE accounts SET points=points-$prix_points WHERE id='".$id_compte."' LIMIT 1" ) or die ( mysql_error () );
					if ($resReqSite && $resReqWow&& $resReqSite2) {
						echo "<div id='success_page'>";
						 echo "<p>Vous avez bien fait la demande, lors de votre prochaine connexion vous pourrez changer l'apparence de votre personnage.</p>";
						 echo "</div>";
						echo '<div id="bottom_contenu"></div>';
					} else {
						echo '<div class="error_message">Erreur avec le serveur de base de données pour votre achat.</div>';
					}
				} else {
					// pas assez de po
					echo '<div class="error_message">Vous n\'avez pas assez de points.</div>';	
				}
		} else {
			// pas un perso du compte donc tentative de hack
			echo '<div class="error_message">Le personnage n\'appartient pas à votre compte.</div>';
		}
	}
	
	break;
}
?>