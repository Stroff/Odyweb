<?php 
exit();
$secure_lvl = 1;
$header_titre = "Achats de niveaux - Boutique";
require "include/template/header_cadres.php"; 
?>
<script type="text/javascript">
		$(document).ready(function() {
			$("#perso").change(function() {
				if ($("select#perso").val() == '' ) {
					return false;
				}
				var post_string = "valeur=" +  $("select#perso").val(); 
				post_string += "&type=level";
					// Send the request and update sub category dropdown  
					$.ajax({  
						type: "POST",  
						data: post_string,  
						dataType: "json",  
						cache: false,  
						url: 'ajax_boutique_level.php',  
						timeout: 2000,  
						error: function() {  
							alert("Failed to submit");  
						},  
						success: function(data) {   
								$("#level_en_plus").html(data.level_en_plus );
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
<?php if ($compte_points>=2) { ?>
<form method="post" action="ajax_boutique_level.php" name="form" id="form">
<p>Vous pouvez acheter des niveaux contre 2 points. Le nombre de niveaux dépend du niveau de votre personnage</p>
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
</select> <span id="level_en_plus">0</span> niveaux 
<input type="submit" class="submit" id="submit" value="Acheter"/>
</p>
<?php } else {?>
	<p>Vous devez avoir 2 points au moins pour acheter des niveaux.<p>
<?php } ?>
<p>Prix par paliers :</p>
<table width="80%" align="center">
	<tr>
        <th>Niveaux</th>
        <th>Prix</th>
    </tr>
	<tr>
		<td>Entre le niveau 1 et le niveau 14 (inclus)</td>
		<td>7 niveaux</td>
	</tr>
	<tr>
		<td>Entre le niveau 15 et le niveau 27 (inclus)</td>
		<td>6 niveaux</td>
	</tr>
	<tr>
		<td>Entre le niveau 28 et le niveau 39 (inclus)</td>
		<td>5 niveaux</td>
	</tr>
	<tr>
		<td>Entre le niveau 40 et le niveau 50 (inclus)</td>
		<td>4 niveaux</td>
	</tr>
	<tr>
		<td>Entre le niveau 51 et le niveau 60 (inclus)</td>
		<td>3 niveaux</td>
	</tr>
	<tr>
		<td>Entre le niveau 61 et le niveau 68 (inclus)</td>
		<td>2 niveaux</td>
	</tr>
	<tr>
		<td>Niveau 69</td>
		<td>1 niveau</td>
	</tr>
</table>
<p>Pas de boutique pour des personnages au dessus du niveau 69.</p>
<br/> <br/>
					</div>
                </div>
            </div>
        <div class="encadrepage-bas">
        </div> 

<?php require "include/template/footer_cadres.php"?>


