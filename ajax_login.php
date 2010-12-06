<?php
session_start();
include("config/config.php");
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");

//get the posted values
$login_check=mysql_escape_string($_POST['login']);
$password=$_POST['password']; 
//now validating the username and password
$sql="SELECT username, password,password_old,points,pp,next_vote_date,activation,email FROM accounts2 WHERE username='".$login_check."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result); 
//if username exists
if(mysql_num_rows($result)>0) {
		$chaine = strtoupper($login_check).':'.strtoupper($password);
		$pass_old=sha1($chaine);
		$pass = sha1($password);
        //compare the password
        if($row['activation']==1&&(strcmp($row['password'],$pass)==0||strcmp($row['password_old'],$pass_old)==0))
        {
			if ($row['password']=='') {
				// je doit faire la migration en sha1 du mdp
				mysql_query("UPDATE accounts2 SET password='".$pass."', password_old='' WHERE username= '".$login_check."'");
				
				// je migre pour flyspeay maintenant
				mysql_query("INSERT into flyspray.flyspray_users SET user_name='".$row['username']."', user_pass='".md5($password)."', real_name='".$row['username']."',email_address='".$row['email']."',account_enabled='1',tasks_perpage='25',register_date='".time()."'");
				$id_compte_flyspray = mysql_insert_id();
				mysql_query("INSERT into flyspray.flyspray_users_in_groups SET user_id='".$id_compte_flyspray ."',group_id='4'");
			}
			//======= CREATION D'UN COOKIE 
       		// Date d'expiration = Timestamp actuel + 30 000 000 secondes soit presque un an 
     		$date_expiration = time() + 30000000; 
      		// Ecrire le cookie(nom du cookie, valeur du cookie, date d'expiration) 
			setcookie("login",$_POST['login'],$date_expiration); 
			setcookie("password",$pass,$date_expiration); 
			
			echo "yes";
            //now set the session from here if needed
			$_SESSION['login']=$_POST['login'];
  			$_SESSION['password']=$pass;
  			$_SESSION['points']=$row['points'];
  			$_SESSION['pp']=$row['pp'];
  			$_SESSION['next_vote']=$row['next_vote_date'];
        } else {
			if($row['activation']==0) {
				echo "noactiv";
			} else {
				echo "nopass";
			}
		}
} else {
	echo "nouser"; 
}//Invalid Login
?>