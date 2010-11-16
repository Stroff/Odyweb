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
	$host_site="127.0.0.1";
	$user_site="root";
	$pass_site="hzwrdtw";
	$site_database="site";
	$forum_database="forum";
	
	$host_wow="127.0.0.1";
	$user_wow="root";
	$pass_wow="hzwrdtw";
	$wow_realmd="realmd";
	$wow_characters="characters";
	$wow_world="tdbprod";
	
	$url_site = 'http://localhost/odyweb/Odyweb/';
	$url_forum = 'http://localhost/forum/';

	//paypal de test
//	$adresse_paypal = 'rnr_1248979681_biz@macuser.fr';
//	$url_paypal = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	
	//paypal de production
	$api_tender_support_staff = "c2118f6696b955178907fc35989cdd7f8e38268e"; 
	
	$adresse_paypal = 'serveur.odyssee@gmail.com';
	$url_paypal = 'https://www.paypal.com/cgi-bin/webscr';
	
}


?>
