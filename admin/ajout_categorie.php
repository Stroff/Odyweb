<?php
$secure_lvl=2;
include '../secure.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Document sans nom</title>
</head>
<body>
	<?php
	include 'config/config.php';
	if (isset($_POST['nom_categorie'])) {
		$sql = "INSERT INTO categorie_boutique SET nom = '".$_POST['nom_categorie']."'";
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		mysql_query($sql);
		if($sql) {
			echo "Ajout de la catégorie Ok";
		} else {
			echo 'Erreur dans l\'ajout';
		}
	}
	?>
<form id="form1" name="form1" method="post" action="ajout_categorie.php">
  <p>
    <label>Nom de la catégorie (Set T5, Hors Set T5, famillier...)
      <input type="text" name="nom_categorie" id="nom_categorie" />
    </label>
  </p>
<input name="new_valid" id="new_valid" type="submit" value="Valider" />

<p>Liste actuel :</p>
<table>
	<tr>
		<th>Nom</th>
	</tr>
	<?php
	$sql = "SELECT nom FROM categorie_boutique";
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$resultats = mysql_query($sql);
	while($categorie = mysql_fetch_array($resultats)) {
		echo '<tr><td>'.$categorie['nom'].'</td></tr>';
	}
	?>
</table>
</form>
</body>
</html>
