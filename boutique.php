<?php
require_once 'secure.php';
?>
<?php 
$secure_lvl = 1;
$header_titre = "Liste de nos boutiques";
require "include/template/header_cadres.php"; 
?>

        	

        	<div class="encadrepage-haut">
            	<div class="encadrepage-titre">
                        <br/>
                        <br/>
           	            <img src="medias/images/titre/boutique.gif" >
                    
            	</div>
            </div>
                <br/>
                        <br/>
                    <p align="center">   <?php echo $compte_username.'</i>, vous avez <b>'.$compte_points.'</b> points Odyss&eacute;e' ?> &nbsp; &nbsp; &nbsp;    <a href="ajout_points.php"> <span style="font-weight:bold; color:red">Acheter des points</span> </a> </p>
                       	<br/>
                        <table cellpadding="0" cellspacing="0" width="80%" align="center">
                        <tr>
                        
							<td><a href="boutique_level.php"><img style = "border: 0px none ;" src="medias/images/boutique/level.jpg" /></a></td>
							<td><a href="boutique_po.php"><img style = "border: 0px none ;" src="medias/images/boutique/po.jpg" /></a></td>
							<td><a href="boutique_objets.php?section=Armes"><img style = "border: 0px none ;" src="medias/images/boutique/arme.jpg" /></a></td> </tr>
                         <tr>
							<td><a href="boutique_objets.php?section=Armures"><img style = "border: 0px none ;" src="medias/images/boutique/armor.jpg" /></a></td>
							<td><a href="boutique_objets.php?section=Compagnons"><img style = "border: 0px none ;" src="medias/images/boutique/compagnons.jpg" /></a></td>
							<td><a href="boutique_objets.php?section=Montures"><img style = "border: 0px none ;" src="medias/images/boutique/mont.jpg" /></a></td> </tr>
						<tr>
							<td><a href="boutique_rename.php"><img style = "border: 0px none ;margin-top:15px;" src="medias/images/boutique/rename.jpg" /></a></td>	
							<td><a href="boutique_objets.php?section=Fun"><img style = "border: 0px none ;" src="medias/images/boutique/fun.jpg" /></a></td>
                            <td><a href="boutique_level_metiers.php"><img style = "border: 0px none ;" src="medias/images/boutique/metiers.jpg" /></a></td>
						</tr>							                          
						<tr>
							<td><a href="boutique_skin.php"><img style = "border: 0px none ;" src="medias/images/boutique/skin.jpg" /></a></td>
<?php
if($_SESSION['gm'] >= 5){ ?>  							
							<td><a href="boutique_race.php"><img style = "border: 0px none ;" src="medias/images/boutique/race.jpg" /></a></td>
<?php } ?>													
						</tr>


						</table>
      	  <p align="center"><a href="account_boutique_logs.php" style = "">Historique de vos achats</a></p>

<br/> <br/> <br/> 				
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
