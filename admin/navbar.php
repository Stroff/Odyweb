
<script>
sfHover = function() {
   var sfEls = document.getElementById("navbar").getElementsByTagName("li");
   for (var i=0; i<sfEls.length; i++) {
      sfEls[i].onmouseover=function() {
         this.className+=" hover";
      }
      sfEls[i].onmouseout=function() {
         this.className=this.className.replace(new RegExp(" hover\\b"), "");
      }
   }
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
</script>
<link href="admin.css" rel="stylesheet" type="text/css" />
<div style="float:left; width:100%; background:url(images/banniereleft.jpg) no-repeat; height:250px;">
<div style="width:65%; float:left;">

<br/>
<table cellpadding="0" cellspacing="0" width="95%" style="margin-left:150px; margin-top:110px;">
	<tr>
    	<td>
        <?php 
		$ouverte = "select * FROM site.demandes_recups WHERE etat_ouverture = 1 OR etat_ouverture = 12";
		$nbrecup =  mysql_query($ouverte);
         echo '<div class="infos"><a href="liste_recup.php">Récupérations ouvertes: '.mysql_num_rows($nbrecup).'</a></div> </p>'; 
         
        ?>
        </td>
        <td>
        <?php
		
	
		$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
		mysql_select_db($wow_characters ,$connexion);
		$enligne = "SELECT DISTINCT t.guid, c.online FROM gm_tickets AS t LEFT JOIN characters AS c ON (c.guid = t.playerGuid)   WHERE t.closed = 0 AND c.online=1";
		$nb =  mysql_query($enligne);
         echo '<div class="infos"><a href="liste_tickets.php">Tickets en ligne: '.mysql_num_rows($nb).'</a></div> '; 
		$connexion = mysql_close($host_wow, $user_wow , $pass_wow);
		 ?>
        
        </td>
       
    </tr>
</table>
<br/>

  <ul id="navbar">
   
         <li><a href="<?=$url?>">Support Hors jeu</a>
         </li>
         <li><a href="#">Recups</a>
            <ul>
               <li> <a href="liste_recup.php">Liste des recups ouvertes</a></li>
               <li> <a href="liste_recup.php?demandes=toutes">Liste de toutes les recups</a> </li>
               <li> <a href="liste_demandes_guildes.php">Liste des demandes de guilde</a> </li>
           </ul>
         </li>
         <li> <a href="#">Logs divers</a>
 	        <ul><li> <a href="logs_renames.php">Logs renames</a></li>
            <?php
				if($_SESSION['gm']==5 || $_SESSION['gm']==6){
				 echo "<li>  <a href=\"gm_logs.php\">Logs MJ</a></li>"; } ?>
            <li> <a href="ip_tool.php"> Recherche d'ip</a> </li>
			<li> <a href="liste_bans.php">Logs bans</a></li></ul>            
         </li>
         <li><a href="#">Boutique</a>
            <ul>
               <li><a href="logs_achats_boutique.php">Liste des achats d'objets boutique</a></li><li>
               <a href="logs_achats_points.php">Liste des achats de points</a></li><li>
                <a href="ajout_categorie.php">Ajout d'une catégorie</a> </li><li>
               <a href="ajout_type.php">Ajout d'un type</a></li>
              <li><a href="ajout_item.php">Ajout d'un item</a></li>
           </ul>        
         </li>
         
         <li> <a href="liste_tickets.php">Tickets IG</a> </li>
         
          <?php
				if($_SESSION['gm']==5 || $_SESSION['gm']==6 || $_SESSION['gm']==4) {
				 echo " <li> <a href=\"pma/\">Base de données</a></li>";} ?>

</ul>
</div>

 <div class="search-box">
 		  <form method="post" action="pinfo.php">
    	Recherche du nom de compte, de perso ou du guid dans les persos:  
        <input type="text" name="filtre" value="" size="15" />
        <input type="submit" name="Recherche" />       	
    </form>
         <form method="post" action="liste_recup.php">
   	   Recherche de nom de compte / perso dans toutes les recup: <br/>
 <input type="text" name="termes" value="" size="15" />
        <input type="submit" name="Recherche" />       	
    </form>
<form method="post" action="logs_achats_boutique.php">
        recherche de nom de compte/ perso dans les logs boutique:  <br/>
        <input type="text" name="logsearch" value="" size="15" />
        <input type="submit" name="Recherche" />
        	
        </form>
		<form method="post" action="liste_bans.php">
		        recherche de nom de compte/ nom de mj/ip dans les bans:  <br/>
		        <input type="text" name="termes" value="" size="15" />
		        <input type="submit" name="Recherche" />
		        </form>
				<?php
				if($_SESSION['gm']==5 || $_SESSION['gm']==6){
				 echo "<br/><form method='post' action='liste_comptes.php'>
					        recherche de compte pour modif Pody:  <br/>
					        <input type='text' name='termes' value=''' size='15' />
					        <input type='submit' name='Recherche' />
					        </form>
				    ";
				}
				?>
        </div>
        </div>
<br/> 
<br/> <br/> 

        
</div>        
