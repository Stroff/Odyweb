<?php
$secure_lvl=2;
include '../secure.php';
require "../lib/phpmailer/class.phpmailer.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" title="currentStyle">
	@import "css/demo_page.css";
	@import "css/demo_table.css";
	@import "css/style.css";
</style>

<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#mmperso').dataTable( {
				"bPaginate": false,
				"bLengthChange": false,
				"bFilter": false,
				"bInfo": false,
				"bAutoWidth": false } );

			$('#mmpersoetserveur').dataTable( {
					"bPaginate": false,
					"bLengthChange": false,
					"bFilter": false,
					"bInfo": false,
					"bAutoWidth": false } );				
				
	} );
</script>
<title>Détails de la recupération</title>
</head>
<body>
<div id="dt_example">
<?php include "navbar.php"; ?>
<p><a href="liste_recup.php">Liste des recupérations</a></p>
	<?php
	include 'config/config.php';
	
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");	
	$id_recup = mysql_escape_string($_GET['id']);
	
	if (isset($_POST['raison_fermeture'])) {
		$nom_perso = mysql_escape_string($_POST['nom_perso']);
	    $serveur_origine = mysql_escape_string($_POST['serveur_origine']);
	    $lvl = mysql_escape_string($_POST['lvl']);
	    $race = mysql_escape_string($_POST['race']);
	    $classe = mysql_escape_string($_POST['classe']);
	    $raison_fermeture = mysql_escape_string($_POST['raison_fermeture']);
		$id_compte = mysql_escape_string($_POST['id_compte']);
		
		$metier1 = mysql_escape_string ( $_POST ["metier1"]);
		$lvl_metier1 = mysql_escape_string ( $_POST ["lvl_metier1"]);
		$metier2 = mysql_escape_string ( $_POST ["metier2"]);
		$lvl_metier2 = mysql_escape_string ( $_POST ["lvl_metier2"]);
		$metier_secondaire1 = mysql_escape_string ( $_POST ["metier_secondaire1"]);
		$metier_secondaire2 = mysql_escape_string ( $_POST ["metier_secondaire2"]);
		$metier_secondaire3 = mysql_escape_string ( $_POST ["metier_secondaire3"]);
		$lvl_metier_secondaire1 = mysql_escape_string ( $_POST ["lvl_metier_secondaire1"]);
		$lvl_metier_secondaire2 = mysql_escape_string ( $_POST ["lvl_metier_secondaire2"]);
		$lvl_metier_secondaire3 = mysql_escape_string ( $_POST ["lvl_metier_secondaire3"]);
		$lvl_mount = mysql_escape_string ( $_POST ["lvl_mount"]);
		$montant_pc = mysql_escape_string ( $_POST ["montant_pc"]);
		
		$id_perso_cible = mysql_escape_string ( $_POST ["id_perso_cible"]);
		
		$old_raison_fermeture  = mysql_escape_string ( $_POST ["old_raison_fermeture"]);
		$message_mail = mysql_escape_string ( $_POST ["message_mail"]);
		
		$id_jeton = mysql_escape_string($_POST['jetons']);
		if ($id_jeton ==0 &&$raison_fermeture==10) {
			echo '<p style="color:red;">Vous devez mettre des jetons si vous validez la récupération.</p>';
		} else {			
			if($old_raison_fermeture!=$raison_fermeture){
				
				$nom_compte_mj = $_SESSION['login'];
				$pseudo_mj = mysql_query("SELECT pseudo_forum FROM staff_usernames WHERE nom_compte='".$nom_compte_mj."'");
				$pseudo_mj = mysql_fetch_array($pseudo_mj);
				
				mysql_query("INSERT INTO logs_mj_recups SET id_compte_mj='".$_SESSION['id']."',date=NOW(),id_demande_recup='".$id_recup."',id_ancien_etat_demande='".$old_raison_fermeture."',id_nouveau_etat_demande='".$raison_fermeture."'");
				
				if ($pseudo_mj[0] == '') {
					$email_mj = 'root@odyssee-serveur.com';
				}else {
					$email_mj = $pseudo_mj[0].'@odyssee-serveur.com';
				}
				
				//recup infos mail
				$email = mysql_query("SELECT email FROM accounts WHERE id='".$id_compte."'");
				$email = mysql_fetch_array($email);
				// envoie du mail
				$subject = "Récupation sur le serveur Odyssée Serveur";
				// message
				$message = '<h2>Email de confirmation</h2><p>Bonjour</p><p>La demande de récupération à changé d\'état. Vous pouvez retrouvé le statut sur ce <a href="'.$url_site.'/etat_recup.php">lien</a>.</p>';
				if($message_mail<>'') {
					$message .='Le maitre du jeu a ajouté un message à votre demande : '.$message_mail.' <p>Merci.</p>';
				} else {
					$message .= ' <p>Merci.</p>';
				}
				$mail = new PHPmailer();
				$mail->IsSMTP();
				$mail->Host='127.0.0.1';
				$mail->CharSet	=	"UTF-8";
				$mail->IsHTML(true);
				$mail->From=$email_mj;
				$mail->AddAddress($email['email']);
				$mail->AddReplyTo($email_mj);	
				$mail->Subject=$subject;
				$mail->Body=$message;				
				$mail->FromName="Odyssée Serveur";
				$mail->Send();
			}
		
			$sql = "UPDATE demandes_recups SET lvl = '".$lvl."', nom_perso = '".$nom_perso."',classe = '".$classe."',race = '".$race."',serveur_origine = '".$serveur_origine."',etat_ouverture='".$raison_fermeture."', 
				metier1='".$metier1."', metier2='".$metier2."', lvl_metier1='".$lvl_metier1."',lvl_metier2='".$lvl_metier2."',metier_secondaire1='".$metier_secondaire1."',metier_secondaire2='".$metier_secondaire2."',
				metier_secondaire3='".$metier_secondaire3."',lvl_metier_secondaire1='".$lvl_metier_secondaire1."',lvl_metier_secondaire2='".$lvl_metier_secondaire2."',lvl_metier_secondaire3='".$lvl_metier_secondaire3."',
			jeton_id = '".$id_jeton."', montant_pc='".$montant_pc."',lvl_mount='".$lvl_mount."',id_perso_cible='".$id_perso_cible."' WHERE id='".$id_recup."' ";
			$connexion = mysql_connect($host_site, $user_site , $pass_site);
			mysql_select_db($site_database ,$connexion);
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sql);
			if($sql) {
				echo '<p style="color:green;">Modification recup Ok</p>';
				if (isset($_POST['bloque_compte'])) {
					mysql_query("INSERT INTO accounts_blocage_recup SET id_compte = '".$id_compte."', id_recup='".$id_recup."', fin_blocage = DATE_ADD(NOW(),INTERVAL 7 DAY)");
				}
			} else {
				echo '<p style="color:red;">Erreur dans la modification de la recup</p>';
			}
		}

	}
	
	$resultat = mysql_query("SELECT * FROM demandes_recups WHERE id = '".$id_recup."'");
	$recup = mysql_fetch_array($resultat);
	
	$metiers['51304'] = 'Alchimiste';
	$metiers['51309'] = 'Couture';
	$metiers['50305'] = 'Dépeceur';
	$metiers['51313'] = 'Enchanteur';
	$metiers['51300'] = 'Forge';
	$metiers['50300'] = 'Herboriste';
	$metiers['51306'] = 'Ingénieur';
	$metiers['51311'] = 'Joaillier';
	$metiers['50310'] = 'Mineur';
	$metiers['51313'] = 'Enchanteur';
	$metiers['51302'] = 'Travail du cuir';
	$metiers['45363'] = 'Calligraphie';
	$metiers_secondaire['51296'] = 'Cuisine';
	$metiers_secondaire['51294'] = 'Pêche';
	$metiers_secondaire['45542'] = 'Secourisme';
	
	$jeton["250000"] = "Jeton T2";
	$jeton["250005"] = "Jeton T3,5";
	$jeton["250001"] = "Jeton T4";
	$jeton["250002"] = "Jeton T5";
	$jeton["250003"] = "Jeton S1";
	$jeton["250004"] = "Jeton S2";
	$jeton["250007"] = "Jeton Stuff 78";
