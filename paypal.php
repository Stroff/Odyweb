<?php 
$secure_lvl = 1;
$header_titre = "Achat de points par Paypal";
include 'include/template/header_cadres.php'; 
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
<h2>Achat de points</h2>

<?php
// Setup class
require_once('include/php/paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = $url_paypal;   // testing paypal url
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url

// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

switch ($_GET['action']) {

	case 'success':      // Order was successful...

	// This is where you would probably want to thank the user for their order
	// or what have you.  The order information at this point is in POST 
	// variables.  However, you don't want to "process" the order until you
	// get validation from the IPN.  That's where you would have the code to
	// email an admin, update the database with payment status, activate a
	// membership, etc.  

	echo "<div style='margin-left:20px;'> <p>Votre paiement a bien été pris en compte. Vous allez avoir recevoir vos points après validation de Paypal.</p></div>";
	echo '</div></div></div></div><div class="encadrepage-bas">
	</div>';
	include'include/template/footer_cadres.php';

	break;

		case 'cancel':       // Order was canceled...

		// The order was canceled before being completed.

		echo "<div style='margin-left:20px;'><p>Vous avez annulé votre commande</p></div>";
		echo '</div></div></div></div><div class="encadrepage-bas">
		</div>';
		include'include/template/footer_cadres.php';

		break;

	}     
?>