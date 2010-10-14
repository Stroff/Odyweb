<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Statistiques des arènes en détails</title>
</head>
<body>
	<style type="text/css" title="currentStyle">
		@import "medias/css/demo_table.css";
	</style>
	<style media="screen" type="text/css">
	 @import "medias/css/custom-theme/jquery-ui-1.7.2.custom.css";
	</style>
	<script type="text/javascript" language="javascript" src="medias/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
	var oTable;

	$(document).ready(function() {
		oTable = $('#example').dataTable( {
			"bJQueryUI": true,
			"bPaginate": true,
			"sPaginationType": "full_numbers",
			"bFilter": true,
			"bInfo": true,
			"bLengthChange": true,
			"bAutoWidth": false,
			"oLanguage": {
				"sSearch": "Recherche :",
				"sInfo": "Montre les teams _START_ à _END_ sur _TOTAL_ teams",
				"sInfoEmpty": "Pas de team",
				"sInfoFiltered": "(filtre _MAX_ objets)",
				"sZeroRecords": "Pas de résultats - désolé",
				"sLengthMenu": "Montre _MENU_ teams par pages",
				"oPaginate": {
						"sFirst":    "Première",
						"sPrevious": "Précédente",
						"sNext":     "Suivante",
						"sLast":     "Dernière"
					}
			}
		});
	} );
	</script>
<h2>Statistiques des arènes en détails</h2>
<?php
include 'config/config.php';
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
mysql_select_db($wow_characters ,$connexion);
mysql_query("SET NAMES 'utf8'");
$liste_arenes = mysql_query("SELECT c.`name`, ca.`name` AS caname, ca.`arenateamid`,ca.`captainguid`, ca.`type`, at.`rating`, at.`wins`, at.`games`, at.`played`, at.`wins2` FROM `arena_team` AS ca
INNER JOIN `characters` AS c INNER JOIN arena_team_stats AS at
ON ca.`captainguid`= c.`guid` AND ca.`arenateamid`=at.`arenateamid`
ORDER BY at.`rating` DESC");
echo '
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
	<tr>
		<th>Nom</th>
		<th>Créateur</th>
		<th>Type</th>
		<th>Côte</th>
		<th>Victoire cette semaine</th>
		<th>Défaites cette semaine</th>
		<th>Taux de victoire cette semaine</th>
		<th>Victoire cette Saison</th>
		<th>Défaites cette Saison</th>
		<th>Taux de victoire cette Saison</th>
		</tr>
</thead>
	<tbody>';
	while($arene = mysql_fetch_array($liste_arenes)) {
		$defaite_semaine = $arene['games']-$arene['wins'];
		$defaite_saison = $arene['played']-$arene['wins2'];
		
		if ($arene['wins']==0 || $arene['games']==0) {
			$taux_victoire_semaine=0;
		} else {
			$taux_victoire_semaine = round($arene['wins']/$arene['games']*100,2);
		}
		if ($arene['wins2']==0 || $arene['played']==0) {
			$taux_victoire_saison=0;
		} else {
			$taux_victoire_saison = round($arene['wins2']/$arene['played']*100,2);
		}
		echo '<tr>';
		echo '<td>'.$arene['caname'].'</td>';
		echo '<td>'.$arene['name'].'</td>';
		echo '<td>'.$arene['type'].'vs'.$arene['type'].'</td>';
		echo '<td>'.$arene['rating'].'</td>';
		
		echo '<td>'.$arene['wins'].'</td>';
		echo '<td>'.$defaite_semaine.'</td>';
		echo '<td>'.$taux_victoire_semaine.'%</td>';
		echo '<td>'.$arene['wins2'].'</td>';
		echo '<td>'.$defaite_saison.'</td>';
		echo '<td>'.$taux_victoire_saison.'%</td>';
		
		echo'</tr>';
	}
	echo '	</tbody>
	</table>';
?>

</body>