//	$jeton["250008"] = "Jeton Stuff Haineux";
	
	
	if (mysql_num_rows($resultat)==0) {
		echo '<p style="color:red;">Id demande de récupération invalide, la demande n\'existe pas</p>';
		exit();
	}
	
	if($recup['etat_ouverture']==2) {
		echo '<p style="color:red;">Récupération de type guilde, la guilde n\'est pas validé</p>';
	} else if($recup['etat_ouverture']==12){
		echo '<p style="color:green;">Récupération de type guilde, la guilde est pas validé</p>';
	}
	?>
<form id="form" name="form" method="post" action="detail_recup.php?id=<?php echo $id_recup; ?>">

	<br />
	<label> Id demande : </label><?php echo $id_recup ?> <br />

	<br />
	<label> Date demande : </label><?php echo $recup['date_demande'] ?> <br />


	<br />
	<label> Nom du perso origine: </label>
	<input name="nom_perso" type="text" id="nom_perso" size="20" value="<?php echo $recup['nom_perso']; ?>"/> <br />

	<br />
	<label> Nom du perso cible: </label>
	<select name="id_perso_cible"> 
	<?php
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$persos = mysql_query("SELECT name,guid FROM characters WHERE account = '".$recup['id_compte']."'");
	while ($perso = mysql_fetch_array($persos)) {
		if($perso['guid']==$recup['id_perso_cible']) {
			echo '<option value="'.$perso['guid'].'" selected>'.$perso['name'].'</option>';
		}else {
			echo '<option value="'.$perso['guid'].'">'.$perso['name'].'</option>';
		}
	}
	?>
	</select><br />


	<br />
	<label> Serveur origine : </label>
	<input name="serveur_origine" type="text" id="serveur_origine" size="20" value="<?php echo $recup['serveur_origine']; ?>"/> <br />

	<br />
	<label> Niveau : </label>
	<input name="lvl" type="text" id="lvl" size="20" value="<?php echo $recup['lvl']; ?>"/> <br />

	<br />
	<label> Race :</label>
	<SELECT name="race">
		<?php 
		if($recup['race']==1) {
			echo '<OPTION VALUE="1" selected=selected>Humain</OPTION>';
		} else {
			echo '<OPTION VALUE="1">Humain</OPTION>';
		}
		if($recup['race']==2) {
			echo '<OPTION VALUE="2" selected=selected>Orc</OPTION>';
		} else {
			echo '<OPTION VALUE="2">Orc</OPTION>';
		}
		if($recup['race']==3) {
			echo '<OPTION VALUE="3" selected=selected>Nain</OPTION>';
		} else {
			echo '<OPTION VALUE="3">Nain</OPTION>';
		}
		if($recup['race']==4) {
			echo '<OPTION VALUE="4" selected=selected>Elfe de la Nuit</OPTION>';
		} else {
			echo '<OPTION VALUE="4">Elfe de la Nuit</OPTION>';
		}
		if($recup['race']==5) {
			echo '<OPTION VALUE="5" selected=selected>Mort Vivant</OPTION>';
		} else {
			echo '<OPTION VALUE="5">Mort Vivant</OPTION>';
		}
		if($recup['race']==6) {
			echo '<OPTION VALUE="6" selected=selected>Tauren</OPTION>';
		} else {
			echo '<OPTION VALUE="6">Tauren</OPTION>';
		}
		if($recup['race']==7) {
			echo '<OPTION VALUE="7" selected=selected>Gnome</OPTION>';
		} else {
			echo '<OPTION VALUE="7">Gnome</OPTION>';
		}
		if($recup['race']==8) {
			echo '<OPTION VALUE="8" selected=selected>Troll</OPTION>';
		} else {
			echo '<OPTION VALUE="8">Troll</OPTION>';
		}
		if($recup['race']==10) {
			echo '<OPTION VALUE="10" selected=selected>Elfe de Sang</OPTION>';
		} else {
			echo '<OPTION VALUE="10">Elfe de Sang</OPTION>';
		}
		if($recup['race']==11) {
			echo '<OPTION VALUE="11" selected=selected>Draeneï</OPTION>';
		} else {
			echo '<OPTION VALUE="11">Draeneï</OPTION>';
		}
		?>
	</select><br />

	<br />
	<label> Classe :</label>
		<SELECT name="classe">
		<?php
		if($recup['classe']==1) {
			echo '<OPTION VALUE="1" selected=selected>Guerrier</OPTION>';
		} else {
			echo '<OPTION VALUE="1">Guerrier</OPTION>';
		}
		if($recup['classe']==2) {
			echo '<OPTION VALUE="2" selected=selected>Paladin</OPTION>';
		} else {
			echo '<OPTION VALUE="2">Paladin</OPTION>';
		}
		if($recup['classe']==3) {
			echo '<OPTION VALUE="3" selected=selected>Chasseur</OPTION>';
		} else {
			echo '<OPTION VALUE="3">Chasseur</OPTION>';
		}
		if($recup['classe']==4) {
			echo '<OPTION VALUE="4" selected=selected>Voleur</OPTION>';
		} else {
			echo '<OPTION VALUE="4">Voleur</OPTION>';
		}
		if($recup['classe']==5) {
			echo '<OPTION VALUE="5" selected=selected>Prêtre</OPTION>';
		} else {
			echo '<OPTION VALUE="5">Prêtre</OPTION>';
		}
		if($recup['classe']==6) {
			echo '<OPTION VALUE="6" selected=selected>Chevalier de la Mort</OPTION>';
		} else {
			echo '<OPTION VALUE="6">Chevalier de la Mort</OPTION>';
		}
		if($recup['classe']==7) {
			echo '<OPTION VALUE="7" selected=selected>Chaman</OPTION>';
		} else {
			echo '<OPTION VALUE="7">Chaman</OPTION>';
		}
		if($recup['classe']==8) {
			echo '<OPTION VALUE="8" selected=selected>Mage</OPTION>';
		} else {
			echo '<OPTION VALUE="8">Mage</OPTION>';
		}
		if($recup['classe']==9) {
			echo '<OPTION VALUE="9" selected=selected>Démoniste</OPTION>';
		} else {
			echo '<OPTION VALUE="9">Démoniste</OPTION>';
		}
		if($recup['classe']==11) {
			echo '<OPTION VALUE="11" selected=selected>Druide</OPTION>';
		} else {
			echo '<OPTION VALUE="11">Druide</OPTION>';
		}
		?>
