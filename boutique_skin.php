<?php
$secure_lvl=2;
require_once 'secure.php';

if($_SESSION['gm'] < 5){
 echo "<h1>juste pour les admins et resp, dsl</h1>";
 exit();
 }
?>

<?php 
$secure_lvl = 1;
$header_titre = "Changement d'apparence - Boutique";
require "include/template/header_cadres.php"; 
?>
<script type="text/javascript">
		$(document).ready(function() {
				$('#form').submit(function(){

						var action = $(this).attr('action');

						$("#message").slideUp(750,function() {
						$('#message').hide();

				 		$('#submit')
							.after('<img src="media/images/ajax-loader.gif" class="loader" />')
							.attr('disabled','disabled');

						$.post(action, { 
							perso: $('#perso').val(),
							type: 'changement_skin'
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
<h2>Changement d'apparence</h2>
<div id="message"></div>
<form method="post" action="ajax_boutique_skin.php" name="form" id="form">
<p>Vous pouvez changer l'apparence de votre perso</p>
<p>Je veux changer l'apparence de 
	<select name="perso" id="perso" class="">
		<option value="" selected>-- Mon perso--</option> 
		<?php
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$persos = mysql_query("SELECT name,guid,online,level,at_login FROM characters WHERE account = '".$compte_id."'");
		while ($perso = mysql_fetch_array($persos)) {
			if($perso['online']==0 && $perso['at_login']==0) {
				echo '<option value="'.$perso['guid'].'">'.$perso['name'].' ( '.$perso['level'].' )</option>';
			}else if ($perso['at_login']<>0){
				echo '<option value="">'.$perso['name'].' ( '.$perso['level'].' ) changement en attente</option>';
			} else {
				echo '<option value="">'.$perso['name'].' ( '.$perso['level'].' ) (en ligne)</option>';
			}
		}
		?>
	</select> contre 2 points
<input type="submit" class="submit" id="submit" value="Acheter"/>
</p>
					</div>
                </div>
            </div>
        <div class="encadrepage-bas">
        </div> 

<?php require "include/template/footer_cadres.php"?>




