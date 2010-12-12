		<?php
			include_once '../secure.php';
			include_once '../config/config.php';
 
			// J'ai mis ceci en condition mais vous pouvez très bien en faire un switch.. Enfin, c'est vous qui décidez ;)
		
			$msg = htmlspecialchars($_GET['msg']);

			if($msg == 1)
			{

				//Connexion Base de donnée Reamld
				$co = mysql_connect($host_site, $user_site, $pass_site);
				mysql_select_db($site_database, $co);
				mysql_query("SET NAMES 'utf8'");
			
				//Syntaxes de recherche SQL
				$sql = "SELECT * FROM `account_banned` WHERE id=".$_SESSION['id'];   
			
				//Recherche
				$recher = mysql_query($sql, $co);  
				$recher_fetch = mysql_fetch_array($recher);



				echo $recher_fetch["bannedby"].' vous a banni(e) depuis le <strong>'.date("d/m/Y à H:m",$recher_fetch["bandate"]).'</strong> jusqu\'au <strong>'.date("d/m/Y à H:m",$recher_fetch["unbandate"]).'</strong> !<br/>Raison : <strong>'.$recher_fetch["banreason"].'</strong>';
			}


		?>
