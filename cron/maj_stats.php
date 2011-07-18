<?php
include '../config/config.php';
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
mysql_select_db($wow_characters ,$connexion);
mysql_query("SET NAMES 'utf8'");//total des joueurs
$sql = mysql_query("SELECT race FROM characters.characters WHERE online=1");
$race = array (
	1 => 'Humain',
	2 => 'Orc',
	3 => 'Nain',
	4 => 'Elfe de la nuit',
	5 => 'Mort vivant',
	6 => 'Tauren',
	7 => 'Gnome',
	8 => 'Troll',
	9 => 'Gnome', 
	10 => 'Elfe de sang',
	11 => 'Draenei',
);
$race_ally = array (1, 3, 4, 7, 9, 11 );
$faction['Alliance']=0;
$faction['Horde']=0;
while($un_perso = mysql_fetch_array($sql)) {
	if (in_array ( $un_perso ['race'], $race_ally )) {
		$faction['Alliance'] = $faction['Alliance']+1;
	} else {
		$faction['Horde']=$faction['Horde']+1;
	}
}
$total_online= $faction['Horde']+$faction['Alliance'];
mysql_select_db('realmd' ,$connexion);
$uptime_query = mysql_query("SELECT * FROM realmd.`uptime` WHERE  realmid = 1 ORDER BY `starttime` DESC LIMIT 1", $connexion)or die(mysql_error()); 
$uptime_db= mysql_fetch_array($uptime_query); 
mysql_close();
$s = $uptime_db['starttime']-time();
//$s= '160287';
$d = ceil($s/86400);
$s -= $d*86400;
$h = ceil($s/3600);
$s -= $h*3600;
$m = ceil($s/60);
$s -= $m*60;
if ($d) $uptime = abs($d) . 'j ';
if ($h) $uptime .= abs($h) . 'h ';
if ($m) $uptime .= abs($m) . 'm ';
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
$sql = mysql_query("UPDATE site.statistiques SET valeur='".$uptime."' WHERE nom = 'uptime'");
$sql = mysql_query("UPDATE site.statistiques SET valeur='".$total_online."' WHERE nom = 'joueurs_online'");
$sql = mysql_query("UPDATE site.statistiques SET valeur='".$faction['Horde']."' WHERE nom = 'joueurs_online_horde'");
$sql = mysql_query("UPDATE site.statistiques SET valeur='".$faction['Alliance']."' WHERE nom = 'joueurs_online_alliance'");
mysql_close();
?>
