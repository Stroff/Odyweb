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
<script src="http://static.wowhead.com/widgets/power.js"></script>
<title>Liste des achats boutique</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p>Liste des achats sur la boutique</p>
<a href="index.php"> Retour a l'accueil </a>
 <form method="post" action="#">
        recherche du nom de compte, de perso dans les logs boutique:  
        <input type="text" name="logsearch" value="" size="15" />
        <input type="submit" name="Recherche" />
        	
        </form>
	<?php
	include 'config/config.php';
	
	if (isset($_POST['logsearch']))
	{
		$sql = "SELECT accounts2.username, 
			logs_achat_boutique.objet_id, 
			logs_achat_boutique.perso_nom, 
			logs_achat_boutique.date
		FROM logs_achat_boutique INNER JOIN accounts2 ON logs_achat_boutique.account_id = accounts2.id WHERE logs_achat_boutique.perso_nom LIKE '%".$_POST['logsearch']."%' OR accounts2.username LIKE '%".$_POST['logsearch']."%'";
	}
	else
	{
	
		$sql = "SELECT accounts2.username, 
			logs_achat_boutique.objet_id, 
			logs_achat_boutique.perso_nom, 
			logs_achat_boutique.date
		FROM logs_achat_boutique INNER JOIN accounts2 ON logs_achat_boutique.account_id = accounts2.id";
	}
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
			<th>Objet</th>
			<th>Nom de perso</th>
			<th>Date</th>
		</tr>
		</thead>
		<tbody>';
		while($log = mysql_fetch_array($resultats)) {
			$id_objet_remboursement = explode(";", $log['objet_id']);
			if(count($id_objet_remboursement)<>2) {
				$id_objet = explode(" ", $log['objet_id']);
				if ($id_objet[0]=='Changement') {
					$objet = $log['objet_id'];
				} else if ($id_objet[0]>'1000') {
					$objet = '<a href="http://fr.wowhead.com/?item='.$id_objet[0].'">Objet boutique : '.$id_objet[0].'</a>';
				} else if ($id_objet[0]=='100' || $id_objet[0]=='200'||$id_objet[0]=='300'||$id_objet[0]=='400'||$id_objet[0]=='500'||$id_objet[0]=='1000'){
					$objet = $id_objet[0].' po';
				} else {
					$objet = $id_objet[0].' levels';
				}
			} else {
				$id_objet = explode("=", $id_objet_remboursement[1]);
				$id_objet = $id_objet[1];
				$prix_objet = explode("=", $id_objet_remboursement[0]);
				$prix_objet = $prix_objet[1];
				$objet = '<a href="http://fr.wowhead.com/?item='.$id_objet.'">Remboursement boutique,'.$prix_objet.' points</a>';
			}
			
			echo '<tr class="gradeA">';
			echo '<td>'.$log['username'].'</td>';
			echo '<td>'.$objet.'</td>';
			echo '<td>'.$log['perso_nom'].'</td>';
			echo '<td>'.$log['date'].'</td>';
			echo'</tr>';
		}

		
	?>
	</tbody>
</table>
</div>
</body>
</html>