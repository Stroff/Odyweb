<?php
// Setup class
include 'config/config.php';
require_once('include/php/paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = $url_paypal;   // testing paypal url

if ($p->validate_ipn()) {

	$connexion = mysql_connect($host_site, $user_site , $pass_site);
	mysql_select_db($site_database ,$connexion);
	mysql_query("SET NAMES 'utf8'");
	$resultat  = mysql_query("SELECT valeur FROM configuration WHERE nom='cout_point_par_paypal' OR nom='pp_par_achat'");
	$cout_point_par_paypal = mysql_fetch_array($resultat);
	$cout_point_par_paypal = $cout_point_par_paypal[0];

	$pp_par_achat = mysql_fetch_array($resultat);
	$pp_par_achat = $pp_par_achat[0];


	$compte_id_paiement = $p->ipn_data['custom'];
	$montant = $p->ipn_data['mc_gross'];
	$quantite = $p->ipn_data['quantity'];

	if ($montant/$quantite == $cout_point_par_paypal && $p->ipn_data['receiver_email'] == $adresse_paypal) {
		$nombredepointsenplus = $quantite * 2; 
		$nombredeppenplus = $quantite * $pp_par_achat; 
	} else { 
		$nombredepointsenplus = 0; 
		$nombredeppenplus = 0;
	}
	$resultat  = mysql_query("UPDATE accounts2 SET points=points+".$nombredepointsenplus.", pp=pp+".$nombredeppenplus." WHERE id='".$compte_id_paiement."' LIMIT 1") or die(mysql_error());
	$log = mysql_query("INSERT INTO logs_achat_points (account_id, type,nombre_points,date) VALUES ($compte_id_paiement, 'paypal',$nombredepointsenplus,NOW())");
} 
?>