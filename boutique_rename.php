<?php
$secure_lvl = 1;
$header_titre = "Changement de nom - Boutique";
require "include/template/header_cadres.php"; 
?>
<script type="text/javascript">
		$(document).ready(function() {
				$('#form').submit(function(){

						var action = $(this).attr('action');
						
						$("#message").slideUp(750,function() {
						$('#message').hide();

				 		$('#submit')
							.after('<img src="medias/images/ajax-loader.gif" class="loader" />')
							.attr('disabled','disabled');

						$.post(action, { 
							perso: $('#perso').val(),
							type: 'changement_nom',
							oubli : $('#checkBox').attr('checked')
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
<h2>Changement de nom</h2>
<div id="message"></div>
<form method="post" action="ajax_boutique_rename.php" name="form" id="form">
<p>Vous pouvez changer le nom de votre perso. <br/> Attention le prix augmente de 2 points par changement de noms de persos.</p>
<p>Je veux changer le nom de 
	<select name="perso" id="perso" class="">
		<option value="" selected>-- Mon perso--</option> 
		<?php
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		mysql_query("SET NAMES 'utf8'");
		$persos = mysql_query("SELECT name,guid,online,level,at_login FROM characters WHERE account = '".$compte_id."'");
		while ($perso = mysql_fetch_array($persos)) {

			mysql_select_db($site_database ,$connexion);
			$nbrenames = mysql_query("SELECT COUNT(*) FROM log_rename WHERE guid = ".$perso['guid']);
			$countrenames = (int)mysql_result($nbrenames, 0);
			if ($countrenames < 4)
				{$prix_points = 2+$countrenames*2;}
			else
				  {$prix_points = 8;}

			if($perso['online']==0 && $perso['at_login']==0) {
				echo '<option value="'.$perso['guid'].'">'.$perso['name'].' ( '.$perso['level'].' ) '.$prix_points.' points </option>';
			}else if ($perso['at_login']<>0){
				echo '<option value="">'.$perso['name'].' ( '.$perso['level'].' ) changement en attente</option>';
			} else {
				echo '<option value="">'.$perso['name'].' ( '.$perso['level'].' ) (en ligne)</option>';
			}
		}
		?>
	</select>
<input type="submit" class="submit" id="submit" value="Acheter"/>
</p>
<p><input type="checkbox" id="checkBox"/>Cochez cette case pour que vous soyez supprimé des listes d'amis des autres joueurs</p>
					</div>
                </div>
            </div>
        <div class="encadrepage-bas">
        </div> 

<?php require "include/template/footer_cadres.php"?>


