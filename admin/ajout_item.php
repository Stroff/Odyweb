<?php
$secure_lvl=2;
include '../secure.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="http://static.wowhead.com/widgets/power.js"></script>
<title>Ajout d'items en boutique</title>
</head>

<body>
<?php
include 'config/config.php';
	if (isset($_POST['id_item'])) {
		$nom_objet = mysql_escape_string($_POST['nom_item']);
		$sql = "INSERT INTO items_boutique SET id_objet = '".$_POST['id_item']."',id_objet_ig = '".$_POST['id_item_ig']."',prix = '".$_POST['prix_item']."',categorie_id = '".$_POST['categorie_item']."',type_id = '".$_POST['type_item']."',section_id = '".$_POST['section_item']."'
		,disponible = '1',nom = '".$nom_objet."'";
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		echo $sql;
		mysql_query($sql);
		if($sql) {
			echo "Ajout de l'item Ok";
		} else {
			echo 'Erreur dans l\'ajout';
		}
	}
?>
<form id="form1" name="form1" method="post" action="">
  <p>
    <label>Id de l'item (voir wowhead) :
      <input type="text" name="id_item" id="id_item" />
    </label>
  </p>
  <p>
    <label>Id de l'item (mm qu'au dessus, sauf monture, il faut 11 devant car monture spécial sans limit reput) :
      <input type="text" name="id_item_ig" id="id_item_ig" />
    </label>
  </p>
  <p>
    <label>Nom de l'item :
      <input type="text" name="nom_item" id="nom_item" />
    </label>
  </p>
  <p>
    <label>Prix :
      <input type="text" name="prix_item" id="prix_item" />
    </label>
  </p>
  <p>
    <label>Type d'item (tissu, épée deux mains...) :
      <select name="type_item" id="type_item">
		<option value=''>Rien</option>
	<?php
		include 'config/config.php';
		$sql = "SELECT nom,id FROM type_boutique";
		$connexion = mysql_connect($host_site, $user_site , $pass_site);
		mysql_select_db($site_database ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$resultats = mysql_query($sql);
		while($type = mysql_fetch_array($resultats)) {
			echo '<option value="'.$type['id'].'">'.$type['nom'].'</option>';
		}
	?>
      </select>
    </label>
  </p>
  <p>
    <label>Catégorie Item (Set T5, Hors Set T5, famillier...) :
      <select name="categorie_item" id="categorie_item">
		<option value=''>Rien</option>
		<?php
			$sql = "SELECT nom,id FROM categorie_boutique";
			$connexion = mysql_connect($host_site, $user_site , $pass_site);
			mysql_select_db($site_database ,$connexion);
			mysql_query("SET NAMES 'utf8'");
			$resultats = mysql_query($sql);
			while($categorie = mysql_fetch_array($resultats)) {
				echo '<option value="'.$categorie['id'].'">'.$categorie['nom'].'</option>';
			}
		?>
      </select>
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
  <p>
    <label>
      <input type="submit" name="Envoyé" id="Envoyé" value="Envoyer" />
    </label>
  </p>
<p>Je pense que le T2 pas besoin de recup il doit pas y avoir bcp de ventes.</p>
<p> Liste actuel :</p>
<table>
	<tr>
		<th>IdWowhead</th>
		<th>Nom</th>
		<th>Section</th>
		<th>Catégorie</th>
		<th>Type</th>
		<th>Prix</th>
		<th>Action</th>
	</tr>
	<?php
	$sql = "SELECT section_boutique.nom AS section_nom, 
		categorie_boutique.nom AS categorie_nom, 
		items_boutique.nom AS item_nom_objet, 
		items_boutique.prix AS item_prix, 
		type_boutique.nom AS item_nom, 
		items_boutique.id_objet AS item_iditem, 
		items_boutique.id AS item_id
	FROM categorie_boutique INNER JOIN items_boutique ON categorie_boutique.id = items_boutique.categorie_id
		 INNER JOIN section_boutique ON section_boutique.id = items_boutique.section_id
		 INNER JOIN type_boutique ON type_boutique.id = items_boutique.type_id";
	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$resultats = mysql_query($sql);
	while($type = mysql_fetch_array($resultats)) {
		echo '<tr>';
		echo '<td><a href="http://fr.wowhead.com/?item='.$type['item_iditem'].'">'.$type['item_iditem'].'</td>';
		echo '<td>'.$type['item_nom_objet'].'</td>';
		echo '<td>'.$type['section_nom'].'</td>';
		echo '<td>'.$type['categorie_nom'].'</td>';
		echo '<td>'.$type['type_nom'].'</td>';
		echo '<td>'.$type['item_prix'].'</td>';
		echo '<td><a href="delete_item.php?id='.$type['item_id'].'">delete</a></td>';
		echo'</tr>';
	}
	?>
</table>
</form>
</body>
</html>
