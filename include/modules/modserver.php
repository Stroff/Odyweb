        	<div class="uptimemod-haut">
            </div>
                  
           
            	<?php
				$connexion = mysql_connect($host_site, $user_site , $pass_site);
				mysql_select_db($site_database ,$connexion);
				mysql_query("SET NAMES 'utf8'");
				$resultat  = mysql_query("SELECT valeur FROM statistiques WHERE nom='uptime' OR nom='joueurs_online' OR nom='joueurs_online_horde' OR nom='joueurs_online_alliance'");
				$uptime = mysql_fetch_array($resultat);
				$uptime = $uptime[0];

				$joueurs_online = mysql_fetch_array($resultat);
				$joueurs_online = $joueurs_online[0];

				$joueurs_online_horde = mysql_fetch_array($resultat);
				$joueurs_online_horde = $joueurs_online_horde[0];

				$joueurs_online_alliance = mysql_fetch_array($resultat);
				$joueurs_online_alliance = $joueurs_online_alliance[0];

				// connexion pour faire les mysql_escape_string
				$joug_txt = "";
				$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
				mysql_select_db($wow_characters ,$connexion);
				mysql_query("SET NAMES 'utf8'");
				$resultat_joug  = mysql_query("SELECT * FROM worldstates where entry in (31002, 31001)");
				while($joug_result = mysql_fetch_array($resultat_joug)) {
					if($joug_result['entry']==31001){
						if($joug_result['value'] == 1)
							$joug_txt .= "Joug en cours, encore ";
					}
					if($joug_result['entry']==31002){
						$joug_txt .= timestamp_to_h_m_s_relative($joug_result['value']/1014);
					}
				}


				$bar_id = ceil($joueurs_online/1500*10)*10;
				?>
<br/>  <br/>
            <div class="uptimemod-infos" id="<?php echo 'infopop_'.$bar_id;?>">
            
            	<div class="nbjoueurs">
                <?php echo $joueurs_online; ?>/1500
                </div>
                <div class="nballyh2">
                <font color="#CC0000"><?php echo $joueurs_online_horde; ?> </font>
                &nbsp; &nbsp; &nbsp; &nbsp; 
                <font color="#68d0e5"> <?php echo $joueurs_online_alliance; ?></font>
                </div>
                <div class="uptimemod-realm">
               <br/>
                	set realmlist serveur.odywow.com <br/>
                    set patchlist odywow.com
                 
                </div>
                <span style="	font-size:80%;">
               <!-- <font style="font-weight:bold;">Uptime:</font> <?php // echo $uptime; ?>
                <br/>-->
                <font style="font-weight:bold;">Rates: </font>  XP = X4, Loot = X1, GOLD = X3
                <br/>
                <font style="font-weight:bold;">Version: </font>  3.3.5a
                <br/>
                <font style="font-weight:bold;">Prochain joug: </font> <?php echo $joug_txt; ?>
                <br/>   <br/>
            </span>
            </div>          
        	<div class="uptimemod-bas">
            	<a href="statistiques.php" title="Afficher toutes les statistiques du serveur Odyssée" longdesc="Afficher toutes les statistiques du serveur WOW privé Odyssée"/> <img src="medias/images/basmod.jpg" alt="Afficher toutes les statistiques du serveur Odyssée" longdesc="Afficher toutes les statistiques du serveur Odyssée" /></a>
       	    </div>            
  
          
  