</SELECT><br />


<?php


	echo '<br />
	<label>Metier 1 et lvl : </label><SELECT name="metier1">';
	if ($recup['metier1']==0) {
		echo '<OPTION VALUE="0" selected=selected>Aucun</OPTION>';
	}else {
		echo '<OPTION VALUE="0">Aucun</OPTION>';
	}
	foreach ($metiers as $key => $value) {
		if($recup['metier1']==$key) {
			echo '<OPTION VALUE="'.$key.'" selected=selected>'.$value.'</OPTION>';
		}else {
			echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
		}
	}
	echo '</select> (<input type="text" name="lvl_metier1" size=4 value="'.$recup['lvl_metier1'].'">/450)<br />';
	
	echo '<br />
	<label>Metier 2 et lvl : </label><SELECT name="metier2">';
	if ($recup['metier2']==0) {
		echo '<OPTION VALUE="0" selected=selected>Aucun</OPTION>';
	}else {
		echo '<OPTION VALUE="0">Aucun</OPTION>';
	}
	foreach ($metiers as $key => $value) {
		if($recup['metier2']==$key) {
			echo '<OPTION VALUE="'.$key.'" selected=selected>'.$value.'</OPTION>';
		}else {
			echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
		}
	}
	echo '</select> (<input type="text" name="lvl_metier2" size=4 value="'.$recup['lvl_metier2'].'">/450)<br />';
	
	echo '<br />
	<label>Metier secondaire 1 et lvl : </label><SELECT name="metier_secondaire1">';
	if ($recup['metier_secondaire1']==0) {
		echo '<OPTION VALUE="0" selected=selected>Aucun</OPTION>';
	}else {
		echo '<OPTION VALUE="0">Aucun</OPTION>';
	}
	foreach ($metiers_secondaire as $key => $value) {
		if($recup['metier_secondaire1']==$key) {
			echo '<OPTION VALUE="'.$key.'" selected=selected>'.$value.'</OPTION>';
		}else {
			echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
		}
	}
	echo '</select> (<input type="text" name ="lvl_metier_secondaire1"size=4 value="'.$recup['lvl_metier_secondaire1'].'">/450)<br />';
	
	echo '<br />
	<label>Metier secondaire 2 et lvl : </label><SELECT name="metier_secondaire2">';
	if ($recup['metier_secondaire2']==0) {
		echo '<OPTION VALUE="0" selected=selected>Aucun</OPTION>';
	}else {
		echo '<OPTION VALUE="0">Aucun</OPTION>';
	}
	foreach ($metiers_secondaire as $key => $value) {
		if($recup['metier_secondaire2']==$key) {
			echo '<OPTION VALUE="'.$key.'" selected=selected>'.$value.'</OPTION>';
		}else {
			echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
		}
	}
	echo '</select> (<input type="text" name = "lvl_metier_secondaire2" size=4 value="'.$recup['lvl_metier_secondaire2'].'">/450)<br />';
	
	echo '<br />

	<label>Metier secondaire 3 et lvl : </label><SELECT name="metier_secondaire3">';
	if ($recup['metier_secondaire3']==0) {
		echo '<OPTION VALUE="0" selected=selected>Aucun</OPTION>';
	}else {
		echo '<OPTION VALUE="0">Aucun</OPTION>';
	}
	foreach ($metiers_secondaire as $key => $value) {
		if($recup['metier_secondaire3']==$key) {
			echo '<OPTION VALUE="'.$key.'" selected=selected>'.$value.'</OPTION>';
		}else {
			echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
		}
	}
	echo '</select> (<input type="text" name="lvl_metier_secondaire3"size=4 value="'.$recup['lvl_metier_secondaire3'].'">/450)<br />';
	
		echo '<br />
	<label>lvl mount: </label><SELECT name="lvl_mount">';
	if ($recup['lvl_mount']==0) {
		echo '<OPTION VALUE="0" selected=selected>0</OPTION>';
	}else {
		echo '<OPTION VALUE="0">0</OPTION>';
	}
	if ($recup['lvl_mount']==150) {
		echo '<OPTION VALUE="150" selected=selected>150</OPTION>';
	}else {
		echo '<OPTION VALUE="150">150</OPTION>';
	}
		if ($recup['lvl_mount']==225) {
		echo '<OPTION VALUE="225" selected=selected>225</OPTION>';
	}else {
		echo '<OPTION VALUE="225">225</OPTION>';
	}
		if ($recup['lvl_mount']==300) {
		echo '<OPTION VALUE="300" selected=selected>300</OPTION>';
	}else {
		echo '<OPTION VALUE="300">300</OPTION>';
	}
	echo '</select> /300<br />';
		
	
	if ($recup['armurerie']<>'') {
	echo '<br />
	<label>Armurerie : </label><a href="'.$recup['armurerie'].'" target="_blank"> '.$recup['armurerie'].' </a><br />';
}

