<?php require "include/template/header_cadres.php"  ?>

        	

        	<div class="encadrepage-haut">
            	<div class="encadrepage-titre">
                        <br/>
                        <br/>
           	            <img src="medias/images/titre/recuperation.gif" >
                    
            	</div>
            </div>
            	<div class="blocpage">
                	<div class="blocpage-haut">
                    </div>
                    <div class="blocpage-bas">
                    	<div class="blocpage-texte">


                        <h2 class="hache1">Récupération</h2>
                        <div align="center">
                            Cette page comporte le formulaire de récupération de personnage. Les récupérations fonctionnent, que votre personnage vienne d'un serveur officiel ou d'un serveur privé. <br/><br/>
                            <div class="warning">Pas de récupération depuis Odyssée Serveur vers Odyssée Serveur (pour un changement de faction entre autre)</div><br/>
                            <a href="#faqrecup">Pour plus d’informations sur les conditions d’une récupération, cliquez ici.</a>
                            </div>
                            <div class="formulaires">
								<?php
								//check si le compte est bloqué au niveau des recups
								$check_blocage_compte=mysql_query("SELECT fin_blocage FROM accounts_blocage_recup WHERE id_compte='".$compte_id."' ORDER BY fin_blocage DESC LIMIT 1");
								if(mysql_num_rows($check_blocage_compte)>0) {
									$date_fin_blocage_compte = mysql_fetch_array($check_blocage_compte);
									echo '<p>Votre compte est bloqué a cause d\'un trop grande nombre de demandes de récupérations refusée. Il serra débloqué automatiquement le '.$date_fin_blocage_compte["fin_blocage"].'</p>';
								} else {
									require "recup_formulaire.php";
								} ?>
                            </div>
                            

<?php require "faqs/faq_recup.php"  ?>
<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
