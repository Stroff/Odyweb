<?php 
$secure_lvl = 1;
$header_titre = "Achats d'objets - Boutique";
require "include/template/header_cadres.php"; 
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");

// je recup le nom de la section
if (isset($_GET ["section"])) {
	$section_nom= mysql_escape_string ( $_GET ["section"]);
} else {
	$section_nom= 'Armes';
}

// recherche items
if ($section_nom<>'Compagnons' && $section_nom<>'Fun') {
	$items_req = mysql_query("SELECT categorie_boutique.nom AS categorie_nom, 
		type_boutique.nom AS type_nom, 
		items_boutique.prix AS prix, 
		items_boutique.nom AS nom, 
		items_boutique.id_objet AS id_objet, 
		items_boutique.id AS id, 
		section_boutique.nom AS section_nom
	FROM items_boutique INNER JOIN categorie_boutique ON items_boutique.categorie_id = categorie_boutique.id
		 INNER JOIN type_boutique ON items_boutique.type_id = type_boutique.id
		 INNER JOIN section_boutique ON section_boutique.id = items_boutique.section_id WHERE section_boutique.nom = '$section_nom' AND items_boutique.disponible=1");
}else {
	$items_req = mysql_query("SELECT 
		items_boutique.prix AS prix, 
		items_boutique.nom AS nom, 
		items_boutique.id_objet AS id_objet, 
		items_boutique.id AS id
	FROM items_boutique INNER JOIN section_boutique ON section_boutique.id = items_boutique.section_id  WHERE section_boutique.nom = '$section_nom' AND items_boutique.disponible=1");
}

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
	
	var sOut = '<form style="padding-left:120px;" name="'+aData[5]+'" method="post" action=""><div id="message'+aData[5]+'"></div><br />';
	sOut += '<label style="width: 90px;">Objet : </label>'+aData[1]+'<br />';
	sOut += '<br /><label style="width: 90px;">Personnage : </label><select id="perso'+aData[5]+'" value="perso"><option value="" selected>-- Mon perso--</option><?php
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$persos = mysql_query("SELECT name,guid,online,level FROM characters WHERE account = '".$compte_id."'");
	while ($perso = mysql_fetch_array($persos)) {
		if($perso['online']==0) {
			echo '<option value="'.$perso['guid'].'">'.$perso['name'].' ( '.$perso['level'].' )</option>';
		} else {
			echo '<option value="'.$perso['guid'].'">'.$perso['name'].' ( '.$perso['level'].' ) (en ligne)</option>';
		}
	}
	?></select><br />';
	sOut += '<br /><label style="width: 90px;"></label><input id="form_achat'+aData[5]+'" type="submit" value="Acheter"/><br />';
	sOut += '</form>';
	sOut += '<script type="text/javascript">$("#form_achat'+aData[5]+'").click(function(){';
	sOut += '	var perso_id = $("#perso'+aData[5]+'").val();';
		
	sOut += '	$("#message'+aData[5]+'").slideUp(750,function() {';
	sOut += '		$("#message'+aData[5]+'").hide();';
	
	sOut += '			$("#form_achat'+aData[5]+'").after(\'<img src="media/images/ajax-loader.gif" class="loader" />\');';
	sOut += '			$("#form_achat'+aData[5]+'").attr("disabled","disabled");';

	sOut += '		$.post("ajax_boutique_objet.php", { ';
	sOut += '			objet: '+aData[5]+',';
	sOut += '			perso: perso_id,';
	sOut += '			type: "achat_objet"';
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
			"sInfo": "Montre les objets _START_ à _END_ sur _TOTAL_ objets",
			"sInfoEmpty": "Pas d'objets",
			"sInfoFiltered": "(filtre _MAX_ objets)",
			"sZeroRecords": "Pas de résultats - désolé",
			"sLengthMenu": "Montre _MENU_ objets par pages",
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
            <img src="medias/images/titre/boutique.gif" >
        
	</div>
</div>
	<div class="blocpage">
    	<div class="blocpage-haut">
        </div>
        <div class="blocpage-bas">
        	<div class="blocpage-texte">
<h2>Boutique <?php echo $section_nom; ?></h2>
<form method="post" action="ajax_boutique_objets.php" name="form" id="form">
<p>Vous pouvez acheter des objets pour vos personnages ici</p>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
	<tr>
		<th>Nom de l'objet</th>
		<th>Catégorie</th>
		<th>Type</th>
		<th>Prix</th>
		<th style = "display:none;">id</th>
		</tr>
</thead>
	<tbody>
<?php 
while($objet = mysql_fetch_array($items_req)) {
	echo '<tr>';
	echo '<td><a href="http://fr.wowhead.com/?item='.$objet['id_objet'].'">'.$objet['nom'].'</a></td>';
	echo '<td>'.$objet['categorie_nom'].'</td>';
	echo '<td>'.$objet['type_nom'].'</td>';
	echo '<td>'.$objet['prix'].'</td>';
	echo '<td style = "display:none;">'.$objet['id'].'</td>';
	echo'</tr>';
}
?>
	</tbody>
</table>
					</div>
                </div>
            </div>
        <div class="encadrepage-bas">
        </div> 

<?php require "include/template/footer_cadres.php"?>




