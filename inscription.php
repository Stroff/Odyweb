<?php 
$secure_lvl = 0;
$header_titre = "Inscription";
require "lib/phpmailer/class.phpmailer.php";
require "include/template/header_cadres.php";
  ?>
<link rel="stylesheet" href="medias/css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" title="default" />
<!-- <script src="Scripts/jquery.js" type="text/javascript"></script -->
<script src="Scripts/jquery.validationEngine-fr.js" type="text/javascript"></script>
<script src="Scripts/jquery.validationEngine.js" type="text/javascript"></script>

<script type="text/javascript">
//Make sure the document is loaded
$(document).ready(function(){

	$("#form").validationEngine({
	inlineValidation: true,
	success :  true,
	failure : false
	})
 });
</script>
        	

        	<div class="encadrepage-haut">
            	<div class="encadrepage-titre">
                        <br/>
                        <br/>
           	            <img src="medias/images/titre/inscription.gif" >
                    
            	</div>
            </div>
            	<div class="blocpage">
                	<div class="blocpage-haut">
                    </div>
                    <div class="blocpage-bas">
                    	<div class="blocpage-texte">
							<div class="formulaires">
								
										<?php
											if ($_POST ["nom"]) {
												$connexion = mysql_connect($host_site, $user_site , $pass_site);
												mysql_select_db($site_database ,$connexion);
												mysql_query("SET NAMES 'utf8'");

												$new_compte_nom = mysql_escape_string ( $_POST ["nom"]);
												$new_compte_email = mysql_escape_string ( $_POST ["email"]);
												$new_compte_extension = mysql_escape_string ( $_POST ["extension"]);

												$sql_check_nom = mysql_query("SELECT username FROM accounts where username = '".$new_compte_nom."'");

												if (mysql_num_rows($sql_check_nom)==0&&check_email_address($new_compte_email)&&$new_compte_nom<>''&&$new_compte_extension<>''&&$_POST ['password1']==$_POST ['password2']) {
													$oldhash_nouveau_password = sha1(strtoupper($new_compte_nom).':'.strtoupper($_POST['password1']));
													$newhash_nouveau_password = sha1($_POST ['password1']);
													$token = md5(uniqid(rand(), true));

													//le serveur site				
													$sql = "INSERT INTO accounts SET password='" . $newhash_nouveau_password . "',password_old='" . $oldhash_nouveau_password . "',activation='0',email='".$new_compte_email."', key_activation='".$token."', extension = '".$new_compte_extension."', username='" . $new_compte_nom . "',next_vote_date=NOW(),last_ip='".get_ip()."'" ;
													$resReqWow = mysql_query ($sql ) or die ( mysql_error () );

													// migration redmine
													mysql_query("INSERT INTO redmine.users SET login='".$new_compte_nom."', hashed_password='".$newhash_nouveau_password ."', mail='".$new_compte_email."', language='fr', status=1, type='User', created_on=NOW()");
													/*	
													// je migre pour flyspeay maintenant
													mysql_query("INSERT into flyspray.flyspray_users SET user_name='".$new_compte_nom."', user_pass='".md5($_POST ['password1'])."', real_name='".$new_compte_nom."',email_address='".$new_compte_email."',account_enabled='1',tasks_perpage='25',register_date='".time()."'");
													$id_compte_flyspray = mysql_insert_id();
													mysql_query("INSERT into flyspray.flyspray_users_in_groups SET user_id='".$id_compte_flyspray ."',group_id='4'");
													*/
													//serveur wow connexion ici
													mysql_close();
													$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
													mysql_select_db($wow_realmd ,$connexion);
													$resReqSite = mysql_query ( "INSERT INTO account SET sha_pass_hash='', expansion = '".$new_compte_extension."',email='".$new_compte_email."',v='',s='',sessionkey='', username='" . $new_compte_nom . "'" ) or die ( mysql_error () );

													if ($resReqSite && $resReqWow) {

														$subject = "Inscription sur le serveur Odyssée Serveur";
														// message
														$message = '<h2>Email de confirmation</h2><p>Bonjour</p><p>Vous avez demandé à vous inscrire sur le serveur privé Odyssée-Serveur, pour confirmer votre demande et pouvoir jouer vous devez suivre ce <a href="'.$url_site.'/activation.php?code='.$token.'">lien</a> vers notre page de confirmation.</p> <p>Merci.</p>';

														$mail = new PHPmailer();
														$mail->IsSMTP();
														$mail->Host='127.0.0.1';
														$mail->CharSet	=	"UTF-8";
														$mail->IsHTML(true);
														$mail->FromName="Odyssée Serveur";
														$mail->From='site@odyssee-serveur.com';
														$mail->AddAddress($new_compte_email);
														$mail->AddReplyTo('site@odyssee-serveur.com');	
														$mail->Subject=$subject;
														$mail->Body=$message;
														if($mail->Send()){ //Teste le return code de la fonction
														    echo '<div style="margin-left:20px;"><br> Votre compte a bien été crée mais vous devez l\'activer pour pouvoir jouer. Il vous suffira de cliquer sur le lien dans le mail de confirmation.</br></div>';
															echo '</div></div></div></div><div class="encadrepage-bas">
															</div>';
															include'include/template/footer_cadres.php';
															exit;
														} else {
															echo '<div style="margin-left:20px;"><br> Votre compte a bien été crée mais le mail de confirmation n\'a pas été envoyé. Veuillez contacté un développeur sur le forum.</br></div>';
															echo '</div></div></div></div><div class="encadrepage-bas">
															</div>';
															include'include/template/footer_cadres.php';
															exit;
														}

													} else {
														$erreur = '<br> Erreur dans la création de compte avec notre serveur de base de données</br>Contactez root@odyssee-serveur.com';
													}
												} else {
													if (mysql_num_rows($sql_check_nom)>0) {
														$erreur = 'Quelqu\'un posséde déjà ce nom de compte';
													}
													if (!check_email_address($new_compte_email)){
														$erreur = 'L\'email n\'est pas une adresse correcte';
													}
													if ($new_compte_extension<>''&&$new_compte_nom<>'') {
														$erreur = 'Vous devez remplir tous les champs';
													}
													if($_POST ["password1"]<>$_POST ["password2"]) {
														$erreur = 'Vos mots de passe ne sont pas identiques';

													}
												}

											}
											if($erreur <> ""){
												echo '<div class="warning">'.$erreur."</div>";
											}
										?>
                        		
                              <form action="inscription.php" method="post" enctype="multipart/form-data" name="form" id="form">
                               <div class="warning">Vous allez recevoir un email de confirmation après l'inscription pour pouvoir vous connecter.</div>
                                    <br />
                                    <label class="form-fill"> Nom de compte :</label>
                                     <div class="form-fill2"><input name="nom" type="text" id="nom" size="20" class="validate[required,custom[noSpecialCaracters],length[0,20],ajax[ajaxUser]]]" /> </div> <br />
                            
                                    <label class="form-fill"> Adresse email :</label>
                                     <div class="form-fill2"><input name="email" type="text" id="email" size="20" class="validate[required,custom[email],ajax[ajaxEmail]]" /> </div> <br />
                            
                                    <label class="form-fill"> Mot de passe :</label>
                                     <div class="form-fill2"><input name="password1" type="password" id="password1" size="20" class="validate[required,length[6,31]]" /> </div> <br />
                            
                                    <label class="form-fill"> Mot de passe confirmation :</label>
                                     <div class="form-fill2"><input name="password2" type="password" id="password2" size="20" class="validate[required,confirm[password1]]" /> </div> <br />
                            
                                    <label class="form-fill"> Extension :</label>
                                     <div class="form-fill2"><SELECT name="extension">
                                        <OPTION VALUE="0">WoW classique</OPTION>
                                        <OPTION VALUE="1">Burning Crusade</OPTION>
                                        <OPTION VALUE="2" selected >Wrath of the Lich King</OPTION>
                                    </SELECT> </div> <br />
                              
                                    <label class="form-fill"> J'accepte le <a href='reglement.php'>règlement</a> :</label>
                                     <div class="form-fill2"><input class="validate[required] checkbox" type="checkbox"  id="agree"  name="agree"/> </div> <br />  <br/>		
                          <div align="center">    <input type="submit" value="Envoyer" /> </div>
							</form>
                              <br/> <br/>
							</div>

<br/> <br/> <br/> 						</div>
                    </div>
                </div>
            <div class="encadrepage-bas">
            </div> 
                       
    
   
<?php require "include/template/footer_cadres.php"?>
