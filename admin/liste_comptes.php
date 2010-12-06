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
<title>Liste des comptes</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p>Liste des bans</p>
	<?php
	include 'config/config.php';
		$sql = "SELECT accounts2.username, 
			accounts2.id, 
			accounts2.email, 
			accounts2.last_ip, 
			accounts2.points
		FROM accounts2 WHERE email LIKE '%".$_POST['termes']."%' OR username LIKE '%".$_POST['termes']."%' OR last_ip LIKE '%".$_POST['termes']."%'";
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);	
		mysql_query("SET NAMES 'utf8'");
		$resultats = mysql_query($sql);
		echo '
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
		echo '
		<thead>
		<tr>
			<th>Id</th>
			<th>Nom du compte</th>
			<th>Adresse IP</th>
			<th>Email</th>
			<th>Points</th>
		</tr>
		</thead>
		<tbody>';
		while($log = mysql_fetch_array($resultats)) {
			echo '<tr class="gradeA">';
			echo '<td><a href="edit_compte.php?id='.$log['id'].'">'.$log['id'].'</a></td>';
			echo '<td>'.$log['username'].'</td>';
			echo '<td>'.$log['last_ip'].'</td>';
			echo '<td>'.$log['email'].'</td>';
			echo '<td>'.$log['points'].'</td>';
			echo'</tr>';
		}
	?>
	</tbody>
</table>
</div>
</body>
</html>