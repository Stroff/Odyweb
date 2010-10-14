<?php 
$secure_lvl = 0;
$header_titre = "Récupération de compte après changement d'email";
include "include/template/header_cadres.php";
require "lib/phpmailer/class.phpmailer.php";
?>


<div id="msgbox"></div>
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
<h2>Rappel de mot de passe</h2>
<?php
if ($_GET ["code"]) {	
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	
	$demande_code = mysql_escape_string ( $_GET["code"]);
	
	$sql_check_compte = mysql_query("SELECT ancienne_email,id_compte FROM accounts_changement_email WHERE token_rollback = '".$demande_code."' AND refuser = 0");
	
	if (mysql_num_rows($sql_check_compte)==1) {
		$row = mysql_fetch_array($sql_check_compte); 
		
		$resReqSite = mysql_query("UPDATE accounts SET email = '".$row['ancienne_email']."' WHERE id = '".$row['id_compte']."'");
		$resReqSite2 = mysql_query("UPDATE accounts_changement_email SET refuser = '1' WHERE token_rollback = '".$demande_code."'");
		
		if ($resReqSite && $resReqSite2) {
			echo '<div style="margin-left:20px;"><br> Vous avez bien remis l\'ancienne adresse email sur le compte</b></br>';
			echo '</div></div></div></div><div class="encadrepage-bas">
			</div>';
			include'include/template/footer_cadres.php';
			exit;
		}else {
			echo '<div style="margin-left:20px;"><br> Problémes dans le changement d\'email. Contactez un développeur sur le forum pour résoudre ce probléme.</br>';
			echo '</div></div></div></div><div class="encadrepage-bas">
			</div>';
			include'include/template/footer_cadres.php';
			exit;
		}
	} else {
		$message = 'Le code ne semble pas valide';
	}

} 
?>

<?php echo '<p style="color:red;">'.@$message.'</p>'; ?>
    
<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>