<?php
include_once "lib/amazon_sdk/sdk.class.php";
//$cout = 30;
$cout=0;
$secure_lvl = 1;
$header_titre = "Demande de récupération";
require "include/template/header_cadres.php";
$pseudo = mysql_escape_string ( $_POST ["pseudo"]);
$id_perso_cible = mysql_escape_string ( $_POST ["guid_perso"]);
$serveur = mysql_escape_string ( $_POST ["serveur"]);
$level = mysql_escape_string ( $_POST ["level"]); 
$armurerie = mysql_escape_string ( $_POST ["armurerie"]); 
$metier1 = mysql_escape_string ( $_POST ["metier1"]);
$lvl_metier1 = mysql_escape_string ( $_POST ["lvl_metier1"]);
$lvl_mount = mysql_escape_string ( $_POST ["lvl_mount"]);

if($lvl_metier1=='') {
	$lvl_metier1= 0;
}
$metier2 = mysql_escape_string ( $_POST ["metier2"]);
$lvl_metier2 = mysql_escape_string ( $_POST ["lvl_metier2"]);
if($lvl_metier2=='') {
	$lvl_metier2= 0;
}
$metier_secondaire1 = mysql_escape_string ( $_POST ["metier_secondaire1"]);
$metier_secondaire2 = mysql_escape_string ( $_POST ["metier_secondaire2"]);
$metier_secondaire3 = mysql_escape_string ( $_POST ["metier_secondaire3"]);
$lvl_metier_secondaire1 = mysql_escape_string ( $_POST ["lvl_metier_secondaire1"]);
if($lvl_metier_secondaire1=='') {
	$lvl_metier_secondaire1= 0;
}
$lvl_metier_secondaire2 = mysql_escape_string ( $_POST ["lvl_metier_secondaire2"]);
if($lvl_metier_secondaire2=='') {
	$lvl_metier_secondaire2= 0;
}
$lvl_metier_secondaire3 = mysql_escape_string ( $_POST ["lvl_metier_secondaire3"]);
if($lvl_metier_secondaire3=='') {
	$lvl_metier_secondaire3= 0;
}

