<?php 
$secure_lvl = 2;
$header_titre = "Historique des renames";

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
				"sInfo": "Montre les renames _START_ à _END_ sur _TOTAL_ renames",
				"sInfoEmpty": "Pas de renames",
				"sInfoFiltered": "(filtre _MAX_ objets)",
				"sZeroRecords": "Pas de résultats - désolé",
				"sLengthMenu": "Montre _MENU_ renames par pages",
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
<h2>Historique des changements de nom</h2>

<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$liste_achats = mysql_query("SELECT oldname,newname,date FROM log_rename ORDER BY DATE");
echo '<p>Histoire des changements de nom:</p>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
	<tr>
		<th>Ancien nom</th>
		<th>Nouveau nom</th>
		<th>Date</th>
		</tr>
</thead>
	<tbody>';
	while($achat = mysql_fetch_array($liste_achats)) {
		echo '<tr>';
		echo '<td>'.$achat['oldname'].'</td>';
		echo '<td>'.$achat['newname'].'</td>';
		echo '<td>'.$achat['date'].'</td>';		
		echo'</tr>';
	}
	echo '	</tbody>
	</table>';
?>
	</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>