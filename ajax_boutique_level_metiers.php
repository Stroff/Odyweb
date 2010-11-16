<?php
$secure_lvl = 1;
include "secure.php";

switch ($_POST['type']) {	
	case 'liste_metiers':
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$guid_perso = mysql_escape_string ( $_POST ["valeur"]);
		$metiers = mysql_query("SELECT skill,value,max FROM character_skills WHERE guid = '".$guid_perso."'");
		$metiers_ig["333"]["id"] = 333;
		$metiers_ig["333"]["nom"] = "Enchantement";
		$metiers_ig["171"]["id"] = 171;
		$metiers_ig["171"]["nom"] = "Alchimie";
		$metiers_ig["773"]["id"] = 773;
		$metiers_ig["773"]["nom"] = "Calligraphie";
		$metiers_ig["197"]["id"] = 197;
		$metiers_ig["197"]["nom"] = "Couture";
		$metiers_ig["393"]["id"] = 393;
		$metiers_ig["393"]["nom"] = "Dépeçage";
		$metiers_ig["164"]["id"] = 164;
		$metiers_ig["164"]["nom"] = "Forge";
		$metiers_ig["182"]["id"] = 182;
		$metiers_ig["182"]["nom"] = "Herboristerie";
		$metiers_ig["202"]["id"] = 202;
		$metiers_ig["202"]["nom"] = "Ingénierie";
		$metiers_ig["755"]["id"] = 755;
		$metiers_ig["755"]["nom"] = "Joaillerie";
		$metiers_ig["186"]["id"] = 186;
		$metiers_ig["186"]["nom"] = "Minage";
		$metiers_ig["165"]["id"] = 165;
		$metiers_ig["165"]["nom"] = "Travail du cuir";
		
		while($metier = mysql_fetch_array($metiers)){
			// recherche d'un metier
			foreach($metiers_ig as $metier_ig) {
				if($metier_ig["id"]==$metier["skill"]){
					$metier_perso = $metier_ig;
					$metier_perso["max"] = $metier["max"];
					$metier_perso["value"] = $metier["value"];
					$retour_metier[] = $metier_perso;
				}
			}
		}
		print json_encode($retour_metier);
	break;
	
	case 'level_prix':
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$metier_perso = mysql_escape_string ( $_POST ["valeur_metier"]);
	$guid_perso = mysql_escape_string ( $_POST ["valeur"]);
	$lvl_metier = mysql_query("SELECT value,max FROM character_skills WHERE guid = '".$guid_perso."' AND skill='".$metier_perso."'");
	$metier = mysql_fetch_array($lvl_metier);
	if($metier['value']+25>$metier['max']){
		//dépasse le max autorisé du lvl
		$new_lvl_prix=-2;
	}else{
		$level_actuel = $metier['value'];
		if($level_actuel<25) {
			$new_lvl_prix =  0.5;
		}else if($level_actuel<50) {
			$new_lvl_prix = 0.75;
		}else if($level_actuel<75) {
			$new_lvl_prix =  1;
		}else if($level_actuel<100) {
			$new_lvl_prix =  1.25;
		}else if($level_actuel<125) {
			$new_lvl_prix =  1.5;
		} else if ($level_actuel<150) {
			$new_lvl_prix = 1.75; 
		}else if ($level_actuel<175) {
			$new_lvl_prix = 2; 
		}else if ($level_actuel<200) {
			$new_lvl_prix = 2.25; 
		}else if ($level_actuel<225) {
			$new_lvl_prix = 2.5; 
		}else if ($level_actuel<250) {
			$new_lvl_prix = 2.75; 
		}else if ($level_actuel<275) {
			$new_lvl_prix = 3; 
		}else if ($level_actuel<300) {
			$new_lvl_prix = 3.25; 
		}else if ($level_actuel<325) {
			$new_lvl_prix = 3.5; 
		}else if ($level_actuel<350) {
			$new_lvl_prix = 3.75;
		}else if ($level_actuel==350) {
			$new_lvl_prix = 4; 
		} else {
			// n'est pas dans les offres possible
			$new_lvl_prix = -1; 
		}
	}
	$arr['prix'] = $new_lvl_prix;
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
			
			$new_lvl_prix = $level_actuel+$lvl_en_plus;
			if ($new_lvl_prix == $level_actuel) {
				echo '<div class="error_message">Vous ne pouvez pas acheter 0 niveaux.</div>';
			} else {
				if ($compte_points >=2) {
					$resReqWow = mysql_query ( "UPDATE characters SET level = '".$new_lvl_prix."' WHERE guid='" . $guid_perso . "' LIMIT 1" ) or die ( mysql_error () );
					mysql_close();
					$connexion = mysql_connect($host_site, $user_site , $pass_site);
					mysql_select_db($site_database ,$connexion);
					mysql_query("SET NAMES 'utf8'");
					$resReqSite = mysql_query ( "INSERT INTO logs_achat_boutique SET date = NOW(), account_id = '".$id_compte."', objet_id='".$lvl_en_plus." levels', perso_id ='" . $guid_perso . "',perso_nom='".$perso['name']."'" ) or die ( mysql_error () );
					$resReqSite2 = mysql_query ( "UPDATE accounts SET points=points-2 WHERE id='".$id_compte."' LIMIT 1" ) or die ( mysql_error () );
					if ($resReqSite && $resReqWow&& $resReqSite2) {
						echo "<div id='success_page'>";
						 echo "<p>Vous avez maintenant le niveau ".$new_lvl_prix." sur le perso ".$perso['name'].".</p>";
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