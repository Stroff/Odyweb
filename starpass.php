<?php
$secure_lvl = 1;
$header_titre = "Achat de points par WeboPass";

include "include/template/header_cadres.php" ; 
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
			<h2>Achat de points</h2>
			<?php
		$code = $_POST['code'];
		$test = @file("http://script.starpass.fr/check_php.php?ident=29433;;47985&codes=$code");
		$tab = explode("|",$test[0]);
		if(substr($tab[0],0,3) == "OUI")		//Script pour un ajout de 50points
		{
			$time = time();
			$resultat  = mysql_query("SELECT valeur FROM configuration WHERE nom='points_par_allopass' OR nom='pp_par_achat'");
			$points_par_allopass = mysql_fetch_array($resultat);
			$points_par_allopass = $points_par_allopass[0];

			$pp_par_achat = mysql_fetch_array($resultat);
			$pp_par_achat = $pp_par_achat[0];


			$connexion = mysql_connect($host_site, $user_site , $pass_site);
			mysql_select_db($site_database ,$connexion);
			mysql_query("SET NAMES 'utf8'");

			$nouveau_nbr_points= $compte_points+$points_par_allopass;

			$resultat  = mysql_query("UPDATE accounts SET points=".$nouveau_nbr_points.", pp=pp+".$pp_par_achat." WHERE id='".$compte_id."' LIMIT 1") or die(mysql_error());
			$log = mysql_query("INSERT INTO logs_achat_points (account_id, type,nombre_points,date) VALUES ($compte_id, 'starpass',$points_par_allopass,NOW())");
			if ($resultat && $log) {
				$message = 'Vous avez bien acheté '.$points_par_allopass.' points Odyssée. Merci de votre soutien';
			} else {
				$message = 'Le code est bon et à été utilisé mais une erreur c\'est produite. Veuillez nous contacté sur le site. Merci';	
			}
		} else {
			$message = 'Le code n\'est pas bon. Vous l\'avez surement mal saisi.';
		}
		echo '<p>'.$message.'</p>';
		?>
							</div>
	                    </div>
	                </div>
	            <div class="encadrepage-bas">
	            </div> 



	<?php require "include/template/footer_cadres.php"?>
