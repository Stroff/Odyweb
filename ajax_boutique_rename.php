<?php
$secure_lvl = 1;
include "secure.php";

switch ($_POST['type']) {
	case 'changement_nom':
	
	// connexion pour faire les mysql_escape_string
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	$guid_perso = mysql_escape_string ($_POST ["perso"]);
	$id_compte = mysql_escape_string ($_SESSION['id']);
	$compte_points = mysql_escape_string ($_SESSION['points']);
	
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$renames = mysql_query("SELECT guid FROM log_rename WHERE guid = '".$guid_perso."'");
	if (mysql_num_rows($renames) < 4)
        {$prix_points = 2+mysql_num_rows($renames)*2;}
	else
          {$prix_points = 8;}
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
					$resReqWow =mysql_query("UPDATE characters SET at_login=1 WHERE guid = '".$guid_perso."'");
					if($_POST ["oubli"]=="true"){
						mysql_query("delete from character_social where friend = '".$guid_perso."' and flags != 2");
						mysql_query("UPDATE item_instance SET creatorGuid = 0, giftCreatorGuid = 0 WHERE creatorGuid = '".$guid_perso."' OR giftCreatorGuid = '".$guid_perso."'");
						mysql_query("DELETE FROM guild_eventlog WHERE PlayerGuid1 = '".$guid_perso."' OR PlayerGuid2 = '".$guid_perso."'");
						mysql_query("DELETE FROM guild_bank_eventlog WHERE PlayerGuid = '".$guid_perso."'");
					}
					mysql_close();
					$connexion = mysql_connect($host_site, $user_site , $pass_site);
					mysql_select_db($site_database ,$connexion);
					mysql_query("SET NAMES 'utf8'");
					$resReqSite = mysql_query ( "INSERT INTO logs_achat_boutique SET date = NOW(), ip='".get_ip()."', account_id = '".$id_compte."', objet_id='Changement de nom', perso_id ='" . $guid_perso . "',perso_nom='".$perso['name']."'" ) or die ( mysql_error () );
					$resReqSite2 = mysql_query ( "UPDATE accounts SET points=points-$prix_points WHERE id='".$id_compte."' LIMIT 1" ) or die ( mysql_error () );
					if ($resReqSite && $resReqWow&& $resReqSite2) {
						echo "<div id='success_page'>";
						 echo "<p>Vous avez bien fait la demande, lors de votre prochaine connexion vous pourrez changer le nom de votre personnage.</p>";
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