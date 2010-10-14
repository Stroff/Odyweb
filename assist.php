<?php 
$secure_lvl = 1;
$header_titre = "Assistance";
require "include/template/header_cadres.php"  ?>

        	<div class="encadrepage-haut">
            	<div class="encadrepage-titre">
                        <br/>
                        <br/>
           	            <img src="medias/images/titre/serveur.gif" >                    
            	</div>
            </div>
            	<div class="blocpage">
                	<div class="blocpage-haut">
                    </div>
                    <div class="blocpage-bas">
                    	<div class="blocpage-texte">
                            <form id="choixsection" name="form1" method="post" action="">

<p align="center"><img src="medias/images/assistance.jpg" alt="Assistance Odyssee"/> <br/><br/><br/> Bienvenue dans l'assistance d'Odyssée serveur.
                        	Choisissez la section appropriée au problème que vous rencontrez: <br/><br/>
                        	  <label>
                        	  J'ai un souci <select name="section" id="section">
								<?php
								if(isset($_POST['section']) && $_POST['section'] ==1){
									echo '<OPTION VALUE="1" selected=selected>avec ma récupération</OPTION>';
								}else{
									echo '<OPTION VALUE="1">avec ma récupération</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==2){
									echo '<OPTION VALUE="2" selected=selected>avec mon login / email</OPTION>';
								}else{
									echo '<OPTION VALUE="2">avec mon login / email</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==3){
									echo '<OPTION VALUE="3" selected=selected>avec mon personnage</OPTION>';
								}else{
									echo '<OPTION VALUE="3">avec mon personnage</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==4){
									echo '<OPTION VALUE="4" selected=selected>avec mon installation</OPTION>';
								}else{
									echo '<OPTION VALUE="4">avec mon installation</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==5){
									echo '<OPTION VALUE="5" selected=selected>avec le forum</OPTION>';
								}else{
									echo '<OPTION VALUE="5" >avec le forum</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==6){
									echo '<OPTION VALUE="6" selected=selected>avec la boutique</OPTION>';
								}else{
									echo '<OPTION VALUE="6">avec la boutique</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==7){
									echo '<OPTION VALUE="7" selected=selected>avec le site</OPTION>';
								}else{
									echo '<OPTION VALUE="7">avec le site</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==8){
									echo '<OPTION VALUE="8" selected=selected>avec le report de bugs</OPTION>';
								}else{
									echo '<OPTION VALUE="8">avec le report de bugs</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==9){
									echo '<OPTION VALUE="9" selected=selected>avec teamspeak ou mumble</OPTION>';
								}else{
									echo '<OPTION VALUE="9">avec teamspeak ou mumble</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==10){
									echo '<OPTION VALUE="10" selected=selected>avec l\'armurerie</OPTION>';
								}else{
									echo '<OPTION VALUE="10">avec l\'armurerie</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==11){
									echo '<OPTION VALUE="11" selected=selected>avec le chat (shoutbox)</OPTION>';
								}else{
									echo '<OPTION VALUE="11">avec le chat (shoutbox)</OPTION>';
								}
								if(isset($_POST['section']) && $_POST['section'] ==12){
									echo '<OPTION VALUE="12" selected=selected>avec le formulaire de support</OPTION>';
								}else{
									echo '<OPTION VALUE="12">avec le formulaire de support</OPTION>';
								}
								?>
                                            
                                            
                                            
                                            
                      	      </select>                            
                      	    </label>
                            <input type="submit" value="OK" > </input>
                              </p>
                              <br/> <br/>
                      	  </form>
                          <?php if ($_POST["section"]) 
						  	{
								switch ($_POST["section"])
								{
									case 1:
										require "faqs/faq_recup.php";
										break;
									case 2:
										require "faqs/faq_compte.php";
										break;
									case 3:
										require "faqs/faq_ig.php";
										break;
									case 4:
										require "faqs/faq_install.php";
										break;
									case 5:
										require "faqs/faq_forum.php";
										break;
									case 6:
										require "faqs/faq_boutique.php";
										break;
									case 7:
										require "faqs/faq_site.php";
										break;
									case 8:
										require "faqs/faq_bugtracker.php";
										break;
									case 9:
										require "faqs/faq_tsmumble.php";
										break;
									case 10:
										require "faqs/faq_armory.php";
										break;
									case 11:
										require "faqs/faq_shoutbox.php";
										break;
									case 12:
										require "faqs/faq_support.php";
										break;
								}
							}
						?>
                        </div>
                    </div>
             </div>
            <div class="encadrepage-bas">
            </div> 
            
<?php require "include/template/footer_cadres.php"?>
