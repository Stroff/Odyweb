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
$post=mysql_query("SELECT * FROM forum.ibf_posts WHERE `pid` LIKE '193749';"); //Nous récupérons le contenu de la requête dans $post
$donnees=mysql_fetch_array($post);
	$post = $parser->preDisplayParse($donnees['post'] );
	$post = str_replace("style_emoticons/<#EMO_DIR#>", "style_emoticons/default", $post);
	echo $post;?>