$message = '';
$nombre_fichiers = 0;
foreach ($_FILES["file"]["error"] as $key => $error) {
	$nombre_fichiers++;
}
if($nombre_fichiers==0){
	$message .="Vous devez mettre des images dans la demande";
}
$metiers = array("51304","51309","50305","51313","51300","50300","51306","51311","50310","51302","45363","0","51296","51294","45542");
if($pseudo==''||$id_perso_cible==""||$serveur==''||$level==''||$level>80||$level<60) {
	if (($level<=80&&$level>=60)||$level==''){
		$message .= "Vous devez remplir les champs obligatoire. Vous avez peut être mis trop d'images ou des images trop grosses. La limite étant de 8mo au total pour toutes les images.";	
	} else {
		$message .= "Vous devez avoir un niveau entre 60 et 80.";
	}
} else {
	if ($_POST ["guilde"]<>'') {
		$guilde_recup = trim(mysql_escape_string ( $_POST ["guilde"]));
		$cout = 10;
		$etat_demande = 2;
	} else {
		$guilde_recup = '';
		$etat_demande = 1;
	}
	if($message==""&&$lvl_metier_secondaire1<=450&&$lvl_metier_secondaire1>=0&&$lvl_metier_secondaire2<=450&&$lvl_metier_secondaire2>=0&&$lvl_metier_secondaire3<=450&&$lvl_metier_secondaire3>=0&&$lvl_metier1<=450&&$lvl_metier1>=0&&$lvl_metier2<=450&&$lvl_metier2>=0&&in_array($metier1,$metiers)&&in_array($metier2,$metiers)&&in_array($metier_secondaire1,$metiers)&&in_array($metier_secondaire2,$metiers)&&in_array($metier_secondaire3,$metiers)&&$lvl_mount<=300&&$lvl_mount>=0) {
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$persos = mysql_query("SELECT name,class,race FROM characters WHERE guid = '".$id_perso_cible."' AND account='".$compte_id."'");
		if (mysql_num_rows($persos) == 1) {
			$connexion = mysql_connect($host_site, $user_site , $pass_site);
			mysql_select_db($site_database ,$connexion);
			mysql_query("SET NAMES 'utf8'");
			$perso_recup_info = mysql_fetch_array($persos);
			$race = $perso_recup_info["race"];
			$classe =$perso_recup_info["class"];


			$autre_recup_mm_perso_cible = mysql_query("SELECT id FROM demandes_recups WHERE id_perso_cible='".$id_perso_cible."'AND etat_ouverture='0'");
			if (mysql_num_rows($autre_recup_mm_perso_cible) == 0) { 
				$ajout_demande = mysql_query("INSERT INTO demandes_recups SET id_compte = '".$compte_id."', nom_perso ='".$pseudo."',serveur_origine='".$serveur."',lvl='".$level."',race='".$race."',classe='".$classe."',
					metier1='".$metier1."', metier2='".$metier2."', lvl_metier1='".$lvl_metier1."',lvl_metier2='".$lvl_metier2."',metier_secondaire1='".$metier_secondaire1."',metier_secondaire2='".$metier_secondaire2."',
					metier_secondaire3='".$metier_secondaire3."',lvl_metier_secondaire1='".$lvl_metier_secondaire1."',lvl_metier_secondaire2='".$lvl_metier_secondaire2."',lvl_metier_secondaire3='".$lvl_metier_secondaire3."',
					armurerie = '".$armurerie."', date_demande = NOW(), lvl_mount = '".$lvl_mount."', id_perso_cible='".$id_perso_cible."',etat_ouverture='".$etat_demande."'");

				$id_demande = mysql_insert_id();
				if($guilde_recup<>'') {
					$ajout_demande_guilde = mysql_query("INSERT INTO demandes_recups_guildes SET id_demande='".$id_demande."',nom = '".$guilde_recup."',etat=0");
				} else {
					$ajout_demande_guilde =true;
				}
				$nouveau_pp = $compte_pp - $cout;
				//	$maj_pp = mysql_query("UPDATE accounts SET pp=$nouveau_pp WHERE id =$compte_id");
				$maj_pp=true;
				//creation des répertoires 
				$repertoire = 'demandes/recups/' . md5($id_demande)  . '/';
				//mkdir ( $repertoire, 0755 );
				$erreur_notification='';


				foreach ($_FILES["file"]["error"] as $key => $error) {

					//On formate le nom du fichier ici...
					$fichier_nom = strtr($_FILES["file"]['name'][$key], 
						'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
						'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
					$fichier_nom = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier_nom);
					//partie sur le cloud storage
					//move_uploaded_file($_FILES["file"]['tmp_name'][$key], "$repertoire/$fichier_nom");
					//partie en as3
					$s3 = new AmazonS3("AKIAJ5WT2F6RPZ5K3AXA", "aKNfOk5MgRq7AtxhIV10ZUtd1eZqBkAM7XMMmaFv");
					
					$s3->batch()->create_object("odyssee-recups",$repertoire.$fichier_nom,array(
						'fileUpload' =>  $_FILES["file"]['tmp_name'][$key],
						'acl' => AmazonS3::ACL_PUBLIC,
						'storage' => AmazonS3::STORAGE_REDUCED
					));
				}
				 $s3->batch()->send();
				if($ajout_demande && $maj_pp&&$ajout_demande_guilde) {
					$message .= "Votre demande de récupération s'est bien déroulée, Vous devez attendre qu'un maitre du jeu valide votre demande. Une fois validé vous allez pouvoir faire .recup à partir du perso sélectionné dans le formulaire précédent. Merci";
				} else {
					$message .= "Suite à une erreur, nous n'avons pas enregistré votre demande";
				}

			} else {
				$message .= "Vous avez déjà fait une récupération avec ce personnage";
			}
		}else {
			$message .= "Le Personnage ne vous appartient pas.";
		}
	} else {
		$message .= "Les niveaux de métiers doivent etre entre 0 et 450.";
	}
}
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
			<?php
		echo '<h2>Récupération</h2>';
		echo '<p>'.$message.'</p>';
		?>

		<br/> <br/> <br/> 						</div>
	</div>
</div>
<div class="encadrepage-bas">
</div> 



<?php require "include/template/footer_cadres.php"?>