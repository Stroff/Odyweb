<?php 
$secure_lvl = 1;
$header_titre = "Etat de la demande sur le support";
require "include/template/header_cadres.php";
include 'config/config.php';
?>
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
				<h3>Etat de la demande sur le support</h3>
<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
//construction du token
$sso = generate_multipass_tender( $_SESSION['email'],$compte_username);
$id_ticket = $_GET['id'];
$process = curl_init(); 
$headers[] = 'Accept: application/vnd.tender-v1+json'; 
$headers[] = "X-Tender-Auth: d4f50ad4dcad463128c20b647725568db7ba34a4";
curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
curl_setopt($process, CURLOPT_HEADER, 0);
curl_setopt($process, CURLOPT_POST,true);
curl_setopt($process, CURLOPT_POSTFIELDS, "");
curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
if($_GET['state']=='resolve'){
	curl_setopt($process, CURLOPT_URL, "https://api.tenderapp.com/odyssee/discussions/".$id_ticket."/resolve");
}else {
	curl_setopt($process, CURLOPT_URL, "https://api.tenderapp.com/odyssee/discussions/".$id_ticket."/unresolve");
}
$return = curl_exec($process); 
curl_close($process);
$data = json_decode($return);
if($data == "The page you are looking for can't be found"){
	echo "Vous n'avez pas les droits";
}else {
	if($_GET['state']=='resolve'){
		echo "<p>Vous avez bien changé le ticket, il est maintenant résolu</p>";
	}else {
		echo "<p>Vous avez bien changé le ticket, il est maintenant ré-ouvert</p>";	
	}
 } ?>
	                        	<br/> 	<br/> 	<br/> 
						   </div>
	                    </div>
	             </div>
	            <div class="encadrepage-bas">
	            </div> 

	<?php require "include/template/footer_cadres.php"?>