echo '<br />
<label>Images : </label>';
$images_uploader = scandir('/var/www/odyssee/demandes/recups/'.md5($recup['id']).'');
$i = 1;
foreach($images_uploader  as $image_name ) {
	if ($image_name=='.'|| $image_name=='..' || $image_name == '.DS_Store' ) {
		continue;
	}	
	echo '<a target="_blank" href="'.$url_site.'/demandes/recups/'.md5($recup['id']).'/'.$image_name.'"><img src="'.$url_site.'/demandes/recups/'.md5($recup['id']).'/'.$image_name.'?width=100"></a>';
$i++;
}
echo '<br />';
?>

    <br />
	<label>Raison fermeture : </label>
      <select name="raison_fermeture" id="raison_fermeture">
		<?php
			if ($recup['etat_ouverture']==1) {
				echo '<option value="1" selected=selected>Ouverte</option>';
			} else {
				echo '<option value="1">Ouverte</option>';
			}
			$sql = "SELECT id,raison_fermeture FROM motifs_recups WHERE id>2";
			$connexion = mysql_connect($host_site, $user_site , $pass_site);
			mysql_select_db($site_database ,$connexion);
			mysql_query("SET NAMES 'utf8'");
			$resultats = mysql_query($sql);
			while($raisons = mysql_fetch_array($resultats)) {
				if ($recup['etat_ouverture']==$raisons['id']) {
					echo '<option value="'.$raisons['id'].'" selected=selected>Fermée, '.$raisons['raison_fermeture'].'</option>';
				} else {
					echo '<option value="'.$raisons['id'].'">Fermée, '.$raisons['raison_fermeture'].'</option>';
				}
			}
		?>
      </select>
    <br />

	
    <br />
	<label>Message supplémentaire pour le mail (si changement d'état d'ouverture) : </label>
	<textarea cols="20" rows="4" name="message_mail"></textarea>
	<input type="hidden" name="old_raison_fermeture" value="<?php echo $recup['etat_ouverture'];?>">
    <br />
	
	<br />
	<label>Jetons de récupération : </label>
	<select name="jetons">
		<?php
		if ($recup['jeton_id']==0) {
			echo '<OPTION VALUE="0" selected=selected>Aucun</OPTION>';
		}else {
			echo '<OPTION VALUE="0">Aucun</OPTION>';
		}
		foreach ($jeton as $key => $value) {
			if($recup['jeton_id']==$key) {
				echo '<OPTION VALUE="'.$key.'" selected=selected>'.$value.'</OPTION>';
			}else {
				echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
			}
		}
		?>
	</select>
	<br />


	<br />
	<label>Po de la recup : </label>
	<select name="montant_pc">
		<?php
		if ($recup['montant_pc']==20000000) {
			echo '<OPTION VALUE="20000000" selected=selected>2000 Po</OPTION>';
			echo '<OPTION VALUE="40000000">4000 Po</OPTION>';	
			
		}else if($recup['montant_pc']==40000000) {
			echo '<OPTION VALUE="20000000">2000 Po</OPTION>';
			echo '<OPTION VALUE="40000000" selected=selected>4000 Po</OPTION>';	
		}
		else {
			echo '<OPTION VALUE="20000000" selected=selected>2000 Po</OPTION>';
			echo '<OPTION VALUE="40000000">4000 Po</OPTION>';			
		}

		?>
	</select>
	<br />

    <br />
	<label>Bloqué les demandes de recups 7jrs : </label><input type="checkbox" name="bloque_compte" value="oui"><input type="hidden" name="id_compte" value="<?php echo $recup['id_compte'] ?>"><br />
	
