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
	@import "css/style.css";
</style>

<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#mmperso').dataTable( {
				"bPaginate": false,
				"bLengthChange": false,
				"bFilter": false,
				"bInfo": false,
				"bAutoWidth": false } );

			$('#mmpersoetserveur').dataTable( {
					"bPaginate": false,
					"bLengthChange": false,
					"bFilter": false,
					"bInfo": false,
					"bAutoWidth": false } );				
				
	} );
</script>
<title>D&eacute;tail du ticket</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p><a href="liste_tickets.php">Liste des tickets</a></p>
	<?php
	include 'config/config.php';
	
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");	
	$id_tick = mysql_escape_string($_GET['id']);
	
	$sql = "SELECT t.*, c.online
		FROM gm_tickets AS t LEFT JOIN characters AS c ON (c.guid = t.guid)
                WHERE t.guid = $id_tick";

	$resultat = mysql_query($sql);

	$ticket = mysql_fetch_array($resultat);

        if (mysql_num_rows($resultat)==0) {
                echo '<p style="color:red;">Id ticket invalide, le ticket n\'existe pas</p>';
                exit();
        }

?>
	<br />
	<label> GUID du ticket : </label><? echo $ticket['guid'];?><br />

        <br />
        <label> Nom du joueur : </label><? echo $ticket['name'];?><br />

        <br />
        <label> Message : </label><br />
		<? echo $ticket['message'];?><br />

	<br />
	<label> Date de cr&eacute;ation : </label><? echo date('H:i:s d-m-Y', $ticket['createtime']); ?><br />

        <br />
        <label> Date de modification : </label><? echo date('H:i:s d-m-Y', $ticket['timestamp']); ?><br />

	<br />
	<label> Status du joueur : </label> <?  if( $ticket['online'] == 0 ) echo 'Hors ligne'; else echo 'En ligne'; ?><br />

	<br />
	<label> Etat du ticket : </label><?php if( $ticket['closed'] == 0 ) echo "Ouvert"; else "Ferm� (guid du player qui a ferm� ".$ticket['closed'];?>



</div>

</body>
</html>
