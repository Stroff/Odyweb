<?php 
$secure_lvl = 1;
$header_titre = "Déblocage de personnages";
require "include/template/header_cadres.php";
?>
<script type="text/javascript">
		$(document).ready(function() {
			$("#perso").change(function() {
				if ($("select#perso").val() == '' ) {
					return false;
				}
				var post_string = "valeur=" +  $("select#perso").val(); 
				post_string += "&type=persos";
					// Send the request and update sub category dropdown  
					$.ajax({  
						type: "POST",  
						data: post_string,  
						dataType: "json",  
						cache: false,  
						url: 'ajax_debloque.php',  
						timeout: 2000,  
						error: function() {  
							alert("Failed to submit");  
						},  
						success: function(data) {   
							// Clear all options from sub category select  
							$("select#destination option").remove();  

							// Fill sub category select  
							$.each(data, function(i, j){  
								var row = "<option value=\"" +  j.destination_id +  "\">" +  j.destination_nom +  "</option>";  
								$(row).appendTo("select#destination");  
							});
						}  
					});  
				});
				$('#form').submit(function(){

						var action = $(this).attr('action');

						$("#message").slideUp(750,function() {
						$('#message').hide();

				 		$('#submit')
							.after('<img src="images/ajax-loader.gif" class="loader" />')
							.attr('disabled','disabled');

						$.post(action, { 
							valeur: $('#perso').val(),
							destination_id: $('#destination').val(),
							type: 'debloque'

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
            <img src="medias/images/titre/serveur.gif" >
        
	</div>
</div>
	<div class="blocpage">
    	<div class="blocpage-haut">
        </div>
        <div class="blocpage-bas">
        	<div class="blocpage-texte">
<h2>Déblocage</h2>
<div id="message"></div>
<form method="post" action="ajax_debloque.php" name="form" id="form">
<p>Vous pouvez débloquer votre personnage facilement grâce à notre outil.</p>
<p>Je veux téléporter 
<select name="perso" id="perso" class="">
	<option value="" selected>-- Mon perso--</option> 
	<?php
	$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	mysql_select_db($wow_characters ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$persos = mysql_query("SELECT name,guid,online FROM characters WHERE account = '".$compte_id."'");
	while ($perso = mysql_fetch_array($persos)) {
		if($perso['online']==0) {
			echo '<option value="'.$perso['guid'].'">'.$perso['name'].'</option>';
		} else {
			echo '<option value="">'.$perso['name'].' (en ligne)</option>';
			
		}
	}
	?>
</select>
vers  	
<select name="destination" id="destination" class="">
	<option value="">-- Une destination --</option>
</select>
<input type="submit" class="submit" id="submit" value="Envoyé"/>
</p>

<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>



