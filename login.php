<?php require "include/template/header_cadres.php"  ?>
<script type="text/javascript">
$(document).ready(function() { 			
$("#login_form").submit(function()
{
        //remove all the class add the messagebox classes and start fading
        //check the username exists or not from ajax
        $.post("ajax_login.php",{ login:$('#username').val(),password:$('#password').val() } ,function(data)
        {
          if(data=='yes') //if correct login detail
          {
                $("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message de confirmation</span>Connection réussie").removeClass().addClass('response-msg success ui-corner-all').fadeTo(900,1,
                  function()
                  {
                     //redirect to secure page
                     document.location="index.php";
                  });
                });
          }
          else if (data=='nouser')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d'erreur</span>Erreur dans le nom de compte").removeClass().addClass('response-msg error ui-corner-all').fadeTo(900,1);
                });
          }
          else if (data=='nopass')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d'erreur</span>Erreur dans le mot de passe.<br><a href='password_lost.php'>Rappel de mot de passe?</a>").removeClass().addClass('response-msg error ui-corner-all').fadeTo(900,1);
                });
          }
          else if (data=='noactiv')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d'erreur</span>Erreur votre compte n'est pas activé.<br>Si vous l'avez perdu rendez vous sur ce <a href='activation_lost.php'>lien</a>").removeClass().addClass('response-msg error ui-corner-all').fadeTo(900,1);
                });
          } else if (data=='lock')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d\'erreur</span>Erreur votre compte est verrouillé.<br>Vous devez attendre pour pouvoir tenté un nouveau mot de passe").removeClass().addClass('response-msg error ui-corner-all').fadeTo(900,1);
                });
          }
       });
       return false;//not to post the  form physically
});

$("#form").submit(function()
{
        //remove all the class add the messagebox classes and start fading
        //check the username exists or not from ajax
        $.post("ajax_login.php",{ login:$('#username_grand').val(),password:$('#password_grand').val() } ,function(data)
        {
          if(data=='yes') //if correct login detail
          {
                $("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message de confirmation</span>Connection réussie").removeClass().addClass('response-msg success ui-corner-all').fadeTo(900,1,
                  function()
                  {
                     //redirect to secure page
                     document.location="index.php";
                  });
                });
          }
          else if (data=='nouser')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d'erreur</span>Erreur dans le nom de compte").removeClass().addClass('response-msg error ui-corner-all').fadeTo(900,1);
                });
          }
          else if (data=='nopass')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d'erreur</span>Erreur dans le mot de passe.<br><a href='password_lost.php'>Rappel de mot de passe?</a>").removeClass().addClass('response-msg error ui-corner-all').fadeTo(900,1);
                });
          }
          else if (data=='noactiv')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d'erreur</span>Erreur votre compte n'est pas activé.<br>Si vous l'avez perdu rendez vous sur ce <a href='activation_lost.php'>lien</a>").removeClass().addClass('response-msg error ui-corner-all').fadeTo(900,1);
                });
          }
       });
       return false;//not to post the  form physically
});

});
</script>
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
                    	<div class="blocpage-texte" align="center">
     	<br/> 	<br/> 
    <h3>Connexion</h3>
  					<form action="" method="post" name="login_form_grand" id="form">
					<div style="margin-left:20px;">
						<br />
					    <label style="width: 215px;font-weight: normal;"> Nom de compte : </label>
					    <input name="username_grand" type="text" id="username_grand" size="20"/> <br />

						<br />
					    <label style="width: 215px;font-weight: normal;"> Mot de passe : </label>
					    <input name="password_grand" type="password" id="password_grand" size="20"/><br />

						<br />
						<input style="margin-left: 213px;" type="submit" value="Envoyer" />

						<br />
						<label style="width: 215px;font-weight: normal;"><a href='password_lost.php'>Rappel de mot de passe?</a></label>
					</div>
					</form>
						
                        	<br/> 	<br/> 	<br/> 
					   </div>
                    </div>
             </div>
            <div class="encadrepage-bas">
            </div> 
            
<?php require "include/template/footer_cadres.php"?>
