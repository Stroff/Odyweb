<?php 
$secure_lvl = 1;
$header_titre = "Achat de points";
 require "include/template/header_cadres.php"; 
?>

<div id="msgbox"></div>
<div class="encadrepage-haut">
	<div class="encadrepage-titre">
            <br/>
            <br/>
            <img src="medias/images/titre/serveur.gif" >
        
	</div>
</div>
	<div class="blocpage">
    	<div class="blocpage-haut">
        </div>
        <div class="blocpage-bas">
        	<div class="blocpage-texte">
<?php
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$resultat  = mysql_query("SELECT valeur FROM configuration WHERE nom='points_par_allopass' OR nom='cout_point_par_paypal' OR nom='pp_par_achat'");
$points_par_allopass = mysql_fetch_array($resultat);
$points_par_allopass = $points_par_allopass[0];

$cout_point_par_paypal = mysql_fetch_array($resultat);
$cout_point_par_paypal = $cout_point_par_paypal[0];

$pp_par_achat = mysql_fetch_array($resultat);
$pp_par_achat = $pp_par_achat[0];
?>
<h2>Achat de points</h2>
<p>Vous pouvez acheter des points Odyssée pour quelques euros. Voici les différentes offres:</p>
<ul>- 1 Webopass pour <?php echo $points_par_allopass; ?> points (entre 1,80€ et 2,30€ pour un audiotel) pour le Magreb et DOM TOM.</ul>
<ul>- 1 Starpass pour <?php echo $points_par_allopass; ?> points (entre 1,80€ et 2,30€ pour un audiotel) pour la France.</ul>
<ul>- <?php echo $cout_point_par_paypal; ?>€ pour 2 points par paypal.</ul>

<h2>Magred, DOM-TOM</h2>
<p>Comme vous devez sûrement le savoir, il faut appeler le numéro indiqué, ou envoyer un SMS au numéro indiqué pour obtenir le code.
Chaque code n'est valable qu'une seule et unique fois.
<a href="#" onclick="window.open('http://payer.webopass.fr/affiche_drapeaux.php?cc=1837583066&document=2382807247&no_saisie_code=1','','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,width=650,height=550');" style="text-decoration: underline;">Choisissez le moyen de paiement de votre choix</a>
</p>
<form method="post" action="webopass.php">
 <p>Veuillez, s'il vous plait, entrez votre <b>code webopass</b> :
<input type="text" name="code"/>
<center><input type="submit" value="Valider" /><br></center>
</form>
<h2>France</h2>
<p>Pour les résidents français uniquement
<a href="#" onclick="window.open('http://script.starpass.fr/numero_pays_v3.php?pays=fr&id_document=21028','','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,width=200,height=200');" style="text-decoration: underline;">Choisissez le moyen de paiement de votre choix</a></p>
<form method="post" action="starpass.php">
 <p>Veuillez, s'il vous plait, entrez votre <b>code starpass</b> :
<input type="text" name="code"/>
<center><input type="submit" value="Valider" /><br></center>
</form>
<?php
require_once('include/php/paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = $url_paypal;   // testing paypal url

	$p->add_field('custom', $compte_id);

    $p->add_field('business', $adresse_paypal);

	$p->add_field('return', $url_site.'/paypal.php?action=success');
	$p->add_field('cancel_return', $url_site.'/paypal.php?action=cancel');
	$p->add_field('notify_url', $url_site.'/paypal_ipn.php');
	$p->add_field('currency_code', 'EUR');
	$p->add_field('item_name', 'Lot de 2 points Odyssée Serveur');
	$p->add_field('amount', $cout_point_par_paypal);
	$p->add_field('undefined_quantity', '1');

	$p->submit_paypal_post(); // submit the fields to paypal

?>
<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