<br />
<input name="new_valid" id="new_valid" type="submit" value="Valider" /><br />
</form>
<?php
// recherche de la derniére modificanntion et affichage uniquement aux resp et plus
if($_SESSION['gm']>4){
	$req_derniere_modif = mysql_query("SELECT accounts.username, logs_mj_recups.date
	FROM logs_mj_recups INNER JOIN demandes_recups ON logs_mj_recups.id_demande_recup = demandes_recups.id
		 INNER JOIN accounts ON logs_mj_recups.id_compte_mj = accounts.id WHERE demandes_recups.id = '".$id_recup."' ORDER BY logs_mj_recups.id DESC LIMIT 1");
	if(mysql_num_rows($req_derniere_modif)>0){
		$dernere_modif = mysql_fetch_array($req_derniere_modif);
		echo "<p>Dernière modification par ".$dernere_modif["username"]." le ".$dernere_modif["date"]."";
	}
}
?>
<p>Liste avec le même nom de perso:</p>


<?php
$sql = "SELECT motifs_recups.raison_fermeture, 
	accounts.username AS nom_compte, 
	demandes_recups.id, 
	demandes_recups.nom_perso, 
	demandes_recups.serveur_origine, 
	demandes_recups.lvl, 
	demandes_recups.etat_ouverture, 
	demandes_recups.date_demande
FROM demandes_recups INNER JOIN accounts ON demandes_recups.id_compte = accounts.id
	 INNER JOIN motifs_recups ON demandes_recups.etat_ouverture = motifs_recups.id WHERE demandes_recups.nom_perso = '".$recup['nom_perso']."' AND demandes_recups.id != '".$id_recup."'";
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$resultats = mysql_query($sql);
echo '
<table cellpadding="0" cellspacing="0" border="0" class="display" id="mmperso">
<thead>
<tr>
	<th>Nom perso</th>
	<th>Serveur</th>
	<th>Level</th>
	<th>Compte demande</th>
	<th>Date demande</th>
	<th>Etat demande</th>
</tr>
</thead>
<tbody>';
while($demande = mysql_fetch_array($resultats)) {
	echo '<tr class="gradeA">';
	echo '<td><a href="detail_recup.php?id='.$demande['id'].'">'.$demande['nom_perso'].'</a></td>';
	echo '<td>'.$demande['serveur_origine'].'</td>';
	echo '<td>'.$demande['lvl'].'</td>';
	echo '<td>'.$demande['nom_compte'].'</td>';
	echo '<td>'.$demande['date_demande'].'</td>';
	if($demande['etat_ouverture']==1){ echo '<td>Ouverte</td>'; } else { echo '<td style="color:red;">Fermée, '.$demande['raison_fermeture'].'</td>';}
	echo'</tr>';
}

?>
</table>
<p>Liste avec le même nom de perso et serveur:</p>
<?php
$sql = "SELECT motifs_recups.raison_fermeture, 
	accounts.username AS nom_compte, 
	demandes_recups.id, 
	demandes_recups.etat_ouverture, 
	demandes_recups.nom_perso, 
	demandes_recups.serveur_origine, 
	demandes_recups.lvl, 
	demandes_recups.etat_ouverture, 
	demandes_recups.date_demande
FROM demandes_recups INNER JOIN accounts ON demandes_recups.id_compte = accounts.id
	 INNER JOIN motifs_recups ON demandes_recups.etat_ouverture = motifs_recups.id WHERE demandes_recups.nom_perso = '".$recup['nom_perso']."'AND demandes_recups.serveur_origine = '".$recup['serveur_origine']."' AND demandes_recups.id != '".$id_recup."'";
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$resultats = mysql_query($sql);
echo '
<table cellpadding="0" cellspacing="0" border="0" class="display" id="mmpersoetserveur">
<thead>
<tr>
	<th>Nom perso</th>
	<th>Serveur</th>
	<th>Level</th>
	<th>Compte demande</th>
	<th>Date demande</th>
	<th>Etat demande</th>
</tr>
</thead>
<tbody>';
while($demande = mysql_fetch_array($resultats)) {
	echo '<tr class="gradeA">';
	echo '<td><a href="detail_recup.php?id='.$demande['id'].'">'.$demande['nom_perso'].'</a></td>';
	echo '<td>'.$demande['serveur_origine'].'</td>';
	echo '<td>'.$demande['lvl'].'</td>';
	echo '<td>'.$demande['nom_compte'].'</td>';
	echo '<td>'.$demande['date_demande'].'</td>';
	if($demande['etat_ouverture']==1){ echo '<td>Ouverte</td>'; } else { echo '<td style="color:red;">Fermée, '.$demande['raison_fermeture'].'</td>';}
	echo'</tr>';
}

?>
</table>
</div>

</body>
</html>
