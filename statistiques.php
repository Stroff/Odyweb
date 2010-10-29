<?php require "include/template/header_cadres.php"  ?>
<script LANGUAGE="Javascript" SRC="Scripts/mootools.js"> </SCRIPT>
<script LANGUAGE="Javascript" SRC="Scripts/faqrecup.js"> </SCRIPT>
        	

        	<div class="encadrepage-haut">
            	<div class="encadrepage-titre">
                        <br/>
                        <br/>
           	            <img src="medias/images/titre/statistiques.gif" >
                    
            	</div>
            </div>
            	<div class="blocpage">
                	<div class="blocpage-haut">
                    </div>
                    <div class="blocpage-bas">
                    	<div class="blocpage-texte">
                    	  <p>&nbsp;</p>
           <a href=# id="titrefaq1">  <h2 class="hache1">Statistiques serveur:</h2></a>
		<div id="textefaq1">
			<p><?php require "statistiques_persos.php"  ?></p>	
        </div>
 			<a href=# id="titrefaq2">  <h2 class="hache1">Statistiques Votes:</h2></a>
			<div id="textefaq2">
				<p><?php require "statistiques_votes.php"  ?></p>
  		 	</div>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p> 
                    	</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
