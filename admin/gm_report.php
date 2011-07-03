<?php
$secure_lvl=2;
require_once '../secure.php';

if($_SESSION['gm'] < 5){
 echo "<h1>juste pour les admins et resp, dsl</h1>";
 exit();
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" title="currentStyle">
	@import "css/demo_page.css";
	@import "css/demo_table.css";
</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"
	} );></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#example').dataTable( {
				"bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bInfo": false,
				"bAutoWidth": false } );
</script>
<title>Liste des commandes MJ</title>
</head>
<body>
<?php include "navbar.php"; include "config/config.php"; ?>
<div id="dt_example">
<?php 
$date_debut = "2011-06-01";
$date_fin = "2011-07-01";
?>

<p>Rapport mensuel MJ</p>
<a href="index.php"> Retour a l'accueil </a> <br/>

<h2>Le TOP</h2>
<p>Ce top est basic et méchant puisqu'il tient seulement compte du nombre de requêtes IG fermés.</p>
<table id="example" class="display">
 <thead><tr><th>Nombre tickets</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM characters.gmlogs where date >= "'.$date_debut.'" and date < "'.$date_fin.'" and cmd1 like '.tic%' and cmd2 like 'cl% GROUP BY account_id ORDER BY count(*) DESC';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Moyennes</h2>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT avg(UNIX_TIMESTAMP(gc.date) - UNIX_TIMESTAMP(g.date)) / 60 FROM characters.gmlogs g left join characters.gmlogs gc USING (cmd3, account_id) where g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and g.cmd1 like ".tic%" and g.cmd2 like "viewid" and gc.cmd2 like "cl%" and UNIX_TIMESTAMP(gc.date ) - UNIX_TIMESTAMP(g.date) < 7200 and UNIX_TIMESTAMP(gc.date ) - UNIX_TIMESTAMP(g.date) > 0';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol:moyennes");
	$val = mysql_fetch_array($res)
?>
<p>Le temps moyen passé sur les requêtes, i.e. temps entre le viewid et le closed : <?php echo $val[0];?> min.</p>    
 <?php
    mysql_select_db("characters");
    $sql = 'select count(*) from characters.gm_tickets where closed = 0';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	$val = mysql_fetch_array($res)
?>
<p>Nombres de requêtes ouvertes : <?php echo $val[0];?></p>
 <?php
    mysql_select_db("characters");
    $sql = 'select from_unixtime(createtime) from characters.gm_tickets where closed = 0 order by createtime asc limit 1';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	$val = mysql_fetch_array($res)
?>
<p>Requête ouverte la plus vieille : <?php echo $val[0];?></p>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*) FROM characters.gm_tickets g where from_unixtime(g.timestamp) >= "'.$date_debut.'" and from_unixtime(g.timestamp) < "'.$date_fin.'" and g.closed = playerGuid';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	$val = mysql_fetch_array($res)
?>
<p>Nombre de tickets abandonnés par les joueurs sur le période : <?php echo $val[0];?></p>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT avg(g.timestamp - g.createtime) / 3600 FROM characters.gm_tickets g where from_unixtime(g.timestamp) >= "'.$date_debut.'" and from_unixtime(g.timestamp) < "'.$date_fin.'" and g.closed = playerGuid';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	$val = mysql_fetch_array($res)
?>
<p>Temps moyens avant l'abandon : <?php echo $val[0];?> heures.</p>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT avg(g.timestamp - g.createtime) / 3600 FROM characters.gm_tickets g where from_unixtime(g.timestamp) >= "'.$date_debut.'" and from_unixtime(g.timestamp) < "'.$date_fin.'" and g.closed !=0';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	$val = mysql_fetch_array($res)
?>
<p>Temps moyen entre création et fermeture des tickets : <?php echo $val[0];?> heures.</p>

