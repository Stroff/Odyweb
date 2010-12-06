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
		$sql = "SELECT accounts2.username, 
			logs_achat_points.type, 
			logs_achat_points.nombre_points, 
			logs_achat_points.date
		FROM logs_achat_points INNER JOIN accounts2 ON logs_achat_points.account_id = accounts2.id";
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$resultats = mysql_query($sql);
		echo '
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
		echo '
		<thead>
		<tr>
			<th>Nom du compte</th>
			<th>Type d\'achat</th>
			<th>Nombre de points</th>
			<th>Date</th>
		</tr>
		</thead>
		<tbody>';
		while($log = mysql_fetch_array($resultats)) {
			echo '<tr class="gradeA">';
			echo '<td>'.$log['username'].'</td>';
			echo '<td>'.$log['type'].'</td>';
			echo '<td>'.$log['nombre_points'].'</td>';
			echo '<td>'.$log['date'].'</td>';
			echo'</tr>';
		}

		
	?>
	</tbody>
</table>
</div>
</body>
</html>