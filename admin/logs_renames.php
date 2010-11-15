<?php
$secure_lvl=2;
require '../secure.php';
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
				
		$('#example2').dataTable( {
						"bPaginate": false,
						"bLengthChange": false,
						"bFilter": true,
						"bInfo": false,
						"bAutoWidth": false } );
	} );
</script>
<title>Liste des renames</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p>Historique des changements de nom:</p>

<span style="color:#09C; font-style:italic;">/!\ les noms que vous recherchez seront pris comme des noms complets, pour faire une recherche sur un bout de nom mettre des "%" avant et/ou apres. <br/>
 Exemple pour "monnom": "%onnom" ou "monno%" ou "%nno%". <br/> <br/></span>
<form method="post" action="#">
	<input type="text" value="Recherche par nom" name="nom" />
	<input type="text" value="Recherche par GUID" name="guid" />
    <input type="submit" value="OK" name="bouton" />    
</form>
<br/>

	<?php										
include 'config/config.php';
$guid= "'".$_POST['guid']."'";
$nom= "'".$_POST['nom']."'";

if (isset ( $_POST['nom']) &&isset ( $_POST['guid']) && $guid != "'Recherche par GUID'" && $nom != "'Recherche par nom'")
{
	$liste_achats = mysql_query("SELECT guid,oldname,newname,accountid,date FROM log_rename WHERE guid = $guid AND (oldname like $nom OR newname like $nom);");
	echo "recherche par GUID et par Nom: Termes de recherche=".$guid." et ".$nom ;	
}
elseif (isset ( $_POST['guid']) && $guid != "'Recherche par GUID'" && $nom == "'Recherche par nom'")
{
	$liste_achats = mysql_query("SELECT guid,oldname,newname,accountid,date FROM log_rename WHERE guid = $guid;");
	echo "recherche par GUID: Termes de recherche=".$guid ;	
}
elseif (isset ( $_POST['nom']) && $nom != "'Recherche par nom'" && $guid == "'Recherche par GUID'" )
{
	$liste_achats = mysql_query("SELECT guid,oldname,newname,accountid,date FROM log_rename WHERE oldname like $nom OR newname like $nom;");
	echo "recherche par nom: Termes de recherche=".$nom ;
}
else 
{			
	mysql_query("SET NAMES 'utf8'");
echo "Liste de tous les renames:";	
$liste_achats = mysql_query("SELECT guid,oldname,newname,accountid,date FROM log_rename ORDER BY DATE");
}
?>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
	<tr>
		<th>Date</th>
		<th>GUID</th>
		<th>Ancien nom</th>
		<th>Nouveau nom</th>
        <th>Account ID</th>

		</tr>
</thead>
	<tbody>
    <?php
	while($achat = mysql_fetch_array($liste_achats)) {
		echo '<tr>';
		echo '<td>'.$achat['date'].'</td>';		
		echo '<td id="example2">'.$achat['guid'].'</td>';
		echo '<td>'.$achat['oldname'].'</td>';
		echo '<td id="example2">'.$achat['newname'].'</td>';
		echo '<td>'.$achat['accountid'].'</td>';
		echo'</tr>';
	}

?>
</tbody>
	</table>

</div>
</body>
</html>