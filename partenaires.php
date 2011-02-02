<?php require "include/template/header_cadres.php"  ?>

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
<?php $connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($forum_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$timestamp_actuel = time();
//DEFINE('IN_IPB',true);
define('IPS_AREA',"other");
define('board_url',"http://forum.odyssee-serveur.com");
require_once( '/volume1/web/odyforum/upload/initdata.php' );
require_once( '/volume1/web/odyforum/upload/admin/sources/base/ipsRegistry.php' );
require_once( '/volume1/web/odyforum/upload/admin/sources/base/ipsController.php' );
require_once( '/volume1/web/odyforum/upload/admin/sources/handlers/han_parse_bbcode.php' );
$ipbRegistry = ipsRegistry::instance();
$ipbRegistry->init();
$parser = new parseBbcode( $ipbRegistry );
$parser->parse_html             = 1;
$parser->parse_nl2br            = 1;
$parser->parse_bbcode           = 1;
$parser->parse_smilies          = 1;

$messagesParPage=1; //Nous allons afficher 1 message par page.
//Une connexion SQL doit être ouverte avant cette ligne...
$post=mysql_query("SELECT * FROM forum.ibf_posts WHERE `pid` LIKE '75140';"); //Nous récupérons le contenu de la requête dans $post
$donnees=mysql_fetch_array($post);
	$post = $parser->preDisplayParse($donnees['post'] );
	$post = str_replace("style_emoticons/<#EMO_DIR#>", "style_emoticons/default", $post);
	echo $post;?>
						
                        	<br/> 	<br/> 	<br/> 
					   </div>
                    </div>
             </div>
            <div class="encadrepage-bas">
            </div> 
            
<?php require "include/template/footer_cadres.php"?>
