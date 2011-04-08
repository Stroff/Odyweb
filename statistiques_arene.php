<?php 
$secure_lvl = 0;
$header_titre = "Statistiques des arènes";

?>
	

Le top teams
<?php
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
mysql_select_db($wow_characters ,$connexion);
mysql_query("SET NAMES 'utf8'");
$liste_arenes = mysql_query("select distinct c.name, t.name, s.rating, a.personal_rating
from characters as c, arena_team as t, arena_team_stats as s, arena_team_member as m, character_arena_stats as a
where c.guid = m.guid and
t.arenateamid=m.arenateamid and
a.guid = c.guid and
t.arenateamid= s.arenateamid and rating> 1800
and a.slot=0
order by rating desc");
echo '
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
	<tr>
		<th>Classement</th>
                <th>Nom</th>
		<th>Team</th>
		<th>Côte</th>
		<th>Côte MMR personnelle</th>
		</tr>
</thead>
	<tbody>';
        $i = 0;
	while($arene = mysql_fetch_array($liste_arenes))
            {    
                $i++;
		echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$arene[0].'</td>';
		echo '<td>'.$arene[1].'</td>';
		echo '<td>'.$arene[2].'</td>';
		echo '<td>'.$arene[3].'</td>';
	
		
	
		
		echo'</tr>';
	}
	echo '	</tbody>
	</table>';
?>