<h2>Temps moyens sur les requêtes</h2>
<p>Le temps en minutes et calcule le temps entre l'ouverture et la fermeture du même ticket (les diff de plus de 2h ont été exclus)</p>
<table id="example" class="display">
 <thead><tr><th>Temps(min)</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT avg(UNIX_TIMESTAMP(gc.date) - UNIX_TIMESTAMP(g.date))/60, g.player_name FROM gmlogs g left join gmlogs gc USING (cmd3, account_id) where g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and g.cmd1 like ".tic%" and g.cmd2 like "viewid" and gc.cmd2 like "cl%" and UNIX_TIMESTAMP(gc.date ) - UNIX_TIMESTAMP(g.date) < 7200 and UNIX_TIMESTAMP(gc.date ) - UNIX_TIMESTAMP(g.date) > 0 GROUP BY account_id ORDER BY avg(UNIX_TIMESTAMP(gc.date) - UNIX_TIMESTAMP(g.date)) DESC';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Le top des additems</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM gmlogs g where  g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and cmd1 like ".addi%" group by account_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Le top levelup</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM gmlogs g where  g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and cmd1 like ".lev%" group by account_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Le top ban</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM gmlogs g where  g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and cmd1 like ".ban%" group by account_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Le top mute</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM gmlogs g where  g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and cmd1 like ".mut%" group by account_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Les /played des comptes</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre(heures)</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT sum( c.totaltime )/3600, c.name FROM realmd.account_access a left join characters.characters c ON a.id = c.account WHERE a.gmlevel > 0 and a.RealmID = -1 GROUP BY a.id ORDER BY sum( c.totaltime ) DESC';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Le top du .gob</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM gmlogs g where  g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and cmd1 like ".gob%" group by account_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Le top du .npc</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM gmlogs g where  g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and cmd1 like ".npc%" group by account_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Le top du .quest</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM gmlogs g where  g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and cmd1 like ".q%" group by account_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Pour le fun le top du .mod scale > 1 les megalos !</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), player_name FROM gmlogs g where  g.date >= "'.$date_debut.'" and g.date < "'.$date_fin.'" and cmd1 like ".mod%" and cmd2 like "sc%" and cmd3 > 1 group by account_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Top des récup</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("site");
    $sql = 'SELECT count(*), a.username FROM logs_mj_recups l left join accounts a on a.id = l.id_compte_mj where l.date >= "'.$date_debut.'" and l.date < "'.$date_fin.'" group by l.id_compte_mj order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Top des joueurs qui ont fait des tickets IG (regroupé par compte) :</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>MJ</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("characters");
    $sql = 'SELECT count(*), a.username FROM characters.gm_tickets g left join characters.characters c on c.guid = g.playerguid left join realmd.account a on c.account = a.id where from_unixtime(g.createtime) >= "'.$date_debut.'" and from_unixtime(g.createtime) < "'.$date_fin.'" group by g.playerguid order by count(*) desc limit 20';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Stats boutique</h2>
<table id="example" class="display">
 <thead><tr><th>Type</th><th>Nombre de points</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("site");
    $sql = 'select type, sum(nombre_points) from site.logs_achat_points where date >= "'.$date_debut.'" and date < "'.$date_fin.'" group by type';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

<h2>Top achats</h2>
<table id="example" class="display">
 <thead><tr><th>Nombre</th><th>Item</th></tr></thead>
 <tbody>
 <?php
    mysql_select_db("site");
    $sql = 'select count(*), objet_id from site.logs_achat_boutique where date >= "'.$date_debut.'" and date < "'.$date_fin.'" group by objet_id order by count(*) desc';
	$res = mysql_query($sql) or die("Anti-Jparsensucettelol");
	while($val = mysql_fetch_array($res))
	{ ?>
	<tr class="gradeA">
    	<td><?php echo $val[0]; ?></td>
        <td><?php echo $val[1]; ?></td>
    </tr>
<?php } ?>
 </tbody>
</table>

</div>
</body>
</html>