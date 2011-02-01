<?php
include "config/config.php";
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$resultat  = mysql_query("SELECT valeur FROM configuration WHERE nom = 'id_vote_saison'");
$id_vote_saison = mysql_fetch_array($resultat);
$id_vote_saison = $id_vote_saison[0];
$palier = 250;
//for($i=1;$i<=$id_vote_saison;$i++){
$i=$id_vote_saison - 1 > 0 ? $id_vote_saison - 1 : 1;
	$nom_saison  = mysql_query("SELECT Nom FROM vote_saison WHERE id = '".$i."'");
	$nom_vote_saison = mysql_fetch_array($nom_saison);
	echo "<h3>$nom_vote_saison[0]</h3>";
 echo "Rappellez-vous que les votes sont seuls garants de la survie du serveur et de sa population! <br/>";
         if (!isset($_SESSION['login'])) {
            echo "Vous devez être connecté pour acceder à vos propres statistiques <br/>";
        } else {
            $statscompte = mysql_query("SELECT * FROM site.accounts_vote_saison WHERE id_account = '" . $_SESSION['id'] . "' AND id_vote_saison = ". $id_vote_saison);
            $votecompte = mysql_fetch_row($statscompte);
            $placementcompte = mysql_query ("SELECT COUNT(*) FROM site.accounts_vote_saison WHERE nombre_votes > " . $votecompte[2] . " AND id_vote_saison = ". $id_vote_saison);
            
            echo "<br/>";
            
            if( $placementcompte )
            {
                $placecompte = mysql_fetch_row($placementcompte);
                $placecompte[0]++;
                echo "Vous êtes le ". $placecompte[0]. "eme du classement de la saison ".$nom_vote_saison[0]. " avec " . $votecompte[2]. " votes totalisés. <br/>" ;
            }
            else {
                echo "Vous n'avez effectué aucun vote la saison dernière, il n'est pas trop tard pour s'y mettre, bon courage !";
            }                       
            
            if ( $votecompte[2] >= $palier)
            {
               echo " Vos efforts ont été récompensés!<a href=\"cadeaux_saison.php\"> Cliquez ici!</a> <br/>";
            }
            else
            {
                $manquevotes = $palier - $votecompte[2];
                echo " Vous etiez à " .$manquevotes . " votes de la récompense (cela peut changer pour les saisons futures). Courage pour la prochaine saison! ";
            }
        }
	echo '<table>
		<tr>
	        <th width="260px">Compte</th>
	        <th>Nombres de votes</th>
	    </tr>';
	$sql = "SELECT accounts.username, 
			accounts_vote_saison.nombre_votes
		FROM accounts_vote_saison INNER JOIN accounts ON accounts_vote_saison.id_account = accounts.id WHERE accounts_vote_saison.id_vote_saison = '".$i."' ORDER BY accounts_vote_saison.nombre_votes DESC LIMIT 10";
	$liste_comptes = mysql_query($sql) or die (mysql_error()); 
	while($compte = mysql_fetch_array($liste_comptes)){
		echo '<tr>
	        <td>'.$compte['username'].'</th>
	        <td>'.$compte['nombre_votes'].'</th>
	    </tr>';
	}
	echo '</table>';
	echo '<br/>';
//}
?>
