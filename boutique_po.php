<?php 
exit();
$secure_lvl = 1;
$header_titre = "Achats d'or - Boutique";
require "include/template/header_cadres.php"; 
?>
<script type="text/javascript">
		$(document).ready(function() {
			$("#po").change(function() {
				if ($("select#po").val() == '' ) {
					return false;
				}
				var post_string = "valeur=" +  $("select#po").val(); 
				post_string += "&type=prix_po";
					// Send the request and update sub category dropdown  
					$.ajax({  
						type: "POST",  
						data: post_string,  
						dataType: "json",  
						cache: false,  
						url: 'ajax_boutique_po.php',  
						timeout: 2000,  
						error: function() {  
							alert("Failed to submit");  
						},  
						success: function(data) {   
								$("#prix_points").html(data.prix_points );
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
							valeur: $('#po').val(),
							perso: $('#perso').val(),
							type: 'achat_po'
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
<h2>Achat de po</h2>
<div id="message"></div>
<?php //if ($compte_points>=1) {
	if ($compte_points>=1) { ?>
<form method="post" action="ajax_boutique_po.php" name="form" id="form">
<p>Vous pouvez acheter des po contre 1 point les 100po</p>
<p>Je veux 
<select name="po" id="po" class="">
	<option value="100" > 100 po</option> 
	<option value="200" > 200 po</option> 
	<option value="300" > 300 po</option> 
	<option value="400" > 400 po</option> 
	<option value="500" > 500 po</option> 
	<option value="1000" > 1 000 po</option> 
</select> contre <span id="prix_points">1</span> points pour 
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
			echo '<option value="'.$perso['guid'].'">'.$perso['name'].' (en ligne)</option>';
			
		}
	}
	?>
</select>
<input type="submit" class="submit" id="submit" value="Acheter"/>
</p>
<?php } else {
	echo "<p>Vous devez avoir 1 point au moins pour acheter des po.<p>";
} ?>
					</div>
                </div>
            </div>
        <div class="encadrepage-bas">
        </div> 

<?php require "include/template/footer_cadres.php"?>
