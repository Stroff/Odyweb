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
if(!isset($_SESSION['login']) || !isset($_SESSION['id']))
{
    echo "Vous devez être authentifié pour accéder à cette page<br/>\n";
}
else
{
    $recu = mysql_query(" SELECT * FROM site.account_cadeaux WHERE id_account = '" . $_SESSION['id'] . "' AND date_envoi is NULL");
    if(isset($_POST['ok']) && isset($_SESSION['login']) && $recu)
    {
        /* reception _POST */
        while($i = mysql_fetch_assoc($recu))
        {
            $select = $_POST['perso_'.$i['id']];
            if(isset($select) && $select != 0)
            {
                /* Attention on ne peut pas envoyer plus de 12 items / courrier, sinon on découpe en plusieurs courriers. */
                $foo = 0;
                do {
                    $mail = mysql_query("INSERT INTO characters.mail_external (`sender`,`receiver`,`subject`,`message`) "
                    ."VALUES ('3', '" . $select . "', 'Cadeau Odyssée', 'Veuillez recevoir votre cadeau.')") 
                    or die("Erreur dans l'envoi du mail à ($select)");
                    $id_mail = mysql_insert_id();
                    for($qt = 0; $foo < $i['quantite'] && $qt < 12; $foo++, $qt++)
                        mysql_query("INSERT INTO characters.mail_external_items (`item`,`mail_id`) VALUES ('".$i['id_item']."', '" . $id_mail . "')") or die("Erreur dans l'envoi du mail à (-$select-)");
                    mysql_query("UPDATE site.account_cadeaux SET date_envoi = NOW(), SET id_characters = $select where id = " . $i['id']);
                    echo "<p>Votre courrier a été envoyé pour l'item ".$i['id_item']."</p>";    
                } while($foo < $i['quantite']);
            }        
        }
    }

    if ($recu) {        
    ?>
        <br/>Choisissez le perso sur lequel vous recevrez vos cadeaux: <br/>
        <form method="post" action="#"><table>
            <th><td>Item reçu</td><td>Quantité</td><td>Personnage cible</td></th>
    <?php
        while($i = mysql_fetch_assoc($recu))
        {
            $persos = mysql_query("SELECT name,guid,online,level FROM characters.characters WHERE account = " . $_SESSION['id'] );
            echo "<tr>";
            if($i['id_account'] != $_SESSION['id'])
            {
                throw new Exception("Hacking attempt!", 01);
                exit();
            }
    ?>       
            <td><?php echo $i['id_item'];?></td>
            <td><?php echo $i['quantite'];?></td>
            <td>
                <select name="<?php echo "perso_".$i['id'];?>" id="perso" class="">
                    <option value="0" selected>Ne pas envoyer</option>
    <?php
            while ($perso = mysql_fetch_array($persos)) {
                if ($perso['online'] == 0) {
                    echo '<option value="' . $perso['guid'] . '">' . $perso['name'] . ' ( ' . $perso['level'] . ' )</option>';
                } else {
                    echo "<option value='" . $perso['guid'] . "'>Vos persos doivent être déconnectés";
                }
            }
            echo "</select>";
            echo '</td></tr>';
        }
    }
    ?>
    </table>
    <input type="submit" name="ok" value="Valider"/>

    </form>
<?php } ?>    
                	<br/> 	<br/> 	<br/>
					   </div>
                    </div>
             </div>
            <div class="encadrepage-bas">
            </div>

<?php require "include/template/footer_cadres.php"?>
