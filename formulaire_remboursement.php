<?php

require "include/template/header_cadres.php";

?>

<?php
if (isset($_SESSION['login']))
{
if ((isset($_POST['confirmyes'])) AND (isset($_POST['confirm'])) AND ($_POST['confirm'] == "Oui")) {
    // Envoi de l'email
    $plateforme = $_POST['plateforme'];
    $media = $_POST['media'];
    $heure_debut = $_POST['heure'];
    $heure_fin = $_POST['heure2'];
    $email = $_POST['email'];
    $code = $_POST['code'];
    $tel = $_POST['tel'];
    $qte = $_POST['qte'];

    $message = "Vous recevez cet email automatique du compte : " . $_SESSION['login'] . "\n"
            . "Plateforme : " . $plateforme . "\n"
            . "Media : " . $media . "\n"
            . "Heure début : " . $heure_debut . "\n"
            . "Heure fin : " . $heure_fin . "\n"
            . "Code : " . $code . "\n"
            . "Telephone : " . $tel . "\n"
            . "Quantité : " . $qte . "\n"
            . "Le formulaire a été posté le " . date(DATE_RFC822) . " avec l'adresse IP : " . $_SERVER['REMOTE_ADDR'] . "\n"
            . "Gros bisous et bonne journée";

    $res = mail("lauriane.bart@gmail.com", "Site: Problème boutique", $message);
    if (!$res) {
        die("Impossible d'envoyer le formulaire, veuillez envoyer votre demande à stroff@odyssee-serveur.com");
    } else {
        echo "Votre demande est prise en compte, nous vous contacterons par email pour vous informer de l'avancement de votre remboursement <br/> Bonne journée et bon jeu sur Odyssée" ;
    }
}
elseif ((isset($_POST['confirmyes'])) AND (isset($_POST['confirm'])) AND ($_POST['confirm'] == "Non"))
{
     header('Location: formulaire_remboursement.php');  
}
?>

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
if (!isset($_POST['OK'])) {
?>
            <div class="formulaires" >
                <br/>   <br/>
                <h2 class="hache1"> Formulaire de revalidation des achats </h1>
                    <br/> <div style="text-align: center; color: #66cccc; font-weight: bold "> Rappel: Les transactions effectuées via paypal ont directement été remboursées via celui-ci, refaites directement vos achats. </div>  <br/>  <br/>

                    <form action="#" method="post">
                        <div class="form-fill">  Choisissez votre plateforme de paiement: </div>
                        <div class="form-fill2">
                            <select name="plateforme">
                                <option value ="Starpass">Starpass</option>
                                <option value ="Webopass">Webopass</option>
                            </select> </div> <br/><br/>
                        <div class="form-fill">Par quel biais avez-vous effectué votre achat? </div>
                        <div class="form-fill2">
                            <select name="media">
                                <option value ="Sms">Sms</option>
                                <option value ="Audiotel">Appel surtaxé</option>
                                <option value ="Autre">Autre</option>
                            </select>
                        </div> <br/><br/>
                        Entrez le mail par lequel vous souhaitez être averti<br/> de l'avancement de votre remboursement :<div class="form-fill2"><input type="text" name="email" /> </div> <br/><br/>
<?php ?>
                        <br/><br/>
                        Combien d'achats avez-vous effectués? <input type="text" name="qte" /> <br/><br/>
                        Entrez le code donné lors de la transaction (s'il y en a plusieurs, separez les d'une virgule)<input type="text" name="code" /> <br/><br/>
                        Entrez l'heure aproximative de votre achat (format: hh:mm) Entre <input type="text" name="heure" /> Et <input type="text" name="heure2" /> <br/><br/>

                        Entrez le numéro de telephone par lequel vous avez effectué votre appel en cas de perte du code: <input type="text" name="tel"/> <br/><br/>

                        <br/><br/>
                        <input type="submit" name="OK">
                    </form>

<?php
} else {

    $plateforme = $_POST['plateforme'];
    $media = $_POST['media'];
    $compte = $_SESSION['login'];
    $heure_debut = $_POST['heure'];
    $heure_fin = $_POST['heure2'];
    $email = $_POST['email'];
    $code = $_POST['code'];
    $tel = $_POST['tel'];
    $qte = $_POST['qte'];
    echo " <div class=\" form-fill\"> Votre plateforme d'achat:</div> <div class=\" form-fill2\"> " . $plateforme . " </div> <br/><div class=\" form-fill\"> Votre moyen de transaction: </div> <div class= \"form-fill2\"> " . $media . " </div><br/>";
    echo " <div class=\" form-fill\"> Vos codes: :</div> <div class=\" form-fill2\"> " . $code . " </div> <br/><div class=\" form-fill\"> Votre numéro de téléphone: </div> <div class= \"form-fill2\"> " . $tel . " </div><br/>";
    echo " <div class=\" form-fill\"> Nombre d'achats:</div> <div class=\" form-fill2\"> " . $qte . " </div> <br/><div class=\" form-fill\"> Heures d'achat: </div> <div class= \"form-fill2\"> Entre: " . $heure_debut . " Et: " . $heure_fin . " </div><br/>";
    echo "<br/> Confirmez vous la demande d'envoi de vos points Odyssée sur le compte " . $compte . " sur votre email : " . $email . " et que toutes les données sont correctes? <br/>";
?><form action="#" method="post">
                        <input type="hidden" name="plateforme" value="<?php echo $_POST['plateforme']; ?>"/>
                        <input type="hidden" name="media" value="<?php echo $_POST['media']; ?>"/>
                        <input type="hidden" name="heure" value="<?php echo $_POST['heure']; ?>"/>
                        <input type="hidden" name="heure2" value="<?php echo $_POST['heure2']; ?>"/>
                        <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>"/>
                        <input type="hidden" name="tel" value="<?php echo $_POST['tel']; ?>"/>
                        <input type="hidden" name="qte" value="<?php echo $_POST['qte']; ?>"/>

                        <select name="confirm">
                            <option value ="Oui">Oui</option>
                            <option value ="Non">Non</option>
                        </select>
                        <input type="submit" name="confirmyes">
                    </form>
<?php }}
 else {

 {
     echo "Vous devez être loggué sur votre compte pour acceder au formulaire. <a href=\"login.php\">Page de connection</a>";
 }
}?>

                    <br/><br/><br/>

            </div>
        </div>
    </div>
    <div class="encadrepage-bas">
    </div>

<?php require "include/template/footer_cadres.php" ?>
