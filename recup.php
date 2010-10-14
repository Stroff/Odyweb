<?php 
$secure_lvl = 1;
$header_titre = "Demande de récupération";
include 'include/header.php'; 
?>

<div id="msgbox"></div>
<div id="content"><!-- Content starts here -->

<div id="leftPart"><!-- LeftPart starts here -->

<img src="images/banner01.jpg" alt="" />

<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<script src="js/jquery.validationEngine-fr.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>

<script type="text/javascript">
//Make sure the document is loaded
$(document).ready(function(){
	//Watch clicks on the add button
	$(":input[name='add']").click(function () { 
      $("div[id='file']:last").clone(true).insertAfter("div[id='file']:last");
	});
	
	$("#form").validationEngine({
	inlineValidation: false,
	success :  true,
	failure : false
	})
 });
</script>

<div class="contenu">
<h2>Récupération</h2>
<p>
Cette page comporte le formulaire de récupération de personnage. Les récupérations fonctionnent, que votre personnage vienne d'un serveur officiel ou d'un serveur privé.
30 Points Parrainage (PP) seront débités de votre compte.</p>
<p style="color:#990000;">Pas de récupération depuis Odyssée Serveur vers Odyssée Serveur (pour un changement de faction entre autre)</p>

<p>Veuillez renseigner les champs de saisie suivants sans omettre un seul détail pour que votre récupération soit acceptée.Le lien pour l'armurerie reste facultatif</p>

