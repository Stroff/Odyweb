<?php
function reduction_string($msg,$longeur) {
	$nbr1 = strlen($msg);
	if($nbr1 > $longeur)
	{
		$string = substr($msg, 0, $longeur);
		$string .= ' ...';
	}else{ 
		$string = $msg;
	}
return $string;
}

function mysql2timestamp($datetime){
       $val = explode(" ",$datetime);
       $date = explode("-",$val[0]);
       $time = explode(":",$val[1]);
       return mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
}

function bbcode($text)  
{ 
  // Pour garder les espaces 
  $text = str_replace('  ','&nbsp; ', stripslashes($text)); 

  // Pour créer les sauts de ligne 
  $text = preg_replace("#n#i", '<br>', $text); 

  // Pour les images, on enlève http pour éviter d'y voir un lien 
  if (eregi('[ picture=', $text))  {  $text = preg_replace("#[ picture=http://#i",'[ picture=', $text);  } 

  // Pour les videos, on enlève http pour éviter d'y voir un lien et on transforme les liens Youtube en url menant directement à la vidéo 
  if (eregi('[ video=', $text))  {  $text = preg_replace("#[ video=http://#i",'[ video=', $text);  $text = preg_replace("#[ video=www.youtube.com/watch?v=#i",'[ video=www.youtube.com/v/', $text);  } 

  // Pour les url classiques et hypertexte 
  if (eregi('[ /url]', $text))  {  $text = preg_replace("#url=http#i",'url=hzzp', $text);  $text = preg_replace("#url]http#i",'url]hzzp', $text);  $array_test_beg = split('[ url',strtolower($text)) + split('[ URL',strtolower($text));  $array_test_end = split('[ /url]',strtolower($text)) + split('[ /URL]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  if (eregi('[ url=', $text))  $text = preg_replace("#[ url=([ ^[ ]*) ?] ?([ ^]]*) ?[ /url]#i", '<a href="1" rel="nofollow" target="_blank" title="2">2</a>', $text);  if (eregi('[ url]', $text))  $text = preg_replace("#[ url]([ ^[ ]*)[ /url]#i", '<a href="1" rel="nofollow" target="_blank">1</a>', $text);  } } 

  // Pour les Url non entourées de tags 
  if (eregi('http://', $text))  {  $text = str_replace("&quot;"," ++^^$$&quot;",$text);  $text = preg_replace("#([ n ])?http://([ a-z0-9-=_%#$~%&;?./()+]+)#i", '1<a href="http://2" rel="nofollow" target="_blank">http://2</a>', $text);  $text = str_replace(" ++^^$$&quot;","&quot;",$text);  } 

  // Pour les Url classiques, reformatage 
  if (eregi('hzzp', $text))  {  $text = preg_replace("#hzzp#i",'http', $text);  } 


  if (eregi('[ ', $text)) 
  { 

  // Pour les couleurs 
  if (eregi('[ /color]', $text))  {  $array_test_beg = split('[ color=',strtolower($text)) + split('[ COLOR=',strtolower($text));  $array_test_end = split('[ /color]',strtolower($text)) + split('[ /COLOR]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $text = preg_replace("#[ color=red]#i", '<font color="#FF0000">', $text);    $text = preg_replace("#[ color=magenta]#i", '<font color="#FF00FF">', $text);    $text = preg_replace("#[ color=brown]#i", '<font color="#AA0000">', $text);    $text = preg_replace("#[ /color]#i", '</font>', $text);  } } 

  // Pour les tailles 
  if (eregi('[ /size]', $text))  {  $array_test_beg = split('[ size=',strtolower($text)) + split('[ SIZE=',strtolower($text));  $array_test_end = split('[ /size]',strtolower($text)) + split('[ /SIZE]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $text = preg_replace("#[ size=([ 0-9])]([ ^]]*)[ /size]#i", '<font size="1">2</font>', $text); } } 

  // Pour les images 
  if (eregi('[ /picture]', $text))  {  $array_test_beg = split('[ picture=',strtolower($text)) + split('[ PICTURE=',strtolower($text));  $array_test_end = split('[ /picture]',strtolower($text)) + split('[ /PICTURE]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  if (eregi('[ picture=', $text))  $text = preg_replace("#[ picture=([ ^[ ]*) ?] ?([ ^]]*) ?[ /pic]#i", '<img src="http://1" alt="2">', $text);  } } 
  
  // Pour les videos youtube (par exemple) 
  if (eregi('[ video=', $text))  {  $text = preg_replace("#[ video=([ a-z0-9-=_%#$~%&;:?./]+)]#i", '<object width="425" height="350"><param name="movie" value="http://1"></param><param name="allowFullScreen" value="true"></param><param name="wmode" value="transparent"></param><embed src="http://1" type="application/x-shockwave-flash" wmode="transparent" width="425" height="350" allowFullScreen="true"></embed></object>', $text);  } 

  // Pour les tableaux 
  if (eregi('[ /table]', $text))  {  $array_test_beg = split('[ table',strtolower($text)) + split('[ TABLE',strtolower($text));  $array_test_end = split('[ /table]',strtolower($text)) + split('[ /TABLE]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $text = preg_replace("#[ table=([ 0-9]+)]#i", '<table width="1">', $text);    $text = preg_replace("#[ table]#i",'<table>', $text);    $text = preg_replace("#[ /table]#i",'</table>', $text);    $text = preg_replace("#[ tr]#i",'<tr>', $text);    $text = preg_replace("#[ /tr]#i",'</tr>', $text);    $text = preg_replace("#[ td]#i",'<td>', $text);    $text = preg_replace("#[ /td]#i",'</td>', $text);  } } 

  // Pour les smilies, juste un exemple 
  if (eregi('[ :', $text))  {  if (eregi('[ :)]',$text)) $text = preg_replace("#[ :)]#i", '<img src="/images/smilies/smile.gif">', $text);  } 

  if (eregi('[ /b]', $text))  {  $array_test_beg = split('[ b]',strtolower($text)) + split('[ B]',strtolower($text));  $array_test_end = split('[ /b]',strtolower($text)) + split('[ /B]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $text = preg_replace("#[ b]#i", '<b>', $text);    $text = preg_replace("#[ /b]#i", '</b>', $text);  } } 
  if (eregi('[ /i]', $text))  {  $array_test_beg = split('[ i]',strtolower($text)) + split('[ I]',strtolower($text));  $array_test_end = split('[ /i]',strtolower($text)) + split('[ /I]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $text = preg_replace("#[ i]#i", '<i>', $text);    $text = preg_replace("#[ /i]#i", '</i>', $text);  } } 
  if (eregi('[ /u]', $text))  {  $array_test_beg = split('[ u]',strtolower($text)) + split('[ U]',strtolower($text));  $array_test_end = split('[ /u]',strtolower($text)) + split('[ /U]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $text = preg_replace("#[ u]#i", '<u>', $text);    $text = preg_replace("#[ /u]#i", '</u>', $text);  } } 

  if (eregi('[ /strike]', $text))  {  $array_test_beg = split('[ strike]',strtolower($text)) + split('[ STRIKE]',strtolower($text));  $array_test_end = split('[ /strike]',strtolower($text)) + split('[ /STRIKE]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $text = preg_replace("#[ strike]#i", '<strike>', $text);    $text = preg_replace("#[ /strike]#i", '</strike>', $text);  } } 

  if (eregi('[ /code]', $text))  {  $array_test_beg = split('[ code]',strtolower($text)) + split('[ CODE]',strtolower($text));  $array_test_end = split('[ /code]',strtolower($text)) + split('[ /CODE]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $quote_color = '#FFE0B0';  $text = preg_replace("#[ code]#i",'<div style="color:#333333;background-color:'.$quote_color.';"><code>', $text);    $text = preg_replace("#[ /code]#i",'</code></div>', $text);  } } 
  if (eregi('[ /quote]', $text))  {  $array_test_beg = split('[ quote]',strtolower($text)) + split('[ QUOTE]',strtolower($text));  $array_test_end = split('[ /quote]',strtolower($text)) + split('[ /QUOTE]',strtolower($text));  if (count($array_test_beg) == count($array_test_end)) {  $text = preg_replace("#[ quote]#i",'<div style="background-color:#F0F0F0;"><blockquote><font size="-1">', $text);    $text = preg_replace("#[ /quote]#i",'</font></blockquote></div>', $text);  } } 

  if (eregi('[ /email]', $text))  {  $text = preg_replace("#[ email]#i",'', $text);    $text = preg_replace("#[ /email]#i",'', $text);  } 

  } 

  // Pour les adresses email en format texte 
  if (eregi('@', $text))  {  $text = preg_replace("#([ n ])?([ a-z0-9-_.]+)@([ a-z0-9-_.]+)#i", '12(at)3', $text);  } 


  return($text); 
} 


function bbcode_title($text)  
{ 
  // Pour les sauts de ligne 
  $text = preg_replace("#([ nr]+)#i", ' ', stripslashes($text)); 

  // Pour les tags  
  if (eregi('[ ', $text))  {  $text = preg_replace("#[ (.[ ^]]*)]#i", '', $text);  } 

  // Pour les adresses email en format texte 
  if (eregi('@', $text))  {  $text = preg_replace("#([ n ])?([ a-z0-9-_.]+)@([ a-z0-9-_.]+)#i", '12(at)3', $text);  } 
  
  return $text; 
}
 function timestamp2mysql($ts) 
    { 
        $d=getdate($ts);
        
        $yr=$d["year"];
        $mo=$d["mon"];
        $da=$d["mday"];
        $hr=$d["hours"];
        $mi=$d["minutes"];
        $se=$d["seconds"]; 

        return sprintf("%04d%02d%02d%02d%02d%02d",$yr,$mo,$da,$hr,$mi,$se); 
    }
function timestamp_to_h_m_s_relative($time){
	if ($time>=86400)
	/* 86400 = 3600*24 c'est à dire le nombre de secondes dans un seul jour ! donc là on vérifie si le nombre de secondes donné contient des jours ou pas */
	{
	// Si c'est le cas on commence nos calculs en incluant les jours

	// on divise le nombre de seconde par 86400 (=3600*24)
	// puis on utilise la fonction floor() pour arrondir au plus petit
	$jour = floor($time/86400); 
	// On extrait le nombre de jours
	$reste = $time%86400;

	$heure = floor($reste/3600); 
	// puis le nombre d'heures
	$reste = $reste%3600;

	$minute = floor($reste/60); 
	// puis les minutes

	$seconde = $reste%60; 
	// et le reste en secondes

	// on rassemble les résultats en forme de date
	$result = $jour.'j '.$heure.'h '.$minute.'min '.$seconde.'s';
	}
	elseif ($time < 86400 AND $time>=3600)
	// si le nombre de secondes ne contient pas de jours mais contient des heures
	{
	// on refait la même opération sans calculer les jours
	$heure = floor($time/3600);
	$reste = $time%3600;

	$minute = floor($reste/60);

	$seconde = $reste%60;

	$result = $heure.'h '.$minute.'min ';
	}
	elseif ($time<3600 AND $time>=60)
	{
	// si le nombre de secondes ne contient pas d'heures mais contient des minutes
	$minute = floor($time/60);
	$seconde = $time%60;
	$result = $minute.'min ';
	}
	elseif ($time < 60)
	// si le nombre de secondes ne contient aucune minutes
	{
	$result = $time.'s';
	}
	return $result;
}
function get_ip(){ 
	
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){ 
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif(isset($_SERVER['HTTP_CLIENT_IP'])){ 
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else{ 
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	return $ip;
}
function convert_text_for_uri($text) {
	// Remove all accents.
	$convertedCharacters = array(
		"À" => "A", "Á" => "A", "Â" => "A", "Ã" => "A", "Ä" => "A", "Å" => "A",
		"à" => "a", "á" => "a", "â" => "a", "ã" => "a", "ä" => "a", "å" => "a",
		"Ò" => "O", "Ó" => "O", "Ô" => "O", "Õ" => "O", "Ö" => "O", "Ø" => "O",
		"ò" => "o", "ó" => "o", "ô" => "o", "õ" => "o", "ö" => "o", "ø" => "o",
		"È" => "E", "É" => "E", "Ê" => "E", "Ë" => "E",
		"é" => "e", "è" => "e", "ê" => "e", "ë" => "e",
		"Ç" => "C", "ç" => "c",
		"Ì" => "I", "Í" => "I", "Î" => "I", "Ï" => "I",
		"ì" => "i", "í" => "i", "î" => "i", "ï" => "i",
		"Ù" => "U", "Ú" => "U", "Û" => "U", "Ü" => "U",
		"ù" => "u", "ú" => "u", "û" => "u", "ü" => "u",
		"ÿ" => "y",
		"Ñ" => "N", "ñ" => "n",
	);

	$text = strtr($text, $convertedCharacters);
	
      $text = strtolower($text);      
      $text = ereg_replace("[^a-zA-Z0-9]", "_", $text);
      
      while (strstr($text, '__'))
         $text = str_replace('__', '_', $text);
         
      return(ereg_replace("_$", "", $text));
}
function check_email_address($email) {
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
         if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            return false;
        }
    }    
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
}
function genere_password($length) {
	// Ensemble des caractères utilisés pour le créer
	$cars='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	// Combien on en a mis au fait ?
	$wlong=strlen($cars);
	// Au départ, il est vide ce mot de passe ;)
	$wpas="";
	// On initialise la fonction aléatoire
	srand((double)microtime()*1000000);
	// On boucle sur le nombre de caractères voulus
	for($i=0;$i<$length;$i++){
	// Tirage aléatoire d'une valeur entre 1 et wlong
	      $wpos=rand(0,$wlong-1);
	// On cumule le caractère dans le mot de passe
	      $wpas=$wpas.substr($cars,$wpos,1);
	// On continue avec le caractère suivant à générer      
	}
	// On affiche le mot de passe (on peut le stocker quelque part...)
	return $wpas;
}
function generate_multipass_tender($email, $pseudo){
	$account_key = "odyssee";
	$api_key     = "e0ba06c114a38ecda11e0b56b937fc7488b580afdab1fa1c0aa5c3d1e7ff3263e198736348b912534ee146b38a8a71d108b78950c4f8d145223cf4f60362b1b3";
	$salted = $api_key . $account_key;
	$hash = hash('sha1',$salted,true);
	$saltedHash = substr($hash,0,16);
	$iv = "OpenSSL for Ruby";
	// use an expires date in the future, of course
	$user_data = array(
		"email" =>$email,
		"name" => $pseudo,
		"tender_pseudo" => $pseudo,
		"expires" => date("Y-m-d H:i:s\Z", strtotime("+30 minutes"))
		);
	$data = json_encode($user_data);
	// double XOR first block
	for ($i = 0; $i < 16; $i++)
	{
		$data[$i] = $data[$i] ^ $iv[$i];
	}

	$pad = 16 - (strlen($data) % 16);
	$data = $data . str_repeat(chr($pad), $pad);

	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'','cbc','');
	mcrypt_generic_init($cipher, $saltedHash, $iv);
	$encryptedData = mcrypt_generic($cipher,$data);
	mcrypt_generic_deinit($cipher);

	$encryptedData = base64_encode($encryptedData);
	$encryptedData = preg_replace('/\=$/', '', $encryptedData);
	$encryptedData = preg_replace('/\=$/', '', $encryptedData);
	$encryptedData = preg_replace('/\n/', '', $encryptedData);
	$encryptedData = preg_replace('/\+/', '-', $encryptedData);
	$encryptedData = preg_replace('/\//', '_', $encryptedData);

	return urlencode($encryptedData);
}
?>