<?php
$secure_lvl = 1;
include "secure.php";

switch ($_POST['type']) {
	case 'level':
	$guid_perso = mysql_escape_string ( $_POST ["valeur"]);
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$persos = mysql_query("SELECT level,name FROM characters WHERE guid = '".$guid_perso."'");
	$perso = mysql_fetch_array($persos);
	$level_actuel = $perso['level'];
	if($level_actuel<15) {
		$new_lvl =  7;
	}else if($level_actuel<28) {
		$new_lvl = 6;
	}else if($level_actuel<40) {
		$new_lvl =  5;
	}else if($level_actuel<51) {
		$new_lvl =  4;
	}else if($level_actuel<61) {
		$new_lvl =  3;
	} else if ($level_actuel==69) {
		$new_lvl = 1; 
	}else if ($level_actuel<70) {
		$new_lvl = 2; 
	} else {
		$new_lvl = 0;
	}
	
	$arr['level_en_plus'] = $new_lvl;
	print json_encode($arr);
	break;
	
	case 'achat_level':
	// connexion pour faire les mysql_escape_string
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	$guid_perso = mysql_escape_string ($_POST ["valeur"]);
	$id_compte = mysql_escape_string ($_SESSION['id']);
	$compte_points = mysql_escape_string ($_SESSION['points']);
	
	if ($guid_perso =='') {
		echo '<div class="error_message">Vous devez mettre un personnage pour l\'achat.</div>';
	} else {
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$persos = mysql_query("SELECT level,name FROM characters WHERE guid = '".$guid_perso."' AND account='".$id_compte."'");
		
		if (mysql_num_rows($persos) == 1) {
			// c'est bien un perso du compte de la personne je calcul le nouveau lvl
			$perso = mysql_fetch_array($persos);
			$level_actuel = $perso['level'];
			if($level_actuel<15) {
				$lvl_en_plus =  7;
			}else if($level_actuel<28) {
				$lvl_en_plus = 6;
			}else if($level_actuel<40) {
				$lvl_en_plus =  5;
			}else if($level_actuel<51) {
				$lvl_en_plus =  4;
			}else if($level_actuel<61) {
				$lvl_en_plus =  3;
			} else if ($level_actuel==69) {
				$lvl_en_plus = 1; 
			}else if ($level_actuel<70) {
				$lvl_en_plus = 2; 
			} else {
				$lvl_en_plus = 0;
			}
			
			$new_lvl = $level_actuel+$lvl_en_plus;
			if ($new_lvl == $level_actuel) {
				echo '<div class="error_message">Vous ne pouvez pas acheter 0 niveaux.</div>';
			} else {
				if ($compte_points >=2) {
					$resReqWow = mysql_query ( "UPDATE characters SET level = '".$new_lvl."' WHERE guid='" . $guid_perso . "' LIMIT 1" ) or die ( mysql_error () );
					mysql_close();
					$connexion = mysql_connect($host_site, $user_site , $pass_site);
					mysql_select_db($site_database ,$connexion);
					mysql_query("SET NAMES 'utf8'");
					$resReqSite = mysql_query ( "INSERT INTO logs_achat_boutique SET date = NOW(), ip='".get_ip()."' account_id = '".$id_compte."', objet_id='".$lvl_en_plus." levels', perso_id ='" . $guid_perso . "',perso_nom='".$perso['name']."'" ) or die ( mysql_error () );
					$resReqSite2 = mysql_query ( "UPDATE accounts SET points=points-2 WHERE id='".$id_compte."' LIMIT 1" ) or die ( mysql_error () );
					if ($resReqSite && $resReqWow&& $resReqSite2) {
						echo "<div id='success_page'>";
						 echo "<p>Vous avez maintenant le niveau ".$new_lvl." sur le perso ".$perso['name'].".</p>";
						 echo "</div>";
						echo '<div id="bottom_contenu"></div>';
					} else {
						echo '<div class="error_message">Erreur avec le serveur de base de données dans le changement du niveau.</div>';
					}
				} else {
					// pas assez de po
					echo '<div class="error_message">Vous n\'avez pas assez de points.</div>';
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