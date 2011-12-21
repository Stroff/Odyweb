<?php 
$secure_lvl = 0;
$header_titre = "Inscription";
require "lib/phpmailer/class.phpmailer.php";
require "include/template/header_cadres.php";
  ?>
<link rel="stylesheet" href="medias/css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" title="default" />
<!-- <script src="Scripts/jquery.js" type="text/javascript"></script -->
<script src="Scripts/jquery.validationEngine-fr.js" type="text/javascript"></script>
<script src="Scripts/jquery.validationEngine.js" type="text/javascript"></script>

<script type="text/javascript">
//Make sure the document is loaded
$(document).ready(function(){

	$("#form").validationEngine({
	inlineValidation: true,
	success :  true,
	failure : false
	})
 });
</script>
        	

        	<div class="encadrepage-haut">
            	<div class="encadrepage-titre">
                        <br/>
                        <br/>
           	            <img src="medias/images/titre/inscription.gif" >
                    
            	</div>
            </div>
            	<div class="blocpage">
                	<div class="blocpage-haut">
                    </div>
                    <div class="blocpage-bas">
                    	<div class="blocpage-texte">
					  Odyssee migre sur Heaven World, <a href="http://heavenworld.org/nous_rejoindre.php">inscrivez-vous ici </a><br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
