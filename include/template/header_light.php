<?php
include_once 'secure.php';
include_once 'config/config.php'; 

if(isset($_SESSION['id']))
{
//Connexion Base de donnée Reamld
	$co = mysql_connect($host_site, $user_site, $pass_site);
	mysql_select_db($site_database, $co);
	mysql_query("SET NAMES 'utf8'");

//Recherche compte dans account_banned
	$search_acc_bann = mysql_query("SELECT id FROM realmd.account_banned WHERE id=".$_SESSION['id'].' AND FROM_UNIXTIME(unbandate) > NOW()'); 

//Si le nombre de compte banni est different de 0 alors il est banni donc redirigé vers msg.php avec le msg numéro 1
	if(mysql_num_rows($search_acc_bann) != 0)
	{
		header("location: message/?msg=1");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if (isset($header_titre)) {
	echo "<title>".$header_titre." - Odyssée Serveur</title>";
} else {
	echo "<title>Odyssée Serveur</title>";
}
?>
<link href="default/default.css" rel="stylesheet" type="text/css" title="default" />
<link href="1024/css/global.css" rel="stylesheet" type="text/css" title="1024" disabled/>
<link href="1280/css/global.css" rel="stylesheet" type="text/css" title="1280" disabled/>
<link href="1440/css/global.css" rel="stylesheet" type="text/css" title="1440" disabled/> 
<link href="1680/css/global.css" rel="stylesheet" type="text/css" title="1680" disabled/>
<link href="1920/css/global.css" rel="stylesheet" type="text/css" title="1920" disabled/>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="Scripts/dynamiclayout.js"></script>
</head>

<body onLoad="init();dynamicLayout();">
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-5994681-2']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	
	<script type="text/javascript" src="http://odyssee-serveur.com/medias/js/re_.js"></script>
	<script type="text/javascript">
	try {
	<?php
	if(isset($_SESSION['login'])){
		echo 're_name_tag = "'.$_SESSION['login'].'";';
	}
	?>
	reinvigorate.track("p3l1w-e61ctw6974");
	} catch(err) {}
	</script>
	
<div id="loading" style="width:100%; text-align:center; background:black center no-repeat; height:1600px; overflow:hidden;">
<div style="margin-top:300px;">
	<b><font color="white">Chargement en cours, veuillez patienter ...  <br/> 
    
    
    </font></b>
	<br/><br/><br/>
	<img src="medias/images/loading.gif"/></div>
</div>

<script>
	var ld=(document.all);
	var ns4=document.layers;
	var ns6=document.getElementById&&!document.all;
	var ie4=document.all;
	if (ns4)
		ld=document.loading;
	else if (ns6)
		ld=document.getElementById("loading").style;
	else if (ie4)
		ld=document.all.loading.style;
	function init()
	{
		if(ns4){ld.visibility="hidden";}
		else if (ns6||ie4) ld.display="none";
	}
</script>

<div class="global">
<div class="banniere">
	<div class="hautban">	
    	<div class="logo" align="center">
   	    	<a href="index.php"><img src="medias/images/logo.gif" /></a>
        </div>
    </div>

</div>
<div class="conteneur">
	<div class="coinhaut">
    </div>
	<div class="corps">
    
        	<div class="moduser">
            	<?php if(isset($_SESSION['id'])) {
	
					$connexion = mysql_connect($host_site, $user_site , $pass_site);
					mysql_select_db($site_database ,$connexion);
					mysql_query("SET NAMES 'utf8'");
					$compte_pp = mysql_real_escape_string($_SESSION['pp']);
					$compte_next_vote_date = mysql_real_escape_string($_SESSION['next_vote_date']);

					$compte_points = mysql_real_escape_string($_SESSION['points']);
					$compte_username = mysql_real_escape_string($_SESSION['login']);
					$compte_id = mysql_real_escape_string($_SESSION['id']);
					$compte_gm = mysql_real_escape_string($_SESSION['gm']);

					$timestamp_actuel = time();
					$timestamp_db=mysql2timestamp($compte_next_vote_date);
					require "include/modules/usermenu.php";
				} else {
					require "include/modules/modlogin.php";
				} ?>        
       	 	</div>
			
	
		<div id="msgbox"></div>