<p>Si votre personnage vient d'un serveur officiel avec compte gelé ou non, ou bien d'un un serveur privé, les demandes en screenshots diffèrent. Merci de visiter <a href="http://forum.odyssee-serveur.com/index.php?showtopic=1845">cette page</a> pour en connaître les modalités.</p>
<?php
if($_SESSION['pp']<10 || 1==0) {
	$manque_groupe = 10-$_SESSION['pp'];
	$manque = 30-$_SESSION['pp'];
	echo '<p>Vous n\'avez pas assez de points parrainage pour avoir une récupération. il vous manque '.$manque_groupe.'pp pour une récupération de guilde/groupe. Pour une récupération individuel il vous manque '.$manque.'pp</p>';
} else {
?>
<form action="recup_traitement.php" method="post" enctype="multipart/form-data" name="form" id="form">
<div style="margin-left:20px;">
	<br />
    <label style="width: 215px;font-weight: normal;"> Nom du perso de la récup :</label>
    <input name="pseudo" type="text" id="pseudo" size="20" class="validate[required]" value="" /> <br />
	
	<br />
    <label style="width: 215px;font-weight: normal;"> Serveur d'origine :</label>
    <input name="serveur" type="text" id="serveur" size="20" class="validate[required]" size="4" value="" /><br />

	<br />
    <label style="width: 215px;font-weight: normal;"> Perso sur le serveur :</label>
    <SELECT name="guid_perso">
<?php
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
mysql_select_db($wow_characters ,$connexion);
mysql_query("SET NAMES 'utf8'");
$persos = mysql_query("SELECT name,guid FROM characters WHERE account = '".$compte_id."'");
while ($perso = mysql_fetch_array($persos)) {
	echo '<option value="'.$perso['guid'].'">'.$perso['name'].'</option>';
}
?>
	</select><br />


	<br />
    <label style="width: 215px;font-weight: normal;"> Race (personnage sur le serveur) :</label>
   		<SELECT name="race">
			<OPTION VALUE="1">Humain</OPTION>
			<OPTION VALUE="2">Orc</OPTION>
			<OPTION VALUE="3">Nain</OPTION>
			<OPTION VALUE="4">Elfe de la Nuit</OPTION>
			<OPTION VALUE="5">Mort Vivant</OPTION>
			<OPTION VALUE="6">Tauren</OPTION>
			<OPTION VALUE="7">Gnome</OPTION>
			<OPTION VALUE="8">Troll</OPTION>
			<OPTION VALUE="10">Elfe de Sang</OPTION>
			<OPTION VALUE="11">Draeneï</OPTION>
		</select><br />

	<br />
    <label style="width: 215px;font-weight: normal;"> Classe :</label>
    <SELECT name="classe">
		<OPTION VALUE="1">Guerrier</OPTION>
		<OPTION VALUE="2">Paladin</OPTION>
		<OPTION VALUE="3">Chasseur</OPTION>
		<OPTION VALUE="4">Voleur</OPTION>
		<OPTION VALUE="5">Prêtre</OPTION>
		<OPTION VALUE="6">Chevalier de la Mort</OPTION>
		<OPTION VALUE="7">Chaman</OPTION>
		<OPTION VALUE="8">Mage</OPTION>
		<OPTION VALUE="9">Démoniste</OPTION>
		<OPTION VALUE="11">Druide</OPTION>
	</SELECT><br />

	<br />
    <label style="width: 215px;font-weight: normal;"> Niveau :</label>
    <input name="level" type="text" id="level" size="3" class="validate[required,custom[onlyNumber],length[0,2]]" value="" /><br />

	<br />
    <label style="width: 215px;font-weight: normal;"> Métier 1 et niveau :</label>
<select name="metier1">
    <OPTION VALUE="0">Aucun</OPTION>
		<OPTION VALUE="51304">Alchimiste</OPTION>
		<OPTION VALUE="51309">Couture</OPTION>
		<OPTION VALUE="50305">Dépeceur</OPTION>
		<OPTION VALUE="51313">Enchanteur</OPTION>
		<OPTION VALUE="51300">Forge</OPTION>
		<OPTION VALUE="50300">Herboriste</OPTION>
		<OPTION VALUE="51306">Ingénieur</OPTION>
		<OPTION VALUE="51311">Joaillier</OPTION>
		<OPTION VALUE="50310">Mineur </OPTION>
		<OPTION VALUE="51302">Travail du cuir</OPTION>
		<OPTION VALUE="45363">Calligraphie</OPTION>
		</SELECT>
		<input name="lvl_metier1" type="text" id="lvl_metier1" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" value="" />/450<br />
		
		<br />
	    <label style="width: 215px;font-weight: normal;"> Métier 2 et niveau :</label>
		<select name="metier2">
		    <OPTION VALUE="0">Aucun</OPTION>
				<OPTION VALUE="51304">Alchimiste</OPTION>
				<OPTION VALUE="51309">Couture</OPTION>
				<OPTION VALUE="50305">Dépeceur</OPTION>
				<OPTION VALUE="51313">Enchanteur</OPTION>
				<OPTION VALUE="51300">Forge</OPTION>
				<OPTION VALUE="50300">Herboriste</OPTION>
				<OPTION VALUE="51306">Ingénieur</OPTION>
				<OPTION VALUE="51311">Joaillier</OPTION>
				<OPTION VALUE="50310">Mineur </OPTION>
				<OPTION VALUE="51302">Travail du cuir</OPTION>
				<OPTION VALUE="45363">Calligraphie</OPTION>
				</SELECT>
				<input name="lvl_metier2" type="text" id="lvl_metier2" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" size="4" value="" />/450<br />
	<br />
    <label style="width: 215px;font-weight: normal;"> Métier secondaire 1 et niveau :</label>
    <SELECT name="metier_secondaire1">
		<OPTION VALUE="0">Aucun</OPTION>
		<OPTION VALUE="51296">Cuisine</OPTION>
		<OPTION VALUE="51294">Pêche</OPTION>
		<OPTION VALUE="45542">Secourisme</OPTION> 
	</select>
		<input name="lvl_metier_secondaire1" type="text" id="lvl_metier_secondaire1" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" size="4" value="" />/450<br /><br />

	<br />
    <label style="width: 215px;font-weight: normal;"> Métier secondaire 2 et niveau :</label>
    <SELECT name="metier_secondaire2">
		<OPTION VALUE="0">Aucun</OPTION>
		<OPTION VALUE="51296">Cuisine</OPTION>
		<OPTION VALUE="51294">Pêche</OPTION>
		<OPTION VALUE="45542">Secourisme</OPTION> 
	</select>
		<input name="lvl_metier_secondaire2" type="text" id="lvl_metier_secondaire2" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" size="4" value="" />/450<br /><br />

	<br />
    <label style="width: 215px;font-weight: normal;"> Métier secondaire 3 et niveau :</label>
    <SELECT name="metier_secondaire3">
		<OPTION VALUE="0">Aucun</OPTION>
		<OPTION VALUE="51296">Cuisine</OPTION>
		<OPTION VALUE="51294">Pêche</OPTION>
		<OPTION VALUE="45542">Secourisme</OPTION> 
	</select>
		<input name="lvl_metier_secondaire3" type="text" id="lvl_metier_secondaire3" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" size="4" value="" />/450<br /><br />
	<br />
    <label style="width: 215px;font-weight: normal;"> Niveau de monture :</label>
    <SELECT name="lvl_mount">
		<OPTION VALUE="0">0</OPTION>
		<OPTION VALUE="75">75</OPTION>
		<OPTION VALUE="150">150</OPTION>
		<OPTION VALUE="225">225</OPTION>
		<OPTION VALUE="300">300</OPTION> 
	</select> /300<br /><br />
				
<br />
<p>Vous devez mettre des images de votre équipement (quelques items seulement), de vos métiers et montes, de votre temps de jeu (/played), ainsi que l'affichage de la sélection des personnages</p>
	<div id="file">
	<br />
    <label style="width: 215px;font-weight: normal;">Image : </label>
    <input type="file" name="file[]" id="file"/></div>
<input name="add" type="button" value="Une image en plus" /><br />
	<br />
	<label style="width: 215px;font-weight: normal;"> Armurerie (si existe) :</label>
	<input name="armurerie" type="text" id="armurerie" class="validate[optional]" size="20" value="" /><br />
	
	<br />
	<br />
	<!--<label style="width: 215px;font-weight: normal;"> Nom de guilde <span style="color:#990000;">(si recup de guilde)<span> :</label>-->
	<input name="guilde" type="hidden" id="guilde" class="validate[optional]" size="20" value="" /><br />


<br /><input style="margin-left: 213px;" type="submit" value="Envoyer" />
</form>
</div>
<?php } ?>
<div id="bottom_contenu"></div>
</div>
<?php include'include/footer.php'; ?>
