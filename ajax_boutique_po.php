<?php
$secure_lvl = 1;
include "secure.php";

switch ($_POST['type']) {
	case 'prix_po':
	$nombre_po = mysql_escape_string ( $_POST ["valeur"]);

	$arr['prix_points'] = $nombre_po/100*1;
	print json_encode($arr);
	break;
	
	case 'achat_po':
	// connexion pour faire les mysql_escape_string
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	$nombre_po = mysql_escape_string ($_POST ["valeur"]);
	$guid_perso = mysql_escape_string ($_POST ["perso"]);
	$id_compte = mysql_escape_string ($_SESSION['id']);
	$compte_points = mysql_escape_string ($_SESSION['points']);
	
	if ($guid_perso =='') {
		echo '<div class="error_message">Vous devez mettre un personnage.</div>';
	} else {
	// 100po = 	1000000 pieces
	//1po = 10000 pieces
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$persos = mysql_query("SELECT name FROM characters WHERE guid = '".$guid_perso."' AND account='".$id_compte."'");
		if (mysql_num_rows($persos) == 1) {
				$perso = mysql_fetch_array($persos);
				$nombre_pieces=$nombre_po*10000;
				$prix_po = $nombre_po/100*1;
				if ($compte_points >=$prix_po) {
					$resReqWow =mysql_query("INSERT INTO `mail_external` (`sender`,`receiver`,`subject`,`message`, `money`) VALUES ('3', '$guid_perso', 'Boutique Odysée Serveur', 'Chèr(e) joueur/joueuse, voici votre argent.', '".$nombre_pieces."')");
					mysql_close();
					$connexion = mysql_connect($host_site, $user_site , $pass_site);
					mysql_select_db($site_database ,$connexion);
					mysql_query("SET NAMES 'utf8'");
					$resReqSite = mysql_query ( "INSERT INTO logs_achat_boutique SET date = NOW(), ip='".get_ip()."', account_id = '".$id_compte."', objet_id='".$nombre_po." po', perso_id ='" . $guid_perso . "',perso_nom='".$perso['name']."'" ) or die ( mysql_error () );
					$resReqSite2 = mysql_query ( "UPDATE accounts SET points=points-$prix_po WHERE id='".$id_compte."' LIMIT 1" ) or die ( mysql_error () );
					if ($resReqSite && $resReqWow&& $resReqSite2) {
						echo "<div id='success_page'>";
						 echo "<p>Vous avez reçu un courrier avec votre argent.</p>";
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