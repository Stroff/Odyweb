<?php
	if(isset($_SESSION['id']))
	{
		//Connexion Base de donnée Reamld
		$co = mysql_connect($host_site, $user_site, $pass_site);
		mysql_select_db($site_database, $co);
		mysql_query("SET NAMES 'utf8'");

		//Recherche compte dans account_banned
		$search_acc_bann = mysql_query("SELECT * FROM realmd.account_banned WHERE id=".$_SESSION['id'].' AND FROM_UNIXTIME(unbandate) > NOW()');

		//Si le nombre de compte banni est different de 0 alors il est banni donc redirigé vers msg.php avec le msg numéro 1
		if(mysql_num_rows($search_acc_bann) != 0)
		{
			$recher_fetch = mysql_fetch_array($search_acc_bann);
			echo '<center>'.$recher_fetch["bannedby"].' vous a banni(e) depuis le <strong>'.date("d/m/Y à H:m",$recher_fetch["bandate"]).'</strong> jusqu\'au <strong>'.date("d/m/Y à H:m",$recher_fetch["unbandate"]).'</strong> !<br/>Raison : <strong>'.$recher_fetch["banreason"].'</strong><br/><br/>Accès : <a href="'.$url_forum.'">Forum</a></center>';
		}
	}	
?>
