<?php 
$secure_lvl = 1;
$header_titre = "Etat des demandes de récupérations";
include "include/template/header_cadres.php"; 
?>
	<style type="text/css" title="currentStyle">
		@import "medias/css/demo_table.css";
	</style>
	<style media="screen" type="text/css">
	 @import "medias/css/custom-theme/jquery-ui-1.7.2.custom.css";
	</style>
	<script type="text/javascript" language="javascript" src="Scripts/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
	var oTable;

	$(document).ready(function() {
		oTable = $('#example').dataTable( {
			"bJQueryUI": true,
			"bPaginate": false,
			"bFilter": false,
			"bInfo": false,
			"bLengthChange": true,
			"bAutoWidth": false,
		});
	$('#guildes').dataTable( {
			"bJQueryUI": true,
			"bPaginate": false,
			"bFilter": false,
			"bInfo": false,
			"bLengthChange": true,
			"bAutoWidth": false,
		});
	} );
	</script>
	
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
<h2>etat de la demande de recuperation</h2>
<br/>
<br/>
<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$demandes_recup = mysql_query("SELECT demandes_recups.nom_perso, 
	demandes_recups.id, 
	motifs_recups.raison_fermeture, 
	demandes_recups.date_demande, 
	demandes_recups.classe, 
	demandes_recups.race, 
	demandes_recups.lvl, 
	demandes_recups.serveur_origine, 
	demandes_recups.id_perso_cible, 
	demandes_recups.etat_ouverture,
	demandes_recups.etat_recuperation
FROM motifs_recups INNER JOIN demandes_recups ON motifs_recups.id = demandes_recups.etat_ouverture WHERE id_compte = '".$compte_id."'");

$demandes_recup_guilde = mysql_query("SELECT demandes_recups.nom_perso, 
	demandes_recups.id, 
	motifs_recups.raison_fermeture, 
	demandes_recups.date_demande, 
	demandes_recups.classe, 
	demandes_recups.race, 
	demandes_recups.lvl, 
	demandes_recups.serveur_origine, 
	demandes_recups.id_perso_cible, 
	demandes_recups.etat_recuperation, 
	demandes_recups_guildes.nom AS nom_guilde, 
	demandes_recups_guildes.etat AS etat_guilde
FROM motifs_recups INNER JOIN demandes_recups ON motifs_recups.id = demandes_recups.etat_ouverture
	 INNER JOIN demandes_recups_guildes ON demandes_recups_guildes.id_demande = demandes_recups.id WHERE demandes_recups.id_compte = '".$compte_id."'");

if(mysql_num_rows($demandes_recup_guilde) <> 0) {
	while($demande_guilde_tmp = mysql_fetch_array($demandes_recup_guilde)) {
		$demande_guilde[$demande_guilde_tmp['id']] = $demande_guilde_tmp;
	}
}
$classe = array (
	1 => 'Guerrier',
	2 => 'Paladin',
	3 => 'Chasseur',
	4 => 'Voleur',
	5 => 'Prêtre',
	6 => 'Chevalier de la Mort',
	7 => 'Chaman',
	8 => 'Mage',
	9 => 'Démoniste', 
	11 => 'Druide',
);

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

if(mysql_num_rows($demandes_recup) == 0) {
	echo '<p>Vous n\'avez pas fait de demandes de récupérations. Ou alors sur l\'ancien site</p>';
} else {
	echo'
	<p>Liste des demandes :</p>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th>Nom Perso d\'origine</th>
			<th>Nom Perso</th>
			<th>Lvl</th>
			<th>Classe</th>
			<th>Race</th>
			<th>Date</th>
			<th>Etat</th>
			</tr>
	</thead>
		<tbody>';
	while($demande = mysql_fetch_array($demandes_recup)) {
		if ($demande['etat_ouverture']==1) {
			if(isset($demande_guilde[$demande['id']])) {
				if(!$demande_guilde[$demande['id']['etat']]==1) {
					$etat="En attente de validation, guilde non validée";
				}
			} else {
				$etat="En attente de validation";				
			}
		} else if($demande['etat_ouverture']==12) {
			$etat="En attente de validation, guilde validé";
			
		}else {
			$etat=$demande['raison_fermeture'];
		}
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$perso_cible_recup = mysql_query("SELECT name FROM characters.characters WHERE guid='".$demande['id_perso_cible']."'");
		mysql_close();
		$perso_cible_recup = mysql_fetch_array($perso_cible_recup);
		
		echo '<tr>';
		echo '<td>'.$demande['nom_perso'].'</td>';
		echo '<td>'.$perso_cible_recup[0].'</td>';
		echo '<td>'.$demande['lvl'].'</td>';
		echo '<td>'.$classe[$demande['classe']].'</td>';
		echo '<td>'.$race[$demande['race']].'</td>';
		echo '<td>'.$demande['date_demande'].'</td>';
		echo '<td>'.$etat.'</td>';
		echo'</tr>';
	}
	echo '	</tbody>
	</table>';
}

if(mysql_num_rows($demandes_recup_guilde) <> 0) {
	echo'
	<p>Liste des demandes de guildes:</p>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="guildes">
	<thead>
		<tr>
			<th>Nom Perso d\'origine</th>
			<th>Nom de guilde</th>
			<th>Nombre de demandes</th>
			<th>Etat</th>
			<th>Migration</th>
			</tr>
	</thead>
		<tbody>';
	foreach( $demande_guilde as $demande_guilde_detail ) {
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$somme_guilde_demandes = mysql_query("SELECT count(id_demande) AS total FROM demandes_recups_guildes  WHERE nom='".$demande_guilde_detail['nom_guilde']."'");
		$perso_cible_recup = mysql_fetch_array($somme_guilde_demandes);
		
		if($demande_guilde_detail['etat_guilde']==0) {
			$etat_guilde ="Non validé";
		} else {
			$etat_guilde ="Guilde validée";
		}
		echo '<tr>';
		echo '<td>'.$demande_guilde_detail['nom_perso'].'</td>';
		echo '<td>'.$demande_guilde_detail['nom_guilde'].'</td>';
		echo '<td>'.$perso_cible_recup[0].'/20</td>';

		echo '<td>'.$etat_guilde.'</td>';
		echo '<td><a href="recup_guilde_to_individuel.php?id='.$demande_guilde_detail['id'].'">Vers recuperation normale (contre 20 pp)</a></td>';
		echo'</tr>';
	}
	echo '	</tbody>
	</table>';
}

?>
<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>