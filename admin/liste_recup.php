<?php
$secure_lvl=2;
include '../secure.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" title="currentStyle">
	@import "css/demo_page.css";
	@import "css/demo_table.css";
</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#example').dataTable( {
				"bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bInfo": false,
				"bAutoWidth": false } );
	} );
</script>
<title>Liste des recups</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p>Liste des recups (nouveau systéme)</p>
<a href="index.php"> Retour a l'accueil </a>
<p>
    <form method="post" action="#">
    	Recherche du nom de compte ou de perso dans toutes les demandes:  
        <input type="text" name="termes" value="" size="15" />
        <input type="submit" name="Recherche" />       	
    </form>
</p>
	<?php
	include 'config/config.php';

	$recherche = "";

	if(!isset($_GET['demandes']) && !isset($_POST['termes'])) {
		
		$sql = "SELECT motifs_recups.raison_fermeture, 
			accounts2.username AS nom_compte, 
			accounts2.email,
			demandes_recups.id, 
			demandes_recups.etat_ouverture, 
			demandes_recups.nom_perso, 
			demandes_recups.serveur_origine, 
			demandes_recups.lvl, 
			demandes_recups.etat_ouverture, 
			demandes_recups.date_demande
			FROM demandes_recups INNER JOIN accounts2 ON demandes_recups.id_compte = accounts2.id
			INNER JOIN motifs_recups ON demandes_recups.etat_ouverture = motifs_recups.id 
			WHERE demandes_recups.etat_ouverture=1 OR demandes_recups.etat_ouverture=12";

		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$resultats = mysql_query($sql);
		echo '<p> Nombre de demandes : '.mysql_num_rows($resultats).'</p>
		<p> Pour voir toutes les demandes, suivez ce <a href="liste_recup.php?demandes=toutes">lien</a></p>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
	
      
		echo '
		<thead>
		<tr>
			<th>Nom perso</th>
			<th>Serveur</th>
			<th>Level</th>
			<th>Compte demande</th>
			<th>Date demande</th>
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
			echo'</tr>';
		}
	} else {
		if(isset($_POST['termes']))
			$recherche="WHERE (accounts2.username LIKE '%".$_POST['termes']."%' OR demandes_recups.nom_perso LIKE '%".$_POST['termes']."%')";		
			
		$sql = "SELECT motifs_recups.raison_fermeture, 
			accounts2.username AS nom_compte, 
			demandes_recups.id, 
			accounts2.email,
			demandes_recups.etat_ouverture, 
			demandes_recups.nom_perso, 
			demandes_recups.serveur_origine, 
			demandes_recups.lvl, 
			demandes_recups.etat_ouverture, 
			demandes_recups.date_demande
			FROM demandes_recups INNER JOIN accounts2 ON demandes_recups.id_compte = accounts2.id
			INNER JOIN motifs_recups ON demandes_recups.etat_ouverture = motifs_recups.id ".$recherche;
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$resultats = mysql_query($sql);
		echo '<p> Nombre de demandes : '.mysql_num_rows($resultats).'</p>
		<p> Pour voir uniquement les demandes ouvertes, suivez ce <a href="liste_recup.php">lien</a></p>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
		echo '
		<thead>
		<tr>
			<th>Nom perso</th>
			<th>Serveur</th>
			<th>Level</th>
			<th>Compte demande</th>
			<th>Email</th>
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
			echo '<td>'.$demande['email'].'</td>';
			echo '<td>'.$demande['date_demande'].'</td>';
			if($demande['etat_ouverture']==1){ echo '<td>Ouverte</td>'; } else { echo '<td style="color:red;">Fermée, '.$demande['raison_fermeture'].'</td>';}
			echo'</tr>';
		}
		
	}
		
	?>
	</tbody>
</table>
</div>
</body>
</html>