<?php

$cout = 30;

$secure_lvl = 1;
$header_titre = "Migration de la demande de récupération de guilde en individuel";
include 'include/header.php';
$id_recup = mysql_escape_string ( $_GET ["id"]);

if($id_recup=='') {
		$message = "Vous devez suivre le lien";	
} else {
	if(20>$compte_pp) {
		$message = "Vous n'avez pas assez de Points Parrainage pour migré votre demande de guilde en normal. Il vous faut 20pp.";
	} else {
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");

		$suppression_demande_guilde = mysql_query("DELETE FROM demandes_recups_guildes WHERE id_demande='".$id_recup."'");
		$changement_etat_demande_guilde = mysql_query("UPDATE demandes_recups SET etat_ouverture=1 WHERE id='".$id_recup."'");
		$maj_pp = mysql_query("UPDATE accounts2 SET pp=pp-20 WHERE id =$compte_id");

		if($maj_pp&&$suppression_demande_guilde&&$changement_etat_demande_guilde) {
			$message = "Votre demande de récupération de guilde est bien passée en demande en demande de récupération individuele";
		} else {
			$message = "Suite à une erreur, nous n'avons pas enregistré votre demande";
		}
	}
}
?>
<div id="msgbox"></div>
<div id="content"><!-- Content starts here -->

<div id="leftPart"><!-- LeftPart starts here -->

<img src="images/banner01.jpg" alt="" />
<div class="contenu">
<?php
echo '<h2>Migration de la Récupération</h2>';
echo '<p>'.$message.'</p>';
?>

<div id="bottom_contenu"></div>
</div>
<?php include'include/footer.php'; ?>