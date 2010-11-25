<?php
$secure_lvl = 2;
include '../secure.php';
error_reporting(E_ALL);
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

        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/base/jquery-ui.css" type="text/css" media="all" />
        <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js" type="text/javascript"></script>
        <script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js" type="text/javascript"></script>

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

        <title>Logs d'arene</title>
    </head>
    <body>
        <script>
            $(function() {
                $.datepicker.setDefaults($.datepicker.regional['']);
                $( "#datepicker" ).datepicker();
                $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                $( "#datepicker" ).datepicker($.datepicker.regional['fr']);
                $( "#datepicker2" ).datepicker();
                $( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                $( "#datepicker2" ).datepicker($.datepicker.regional['fr']);
            });

        </script>


        <?php include "navbar.php"; ?>
        <div id="dt_example">
            <p>Logs d'arene <br/><a href="index.php"> Retour a l'accueil </a>
            </p>
            <div class="arena_header">
                <div class="arena_search">
                    <form method="post" action="#">
                        Choisissez votre type d'arene :
                        <select type="listbox" name="arena_type">
                            <?php
                            $sql = "Select date, date_fin, TIMEDIFF (date_fin, date) AS duree, id, type, team1, team2, winner, ratechange from characters.log_arenes WHERE type_action LIKE 'arena_end'";
                            $team = $_POST['team'];
                            $team2 = $_POST['team2'];
                            $sqlteam = "SELECT arenateamid, name FROM characters.arena_team WHERE arenateamid = '" . $team . "'";
                            $sqlteam2 = "SELECT arenateamid, name FROM characters.arena_team WHERE arenateamid = '" . $team2 . "'";
                            $sqlpersojoin = "SELECT lo.joueur_guid, lo.date AS debut, (SELECT lu.date FROM log_arenes AS lu"
                            . "WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_left' AND lu.team1 = ".$_POST['team']. " AND lu.date > '".$_POST["date"]."' AND lu.id > lo.id HAVING MIN(DATEDIFF(lu.date,lo.date))) AS fin FROM log_arenes AS lo WHERE lo.team1 = ".$_POST['team']. " AND lo.joueur_guid = '".$_POST["perso"]."' AND lo.type_action LIKE 'player_join' AND lo.date <= '".$_POST["date2"]."' AND NOT EXISTS (SELECT * FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_left' AND lu.team1 = ".$_POST['team']. " AND lu.date <= '".$_POST["date"]."' AND lu.id > lo.id ) UNION (SELECT lo.joueur_guid, NULL AS debut, lo.date AS fin FROM log_arenes AS lo WHERE lo.team1 = ".$_POST['team']. " AND lo.joueur_guid = '".$_POST["perso"]."' AND lo.type_action LIKE 'player_left' AND lo.date >= '".$_POST["date"]."' AND NOT EXISTS (SELECT * FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_join' AND lu.team1 = '" .$_POST['team']. "' AND lu.date > '".$_POST["date2"]."' AND lu.id < lo.id ))" ;
                            $sqlpersojoin2 = "SELECT lo.joueur_guid, lo.date AS debut, (SELECT lu.date FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_left' AND lu.team1 = ".$_POST['team2']. " AND lu.date > '".$_POST["date"]."' AND lu.id > lo.id HAVING MIN(DATEDIFF(lu.date,lo.date))) AS fin FROM log_arenes AS lo WHERE lo.team1 = ".$_POST['team2']. " AND lo.joueur_guid = '".$_POST["perso"]."' AND lo.type_action LIKE 'player_join' AND lo.date <= '".$_POST["date2"]."' AND NOT EXISTS (SELECT * FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_left' AND lu.team1 = ".$_POST['team2']. " AND lu.date <= '".$_POST["date"]."' AND lu.id > lo.id ) UNION (SELECT lo.joueur_guid, NULL AS debut, lo.date AS fin FROM log_arenes AS lo WHERE lo.team1 = ".$_POST['team2']. " AND lo.joueur_guid = '".$_POST["perso"]."' AND lo.type_action LIKE 'player_left' AND lo.date >= '".$_POST["date"]."' AND NOT EXISTS (SELECT * FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_join' AND lu.team1 = '".$_POST['team2']. "' AND lu.date > '".$_POST["date2"]."' AND lu.id < lo.id ))" ;
                            $sqljoin = "SELECT * FROM (SELECT DISTINCT date, account, ip, action, perso, guid FROM log_char AS lc, (SELECT lo.joueur_guid, lo.date AS debut, (SELECT lu.date FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_left' AND lu.team1 = '".$_POST['team']. "' AND lu.date > '".$_POST["date"]."' AND lu.id > lo.id HAVING MIN(DATEDIFF(lu.date,lo.date))) AS fin FROM log_arenes AS lo WHERE lo.team1 = '".$_POST['team']. "' AND lo.type_action LIKE 'player_join' AND lo.date <= '".$_POST["date2"]."' AND NOT EXISTS (SELECT * FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_left' AND lu.team1 = '".$_POST['team']. "' AND lu.date <= '".$_POST["date"]."' AND lu.id > lo.id ) UNION (SELECT lo.joueur_guid, NULL AS debut, lo.date AS fin FROM log_arenes AS lo WHERE lo.team1 = '".$_POST['team']. "' AND lo.type_action LIKE 'player_left' AND lo.date >= '".$_POST["date"]."' AND NOT EXISTS (SELECT * FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_join' AND lu.team1 = '".$_POST['team']. "' AND lu.date > '".$_POST["date2"]."' AND lu.id < lo.id ))) AS foo WHERE foo.joueur_guid = lc.guid AND (lc.action like 'login' OR lc.action like 'logout') AND lc.date BETWEEN IFNULL(foo.debut, '".$_POST["date"]."') AND IFNULL(foo.fin, '".$_POST["date2"]."')) AS bar WHERE date BETWEEN '".$_POST["date"]."' AND '".$_POST["date2"]."'" ;
                            $sqljoin2 = "SELECT * FROM (SELECT DISTINCT date, account, ip, action, perso, guid FROM log_char AS lc, (SELECT lo.joueur_guid, lo.date AS debut, (SELECT lu.date FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_left' AND lu.team1 = '".$_POST['team2']. "' AND lu.date > '".$_POST["date"]."' AND lu.id > lo.id HAVING MIN(DATEDIFF(lu.date,lo.date))) AS fin FROM log_arenes AS lo WHERE lo.team1 = '".$_POST['team2']. "' AND lo.type_action LIKE 'player_join' AND lo.date <= '".$_POST["date2"]."' AND NOT EXISTS (SELECT * FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_left' AND lu.team1 = '".$_POST['team2']. "' AND lu.date <= '".$_POST["date"]."' AND lu.id > lo.id ) UNION (SELECT lo.joueur_guid, NULL AS debut, lo.date AS fin FROM log_arenes AS lo WHERE lo.team1 = '".$_POST['team2']. "' AND lo.type_action LIKE 'player_left' AND lo.date >= '".$_POST["date"]."' AND NOT EXISTS (SELECT * FROM log_arenes AS lu WHERE lu.joueur_guid = lo.joueur_guid AND lu.type_action LIKE 'player_join' AND lu.team1 = '".$_POST['team2']. "' AND lu.date > '".$_POST["date2"]."' AND lu.id < lo.id ))) AS foo WHERE foo.joueur_guid = lc.guid AND (lc.action like 'login' OR lc.action like 'logout') AND lc.date BETWEEN IFNULL(foo.debut, '".$_POST["date"]."') AND IFNULL(foo.fin, '".$_POST["date2"]."')) AS bar WHERE date BETWEEN '".$_POST["date"]."' AND '".$_POST["date2"]."'" ;
                            $sqlconnections = "SELECT log_pl_arena_connexion (".$_POST['team'].", '".$_POST['date']."', '". $_POST['date2']."')";
                            $arenatype = $_POST["arena_type"];
                            $perso = $_POST['perso'];
                            $sqlpinfo = "SELECT c.guid, c.name, c.race, c.class, c.money AS money, a.username, a.id FROM characters.characters AS c, realmd.account AS a WHERE a.id = c.account AND c.guid = '" . $_POST['perso'] . "'";
                            $fetchpinfo = mysql_query($sqlpinfo) or die(mysql_error());
                            $sqlteamsperso = "select date, team1, joueur_guid, type_action from characters.log_arenes where (type_action LIKE 'player_join' OR type_action LIKE 'player_left' OR type_action LIKE 'arena_new' OR type_action LIKE 'arena_disband') AND joueur_guid = '" . $_POST['perso'] . "'";
                            $fetchteamsperso = mysql_query($sqlteamsperso);
                            $fetchjoin = mysql_query($sqljoin) OR die(mysql_error());
                            $fetchjoin2 = mysql_query($sqljoin2);
                            $fetchteam = mysql_query($sqlteam);
                            $fetchteam2 = mysql_query($sqlteam2);
                            $nomteam = mysql_fetch_array($fetchteam);
                            $nomteam2 = mysql_fetch_array($fetchteam2);
                            $date1 = $_POST["date"];
                            $date2 = $_POST["date2"];
                            $duree = $_POST["duree"];
                            if (isset($_POST["Recherche"])) {
                                if (isset($_POST["arena_type"])) {
                                    $sql = $sql . " AND type = '" . $arenatype . "'";
                                    if ($arenatype == 2) {
                                        echo "<option selected value=\"2\"> 2c2 </option>";
                                        echo "<option value=\"3\"> 3c3 </option>";
                                        echo "<option value=\"5\"> 5c5 </option>";
                                    }
                                    if ($arenatype == 3) {
                                        echo "<option value=\"2\"> 2c2 </option>";
                                        echo "<option selected value=\"3\"> 3c3 </option>";
                                        echo "<option value=\"5\"> 5c5 </option>";
                                    } elseif ($arenatype == 5) {
                                        echo "<option value=\"2\"> 2c2 </option>";
                                        echo "<option value=\"3\"> 3c3 </option>";
                                        echo "<option selected value=\"5\"> 5c5 </option>";
                                    } else {
                                        echo "Houston le type a un probleme";
                                    }
                                }
                                if ($team != 0) {
                                    $sql = $sql . " AND (team1 = '" . $team . "' OR team2 = '" . $team . "')";
                                }
                                if ($team2 != 0) {
                                    $sql = $sql . " AND (team1 = '" . $team2 . "' OR team2 = '" . $team2 . "')";
                                }

                                if (isset($_POST['date']) && $date1 != "") {

                                    $sql = $sql . " AND date > '" . $date1 . "'";
                                }
                                if (isset($_POST['date2']) AND $date2 != "") {

                                    $sql = $sql . " AND date < '" . $date2 . "'";
                                }
                                if (isset($_POST['duree']) AND $duree != "") {

                                    $sql = $sql . " AND TIMEDIFF (date_fin, date) < '" . $duree . "'";
                                }
                            } else {
                                $sql = "Select  date, date_fin,TIMEDIFF (date_fin, date) AS duree, id, type, team1, team2, winner, ratechange from characters.log_arenes WHERE type_action LIKE 'arena_end' ORDER BY date DESC LIMIT 1, 1000";
                                echo "<option selected value=\"2\"> 2c2 </option>";
                                echo "<option value=\"3\"> 3c3 </option>";
                                echo "<option value=\"5\"> 5c5 </option>";
                            }
                            ?>
                        </select>
                        <br/>
                        Un ID de team:
                        <input type="text" name="team" value="" size="15" />
                        <br/>
                        <br/>
                        Un ID de team adverse:
                        <input type="text" name="team2" value="" size="15" />
                        <br/>
                        Date de début: <input type="text" id="datepicker" name="date"/>
                        <br/>
                        Date de fin: <input type="text" id="datepicker2" name="date2"/>
                        <br/>
                        Durée maxi (hh:mm:ss): <input type="text" name="duree"/>
                        <br/>
                        <div style="color: #333; font-size: 90%; font-style: italic">
                            /!\ Le champ perso n'influe pas sur la liste des matchs.</div>
                        Recherche Par perso probable: <input type="text" name="perso"/>


                        <input type="submit" name="Recherche" />
                    </form>
                </div>
                <div class="arena_filters">
                    Mes filtres:
                    <table cellpading="0" cellspacing="0" style="margin-left:auto; margin-right:auto ">
                        <tr>
                            <td>
                                Type d'arene:
                                <?php
                                if ($arenatype == 2) {
                                    echo "2c2";
                                } elseif ($arenatype == 3) {
                                    echo "3c3";
                                } elseif ($arenatype == 5) {
                                    echo "5c5";
                                }
                               
                                ?><br/>	Nombre de Matchs :

                                <?php
                                date_default_timezone_set('Europe/Paris');
                                $resultats = mysql_query($sql) or die(mysql_error());
                                $nb = mysql_num_rows($resultats);
                                echo $nb;
                                ?>
                            </td>
                            <td>
                                <br/>
                                <?php if (isset($_POST['date']) AND ($_POST['date2'])) {
                                ?>
                            		Periode :  Entre le <?php echo $date1; ?> et le <?php echo $date2;
                                } ?>
                                <br/>
                                <?php if (isset($_POST['duree']) AND $duree != "") {
                                ?>
                                    Durée maxi:  <?php echo $duree;
                                } ?>
<br/>
                        </tr>
                       

                            <?php
                                if (isset($_POST['team']) AND $_POST['team'] != "") {
                                    if ($nomteam['name'] == "") {
                                        $nomteam['name'] = "Team Supprimée";
                                    }
                            ?>  <tr style="font-weight:normal">
                        <td class="arena_teams">
                                        <strong>Team d'arene n°1 :</strong><?php
                                    echo $team;
                                    $teamsearch = strtr($nomteam['name'], " ", "+");
                                    $urlarmory = "<a href= http://armurerie.odyssee-serveur.com/team-info.xml?b=Odyss%C3%A9e+Serveur&r=Odyssee&ts=".$arenatype."&select=". $teamsearch.">".$nomteam['name']."</a> ";
                                    echo ' <br/> <strong>Nom de la team:</strong>"' . $urlarmory . '"';
                            ?>
                                    <br/>
<?php
                                    echo " <a href=\"#\"><h4 style=\"line-height: 15px; font-size: 120%;\"><img style=\"padding-right:10px\" src=\"images/pblue.gif\" /> Mouvement des joueurs dans la team:</h4></a>";
                                   ?> <table>
                                    <th> Date et Heure </th><th> Action </th><th> GUID </th><th> Nom de l'époque </th><th> Compte </th><th> IP </th>
                                    <?php
                                    while ($jointeam = mysql_fetch_array($fetchjoin)) {

                                        echo "<tr><td style=\"color:#222; font-weight:bold\"> " . $jointeam ['date'] . " :</td><td> "  . $jointeam ['action'] ." </td><td>  ". $jointeam ['guid'] . " </td><td> " . $jointeam ['perso'] . " </td><td> " . $jointeam ['account'] ." </td><td>  " . $jointeam ['ip']   ;
                                        
                                 
                                    }
                                } ?>

                                </table> 

                            </td>

<?php
                              
                                      
?>
                                <br/>                               <?php
                                if (isset($_POST['team2']) AND $_POST['team2'] != "") {
                                    if ($nomteam2['name'] == "") {
                                        $nomteam2['name'] = "Team Supprimée";
                                    }
                            ?> 
                        <td class="arena_teams">
                                        <strong>Team d'arene n°2 :</strong><?php
                                    echo $team2;
                                    $teamsearch2 = strtr($nomteam2['name'], " ", "+");
                                    $urlarmory2 = "<a href= http://armurerie.odyssee-serveur.com/team-info.xml?b=Odyss%C3%A9e+Serveur&r=Odyssee&ts=".$arenatype."&select=". $teamsearch2.">".$nomteam2['name']."</a> ";
                                    echo ' <br/> <strong>Nom de la team:</strong>"' . $urlarmory2 . '"';
                            ?>
                                    <br/>
<?php
                                    echo " <a href=\"#\"><h4 style=\"line-height: 15px; font-size: 120%;\"><img style=\"padding-right:10px\" src=\"images/pblue.gif\" /> Mouvement des joueurs dans la team:</h4></a>";
                                   ?> <table>
                                    <th> Date et Heure </th><th> Action </th><th> GUID </th><th> Nom de l'époque </th><th> Compte </th><th> IP </th>
                                    <?php
                                    while ($jointeam2 = mysql_fetch_array($fetchjoin2)) {

                                        echo "<tr><td style=\"color:#222; font-weight:bold\"> " . $jointeam2 ['date'] . " :</td><td> "  . $jointeam2 ['action'] ." </td><td>  ". $jointeam2 ['guid'] . " </td><td> " . $jointeam2 ['perso'] . " </td><td> " . $jointeam2 ['account'] ." </td><td>  " . $jointeam2 ['ip']   ;


                                    }
                                } ?>

                                </table>

                            </td>

<?php

                                        if ($nomteam2['name'] == "") {
                                    $nomteam2['name'] = "Team Supprimée";
                                }
?>
                                <br/>

                        </tr>
<?php
                                if (isset($_POST['perso']) AND $_POST['perso'] != "") {
                                     $persodetails = mysql_fetch_array($fetchpinfo);
                                     $urlpersoarmory = "<a href= http://armurerie.odyssee-serveur.com/character-sheet.xml?r=Odyssee&cn=".$persodetails['name'].">". $persodetails['name']."</a> ";
                                    echo "<tr><td class=\"arena-teams\"> <strong>Joueur selectionné : " . $urlpersoarmory . " </strong>";
                                    echo "<br/><strong> Details du perso:</strong>";

                                    
                                        echo "<table cellpadding=\"2\" cellspacing=\"2\" > <tr> <td> Nom: " . $persodetails['name'] . " </td><td> Race: ";
                                        switch ($persodetails['race']) {
                                            case 1:
                                                echo "Humain";
                                                break;
                                            case 2:
                                                echo "Orc";
                                                break;
                                            case 3:
                                                echo "Nain";
                                                break;
                                            case 4:
                                                echo "Elfe de la nuit";
                                                break;
                                            case 5:
                                                echo "Mort Vivant";
                                                break;
                                            case 6:
                                                echo "Tauren";
                                                break;
                                            case 7:
                                                echo "Gnome";
                                                break;
                                            case 8:
                                                echo "Troll";
                                                break;
                                            case 10:
                                                echo "Elfe de sang";
                                                break;
                                            case 11:
                                                echo "Draeneï";
                                                break;

                                            default:
                                                echo "Données illisibles";
                                        }
                                        echo " </td> <td> Classe: ";
                                        switch ($persodetails['class']) {
                                            case 1:
                                                echo "Guerrier";
                                                break;
                                            case 2:
                                                echo "Paladin";
                                                break;
                                            case 3:
                                                echo "Chasseur";
                                                break;
                                            case 4:
                                                echo "Voleur";
                                                break;
                                            case 5:
                                                echo "Prêtre";
                                                break;
                                            case 6:
                                                echo "Chevalier de la mort";
                                                break;
                                            case 7:
                                                echo "Chaman";
                                                break;
                                            case 8:
                                                echo "Mage";
                                                break;
                                            case 9:
                                                echo "Démoniste";
                                                break;
                                            case 11:
                                                echo "Druide";
                                                break;
                                            default:
                                                echo "Données illisibles";
                                        }
                                        echo " Possède " . $persodetails['money'] / 10000 . "Po";
                                        echo " Compte: " . $persodetails['username'] . " </td> </tr> </table> ";
                                    
                                    echo "<table cellpadding\"2\" cellspacing\"2\" style=\"background-color: white; color: black\">";
                                    echo "<h4 style=\"line-height: 15px; font-size: 120%;\"><img style=\"padding-right:10px\" src=\"images/pblue.gif\" /> Mouvement du joueur dans les teams d'arene:</h4>";
                                    while ($persoteams = mysql_fetch_array($fetchteamsperso)) {
                                        echo "<tr><td style=\"color:#222; font-weight:bold\">" . $persoteams ['date'] . "</td><td> ";
                                        if ($persoteams['type_action'] == "player_left") {

                                            echo "</td><td style=\"color:red\"> est parti de la team </td>";
                                        } elseif ($persoteams['type_action'] == "player_join") {
                                            echo "</td><td style=\"color:green\"> a rejoint la team </td>";
                                        } elseif ($persoteams['type_action'] == "arena_new") {
                                            echo "</td><td style=\"color:green; font-weight:bold\"> a crée la team </td>";
                                        } elseif ($persoteams['type_action'] == "player_disband") {
                                            echo "</td><td style=\"color:red; font-weight:bold\"> a supprimé la team </td>";
                                        }
                                        echo "<td>" . $persoteams ['team1'] . "</td></tr>";
                                    }

                                    echo "</table>";
                                    echo "</td></tr>";
                                }
?>
                            </table>
                        </div>
                    </div>
                        <?php
                                if ($nb > 1000) {
                                    $sql = $sql . " LIMIT 0,1000";
                                    echo " <br> <div style = \"color:red;\"> Les resultats sont limités a 1000 pour soulager votre navigateur </div>";
                                }
                               
                        ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>ID Match</th>
                                <th>Date début</th>
                                <th>Date fin</th>
                                <th>Durée du match</th>
                                <th>type</th>
                                <th>Team 1</th>
                                <th>Team 2</th>
                                <th>Victoire de:</th>
                                <th>Cote du gagnant:</th>
                            </tr>
                        </thead>
                        <tbody>
            <?php
                            $resultats = mysql_query($sql) or die(mysql_error());
                                while ($demande = mysql_fetch_array($resultats)) {
                                    echo '<tr class="gradeA">';
                                    echo '<td>' . $demande['id'] . '</td>';
                                    echo '<td>' . $demande['date'] . '</td>';
                                    echo '<td>' . $demande['date_fin'] . '</td>';
                                    if ($demande['duree'] < "00:00:20") {
                                        echo '<td style="color:red">' . $demande['duree'] . '</td>';
                                    } elseif ($demande['duree'] < "00:00:40") {
                                        echo '<td style="color:orange">' . $demande['duree'] . '</td>';
                                    } else {
                                        echo '<td style="color:green">' . $demande['duree'] . '</td>';
                                    }
                                    echo '<td>' . $demande['type'] . '</td>';
                                    echo '<td> <a href="#" title="' . $nomteam['name'] . '">' . $demande['team1'] . '</a></td>';
                                    echo '<td><a href="#" title=".$nomteam2.">' . $demande['team2'] . '</a></td>';
                                    echo '<td>' . $demande['winner'] . '</td>';
                                    echo '<td>' . $demande['ratechange'] . '</td>';
                                    echo'</tr>';
                                }
            ?>
                </tbody>
            </table>
        </div>
    </body>
</html>