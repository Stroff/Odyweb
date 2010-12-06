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
<title>Liste des achats points</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p>Liste des achats de points</p>
	<?php
	include 'config/config.php';
		$sql = "SELECT accounts2.username AS nom_compte_mj, 
			logs_mj_recups.id AS id_demande_recup, 
			logs_mj_recups.date AS date, 
			motifs_recups.raison_fermeture,
			motifs_recups.raison_fermeture,	
		FROM accounts2 INNER JOIN logs_mj_recups ON accounts2.id = logs_mj_recups.id_compte_mj
			 INNER JOIN motifs_recups ON motifs_recups.id = logs_mj_recups.id_nouveau_etat_demande AND motifs_recups.id = logs_mj_recups.id_ancien_etat_demande";
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$resultats = mysql_query($sql);
		echo '
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
		echo '
		<thead>
		<tr>
			<th>Nom du mj</th>
			<th>Id demande</th>
			<th>Ancien état</th>
			<th>Nouveau état</th>
			<th>Date</th>
		</tr>
		</thead>
		<tbody>';
		while($log = mysql_fetch_array($resultats)) {
			echo '<tr class="gradeA">';
			
			echo '<td>'.$log['nom_compte_mj'].'</td>';
			echo '<td>'.$log['id_demande_recup'].'</td>';
			echo '<td><a href="detail_recup.php?id='.$log['id_demande_recup'].'">'.$log['id_demande_recup'].'</a></td>';
			echo '<td>'.$log['nom_ancien_etat_demande'].'</td>';
			echo '<td>'.$log['nom_nouveau_etat_demande'].'</td>';
			echo '<td>'.$log['date'].'</td>';
			echo'</tr>';
		}

		
	?>
	</tbody>
</table>
</div>
</body>
</html>