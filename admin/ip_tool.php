<?php
$secure_lvl=2;
require '../secure.php';

/*
 * This function returns the real hostname of an ip address.
 *
 * @param: $ip - the ip address in format x.x.x.x where x are
 *         numbers (0-255) or the hostname you want to lookup
 * @return: returns the hostname as string. Something like 'user-id.isp-dialin.tld'
 *
 * Warning: $ip must be validated before calling this function.
 */
function nslookup($ip) {

        // execute nslookup command
        exec('nslookup '.$ip, $op);

        // php is running on windows machine
        if (substr(php_uname(), 0, 7) == "Windows") {
                return substr($op[3], 6);
        }
        else {
                // on linux nslookup returns 2 diffrent line depending on
                // ip or hostname given for nslookup
                if (strpos($op[4], 'name = ') > 0)
                        return substr($op[4], strpos($op[4], 'name =') + 7, -1);
                else
                        return substr($op[4], strpos($op[4], 'Name:') + 6);
        }
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
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#example').dataTable( {
				"bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bInfo": false,
				"bAutoWidth": false } );
	} );
</script>
<title>Liste des recups</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div id="dt_example">
<p>Liste des recups (nouveau systéme)</p>
<a href="index.php"> Retour a l'accueil </a>
<p>
    <form method="post" action="#">
    	Recherche d'ip sur le site, le forum, l'admin, IG...
        <input type="text" name="termes" value="" size="15" />
        <input type="submit" name="Recherche" />       	
    </form>
</p>
	<?php
	include 'config/config.php';

        // Récupération des élèments POST
        if(isset($_POST("termes")) && $_POST("termes") != "")
        {
            $ip = $_POST("termes"); 
            echo "<i>Nslookup : ".nslookup($ip)."</i><br/>\n";

            $recherche = array(
              // Table         =>    Clé de recherche  /   Champs à afficher
              "realmd.account" => array("last_ip", array("last_ip","username","id","email","last_login")),
              "realmd.gmlogs"  => array("ip", array("ip","player_name","account_id","","date")),
              "forum.ibf_members"  => array("ip_address", array("ip_address","name","member_id","email","FROM_UNIXDATE(joined)")),
              "forum.ibf_message_posts"  => array("msg_ip_address", array("msg_ip_address","","msg_author_id","","FROM_UNIXDATE(msg_date)")),
            );

            ?>
            <h3>Ip bannie</h3>
            <table id="example">
                <thead>
                    <tr>
                        <th>Origine</th>
                        <th>IP</th>                        
                        <th>Nom du compte</th>
                        <th>Id du compte</th>
                        <th>Email</th>
                        <th>Date (enregistrement)</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            // Recherche dans les bans
            $sql = "SELECT * FROM realmd.ip_banned WHERE ip like '$ip'";
            $res = mysql_query($sql) or die (mysql_error()); 

            while($row = mysql_fetch_assoc($res))

               ?>
                </tbody>
            </table>
<?php
        }

	?>

</div>
</body>
</html>