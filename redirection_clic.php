<?php
if($_GET['source']=='rpg'){
	$monfichier = fopen('compteur_clique/rpg', 'r+');
	$redirection = 'Location: http://www.rpg-paradize.com/?page=vote&vote=5683';
} else {
	$monfichier = fopen('compteur_clique/gowanda', 'r+');
	$redirection = 'Location: http://www.gowonda.com/vote.php?server_id=800';
}

 
$pages_vues = fgets($monfichier); // On lit la premire ligne (nombre de pages vues)
$pages_vues++; // On augmente de 1 ce nombre de pages vues
fseek($monfichier, 0); // On remet le curseur au dŽbut du fichier
fputs($monfichier, $pages_vues); // On Žcrit le nouveau nombre de pages vues
 
fclose($monfichier);
header($redirection); 
?>
