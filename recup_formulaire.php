<link rel="stylesheet" href="medias/css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" title="default" />
<!-- <script src="Scripts/jquery.js" type="text/javascript"></script -->
<script src="Scripts/jquery.validationEngine-fr.js" type="text/javascript"></script>
<script src="Scripts/jquery.validationEngine.js" type="text/javascript"></script>

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

<form action="recup_traitement.php" method="post" enctype="multipart/form-data" name="form" id="form">

<br/>
   <label class="form-fill"> Nom du perso de la récup :</label>
   <div class="form-fill2"> <input name="pseudo" type="text" id="pseudo" size="20" class="validate[required]" value="" /> </div> <br />
	
	
   <label class="form-fill"> Serveur d'origine :</label>
    <div class="form-fill2"> <input name="serveur" type="text" id="serveur" size="20" class="validate[required]" size="4" value="" /> </div> <br />


   <label class="form-fill"> Perso sur le serveur :</label>
    <div class="form-fill2">  <SELECT name="guid_perso"> 
		<?php
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$persos = mysql_query("SELECT name,guid FROM characters WHERE account = '".$compte_id."'");
		while ($perso = mysql_fetch_array($persos)) {
			echo '<option value="'.$perso['guid'].'">'.$perso['name'].'</option>';
		}
		?>
	</select></div> 


	<br />
   <label class="form-fill"> Race ( /!\ du personnage niveau 1 sur le serveur) :</label>
   	 <div class="form-fill2"> 	<SELECT name="race">
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
		</select> </div> 

	<br />
   <label class="form-fill"> Classe :</label>
    <div class="form-fill2">  <SELECT name="classe">
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
	</SELECT> </div> 

	<br />
   <label class="form-fill"> Niveau :</label>
    <div class="form-fill2">  <input name="level" type="text" id="level" size="3" class="validate[required,custom[onlyNumber],length[0,2]]" value="" /> </div> <br />


    <label class="form-fill"> Métier 1 et niveau :</label>
 <div class="form-fill2"> <select name="metier1">
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
		<input name="lvl_metier1" type="text" id="lvl_metier1" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" value="" />/450 </div> <br />

	    <label class="form-fill"> Métier 2 et niveau :</label>
		 <div class="form-fill2"> <select name="metier2">
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
				<input name="lvl_metier2" type="text" id="lvl_metier2" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" size="4" value="" />/450 </div> <br />

    <label class="form-fill"> Métier secondaire 1 et niveau :</label>
     <div class="form-fill2"> <SELECT name="metier_secondaire1">
		<OPTION VALUE="0">Aucun</OPTION>
		<OPTION VALUE="51296">Cuisine</OPTION>
		<OPTION VALUE="51294">Pêche</OPTION>
		<OPTION VALUE="45542">Secourisme</OPTION> 
	</select>
		<input name="lvl_metier_secondaire1" type="text" id="lvl_metier_secondaire1" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" size="4" value="" />/450 </div> <br />


    <label class="form-fill"> Métier secondaire 2 et niveau :</label>
     <div class="form-fill2"> <SELECT name="metier_secondaire2">
		<OPTION VALUE="0">Aucun</OPTION>
		<OPTION VALUE="51296">Cuisine</OPTION>
		<OPTION VALUE="51294">Pêche</OPTION>
		<OPTION VALUE="45542">Secourisme</OPTION> 
	</select>
		<input name="lvl_metier_secondaire2" type="text" id="lvl_metier_secondaire2" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" size="4" value="" />/450 </div> 

	<br />
    <label class="form-fill"> Métier secondaire 3 et niveau :</label>
    <div class="form-fill2"> <SELECT name="metier_secondaire3">
		<OPTION VALUE="0">Aucun</OPTION>
		<OPTION VALUE="51296">Cuisine</OPTION>
		<OPTION VALUE="51294">Pêche</OPTION>
		<OPTION VALUE="45542">Secourisme</OPTION> 
	</select>
		<input name="lvl_metier_secondaire3" type="text" id="lvl_metier_secondaire3" class="validate[optional,custom[onlyNumber],length[0,3]]" size="4" size="4" value="" />/450 </div> 
	<br />
    <label class="form-fill"> Niveau de monture :</label>
     <div class="form-fill2"> <SELECT name="lvl_mount">
		<OPTION VALUE="0">0</OPTION>
		<OPTION VALUE="75">75</OPTION>
		<OPTION VALUE="150">150</OPTION>
		<OPTION VALUE="225">225</OPTION>
		<OPTION VALUE="300">300</OPTION> 
	</select> /300  </div> 



				
<br /><br />
<p>Vous devez mettre des images de votre équipement (quelques items seulement), de vos métiers et montes, de votre temps de jeu (/played), ainsi que l'affichage de la sélection des personnages</p>
	<div id="file">
	<br />
    <label class="form-fill">Image : </label>
    <input type="file" name="file[]" id="file"/></div>
    <br/>
<input name="add" type="button" value="Une image en plus" /><br />

	<label class="form-fill"> Armurerie (si existe) :</label>
	<input name="armurerie" type="text" id="armurerie" class="validate[optional]" size="20" value="" /><br />

	<!--<label> Nom de guilde <span style="color:#990000;">(si recup de guilde)<span> :</label>-->
	<input name="guilde" type="hidden" id="guilde" class="validate[optional]" size="20" value="" />


<br /><input type="submit" value="Envoyer" />
</form>
<br/>

