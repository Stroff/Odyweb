        	<div class="modnews-haut">
            </div>
            <!-- debut du bloc individuel pour les news -->
<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
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

$req="SELECT ibf_topics.title, 
	ibf_posts.post, 
	ibf_topics.posts, 	
	ibf_posts.author_name, 
	ibf_topics.starter_name,
	ibf_topics.start_date, 
	ibf_topics.forum_id, 
	ibf_topics.tid
FROM ibf_posts INNER JOIN ibf_topics ON ibf_posts.topic_id = ibf_topics.tid AND ibf_posts.pid = ibf_topics.topic_firstpost 
WHERE ibf_topics.forum_id = '8' OR ibf_topics.forum_id = '91' OR ibf_topics.forum_id= '92' OR ibf_topics.forum_id = '93' OR ibf_topics.forum_id = '24' ORDER BY ibf_topics.start_date DESC LIMIT 3";
$retour = mysql_query($req) or die (mysql_error()); 
while ($donnees = mysql_fetch_array($retour)) {
	$new = $parser->preDisplayParse($donnees['post'] );
	$new = str_replace("style_emoticons/<#EMO_DIR#>", "style_emoticons/default", $new);
?>
            	<div class="blocnews">
                <div class="blocnews-haut">
                </div>
                <div class="blocnews-bas">
                	
                <!-- ici le code pour la publication  -->
                <div class="blocnews-cadre">
			<?php
				$img_id = "catmodnews_comm";
				switch( $donnees['forum_id'] )
				{
					case 8 : // Comm
						$img_id = "catmodnews_comm";
						break ;
					case 91: // Dev
					case 92: // Ann tech
					case 93: // Mise a jour
						$img_id = "catmodnews_tech";
						break ;
					case 24: // Evenement
						$img_id = "catmodnews_events";
						break ;
				}
			?>
                	<div class="blocnews-img <?php echo $img_id;?>">
                    	<!-- insertion de l'image de categorie -->
                    </div>
                	<div class="blocnews-titre">
                    	<!-- insertion du titre de news -->
                    <?= $donnees["title"]?>
                    </div>
                    <div class="blocnews-texte">
                    	<!-- insertion du texte des news -->
					<?=$new?>
                   	<div class="blocnews-infos">
                    <a href="http://forum.odyssee-serveur.com/index.php?showtopic=<?php echo $donnees['tid']; ?>">Voir les commentaires (<?php echo $donnees['posts'];?>)</a>
                    </div>
               		</div>
       			</div>
			</div>
            </div>
<?php
}
?>
                
                <!-- fin du bloc individuel pour les news -->
                      <div class="news-lien">
            	<a href="news.php" title="Les news d'Oddyssée Serveur">Consultez toutes les news, c'est par ici!</a>
            </div>
            <div class="modnews-bas">
      
            </div>
        	
