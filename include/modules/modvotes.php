<div style="margin:10px;">

<?php 
$monfichier = fopen('compteur_clique/rpg', 'r');
$clics_fait = fgets($monfichier);
if(isset($_SESSION['login'])) {
	if (@$timestamp_actuel>=@$compte_next_vote) {
		echo '<a href="vote.php"><img src="medias/images/rpgp.jpg" style = "border:none;" alt="Votez pour odyssee serveur" /></a>';
		
	} else {
		echo '<img src="images/rpgp.jpg" style = "border:none;" alt="" />';
	}

}else {
	echo '<a href="redirection_clic.php?source=rpg"><img src="medias/images/rpgp.jpg" style = "border:none;" alt="Votez pour odyssee serveur" /></a>';
}
echo '<p style=" font-size:80%; font-weight:bold; text-align:center;"> &gt;&gt; Nombre de clics : 	<br/> <span>'.$clics_fait.'</span></p>';
if(isset($_SESSION['login'])) {
	if ($timestamp_actuel>=$timestamp_db) {
		echo '<p><a style="text-decoration:none; font-size:80%;" href="vote.php">Vous pouvez voter pour le serveur</a></p>';
	} else {
	
	echo'
	<p style=" font-size:80%; font-weight:bold; text-align:center">Prochain vote dans 	<br/>
<span id="textLayout"></span></p>	
	
	<script type="text/javascript" src="Scripts/jquery.countdown.min.js"></script>
	<script type="text/javascript" src="Scripts/jquery.countdown-fr.js"></script>


	<span style="float:right; font-size:80%;">
		<script type="text/javascript">
		$(document).ready(function() { 	
		var austDay = new Date();
		austDay =  mysqlTimeStampToDate("'.$compte_next_vote_date.'");
		
$(\'#textLayout\').countdown({until: austDay, layout: \'{hn}h, {mn}m et {sn}s\'});
    });
    
     function mysqlTimeStampToDate(timestamp) {
    var regex=/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/;
    var parts=timestamp.replace(regex,"$1 $2 $3 $4 $5 $6").split(\' \');
    return new Date(parts[0],parts[1]-1,parts[2],parts[3],parts[4],parts[5]);
  }
	</script>';
	
	}
}
?> <br/>
    <a href="http://www.facebook.com/odyssee.serveur"><img src="medias/images/facebook.jpg" alt="facebook Odyssee serveur"/></img></a>
</div>