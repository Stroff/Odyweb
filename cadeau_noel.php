<?php require "include/template/header_cadres.php"  ?>

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
<?
$recu = mysql_query(" SELECT gift FROM site.accounts WHERE id = '" . $_SESSION['id'] . "' ");
$val = mysql_fetch_row($recu);
if ($val[0] == 0) {
    if (!isset($_POST['ok'])) {
        if (!isset($_SESSION['login'])) {
            echo "Vous devez être connecté pour acceder à cette page";
        } else {
            $persos = mysql_query("SELECT name,guid,online,level FROM characters.characters WHERE account = '" . $_SESSION['id'] . "'");

?>

            <br/>Choisissez le perso sur lequel vous recevrez votre cadeau: <br/>
            <form method="post" action="#">
                <select name="perso" id="perso" class="">
                    <option value="" selected>-- Mon perso--</option>
<?php
            while ($perso = mysql_fetch_array($persos)) {
                if ($perso['online'] == 0) {
                    echo '<option value="' . $perso['guid'] . '">' . $perso['name'] . ' ( ' . $perso['level'] . ' )</option>';
                } else {
                    echo "<option value='" . $perso['guid'] . "'> Vos persos doivent être déconnectés";
                }
            }
        }
?>
    </select>
    <input type="submit" name="ok" value="Valider"/>

</form>
        <?php
    } else {
        $perso = $_POST['perso'];
        $recu = mysql_query(" UPDATE site.accounts SET gift = 1 where id = '" . $_SESSION['id'] . "' ");
        $mailnoel = mysql_query("INSERT INTO characters.mail_external (`sender`,`receiver`,`subject`,`message`, `money`) VALUES ('3', '". $perso ."', 'Pere Noël Odyssée', 'Chèr(e) joueur/joueuse, voici le cadeau de Noël Odyssée, en vous souhaitant de nombreux moments de plaisir IG et une excellente fin d\'année de la part de toute l\équipe. Que l'année qui suive soit pleine de promesses!.', '0')") or die("Erreur dans l'envoi du mail");
        $id_mail = mysql_insert_id();
        $mailnoel2 = mysql_query("INSERT INTO characters.mail_external_items (`item`,`mail_id`) VALUES ('213100','" . $id_mail . "')");

        echo "<br/>Votre courrier a été envoyé. A bientôt! ";
    }
}
else
{
    echo "Un seul cadeau de noël par compte!";
}
?>


                        	<br/> 	<br/> 	<br/>
					   </div>
                    </div>
             </div>
            <div class="encadrepage-bas">
            </div>

<?php require "include/template/footer_cadres.php"?>
