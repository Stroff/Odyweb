<?php 
$secure_lvl = 1;
$header_titre = "Historique des achats boutique";

include "include/template/header_cadres.php"; 
?>
	<style type="text/css" title="currentStyle">
		@import "medias/css/demo_table.css";
	</style>
	<style media="screen" type="text/css">
	 @import "medias/css/custom-theme/jquery-ui-1.7.2.custom.css";
	</style>
	<script type="text/javascript" language="javascript" src="Scripts/jquery.dataTables.min.js"></script>
	<script src="http://static.wowhead.com/widgets/power.js"></script>
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
				"sInfo": "Montre les achats _START_ à _END_ sur _TOTAL_ achats",
				"sInfoEmpty": "Pas d'achats",
				"sInfoFiltered": "(filtre _MAX_ objets)",
				"sZeroRecords": "Pas de résultats - désolé",
				"sLengthMenu": "Montre _MENU_ achats par pages",
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
<h2>Historique de vos achats</h2>

<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$liste_achats = mysql_query("SELECT perso_nom, date, objet_id FROM logs_achat_boutique WHERE account_id='".$compte_id."'");
echo '<p>Histoire de vos achats :</p>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
	<tr>
		<th>Nom du perso</th>
		<th>Achat</th>
		<th>Date</th>
		</tr>
</thead>
	<tbody>';
	while($achat = mysql_fetch_array($liste_achats)) {
		$id_objet_remboursement = explode(";", $achat['objet_id']);
		if(count($id_objet_remboursement)<>2) {
			$id_objet = explode(" ", $achat['objet_id']);
			if ($id_objet[0]=='Changement') {
				$objet = $achat['objet_id'];
			} else if ($id_objet[0]>'1000') {
				$objet = '<a href="http://fr.wowhead.com/?item='.$id_objet[0].'">Objet boutique : '.$id_objet[0].'</a>';
			} else if ($id_objet[0]=='100' || $id_objet[0]=='200'||$id_objet[0]=='300'||$id_objet[0]=='400'||$id_objet[0]=='500'||$id_objet[0]=='1000'){
				$objet = $id_objet[0].' po';
			} else if ($id_objet[0]=='changement') {
				$objet = $achat['objet_id'];
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
		echo '<tr>';
		echo '<td>'.$achat['perso_nom'].'</td>';
		echo '<td>'.$objet.'</td>';
		echo '<td>'.$achat['date'].'</td>';		
		echo'</tr>';
	}
	echo '	</tbody>
	</table>';
?>
 
<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>

