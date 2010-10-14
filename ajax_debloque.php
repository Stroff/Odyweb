<?php
$secure_lvl = 1;
include "secure.php";

switch ($_POST['type']) {
	case 'persos':
	$guid_perso = mysql_escape_string ( $_POST ["valeur"]);
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$persos = mysql_query("SELECT guid,class,level,race FROM characters WHERE guid = '".$guid_perso."'");
	$perso = mysql_fetch_array($persos);
	$race = array (
		1 => 'Humain',
		2 => 'Orc',
		3 => 'Nain',
		4 => 'Elfe de la nuit',
		5 => 'Mort vivant',
		6 => 'Tauren',
		7 => 'Gnome',
		8 => 'Troll',
		9 => 'Gnome', 
		10 => 'Elfe de sang',
		11 => 'Draenei',
		);
		
	$race_ally = array (1, 3, 4, 7, 9, 11 );
	if (in_array ( $perso ['race'], $race_ally )) {
		$faction = '1'; // les ally c'est 1
	} else {
		$faction = '2';
	}
	$arr = array();
	mysql_close();
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$sql = "SELECT nom AS destination_nom,id AS destination_id FROM destinations_deblocage where lvl_min <= ".$perso['level']." AND (faction = '".$faction."' OR faction = '0') AND (class = '".$perso['class']."' OR class='0')";
	//echo $sql;
	$rs = mysql_query($sql);
	
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}
	
	print json_encode($arr);
	break;
	
	case 'debloque':
	// connexion pour faire les mysql_escape_string
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	$guid_perso = mysql_escape_string ($_POST ["valeur"]);
	$destination_id = mysql_escape_string ($_POST ["destination_id"]);
	$id_compte = mysql_escape_string ($_SESSION['id']);
	
	if ($guid_perso =='') {
		echo '<div class="error_message">Vous devez mettre un personnage pour le déblocage.</div>';
	} else {
		// controle si le perso appartien bien au compte
		$persos = mysql_query("SELECT guid,class,level,race FROM characters WHERE guid = '".$guid_perso."'AND account = '".$id_compte."'");
		$perso = mysql_fetch_array($persos);
		$race = array (
			1 => 'Humain',
			2 => 'Orc',
			3 => 'Nain',
			4 => 'Elfe de la nuit',
			5 => 'Mort vivant',
			6 => 'Tauren',
			7 => 'Gnome',
			8 => 'Troll',
			9 => 'Gnome', 
			10 => 'Elfe de sang',
			11 => 'Draenei',
			);

		$race_ally = array (1, 3, 4, 7, 9, 11 );
		if (in_array ( $perso ['race'], $race_ally )) {
			$faction = '1'; // les ally c'est 1
		} else {
			$faction = '2';
		}
		
		if (mysql_num_rows($persos) == 1) {
			mysql_close();
			// connexion sur le serveur web pour recup les coordonées
			$connexion = mysql_connect($host_site, $user_site , $pass_site);
			mysql_select_db($site_database ,$connexion);
			mysql_query("SET NAMES 'utf8'");
			$sql = mysql_query("SELECT x,y,z,map,zone FROM destinations_deblocage where lvl_min <= ".$perso['level']." AND (faction = '".$faction."' OR faction = '0') AND (class = '".$perso['class']."' OR class='0') AND id=$destination_id");
			if(mysql_num_rows($sql)==1) {
				$destination = mysql_fetch_array($sql);
				
				// connexion au serveur wow pour mettre à jour les infos
				mysql_close();
				$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
				mysql_select_db($wow_characters ,$connexion);
				mysql_query("SET NAMES 'utf8'");
				// déplacement du perso
				$resReq = mysql_query ( "UPDATE characters SET position_x='" . $destination['x'] . "', position_y='" . $destination['y'] . "', position_z='" . $destination['z'] . "', map ='" . $destination['map'] . "',zone='" . $destination['zone'] . "' WHERE guid='" . $guid_perso . "' LIMIT 1" ) or die ( mysql_error () );
				if ($resReq) {
					echo "<div id='success_page'>";
					 echo "<p>Le débloquage s'est bien passé.</p>";
					 echo "</div>";
					echo '<div id="bottom_contenu"></div>';
				} else {
					echo '<div class="error_message">Erreur avec le serveur de base de données dans le déplacement de votre personnage.</div>';
				}
				
			} else {
				echo '<div class="error_message">Le personnage n\'a pas le niveau requis ou la faction pour se rendre sur cette destination.</div>';
			}
			 
		} else {
			// pas un perso du compte donc tentative de hack
			echo '<div class="error_message">Le personnage n\'appartient pas à votre compte.</div>';
		}
	}
	
	break;
}
?>