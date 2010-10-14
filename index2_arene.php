<?php 
$header_titre = "Accueil";
$secure_lvl = 0; 
require "include/template/header_light.php";
?>

     
    <div class="page">
    <div class="leftcolumn">
  		<div class="flashbanner" name="flash">
        	<?php require "include/modules/flashbanner.php"  ?>
        </div>   	

    	<div class="modnews">
			<?php require "include/modules/modnews.php"  ?>
        </div>
        
    </div>
 
    <div class="rightcolumn">
         
    	<?php require "include/modules/modgoule.php"  ?>
 		<div class="modserv">
                <div class="modrecup">
           <?php require "include/modules/modrecup.php"; ?>                 
 		</div>
    

     <div class="uptimemod">
			<?php require "include/modules/modserver.php"  ?>
			<!--contient  uptime, realm goule et vote -->        
        </div>


         </div>
        
    <div class="mainmenu">
			<?php require "include/modules/mainmenu.php"  ?>


     </div>
     </div>
     <div class="rightcolumn">
           <div class="spacer"">
        </div>
    	<div class="modevents">
			<?php require "include/modules/modevents.php"  ?>
        </div>
  
        
        <div class="spacer">
        </div>
        <div class="modtwit" >
			<?php require "include/modules/modtwitter.php"  ?>
        </div>
                <div class="spacer">
        </div>

        <?php require "include/modules/modvideo.php"  ?>
        <div class="spacer">
        </div>
      
        <div class="modtoparene">
                     	<?php require "include/modules/modarene.php"  ?>
         </div>            
  <?php require "include/modules/modbestvote.php"  ?>
                       
        </div>
     </div>
<?php require "include/template/footer_light.php"?>
