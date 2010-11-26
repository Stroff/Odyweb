<?php
$secure_lvl = 1;
include "secure.php";

switch ($_POST['type']) {
	
	case 'achat_objet':
	// connexion pour faire les mysql_escape_string
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	$id_objet= mysql_escape_string ($_POST ["objet"]);
	$guid_perso = mysql_escape_string ($_POST ["perso"]);
	$id_compte = mysql_escape_string ($_SESSION['id']);
	$compte_points = mysql_escape_string ($_SESSION['points']);
	
	if ($guid_perso =='') {
		echo '<div class="error_message">Vous devez mettre un personnage.</div>';
	} else {
		$persos = mysql_query("SELECT name FROM characters WHERE guid = '".$guid_perso."' AND account='".$id_compte."'");
		if (mysql_num_rows($persos) == 1) {
				$perso = mysql_fetch_array($persos);
				// connexion site pour avoir les infos sur l'item
				mysql_close();
				$connexion = mysql_connect($host_site, $user_site , $pass_site);
				mysql_select_db($site_database ,$connexion);
				mysql_query("SET NAMES 'utf8'");
				$objet = mysql_query("SELECT prix,disponible,id_objet,id_objet_ig FROM items_boutique WHERE id = '".$id_objet."'");
				$objet = mysql_fetch_array($objet);
				if ($compte_points >=$objet['prix'] && $objet['disponible']==1) {
					
					mysql_close();
					// connexion wow pour faire le mail
					$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
					mysql_select_db($wow_characters ,$connexion);
					mysql_query("SET NAMES 'utf8'");
					$resReqWow = mysql_query("INSERT INTO `mail_external` (`sender`,`receiver`,`subject`,`message`, `money`) VALUES ('3', '$guid_perso', 'Boutique Odysée Serveur', 'Chèr(e) joueur/joueuse, voici l\'objet que vous avez acheté.', '0')");
					$id_mail = mysql_insert_id();
					$resReqWow2 = mysql_query("INSERT INTO `mail_external_items` (`item`,`mail_id`) VALUES ('".$objet['id_objet_ig']."','".$id_mail."')");
					mysql_close();
					// retour sur le site pour maj des points et logs
					$connexion = mysql_connect($host_site, $user_site , $pass_site);
					mysql_select_db($site_database ,$connexion);
					mysql_query("SET NAMES 'utf8'");
					$resReqSite = mysql_query ( "INSERT INTO logs_achat_boutique SET date = NOW(), ip='".get_ip()."', account_id = '".$id_compte."', objet_id='".$objet['id_objet']." objet', perso_id ='" . $guid_perso . "',perso_nom='".$perso['name']."'" ) or die ( mysql_error () );
					$resReqSite2 = mysql_query ( "UPDATE accounts SET points=points-".$objet['prix']." WHERE id='".$id_compte."' LIMIT 1" ) or die ( mysql_error () );
					if ($resReqSite && $resReqWow&& $resReqSite2&&$resReqWow2) {
						echo "<div class='success_message'>";
						echo "Vous avez reçu un courrier avec votre objet";	
						echo "</div>";
					} else {
						echo '<div class="error_message">Erreur avec le serveur de base de données pour votre achat.</div>';
					}
				} else {
					if ($compte_points < $objet['prix']) {
						echo '<div class="error_message">Vous n\'avez pas assez de points.</div>';							
					} else if($objet['disponible']==0) {
						echo '<div class="error_message">L\'objet n\'est pas disponible.</div>';							
					}
				}
		} else {
			// pas un perso du compte donc tentative de hack
			echo '<div class="error_message">Le personnage n\'appartient pas à votre compte.</div>';
		}
	}
	
	break;
}
?>