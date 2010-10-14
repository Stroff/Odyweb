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
	if (isset($_POST['nom_type'])) {
		$sql = "INSERT INTO type_boutique SET nom = '".$_POST['nom_type']."', section_id = '".$_POST['section_item']."'";
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		mysql_query($sql);
		if($sql) {
			echo "Ajout du type Ok";
		} else {
			echo 'Erreur dans l\'ajout';
		}
	}
	?>
<form id="form1" name="form1" method="post" action="ajout_type.php">
  <p>
    <label>Nom du type (épée une main, bouclier...)
      <input type="text" name="nom_type" id="nom_type" />
    </label>
  </p>
  <p>
    <label>Section (armes...) :
      <select name="section_item" id="section_item">
		<?php
			$sql = "SELECT nom,id FROM section_boutique";
			$connexion = mysql_connect($host_site, $user_site , $pass_site);
			mysql_select_db($site_database ,$connexion);
			mysql_query("SET NAMES 'utf8'");
			$resultats = mysql_query($sql);
			while($section = mysql_fetch_array($resultats)) {
				echo '<option value="'.$section['id'].'">'.$section['nom'].'</option>';
			}
		?>
      </select>
    </label>
  </p>

<input name="new_valid" id="new_valid" type="submit" value="Valider" />

<p>Liste actuel :</p>
<table>
	<tr>
		<th>Nom</th>
		<th>Section</th>
	</tr>
	<?php
	$sql = "SELECT type_boutique.nom AS type_nom, 
		section_boutique.nom AS section_nom
	FROM section_boutique INNER JOIN type_boutique ON section_boutique.id = type_boutique.section_id";
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$resultats = mysql_query($sql);
	while($type = mysql_fetch_array($resultats)) {
		echo '<tr><td>'.$type['type_nom'].'</td>
		<td>'.$type['section_nom'].'</td>
		</tr>';
	}
	?>
</table>
</form>
</body>
</html>
