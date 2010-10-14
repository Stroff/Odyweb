<?php
// je met le js de connexion ajax
	echo'<script type="text/javascript">
$(document).ready(function() { 			
$("#login_form").submit(function()
{
        //remove all the class add the messagebox classes and start fading
        //check the username exists or not from ajax
        $.post("ajax_login.php",{ login:$(\'#username\').val(),password:$(\'#password\').val() } ,function(data)
        {
          if(data==\'yes\') //if correct login detail
          {
                $("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message de confirmation</span>Connection réussie").removeClass().addClass(\'response-msg success ui-corner-all\').fadeTo(900,1,
                  function()
                  {
                     //redirect to secure page
                     document.location="index.php";
                  });
                });
          }
          else if (data==\'nouser\')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d\'erreur</span>Erreur dans le nom de compte").removeClass().addClass(\'response-msg error ui-corner-all\').fadeTo(900,1);
                });
          }
          else if (data==\'nopass\')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d\'erreur</span>Erreur dans le mot de passe.<br><a href=\'password_lost.php\'>Rappel de mot de passe?</a>").removeClass().addClass(\'response-msg error ui-corner-all\').fadeTo(900,1);
                });
          }
          else if (data==\'noactiv\')
          {
                $("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
                {
                  //add message and change the class of the box and start fading
                  $(this).html("<span>Message d\'erreur</span>Erreur votre compte n\'est pas activé.<br>Si vous l\'avez perdu rendez vous sur ce <a href=\'activation_lost.php\'>lien</a>").removeClass().addClass(\'response-msg error ui-corner-all\').fadeTo(900,1);
                });
          }
       });
       return false;//not to post the  form physically
});
});
</script>';
	// ajout du style pour les msgs d'erreurs
	echo '
	<style type="text/css">
	.response-msg {
font-size:0.9em;
margin:0 0 10px;
padding:6px 10px 10px 45px;
}
.response-msg span {
display:block;
font-weight:bold;
padding:0 0 4px;
}
.error {
-moz-background-clip:border;
-moz-background-inline-policy:continuous;
-moz-background-origin:padding;
background:#F9E5E6 url(images/icon-error.gif) no-repeat scroll 10px 50%;
border:1px solid #E8AAAD;
color:#B50007;
}
.success {
-moz-background-clip:border;
-moz-background-inline-policy:continuous;
-moz-background-origin:padding;
background:#E9F9E5 url(images/icon-confirm.gif) no-repeat scroll 10px 50%;
border:1px solid #B4E8AA;
color:#1C8400;
}
.ui-corner-all, .pagination li a, .pagination li, #tooltip, ul#dashboard-buttons li a, .fixed #sidebar {
-moz-border-radius-bottomleft:3px;
-moz-border-radius-bottomright:3px;
-moz-border-radius-topleft:3px;
-moz-border-radius-topright:3px;
}
</style>';
?>
<div class="moduser-texte" style="background: url(medias/images/h1.gif); line-height:45px; text-align:center; color:#b3dbff;">

        	<form action="login" method="get" id="login_form">
           Login compte:
            <input type="text" name="pseudo" id="username" value="" size="20">        
            Mot de passe: 
            <input type="password" name="pass" value="" id="password" size="20">  
                   
            <input type="submit" border="0" value="Connexion" name="submit" style="color:#b3dbff;" />
      
</form>
</div> 