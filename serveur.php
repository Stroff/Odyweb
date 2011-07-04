<?php require "include/template/header_cadres.php"  ?>
<script LANGUAGE="Javascript" SRC="Scripts/mootools.js"> </SCRIPT>
<script LANGUAGE="Javascript" SRC="Scripts/faqrecup.js"> </SCRIPT>
       	

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
                    	  <h2 class="hache1">Infos générales</h2>
                    	  <p>Nom du serveur : <strong>Odyssée serveur Pve &amp; PvP en version 3.3.5</strong><br />
                            <br />
Le realmlist : set realmlist <strong>serveur.odyssee-serveur.com</strong></p>
                    	  <a href=# id="titrefaq1"><h2 class="hache1">Rates</h2></a>
			  <div id="textefaq1">
                    	  <p>Les Rates (les plus généraux seulement) : <strong>Rate.XP.Kill = 4 (Gain d'expérience en tuant x 4)<br />
                              <br />
Rate.XP.Quest = 4 (Gain d'expérience via les quêtes x 4)<br />
<br />
Rate.XP.Explore = 4 (Gain d'expérience via l'exploration x 4)<br />
<br />
Rate.Honor = 1 (Gain d'honneur x 1)<br />
<br />
Rate.Drop.Money = 3 (Gain d'or x 3)<br />
<br />
Rate.Drop.Item.Uncommon = 3 (Gain d'item vert x 3)<br />
<br />
Rate.Drop.Item.Rare = 2 (Gain d'item bleu x 2)<br />
<br />
Rate.Drop.Item.Epic = 1 (Gain d'item violet x 1)<br />
<br />
Rate.Drop.Item.Legendary = 1 (Gain d'item orange x 1)<br />
<br />
Rate.Reputation.Gain = 2 (Gain de réputation x 2)</strong><br />
                          </p></div>

<a href=# id="titrefaq2"><h2 class="hache1">Le PVP (Player Versus Player)</h2></a>
<div id="textefaq2">
                    	  <p>Le PvP :   -  Les arènes de WOTLK scriptées et disponibles : <strong>Les égouts de Dalaran</strong><br />
                            <br />
- Les champs de batailles scriptés et disponibles : <strong>Le Goulet des Chanteguerres<br />
Le bassin d'Arathi<br />
L'Oeil du Cyclone<br />
Le Rivage des anciens (en réparation)</strong><br />
<br />
- La bataille pour<strong> le Joug d'hiver</strong> est entièrement fonctionnelle.</p>
                    	  <p><br />
                  	    </p>
</div>

<a href=# id="titrefaq3"> <h2 class="hache1">Le PVE (Player Versus Environment)</h2></a>
<div id="textefaq3" align="center">
 	<?php $connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($forum_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$timestamp_actuel = time();
	//DEFINE('IN_IPB',true);
	define('IPS_AREA',"other");
	define('board_url',"http://forum.odyssee-serveur.com");
	require_once( '/var/www/board/upload/initdata.php' );
	require_once( '/var/www/board/upload/admin/sources/base/ipsRegistry.php' );
	require_once( '/var/www/board/upload/admin/sources/base/ipsController.php' );
	require_once( '/var/www/board/upload/admin/sources/handlers/han_parse_bbcode.php' );
	$ipbRegistry = ipsRegistry::instance();
	$ipbRegistry->init();
	$parser = new parseBbcode( $ipbRegistry );
	$parser->parse_html             = 1;
	$parser->parse_nl2br            = 1;
	$parser->parse_bbcode           = 1;
	$parser->parse_smilies          = 1;

	$messagesParPage=1; //Nous allons afficher 1 message par page.
	//Une connexion SQL doit être ouverte avant cette ligne...
	$post=mysql_query("SELECT * FROM forum.ibf_posts WHERE `pid` LIKE '212008';"); //Nous récupérons le contenu de la requête dans $post
	$donnees=mysql_fetch_array($post);
		$post = $parser->preDisplayParse($donnees['post'] );
		$post = str_replace("style_emoticons/<#EMO_DIR#>", "style_emoticons/default", $post);
		echo $post;?>
                          </div>
                        </div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
