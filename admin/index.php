﻿<?php 
$secure_lvl=2;
include '../secure.php';
include_once '../include/php/fonctions.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Page temporaire Administration</title>
</head>




<form id="form1" name="form1" method="post" action="ajout_categorie.php">
</form>

<?php if($_SESSION['gm']==4){
	$nom = 'Développeurs';
	$email = 'dev@odyssee-serveur.com';
}
if($_SESSION['gm']==6 || $_SESSION['gm']==5){
	$nom = 'Administration';
	$email = 'admin@odyssee-serveur.com';
}
if($_SESSION['gm']==3){
	$nom = 'Maîtres de jeu - Animateurs';
	$email = 'mj@odyssee-serveur.com';
}
$sso = generate_multipass_tender($email, $nom);
$url = "http://odyssee.tenderapp.com?sso=".$sso;


include "navbar.php";
?>




  
<p> boutique -&gt;
Liens utiles : <a href="ajout_categorie.php">Ajout d'une cat&eacute;gorie</a> <a href="ajout_type.php">Ajout d'un type</a> <a href="ajout_item.php">Ajout d'un item</a>

  </p>


 recups -&gt; <a href="liste_recup.php">Liste des recups ouvertes</a> <a href="liste_recup.php?demandes=toutes">Liste de toutes les recups</a> - <a href="liste_demandes_guildes.php">Liste des demandes de guilde</a>
 
<form method="post" action="liste_recup.php">
    	Recherche du nom de compte ou de perso dans toutes les demandes de recup (nouveau systeme):  
        <input name="termes" value="" size="15" type="text" />
        <input name="Recherche" type="submit" />       	
    </form>

 logs boutique -&gt; <a href="logs_achats_boutique.php">Liste des achats d'objets boutique</a> <a href="logs_achats_points.php">Liste des achats de points</a>
  
<form method="post" action="logs_achats_boutique.php">
        recherche du nom de compte, de perso dans les logs boutique:  
        <input name="logsearch" value="" size="15" type="text" />
        <input name="Recherche" type="submit" />
        	
        </form>



<p> tickets IG -&gt; <a href="liste_tickets.php">Lister les tickets ouverts</a></p>


<p>Ancien syst&eacute;me de r&eacute;cup&eacute;ration -&gt;  <a href="old/list_recup.php?cat=0">Liste des recups ouvertes</a> <a href="old/list_recup_f.php?cat=0">Liste de toutes les recups</a> - <a href="old/list_demande_onisan.php?cat=0">Liste des demandes onisan</a></p>

<p><a href="%3C?=$url?%3E">Connexion sur le syst&egrave;me de support</a></p>


<form action='script1.php' method='POST'>
<head>
<span style="color: rgb(255, 0, 0);">Bloc-Note pour mettre
les infos à partager :</span>
</head> 
 <br>
<textarea name='texte' cols='37' rows='6'><?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
// on crée la requête SQL
$sql = "SELECT valeur FROM configuration WHERE nom ='bloc_note'";
// on envoie la requête
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
echo $data["valeur"];
?>
</textarea><br>
<input type='submit' value='Valider'>
</form>
</body>
</html>
