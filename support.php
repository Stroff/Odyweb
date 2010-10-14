<?php
$secure_lvl=1;
$header_titre = "Support";
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
			<h3>Support</h3>

<?php
if(!isset($_POST['section_id'])){
		echo '<div style="margin-left:20px;"><br> Vous devez passez par la page d\'assistance avant</br>';
		echo '</div></div></div></div><div class="encadrepage-bas">
		</div>';
		include'include/template/footer_cadres.php';
		exit;
}
		if($_POST ["title"]) {
			if($_POST ["title"]<>'' && $_POST ["message"]<>''){
				$connexion = mysql_connect($host_site, $user_site , $pass_site);
				mysql_select_db($site_database ,$connexion);
				mysql_query("SET NAMES 'utf8'");

				//construction du token
				$sso = generate_multipass_tender( $_SESSION['email'],$compte_username);
				
				$process = curl_init(); 
				$headers[] = "Accept: application/vnd.tender-v1+json"; 
				//$headers[] = "Content-Type: application/vnd.tender-v1+json";
				$headers[] = "X-Multipass: $sso";
				
			//	$headers[] = "X-Tender-Auth: $api_tender_support_staff";
				$requete['body'] = "Nom de compte : ".$compte_username."\n".$_POST['message'];
				$requete['title'] = $_POST['title'];
//				$requete['author_name'] = $compte_username;
//				$requete['author_email'] = $_SESSION['email'];
				$requete['public'] = false;
			//	$requete['extra'] = array("Nom de compte"=> $compte_username);
				// je passe en get car le post en json marche pas avec la version php de curl
				foreach($requete as $key => $val){
					$inputdata[] = $key."=".urlencode($val);
				}
				$query = implode("&", $inputdata);
				curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($process, CURLOPT_HEADER, 0);
				curl_setopt($process, CURLOPT_POST,true);
				curl_setopt($process, CURLOPT_POSTFIELDS,$query);
				curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($process, CURLOPT_URL, "http://api.tenderapp.com/odyssee/categories/".$_POST['section_id']."/discussions");
				$return = curl_exec($process); 
				curl_close($process);
				$data = json_decode($return);
				$url_user = $data->user_href;
				
				preg_match('#[0-9]*$#', $url_user, $id_user);
				if($id_user[0] != 0){
					$sql_check_id_tender = mysql_query("SELECT id_tender FROM accounts_to_tender where id = '".$compte_id."'");

					if (mysql_num_rows($sql_check_id_tender)==0){
						$sql = mysql_query("INSERT INTO accounts_to_tender SET id = '$compte_id', id_tender = '$id_user[0]'");
					}
					echo '<div style="margin-left:20px;"><br> Votre ticket est bien posté sur le support. <a href="support_liste.php">Vous pouvez voir vos tickets ici</a></br>';
					echo '</div></div></div></div><div class="encadrepage-bas">
					</div>';
					include'include/template/footer_cadres.php';
					exit;
				}else {
					echo '<div style="margin-left:20px;"><br>Il semblerais qu\'il y ai un probléme avec le support</br>';
					echo '</div></div></div></div><div class="encadrepage-bas">
					</div>';
					include'include/template/footer_cadres.php';
					exit;
				}
				
			}else {
				echo "<p>Vous devez remplir les champs</p>";
			}
			
		}
		?>

		<form action="support.php" method="post" enctype="multipart/form-data" name="form" id="form">
			<div style="margin-left:20px;">
				<br />
				<label style="width: 215px;font-weight: normal;"> Titre :</label>
				<input name="title" type="text" id="title" size="20"  /> <br />
				<input name="section_id" type="hidden" value="<?=$_POST['section_id'] ?>">

				<br />
				<p><label style="width: 215px;font-weight: normal;"> Message :</label></p><TEXTAREA name="message" rows=10 COLS=40></TEXTAREA>


				<br /><input style="margin-left: 213px;" type="submit" value="Envoyer" />
			</div>
		</form>
		                        	<br/> 	<br/> 	<br/> 
							   </div>
		                    </div>
		             </div>
		            <div class="encadrepage-bas">
		            </div> 

		<?php require "include/template/footer_cadres.php"?>