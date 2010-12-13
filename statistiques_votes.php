<?php
include "config/config.php";
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$resultat  = mysql_query("SELECT valeur FROM configuration WHERE nom = 'id_vote_saison'");
$id_vote_saison = mysql_fetch_array($resultat);
$id_vote_saison = $id_vote_saison[0];
for($i=1;$i<=$id_vote_saison;$i++){
	$nom_saison  = mysql_query("SELECT Nom FROM vote_saison WHERE id = '".$i."'");
	$nom_vote_saison = mysql_fetch_array($nom_saison);
	echo "<h3>$nom_vote_saison[0]</h3>";
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
}
?>
