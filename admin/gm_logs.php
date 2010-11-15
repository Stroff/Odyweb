<?php
$secure_lvl=2;
include '../secure.php';

if($_SESSION['gm']==4 || $_SESSION['gm']==3){
 echo "<h1>juste pour les admins et resp, dsl</h1>";
 exit();
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" title="currentStyle">
	@import "css/demo_page.css";
	@import "css/demo_table.css";
</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"
	} );></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#example').dataTable( {
				"bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bInfo": false,
				"bAutoWidth": false } );
</script>
<title>Liste des commandes MJ</title>
</head>
<body>
<?php include "navbar.php"; include "config/config.php"; ?>
<div id="dt_example">
<?php 
$sql="Select * from realmd.gmlogs WHERE ";
if (isset ($_POST["filtres"]))
{
	// variable qui permet d'ajouter "and" dans la requete
	$ajouter_and = 0;
	
	// si ya n'y a aucun MJ ou tous les mjs selectionné on affiche les commandes des 3 derniers jours
	if (isset ($_POST["MJ"]) && $_POST["MJ"] !=0)
	{
		$sql .= "account_id = ".$_POST["MJ"]." ";
		$ajouter_and = 1;
	}
	if( $ajouter_and )
		$sql .= " AND ";
}
$sql .= "date > DATE_SUB(CURDATE(), INTERVAL 3 DAY) ";
$sql .= "ORDER BY id DESC";
// r equete avec MJ selectionné
$MJ= mysql_query("Select a.id, s.pseudo_forum from site.staff_usernames AS s, realmd.account AS a WHERE a.username LIKE s.nom_compte;"); ?>

<form action="#" method="post">
<SELECT name="MJ">
	
<?php
	$table_mj = array();

	if(isset ($_POST["MJ"]) && $_POST["MJ"] == 0)
		echo "<OPTION SELECTED value=\"0\">Tous les MJS</OPTION> \n";	
	else
		echo "<OPTION value=\"0\">Tous les MJS</OPTION> \n";	
	
	while($ligne_MJ = mysql_fetch_array($MJ))
	{
		$table_mj[$ligne_MJ["id"]] = $ligne_MJ["pseudo_forum"];
		if(isset ($_POST["MJ"]) && $_POST["MJ"] == $ligne_MJ["id"])
			echo "<OPTION SELECTED value=\"".$ligne_MJ["id"]."\">".$ligne_MJ["pseudo_forum"]."</OPTION> \n";	
		else
			echo "<OPTION value=\"".$ligne_MJ["id"]."\">".$ligne_MJ["pseudo_forum"]."</OPTION> \n";
	}
?>
	</SELECT>
    <input type="text" name="commande" value="Commande" />
  <input type="submit" name="filtres" value="Recherche"	 />
</form>
<p>Liste des commandes MJ</p>
<a href="index.php"> Retour a l'accueil </a> <br/>
<table id="example" class="display">
 <thead>
 	<tr>
    	<th>
        	ID de la commande:
        </th>
        <th>
        	Date:
        </th>
    	<th>
        	Nom du MJ utilisé:
        </th>
    	<th>
        	Membre du staff:
        </th>
    	<th>
        	IP:
        </th>
        <th>
        	Type de cible:
    	<th>
        	Joueur selectionné:
        </th>
    	<th>
        	Commande utilisée:
        </th>
    	<th>
        	Position:
        </th>
    </tr>
 </thead>
 <tbody>
 <?php
// echo $sql."<br />\n";
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td>
        	<?php echo $val["id"]; ?>
        </td>
        <td>
        	<?php echo $val["date"]; ?>
        </td>
    	<td>
        	<?php echo $val["player_name"]; ?>
        </td>
    	<td>
        	<?php echo $table_mj[$val["account_id"]]; ?>
        </td>
    	<td>
        	<?php echo $val["ip"]; ?>
        </td>
    	<td>
        	<?php echo $val["selected"]; ?>
        </td>
        <td>
        	<?php echo $val["guid_selected"]; ?>
        </td>
    	<td>
        	<?php echo $val["cmd1"]." ".$val["cmd2"]." ".$val["cmd3"]." ".$val["cmd4"]." ".$val["cmd5"]; ?>
        </td>
    	<td>
        	<?php echo "x:".$val["posx"]." y:".$val["posy"]."  z:".$val["posz"]; ?>
        </td>
    </tr>
<?php
	} 
 
 ?>
 </tbody>
 </table>
</div>
</body>
</html>