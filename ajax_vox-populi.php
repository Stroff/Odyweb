<?php
$secure_lvl = 1;
include "secure.php";

// connexion pour faire les mysql_escape_string
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
	
$bug_id = mysql_escape_string ($_POST ["bug"]);
$id_compte = mysql_escape_string ($_SESSION['id']);
	
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");

$nbr_votes = mysql_query("SELECT * FROM accounts_votes_bug WHERE id_issue = $bug_id AND id_compte = $id_compte");
if (mysql_num_rows($nbr_votes) == 0){
	mysql_query("INSERT INTO accounts_votes_bug SET id_issue = $bug_id, id_compte = $id_compte, date_vote = NOW()");

	mysql_select_db($redmine_database ,$connexion);
	mysql_query("UPDATE issues SET vote_joueurs = vote_joueurs+1 WHERE id = $bug_id LIMIT 1");
	echo "<div id='success_page'>";
	echo "<p>Merci de votre vote !</p>";
	echo "</div>";
	echo '<div id="bottom_contenu"></div>';
} else {
	echo '<div class="error_message">Vous devez avez déjà voter pour ce bug.</div>';
}
?>