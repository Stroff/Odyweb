<?php 
$secure_lvl = 1;
$header_titre = "Etat des demandes sur le support";
require "include/template/header_cadres.php";
include 'config/config.php';
?>
	<style type="text/css" title="currentStyle">
		@import "medias/css/demo_table.css";
	</style>
	<style media="screen" type="text/css">
	 @import "medias/css/custom-theme/jquery-ui-1.7.2.custom.css";
	</style>
	<script type="text/javascript" language="javascript" src="medias/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
	var oTable;

	$(document).ready(function() {
		oTable = $('#example').dataTable( {
			"bJQueryUI": true,
			"bPaginate": false,
			"bFilter": false,
			"bInfo": false,
			"bLengthChange": true,
			"bAutoWidth": false,
		});
	});
	</script>
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
					<h3>Etat des demandes sur le support</h3>

<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");

$req= mysql_query("SELECT id_tender FROM accounts_to_tender WHERE id=$compte_id");
if (mysql_num_rows($req)==0){
	echo '<p>Vous n\'avez pas fait de demandes de support</p>';
}
$id_tender = mysql_fetch_array($req);
$id_tender = $id_tender[0];
//construction du token
$sso = generate_multipass_tender( $_SESSION['email'],$compte_username);
$process = curl_init(); 
$headers[] = 'Accept: application/vnd.tender-v1+json'; 
$headers[] = "X-Multipass: $sso";
curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
curl_setopt($process, CURLOPT_HEADER, 0);
curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
curl_setopt($process, CURLOPT_URL, "http://api.tenderapp.com/odyssee/discussions?user_id=".$id_tender);
$return = curl_exec($process); 
curl_close($process);
$data = json_decode($return);
	echo'
	<p>Liste des demandes ('.$data->total.'):</p>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th>Titre</th>
			<th>Nombre messages</th>
			<th>Dernier message</th>
			<th>Etat</th>
			</tr>
	</thead>
		<tbody>';
	for($intI = 0; $intI < count($data->discussions); $intI++){ 
			preg_match('#[0-9]*$#', $data->discussions[$intI]->href, $id_ticket);
			echo '<tr>';
			echo '<td><a href="support_detail.php?id='.$id_ticket[0].'">'.$data->discussions[$intI]->title.'</a></td>';
			echo '<td>'.$data->discussions[$intI]->comments_count.'</td>';
			echo '<td>'.$data->discussions[$intI]->last_author_name.'</td>';
			echo '<td>'.$data->discussions[$intI]->state.'</td>';
			echo'</tr>';
	}?>
	</tbody>
	</table>
	                        	<br/> 	<br/> 	<br/> 
						   </div>
	                    </div>
	             </div>
	            <div class="encadrepage-bas">
	            </div> 

	<?php require "include/template/footer_cadres.php"?>
