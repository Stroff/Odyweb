<?php 
$secure_lvl = 1;
$header_titre = "Vote pour le serveur";
require "include/template/header_cadres.php"; 
$monfichier = fopen('compteur_clique/rpg', 'r+');
$pages_vues = fgets($monfichier); // On lit la première ligne (nombre de pages vues)
$pages_vues++; // On augmente de 1 ce nombre de pages vues
fseek($monfichier, 0); // On remet le curseur au début du fichier
fputs($monfichier, $pages_vues); // On écrit le nouveau nombre de pages vue
fclose($monfichier);
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
<h2>Vote</h2>
<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$resultat  = mysql_query("SELECT valeur FROM configuration WHERE nom='points_par_votes' OR nom='temp_entre_votes' OR nom = 'pp_par_votes' OR nom = 'id_vote_saison'");
$points_par_vote = mysql_fetch_array($resultat);
$points_par_vote = $points_par_vote[0];

$temp_entre_votes = mysql_fetch_array($resultat);
$temp_entre_votes = $temp_entre_votes[0];

$pp_par_votes = mysql_fetch_array($resultat);
$pp_par_votes = $pp_par_votes[0];

$id_vote_saison = mysql_fetch_array($resultat);
$id_vote_saison = $id_vote_saison[0];

$prochain_vote = timestamp2mysql(time()+ $temp_entre_votes);

	if (isset($_POST['token'])&&$_POST['token']<>'') {
		$mon_token = mysql_escape_string ( $_POST['token']);
		$check_token = mysql_query("SELECT id FROM accounts WHERE key_activation= '".$mon_token."-4PGkOkg'");
		if(mysql_num_rows($check_token)==1 && $timestamp_actuel>=$timestamp_db) {
			$nouveau_nbr_points= $compte_points+$points_par_vote;
			$temps_en_plus = $timestamp_actuel - $timestamp_db;
			if ($temps_en_plus<500) {
				$log_vote = mysql_query("INSERT INTO logs_votes SET username='".$compte_username."', temps_en_plus='".$temps_en_plus."', date=NOW()");
			}

			$resultat  = mysql_query("UPDATE accounts SET key_activation='',next_vote_date='".$prochain_vote ."',points=".$nouveau_nbr_points." WHERE id='".$compte_id."' LIMIT 1") or die(mysql_error());
			
			$check_top_vote = mysql_query("SELECT nombre_votes FROM accounts_vote_saison WHERE id_account= '".$compte_id."' AND id_vote_saison='".$id_vote_saison."'");
			if (mysql_num_rows($check_top_vote)==0){
				//insert alors
				$top_vote  = mysql_query("INSERT INTO accounts_vote_saison SET nombre_votes=nombre_votes+1, id_account='".$compte_id."', id_vote_saison='".$id_vote_saison."'") or die(mysql_error());
			}else {
				// update alors
				$top_vote  = mysql_query("UPDATE accounts_vote_saison SET nombre_votes=nombre_votes+1 WHERE id_account='".$compte_id."' AND id_vote_saison='".$id_vote_saison."' LIMIT 1") or die(mysql_error());
			}
			
			echo "<p>Vous allez être redirigé vers la page de <a href=\"http://www.rpg-paradize.com/?page=vote&vote=5683\">Rpg Paradize</a> pour finir votre vote. Vous avez maintenant ".$nouveau_nbr_points." points</p>
			<META http-equiv='refresh' content='0; URL=http://www.rpg-paradize.com/?page=vote&vote=5683'>";
		} else {
			echo 'Vous ne semblez pas avoir cliqué sur le bouton. Peut être un vote automatique?';
		}
		
	} else {
		if ($timestamp_actuel>=$timestamp_db) {
		$token = md5(uniqid(rand(), true));
		mysql_query("UPDATE accounts SET key_activation= '".$token."-4PGkOkg' WHERE id='".$compte_id."' LIMIT 1");
		echo '<p>Vous pouvez voter, mais pour cela vous devez juste cliquer sur le bouton pour éviter les programmes de votes automatique</p>'.'<form style="padding-left:15px;" action = "vote.php" method="post"><input type="hidden" name="token" value="'.$token.'"/><input  type="submit" value="Je suis humain !" /></form>';
		
		} else {
			//pas de vote
			$temp_restant= $timestamp_db-$timestamp_actuel;
			echo'
			<script type="text/javascript" src="js/jquery.countdown.min.js"></script>
			<script type="text/javascript" src="js/jquery.countdown-fr.js"></script>


				<script type="text/javascript">
				$(document).ready(function() { 	
				var austDay = new Date();
				austDay =  mysqlTimeStampToDate("'.$compte_next_vote_date.'");

		$(\'#textLayout2\').countdown({until: austDay, layout: \'{hn}h, {mn}m et {sn}s\',expiryUrl: \'vote.php\'});
		    });

		     function mysqlTimeStampToDate(timestamp) {
		    var regex=/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/;
		    var parts=timestamp.replace(regex,"$1 $2 $3 $4 $5 $6").split(\' \');
		    return new Date(parts[0],parts[1]-1,parts[2],parts[3],parts[4],parts[5]);
		  }
			</script>';

			echo "<p>Vous ne pouvez plus voter pour l'instant. Vous pourrez revoter dans <span id='textLayout2'></span></p>";
		}
	}

?>

<p>Classement des meilleurs voteurs :</p>
<table>
	<tr>
        <th>Compte</th>
        <th>Nombres de votes</th>
    </tr>
<?php
$sql = "SELECT accounts.username, 
		accounts_vote_saison.nombre_votes
	FROM accounts_vote_saison INNER JOIN accounts ON accounts_vote_saison.id_account = accounts.id WHERE accounts_vote_saison.id_vote_saison = '".$id_vote_saison."' ORDER BY accounts_vote_saison.nombre_votes DESC LIMIT 10";
$liste_comptes = mysql_query($sql) or die (mysql_error()); 
while($compte = mysql_fetch_array($liste_comptes)){
	echo '<tr>
        <td>'.$compte['username'].'</th>
        <td>'.$compte['nombre_votes'].'</th>
    </tr>';
}
?>	
</table>
<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
