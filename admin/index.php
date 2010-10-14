<?php
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

<body>
<form id="form1" name="form1" method="post" action="ajout_categorie.php">
</form>
<?php

if($_SESSION['gm']==4){
	$nom = 'Développeurs';
	$email = 'dev@odyssee-serveur.com';
}
if($_SESSION['gm']==6){
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




  <p> boutique ->
Liens utiles : <a href="ajout_categorie.php">Ajout d'une catégorie</a> <a href="ajout_type.php">Ajout d'un type</a> <a href="ajout_item.php">Ajout d'un item</a>

  </p>

 recups -> <a href="liste_recup.php">Liste des recups ouvertes</a> <a href="liste_recup.php?demandes=toutes">Liste de toutes les recups</a> - <a href="liste_demandes_guildes.php">Liste des demandes de guilde</a>
 <form method="post" action="liste_recup.php">
    	Recherche du nom de compte ou de perso dans toutes les demandes de recup (nouveau systeme):  
        <input type="text" name="termes" value="" size="15" />
        <input type="submit" name="Recherche" />       	
    </form>
 logs boutique -> <a href="logs_achats_boutique.php">Liste des achats d'objets boutique</a> <a href="logs_achats_points.php">Liste des achats de points</a>
  <form method="post" action="logs_achats_boutique.php">
        recherche du nom de compte, de perso dans les logs boutique:  
        <input type="text" name="logsearch" value="" size="15" />
        <input type="submit" name="Recherche" />
        	
        </form>


<p> tickets IG -> <a href="liste_tickets.php">Lister les tickets ouverts</a></p>

<p>Ancien systéme de récupération ->  <a href="old/list_recup.php?cat=0">Liste des recups ouvertes</a> <a href="old/list_recup_f.php?cat=0">Liste de toutes les recups</a> - <a href="old/list_demande_onisan.php?cat=0">Liste des demandes onisan</a></p>
<p><a href="<?=$url?>">Connexion sur le système de support</a></p>

</body>
</html>
