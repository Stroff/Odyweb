<?php
$config="prod";
if($config=="dev_creatix"){
	$host_site="localhost";
	$user_site="ipbsite";
	$pass_site="eze13xsqx56zd44e42dsqdq";
	$site_database="site";
	$forum_database="forum";
	
	$host_wow="localhost";
	$user_wow="ipbsite";
	$pass_wow="eze13xsqx56zd44e42dsqdq";
	$wow_reamld="serveur";
	$wow_characters="characters";
	
}else if($config=="prod") {
	$host_site="188.165.223.35";
	$user_site="ipbsite";
	$pass_site="eze13xsqx56zd44e42dsqdq";
	$site_database="site";
	$forum_database="forum";
	
	$host_wow="serveur.odyssee-serveur.com";
	$user_wow="site";
	$pass_wow="errhkncsqd53535dzede";
	$wow_realmd="realmd";
	$wow_characters="characters";
	
	$url_site = 'http://odyssee-serveur.com';

	//paypal de test
//	$adresse_paypal = 'rnr_1248979681_biz@macuser.fr';
//	$url_paypal = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	
	//paypal de production
	$adresse_paypal = 'ludovicthomas1@hotmail.fr';
	$url_paypal = 'https://www.paypal.com/cgi-bin/webscr';
	
}


?>
