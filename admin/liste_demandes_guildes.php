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
<p>Liste des demandes de récup de guilde</p>
	<?php
	include 'config/config.php';
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	if (isset($_GET['id_demande'])) {
		$sql = mysql_query("SELECT nom FROM demandes_recups_guildes WHERE id_demande = '".$_GET['id_demande']."'");
		$nom_guilde = mysql_fetch_array($sql);

		$sql_demandes = mysql_query("SELECT id_demande FROM demandes_recups_guildes WHERE nom = '".$nom_guilde['nom']."'");
		while($detail_demande_guilde_to_individuel =  mysql_fetch_array($sql_demandes) ) {
			$sql_modif_demande = mysql_query("UPDATE demandes_recups SET etat_ouverture = 12 WHERE id = '".$detail_demande_guilde_to_individuel['id_demande']."'");
		}
		
		$sql = mysql_query("DELETE FROM demandes_recups_guildes WHERE nom = '".$nom_guilde['nom']."'");
		if ($sql){
			echo '<p style="color:green;">Vous avez bien validé la guilde. Les demandes des membres de la guilde sont désormais considéré comme individuel par le systéme</p>';
		}
	}
		$resultats_guildes = mysql_query("SELECT * FROM demandes_recups_guildes");
		if(mysql_num_rows($resultats_guildes) <> 0) {
			while($demande_guilde_tmp = mysql_fetch_array($resultats_guildes)) {
				if(!isset($demande_guilde[$demande_guilde_tmp['nom']])){
					$demande_guilde[$demande_guilde_tmp['nom']] = $demande_guilde_tmp;
				}
			}
		}
		echo '
		<p>Vous devez validez une demande de guilde quand le GM vous a contacté et confirme que tous le monde à bien fait la demande. Une fois validée une autre demande en guilde ne serra pas possible</p>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
		echo '
		<thead>
		<tr>
			<th>Nom de guilde</th>
			<th>Nombre de demandes</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>';
		if (!empty($demande_guilde)) {
			foreach( $demande_guilde as $demande_guilde_detail ) {
				$total_demande_guilde = mysql_query("SELECT count(id_demande) FROM demandes_recups_guildes  WHERE nom='".$demande_guilde_detail['nom']."'");
				$total_demande_guilde = mysql_fetch_array($total_demande_guilde);
				echo '<tr class="gradeA">';
				echo '<td>'.$demande_guilde_detail['nom'].'</td>';
				echo '<td>'.$total_demande_guilde[0].'/20</td>';
				echo '<td><a href="liste_demandes_guildes.php?id_demande='.$demande_guilde_detail['id_demande'].'">Validé la demande de groupe</a></td>';
				echo'</tr>';
			}
		}
		
		
	?>
	</tbody>
</table>
</div>
</body>
</html>