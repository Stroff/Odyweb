<?php 
$secure_lvl = 1;
$header_titre = "Achats de niveaux de métiers - Boutique";
require "include/template/header_cadres.php"; 
?>
<style type="text/css">
.response-msg {
font-size:0.9em;
margin:0 0 10px;
padding:6px 10px 10px 45px;
}
.response-msg span {
display:block;
font-weight:bold;
padding:0 0 4px;
}
.error {
-moz-background-clip:border;
-moz-background-inline-policy:continuous;
-moz-background-origin:padding;
background:#F9E5E6 url(images/icon-error.gif) no-repeat scroll 10px 50%;
border:1px solid #E8AAAD;
color:#B50007;
}
.success {
-moz-background-clip:border;
-moz-background-inline-policy:continuous;
-moz-background-origin:padding;
background:#E9F9E5 url(images/icon-confirm.gif) no-repeat scroll 10px 50%;
border:1px solid #B4E8AA;
color:#1C8400;
}
.ui-corner-all, .pagination li a, .pagination li, #tooltip, ul#dashboard-buttons li a, .fixed #sidebar {
-moz-border-radius-bottomleft:3px;
-moz-border-radius-bottomright:3px;
-moz-border-radius-topleft:3px;
-moz-border-radius-topright:3px;
}
</style>
<script type="text/javascript">
		$(document).ready(function() {
			$("#perso").change(function() {
				if ($("select#perso").val() == '' ) {
					return false;
				}
				var post_string = "valeur=" +  $("select#perso").val(); 
				post_string += "&type=liste_metiers";
					// Send the request and update sub category dropdown  
					$.ajax({  
						type: "POST",  
						data: post_string,  
						dataType: "json",  
						cache: false,  
						url: 'ajax_boutique_level_metiers.php',  
						timeout: 2000,  
						error: function() {  
							alert("Failed to submit");  
						},  
						success: function(data) {  
							$("select#metier option").remove();  
							if(data != null) {
								var row = "<option value=\"\" selected = selected> Choisir un metier </option>";  
								$(row).appendTo("select#metier");
								// Fill sub category select  
								$.each(data, function(i, j){  
									var row = "<option value=\"" +  j.id +  "\">" +  j.nom +  " (" +  j.value + "/" +  j.max + ")</option>";  
									$(row).appendTo("select#metier");  
								});	
							}		
						}
					});  
				});
				$("#metier").change(function() {
					if ($("select#metier").val() == '' || $("select#perso").val() == '') {
						return false;
					}
					var post_string = "valeur=" +  $("select#perso").val();
					post_string += "&valeur_metier="+  $("select#metier").val(); 
					post_string += "&type=level_prix";
						// Send the request and update sub category dropdown  
						$.ajax({  
							type: "POST",  
							data: post_string,  
							dataType: "json",  
							cache: false,  
							url: 'ajax_boutique_level_metiers.php',  
							timeout: 2000,  
							error: function() {  
								alert("Failed to submit");  
							},  
							success: function(data) { 
								$("#message").html("").removeClass('response-msg error ui-corner-all');
								$("#prix").html("");
								if(data.prix==-2){
									$("#message").html("Vous ne pouvez pas prendre plus de levels. Vous avez surement besoin d'aller voir le maitre de votre metier").addClass('response-msg error ui-corner-all').fadeTo(900,1);							
								}else if(data.prix == -1){
									$("#message").html("Vous ne pouvez pas dépassez le niveau 375 via boutique").addClass('response-msg error ui-corner-all').fadeTo(900,1);							
								}else {
									$("#prix").html(data.prix);
								}
							}
						});  
					});
				$('#form').submit(function(){

						var action = $(this).attr('action');

						$("#message").slideUp(750,function() {
						$('#message').hide();

				 		$('#submit')
							.after('<img src="medias/images/ajax-loader.gif" class="loader" />')
							.attr('disabled','disabled');

						$.post(action, { 
							valeur: $('#perso').val(),
							type: 'achat_level'
						},
							function(data){
								document.getElementById('message').innerHTML = data;
								$('#message').slideDown('slow');
								$('#form img.loader').fadeOut('slow',function(){$(this).remove()});
								$('#form #submit').attr('disabled',''); 
								if(data.match('success') != null) $('#form').slideUp('slow');

							}
						);
						});
						return false; 
				});
				
		});	
</script>
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
<h2>Achat de niveaux</h2>
<div id="message"></div>
<form method="post" action="ajax_boutique_level_metiers.php" name="form" id="form">
<p>Vous pouvez acheter des packs de 25 niveaux de métiers contre un certain nombre de points. Le nombre de points nécessaire dépend du niveau de votre métier actuel</p>
<p>Je veux donner à mon perso 
<select name="perso" id="perso" class="">
	<option value="" selected>-- Mon perso--</option> 
	<?php
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$persos = mysql_query("SELECT name,guid,online,level FROM characters WHERE account = '".$compte_id."'");
	while ($perso = mysql_fetch_array($persos)) {
		if($perso['online']==0) {
			echo '<option value="'.$perso['guid'].'">'.$perso['name'].' ( '.$perso['level'].' )</option>';
		} else {
			echo '<option value="">'.$perso['name'].' ( '.$perso['level'].' ) (en ligne)</option>';
			
		}
	}
	?>
</select> pour le metier 
<select name="metier" id="metier" class="">
</select>
25 niveaux en plus pour <span id="prix"></span> points 
<input type="submit" class="submit" id="submit" value="Acheter"/>
</p>
					</div>
                </div>
            </div>
        <div class="encadrepage-bas">
        </div> 

<?php require "include/template/footer_cadres.php"?>


