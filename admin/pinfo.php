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
<title>Infos sur les personnages</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div>
<p>Infos sur les personnages</p>
<a href="index.php"> Retour a l'accueil </a>
<p>
    <form method="post" action="#">
    	Recherche du nom de compte, de perso ou du guid dans les personnages:  
        <input type="text" name="filtre" value="" size="15" />
        <input type="submit" name="Recherche" />       	
    </form>
</p>
	<?php
	include 'config/config.php';
	
	$filtre= "'".$_POST['filtre']."'";
	$sql=mysql_query("SELECT c.guid, c.name, c.race, c.class, c.level, c.gender, c.money AS money, a.username, a.id FROM characters.characters AS c, realmd.account AS a WHERE a.id = c.account AND (c.guid = $filtre OR c.name LIKE $filtre OR a.username LIKE $filtre) ;");
	?>
<table class="display" id="dt_example">
 <thead>
 	<tr>
    	<th>
        	GUID:
        </th>
        <th>
        	Nom du perso:
        </th>
    	<th>
        	Race:
        </th>
    	<th>
        	Classe:
        </th>
    	<th>
        	Level:
        </th>
        <th>
        	Sexe:
    	<th>
        	Argent (pièces d'or):
        </th>
    	<th>
        	Nom du compte (id):
        </th>   	
    </tr>
 </thead>
 <tbody>
 <?php
	while($tableau = mysql_fetch_array($sql))
	{ ?>
 	<tr class="gradeA">
    	<td>
        	<?php echo $tableau['guid']; ?>
        </td>
        <td>
        	<?php echo $tableau['name']; ?>
        </td>
    	<td>
        	<?php 
		switch( $tableau['race'])
		{
			case 1:
				echo "Humain";
				break;
			case 2:
				echo "Orc";
				break;
			case 3:
				echo "Nain";
				break;
			case 4:
				echo "Elfe de la nuit";
				break;
			case 5:
				echo "Mort Vivant";
				break;
			case 6:
				echo "Tauren";
				break;
			case 7:
				echo "Gnome";
				break;
			case 8:
				echo "Troll";
				break;
			case 10:
				echo "Elfe de sang";
				break;
			case 11:
				echo "Draeneï";
				break;
			
			default:
				echo "Données illisibles";
		}
			?>

        </td>
    	<td>
        	<?php 		switch( $tableau['class'])
		{
			case 1:
				echo "Guerrier";
				break;
			case 2:
				echo "Paladin";
				break;
			case 3:
				echo "Chasseur";
				break;
			case 4:
				echo "Voleur";
				break;
			case 5:
				echo "Prêtre";
				break;
			case 6:
				echo "Chevalier de la mort";
				break;
			case 7:
				echo "Chaman";
				break;
			case 8:
				echo "Mage";
				break;
			case 9:
				echo "Démoniste";
				break;
			case 11:
				echo "Druide";
				break;
			
			default:
				echo "Données illisibles";
		} ?>
        </td>
    	<td>
        	<?php echo $tableau['level']; ?>
        </td>
    	<td>
        	<?php 
			switch ($tableau['gender'])
			{
				case 0:
					echo "Masculin";
					break;
				case 1:
					echo "Feminin";
					break;
				default:
					echo "Transexuel?";
					break;
			}
			?>
        </td>        
    	<td>
        	<?php echo $tableau['money']/ 10000; ?>
        
        </td>
    	<td>
        	<?php echo $tableau['username']; ?> ( ID: <?php echo $tableau['id']; ?>)
        
        </td>

    </tr>
 <?php } ?>
 </tbody>
</div>
</body>
</html>