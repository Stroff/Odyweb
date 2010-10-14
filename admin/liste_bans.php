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
				
		$('#example2').dataTable( {
						"bPaginate": false,
						"bLengthChange": false,
						"bFilter": true,
						"bInfo": false,
						"bAutoWidth": false } );
	} );
</script>
<title>Liste des bans</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p>Liste des bans</p>
	<?php
	include 'config/config.php';
		$sql = "SELECT account_banned.bannedby, 
			account_banned.banreason, 
			account_banned.active, 
			account_banned.bandate, 
			account_banned.unbandate, 
			account_banned.id, 
			account.username
		FROM account_banned INNER JOIN account ON account_banned.id = account.id WHERE account.username LIKE '%".$_POST['termes']."%' OR account_banned.bannedby LIKE '%".$_POST['termes']."%'";
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_realmd ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$resultats = mysql_query($sql);
		echo '
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
		echo '
		<thead>
		<tr>
			<th>Id</th>
			<th>Nom du compte</th>
			<th>Nom du mj</th>
			<th>Début</th>
			<th>Fin</th>
			<th>Raison</th>
			<th>Actif?</th>
		</tr>
		</thead>
		<tbody>';
		while($log = mysql_fetch_array($resultats)) {
			echo '<tr class="gradeA">';
			echo '<td>'.$log['id'].'</td>';
			echo '<td>'.$log['username'].'</td>';
			echo '<td>'.$log['bannedby'].'</td>';
			echo '<td>'.date("d/m/Y H:i", $log['bandate']).'</td>';
			if($log['bandate']==$log['unbandate']){
				echo '<td>à vie</td>';
			}else{
				echo '<td>'.date("d/m/Y H:i",$log['unbandate']).'</td>';
			}
			echo '<td>'.$log['banreason'].'</td>';
			if($log['active']==0){
				echo '<td>Non</td>';
			} else {
				echo '<td>Oui</td>';
			}
			echo'</tr>';
		}

		
	?>
	</tbody>
</table>

<p>Liste des bans ip</p>
<?php
		$sql = "SELECT ip_banned.ip, 
			ip_banned.bandate, 
			ip_banned.unbandate, 
			ip_banned.bannedby, 
			ip_banned.banreason
		FROM ip_banned WHERE ip_banned.ip LIKE '%".$_POST['termes']."%' OR ip_banned.bannedby LIKE '%".$_POST['termes']."%'";
		$resultats = mysql_query($sql);
		echo '
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">';
		echo '
		<thead>
		<tr>
			<th>Ip</th>
			<th>Nom du mj</th>
			<th>Début</th>
			<th>Fin</th>
			<th>Raison</th>
			<th>Actif?</th>
		</tr>
		</thead>
		<tbody>';
		while($log = mysql_fetch_array($resultats)) {
			echo '<tr class="gradeA">';
			echo '<td>'.$log['ip'].'</td>';
			echo '<td>'.$log['bannedby'].'</td>';
			echo '<td>'.date("d/m/Y H:i", $log['bandate']).'</td>';
			if($log['bandate']==$log['unbandate']){
				echo '<td>à vie</td>';
			}else{
				echo '<td>'.date("d/m/Y H:i",$log['unbandate']).'</td>';
			}
			echo '<td>'.$log['banreason'].'</td>';
			if($log['active']==0){
				echo '<td>Non</td>';
			} else {
				echo '<td>Oui</td>';
			}
			echo'</tr>';
		}

		
	?>
	</tbody>
</table>
</div>
</body>
</html>