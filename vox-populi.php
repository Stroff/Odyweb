<?php 
$secure_lvl = 1;
$header_titre = "Vote pour les débugs";
require "include/template/header_cadres.php"; 
?>
	<style type="text/css" title="currentStyle">
		@import "medias/css/demo_table.css";
	</style>
	<script src="http://static.wowhead.com/widgets/power.js"></script>
	<style media="screen" type="text/css">
	 @import "medias/css/custom-theme/jquery-ui-1.7.2.custom.css";
	</style>
	<script type="text/javascript" language="javascript" src="medias/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
	var oTable;
	function fnFormatDetails ( nTr )
	{
		var iIndex = oTable.fnGetPosition( nTr );
		var aData = oTable.fnSettings().aoData[iIndex]._aData;

		var sOut = '<form style="padding-left:20px;" name="'+aData[5]+'" method="post" action=""><div id="message'+aData[5]+'"></div><br />';
		sOut += ''+aData[4]+'<br />';
		sOut += '<br />';
		sOut += '<a href="http://bug.odyssee-serveur.com/issues/'+aData[5]+'" target="_BLANK">Pour en savoir plus</a><br />';
		
		sOut += '<br /><label style="width: 90px;"></label><input id="form_achat'+aData[5]+'" type="button" value="Je vote +1"/><br /><br />';
		sOut += '</form>';
		sOut += '<script type="text/javascript">$("#form_achat'+aData[5]+'").click(function(){';
		sOut += '	$("#message'+aData[5]+'").slideUp(750,function() {';
		sOut += '		$("#message'+aData[5]+'").hide();';
		sOut += '			$("#form_achat'+aData[5]+'").after(\'<img src="media/images/ajax-loader.gif" class="loader" />\');';
		sOut += '			$("#form_achat'+aData[5]+'").attr("disabled","disabled");';
		sOut += '		$.post("ajax_vox-populi.php", { ';
		sOut += '			bug: '+aData[5]+',';
		sOut += '			}, function(data){';
		sOut += '					document.getElementById("message'+aData[5]+'").innerHTML = data;';
		sOut += '					$("#message'+aData[5]+'").slideDown("slow");';
		sOut += '					$("form img.loader").fadeOut("slow",function(){$(this).remove()});';
		sOut += '					$("#form_achat'+aData[5]+'").attr("disabled","");';
		sOut += '			}';
		sOut += '		);';
		sOut += '	});';
		sOut += '	return false; ';
		sOut += '	});<\/script>';

		return sOut;
	}
	
	
	$(document).ready(function() {
		/*
		 * Insert a 'details' column to the table
		 */
		var nCloneTh = document.createElement( 'th' );
		var nCloneTd = document.createElement( 'td' );
		nCloneTd.innerHTML = '<img src="http://www.datatables.net/examples/examples_support/details_open.png">';
		nCloneTd.className = "center";

		$('#example thead tr').each( function () {
			this.insertBefore( nCloneTh, this.childNodes[0] );
		} );

		$('#example tbody tr').each( function () {
			this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
		} );

		/*
		 * Initialse DataTables, with no sorting on the 'details' column
		 */
		oTable = $('#example').dataTable( {
			"bJQueryUI": true,
			"bPaginate": true,
			"sPaginationType": "full_numbers",
			"bFilter": true,
			"bLengthChange": true,
			"bAutoWidth": false,
			"oLanguage": {
				"sSearch": "Recherche :",
				"sInfo": "Montre les bugs _START_ à _END_ sur _TOTAL_ bugs",
				"sInfoEmpty": "Pas de bugs !",
				"sInfoFiltered": "(filtre _MAX_ bugs)",
				"sZeroRecords": "Pas de résultats - désolé",
				"sLengthMenu": "Montre _MENU_ bugs par pages",
				"oPaginate": {
						"sFirst":    "Première",
						"sPrevious": "Précédente",
						"sNext":     "Suivante",
						"sLast":     "Dernière"
					}
			}
		});

		/* Add event listener for opening and closing details
		 * Note that the indicator for showing which row is open is not controlled by DataTables,
		 * rather it is done here
		 */
		$('td img', oTable.fnGetNodes() ).each( function () {
			$(this).click( function () {
				var nTr = this.parentNode.parentNode;
				if ( this.src.match('details_close') )
				{
					/* This row is already open - close it */
					this.src = "http://www.datatables.net/examples/examples_support/details_open.png";
					oTable.fnClose( nTr );
				}
				else
				{
					/* Open this row */
					this.src = "http://www.datatables.net/examples/examples_support/details_close.png";
					oTable.fnOpen( nTr, fnFormatDetails(nTr), 'details' );
				}
			} );
		} );
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
<?php
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
mysql_select_db($wow_characters ,$connexion);
$persos  = mysql_query("SELECT totaltime FROM characters WHERE account = ".$_SESSION['id']."");
$time = 0;
while($perso = mysql_fetch_array($persos)) {
	$time += $perso["totaltime"];
}
if($time_min_vote_bug<$time){
?>
<h2>Vote pour les débugs</h2>
<form method="post" action="ajax_vox-populi.php" name="form" id="form">
<p>Vous pouvez voter pour les bugs qui vous semblent les plus génants ici (2 jours de played minimum par compte)</p>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
	<tr>
		<th>Catégorie</th>
		<th>Nom du bug</th>
		<th>Nombre de votes</th>
		<th style = "display:none;">id</th>
		<th style = "display:none;">description</th>
		</tr>
</thead>
	<tbody>
<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($redmine_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$resultat  = mysql_query("SELECT issues.id, 
	issues.description, 
	issues.`subject`, 
	issues.vote_joueurs,
	issues.created_on,
	trackers.name AS categorie
FROM trackers INNER JOIN issues ON trackers.id = issues.tracker_id
WHERE status_id != 6 AND status_id != 5 AND status_id != 3 AND status_id != 4 AND project_id = 2");
while($bug = mysql_fetch_array($resultat)) {
	echo '<tr>';
	echo '<td>'.$bug['categorie'].'</td>';
	echo '<td>'.$bug['subject'].'</td>';
	echo '<td>'.(int)$bug['vote_joueurs'].'</td>';
	echo '<td style = "display:none;">'.$bug['description'].'</td>';
	echo '<td style = "display:none;">'.$bug['id'].'</td>';
	echo'</tr>';
}
?>
		</tbody>
	</table>
<br />
<p>Les plus grosses demandes :</p>
<table>
	<tr>
		<th>Catégorie</th>
		<th>Nom du bug</th>
		<th>Nombre de votes</th>
    </tr>
<?php
$resultat  = mysql_query("SELECT issues.id, 
	issues.description, 
	issues.`subject`, 
	issues.vote_joueurs,
	issues.created_on,
	trackers.name AS categorie
FROM trackers INNER JOIN issues ON trackers.id = issues.tracker_id
WHERE status_id != 6 AND status_id != 5 AND status_id != 3 AND status_id != 4 AND project_id = 2 ORDER BY issues.vote_joueurs DESC LIMIT 10");
while($bug = mysql_fetch_array($resultat)) {
	echo '<tr>';
	echo '<td>'.$bug['categorie'].'</td>';
	echo '<td>'.$bug['subject'].'</td>';
	echo '<td>'.(int)$bug['vote_joueurs'].'</td>';
    echo'</tr>';
}
?>	
</table>
<br/> <br/> <br/>
<?php } else {
	echo "<h2>Vote pour les débug</h2><p>Vous n'avez pas un /played assez grand pour faire un vote pour les débug</p>";
}?> 				
		</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
