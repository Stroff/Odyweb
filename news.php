<?php require "include/template/header_cadres.php";
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

$messagesParPage=5; //Nous allons afficher 5 messages par page.

//Une connexion SQL doit être ouverte avant cette ligne...
$retour_total=mysql_query("SELECT COUNT(*) AS total FROM ibf_posts INNER JOIN ibf_topics ON ibf_posts.topic_id = ibf_topics.tid AND ibf_posts.pid = ibf_topics.topic_firstpost 
WHERE ibf_topics.forum_id = '8' OR ibf_topics.forum_id = '91' OR ibf_topics.forum_id= '92' OR ibf_topics.forum_id = '93' OR ibf_topics.forum_id = '24' ORDER BY ibf_topics.start_date"); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total=mysql_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.

//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$messagesParPage);

if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
     $pageActuelle=intval($_GET['page']);
     
     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
     {
          $pageActuelle=$nombreDePages;
     }
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1    
}
$premiereEntree=($pageActuelle-1)*$messagesParPage;

$news = mysql_query("SELECT ibf_topics.title, 
	ibf_posts.post, 
	ibf_topics.posts, 	
	ibf_posts.author_name, 
	ibf_topics.starter_name,
	ibf_topics.start_date, 
	ibf_topics.forum_id, 
	ibf_topics.tid
FROM ibf_posts INNER JOIN ibf_topics ON ibf_posts.topic_id = ibf_topics.tid AND ibf_posts.pid = ibf_topics.topic_firstpost 
WHERE ibf_topics.forum_id = '8' OR ibf_topics.forum_id = '91' OR ibf_topics.forum_id= '92' OR ibf_topics.forum_id = '93' OR ibf_topics.forum_id = '24' ORDER BY ibf_topics.start_date DESC LIMIT ".$premiereEntree.", ".$messagesParPage."");
?>

        	

        	<div class="encadrepage-haut">
            	<div class="encadrepage-titre">
                        <br/>
                        <br/>
           	            <img src="medias/images/titre/news.gif" >
                    
            	</div>                
            </div>
           
            <div class="pagenews-filtres">
             <!--	<div class="pagenews-search">
                	<form method="post" action="include/php/recup_traitement.php" name="newsfiltres">
                    	<input type="text" name="searchnews-text" />
                        </input>
                        <input type="submit" value="Rechercher" name="searchnews-button"/>
                        </input>
                    </form>
                </div>
                <div class="pagenews-select">
                    	<select name="filter">
                        		<OPTION VALUE="1">Choisissez une catégorie</OPTION>
                                <OPTION VALUE="2">Technique</OPTION>
								<OPTION VALUE="2">Events</OPTION>
								<OPTION VALUE="3">Communauté</OPTION>
								<OPTION VALUE="4">Boutique</OPTION>
                        </select>                  
                    </form>
                </div> -->
            </div>
<?php while ($donnees=mysql_fetch_array($news)) {
	$new = $parser->preDisplayParse($donnees['post'] );
	$new = str_replace("style_emoticons/<#EMO_DIR#>", "style_emoticons/default", $new);
	
	switch( $donnees['forum_id'] )
	{
		case 8 : // Comm
			$img_id = "cat-communaute";
			break ;
		case 91: // Dev
		case 92: // Ann tech
		case 93: // Mise a jour
			$img_id = "cat-tech";
			break ;
		case 24: // Evenement
			$img_id = "cat-events";
			break ;
	}
	?>                    	
                <div class="pagenews">
                	<div class="pagenews-haut">
                    </div>
                    	<div class="pagenews-titre <?=$img_id?>">
                            <br/>
                           &nbsp; &nbsp;&nbsp; <strong> <?=date('d-m-Y', $donnees['start_date']);?></strong> &nbsp; - &nbsp;  <?= $donnees["title"]?>
                        </div>
                        <div class="pagenews-texte">
							<?=$new?>
					  </div>
                    <div class="pagenews-bas">
                    	
                  </div>
                </div>

                 <div class="spacer">
                  </div>      
<?php
}
echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
{
     //On va faire notre condition
     if($i==$pageActuelle) //Si il s'agit de la page actuelle...
     {
         echo ' [ '.$i.' ] '; 
     }	
     else //Sinon...
     {
          echo ' <a href="news.php?page='.$i.'">'.$i.'</a> ';
     }
}
echo '</p>';
?>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
