<?php
include '../config/config.php';
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
mysql_select_db('tdb' ,$connexion);
// suppression de l'ancienne quéte
mysql_query("DELETE FROM creature_questrelation WHERE id = 20735 and quest BETWEEN '0' and '30000';");

// une requéte parmis la liste
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24589');";
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24588');";
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24587');";
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24584');";
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24583');";
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24582');";
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24581');";
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24580');";
$req[] = "INSERT INTO `creature_questrelation` (`id`, `quest`) VALUES ('20735', '24579');";

$nombre =  rand (1, 9 );
mysql_query($req[$nombre]);
echo mysql_error();
mysql_close();
?>
