<?php 
$secure_lvl = 1;
$header_titre = "Achats d'objets - Catégories - Boutique";
require "include/template/header_cadres.php"; 
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");

// je recup le nom de la section
if (isset($_GET ["section"])) {
	$section_nom= mysql_escape_string ( $_GET ["section"]);
} else {
	$section_nom= 'Armes';
}

// recherche des catefories
if ($section_nom<>'Compagnons' && $section_nom<>'Fun') {
	$items_req = mysql_query("SELECT categorie_boutique.nom AS categorie_nom, 
		categorie_boutique.image AS categorie_image, 
		type_boutique.nom AS type_nom, 
		items_boutique.prix AS prix, 
		items_boutique.nom AS nom, 
		items_boutique.id_objet AS id_objet, 
		items_boutique.id AS id, 
		section_boutique.nom AS section_nom
	FROM items_boutique INNER JOIN categorie_boutique ON items_boutique.categorie_id = categorie_boutique.id
		 INNER JOIN type_boutique ON items_boutique.type_id = type_boutique.id
		 INNER JOIN section_boutique ON section_boutique.id = items_boutique.section_id WHERE section_boutique.nom = '$section_nom' AND items_boutique.disponible=1");
}else {
	exit();
}
?>
<div id="msgbox"></div>
<div class="encadrepage-haut">
	<div class="encadrepage-titre">
            <br/>
            <br/>
            <img src="medias/images/titre/boutique.gif" >
        
	</div>
</div>
	<div class="blocpage">
    	<div class="blocpage-haut">
        </div>
        <div class="blocpage-bas">
        	<div class="blocpage-texte">
<h2>Boutique <?php echo $section_nom; ?></h2>
<p>Vous pouvez acheter des objets pour vos personnages ici</p>
<?php
$categories = array(); 
while( $item = mysql_fetch_array($items_req)){
	if(!isset($categories[$item['categorie_nom']])){
		$categories[$item['categorie_nom']]["image"] = $item['categorie_image'];
		$categories[$item['categorie_nom']]["nom"] = $item['categorie_nom'];
	}
}
echo '<table cellpadding="0" cellspacing="0" width="80%" align="center"><tr>';
$i=0;
foreach($categories as $categorie){
	if ($i % 3 == 0) 
		echo '</tr><tr>';
	//je fait l'affichage de mon image
	echo'<td><a href="boutique_objets.php?section='. $_GET ["section"].'&categorie='.$categorie['nom'].'"><img style = "border: 0px none ;" src="medias/images/boutique/'.$categorie['image'].'" /></a></td>';
	$i++;
}
?>
</table>
					</div>
                </div>
            </div>
        <div class="encadrepage-bas">
        </div> 

<?php require "include/template/footer_cadres.php"?>




