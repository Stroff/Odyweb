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
            	<div class="blocpage">
                	<div class="blocpage-haut">
                    </div>
                    <div class="blocpage-bas">
                    	<div class="blocpage-texte">
                    <p align="center">   <?php echo $compte_username.'</i>, vous avez <b>'.$compte_points.'</b> points Odyss&eacute;e' ?> &nbsp; &nbsp; &nbsp;    <a href="ajout_points.php"> <span style="font-weight:bold; color:red">Acheter des points</span> </a> </p>
                       	<br/>
                        
							<a href="boutique_level.php"><img style = "padding-left: 80px;border: 0px none ;" src="medias/images/boutique_level.png" /></a>
							<a href="boutique_po.php"><img style = "padding-left: 80px;border: 0px none ;" src="medias/images/boutique_po.png" /></a>

							<a href="boutique_objets.php?section=Armes"><img style = "padding-left: 70px;border: 0px none ;" src="medias/images/boutique_arme.png" /></a>
							<a href="boutique_objets.php?section=Armures"><img style = "padding-left: 70px;border: 0px none ;" src="medias/images/boutique_armure.png" /></a>
							<a href="boutique_objets.php?section=Compagnons"><img style = "padding-left: 70px;border: 0px none ;" src="medias/images/boutique_compagnions.png" /></a>
							<a href="boutique_objets.php?section=Montures"><img style = "padding-left: 70px;border: 0px none ;" src="medias/images/boutique_montures.png" /></a>

							<a href="boutique_skin.php"><img style = "padding-left: 70px;border: 0px none ;" src="medias/images/boutique_skin.png" /></a>
							<a href="boutique_rename.php"><img style = "padding-left: 70px;border: 0px none ;margin-top:15px;" src="medias/images/boutique_rename.png" /></a>

							<p><a href="account_boutique_logs.php" style = "">Historique de vos achats</a></p>

<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
