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
<title>Liste des tickets</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p>Liste des tickets</p>
<a href="index.php"> Retour a l'accueil </a> <br/>
	<?php
	include 'config/config.php';
		
		$sql = "SELECT DISTINCT t.guid, t.name, t.createtime, c.online 
			FROM gm_tickets AS t LEFT JOIN characters AS c ON (c.guid = t.playerGuid) 
			WHERE t.closed = 0 ORDER BY c.online DESC, t.guid ASC";
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$resultats = mysql_query($sql);
		echo '<p> Nombre de tickets : '.mysql_num_rows($resultats).' <br/> Tickets en ligne: </p>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
		echo '
		<thead>
		<tr>
			<th>Num du ticket</th>
			<th>Nom du personnage</th>
			<th>Date demande</th>
			<th>En ligne</th>
		</tr>
		</thead>
		<tbody>';
		while($demande = mysql_fetch_array($resultats)) {
			echo '<tr class="gradeA">';
			echo '<td><a href="detail_ticket.php?id='.$demande['guid'].'">'.$demande['guid'].'</a></td>';
			echo '<td>'.$demande['name'].'</td>';
			echo '<td>'.date('H:i:s d-m-Y', $demande['createtime']).'</td>';
			echo '<td>';
			if( $demande['online'] == 0 ) echo 'Hors ligne'; else  echo 'En ligne';
			echo '</td>';
			echo'</tr>';
		}
	?>
	</tbody>
</table>
</div>
</body>
</html>
