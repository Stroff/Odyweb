<?php 
$secure_lvl = 1;
$header_titre = "Etat de la
 demande sur le support";
require "include/template/header_cadres.php";
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
if($_POST ["message"]) {
	$process = curl_init(); 
	$headers[] = 'Accept: application/vnd.tender-v1+json'; 
	$headers[] = "X-Multipass: $sso";
	$requete['body'] = $_POST['message'];
	// je passe en get car le post en json marche pas avec la version php de curl
	foreach($requete as $key => $val){
		$inputdata[] = $key."=".urlencode($val);
	}
	$query = implode("&", $inputdata);
	curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($process, CURLOPT_HEADER, 0);
	curl_setopt($process, CURLOPT_POST,true);
	curl_setopt($process, CURLOPT_POSTFIELDS, $query);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($process, CURLOPT_URL, "https://api.tenderapp.com/odyssee/discussions/".$id_ticket."/comments");
	$return = curl_exec($process); 
	curl_close($process);
	$data = json_decode($return);
	$message = "Votre réponse a bien été enregistré";
}
$process = curl_init(); 
$headers="";
$headers[] = 'Accept: application/vnd.tender-v1+json'; 
$headers[] = "X-Multipass: $sso";
curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
curl_setopt($process, CURLOPT_HEADER, 0);
curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
curl_setopt($process, CURLOPT_URL, "https://api.tenderapp.com/odyssee/discussions/".$id_ticket);
$return = curl_exec($process); 
curl_close($process);
$data = json_decode($return);
if($data == "The page you are looking for can't be found"){
	echo "Vous n'avez pas les droits";
}else {
	echo @$message;
	echo '<p><strong>Titre : </strong>'.$data->title.'</p>';
	echo '<p><strong>Message :</strong>'.$data->comments[0]->body.'</p>';
	echo '<p><strong>Status : </strong>'.$data->state.'</p>';
	$date_creation = strtotime($data->created_at);
	echo '<p><strong>Date de création :</strong> '.date("F j, Y, g:i a", $date_creation).'</p>';
	if(count($data->comments)>1){
		echo '<ol>';
		for($intI = 1; $intI < count($data->comments); $intI++){ 
				if($data->comments[$intI]->user_is_supporter == true) {
					echo '<li style="background-color: #1b4668; margin-left: 20px; background-image: url(../medias/images/blizz.gif) no-repeat; padding:2px;">';
				} else {
					echo '<li style="background-color: #555555; padding:2px;">';	
				}
				$time = strtotime($data->comments[$intI]->created_at);
				echo'<p>'.$data->comments[$intI]->body.'</p>
				<span class="commentmeta">
				Comment by: '.$data->comments[$intI]->author_name.' @ <abbr title="'.$data->comments[$intI]->created_at.'" class="posted">'.date("F j, Y, g:i a", $time).'</abbr></span>
				</li>';
		}
		echo '</ol>';
	}
		if($data->state == 'open' || $data->state=='new'){
	?>
	<p>Ecrire une réponse :</p>
	<form action="support_detail.php?id=<?=$id_ticket;?>" method="post" enctype="multipart/form-data" name="form" id="form">
		<div style="margin-left:20px;">
			<br />
			<label style="width: 215px;font-weight: normal;"> Message :</label><TEXTAREA name="message" rows=10 COLS=40></TEXTAREA>
			<br /><input style="margin-left: 213px;" type="submit" value="Envoyer" />
		</div>
	</form>
<?php 
	}
	if($data->state == 'open' || $data->state=='new'){
		echo '<a href="support_state.php?id='.$id_ticket.'&state=resolve">Clore le ticket</a>';
	} else {
		echo '<a href="support_state.php?id='.$id_ticket.'&state=unresolve">Ré-ouvrir le ticket</a>';
	}
 } ?>
	                        	<br/> 	<br/> 	<br/> 
						   </div>
	                    </div>
	             </div>
	            <div class="encadrepage-bas">
	            </div> 

	<?php require "include/template/footer_cadres.php"?>
