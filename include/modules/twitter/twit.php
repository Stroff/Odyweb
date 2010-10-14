<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Mon titre</title>
</head>
<body>
<?php
function init()
{
    $filename = "./cache.txt";
    $datecreation = filemtime($filename);
    $time = time();
    if( $time > ($datecreation + 60) )
    {
        creationcache();
    }
    else
    {
        affiche_tweet();
    }
}
function creationcache()
{
    $twitterUser = "OdysseeServeur";
    $twitterPassword = "fzerrzer54";
    $twitter= curl_init();
    curl_setopt($twitter,CURLOPT_URL,"http://$twitterUser:$twitterPassword@twitter.com/statuses/user_timeline.json");
    curl_setopt($twitter,CURLOPT_TIMEOUT,2);
    curl_setopt($twitter,CURLOPT_RETURNTRANSFER,true);
    $tweet=curl_exec($twitter);
    if($tweet)
    {
        file_put_contents('./cache.txt',$tweet);
    }
    affiche_tweet();
}
function affiche_tweet()
{
    $rawTweets = file_get_contents('./cache.txt', true);
    $tab= json_decode($rawTweets);
    foreach($tab as $a)
    {
            echo twitter($a->text);
            echo "<br />";
    }
}
function twitter($text)
{
$search = array('|(http://[^ ]+)|', '/(^|[^a-z0-9_])@([a-z0-9_]+)/i','/(^|[^a-z0-9_])#([a-z0-9_]+)/i');
$replace = array('<a href="$1" class="lienvrai">$1</a>', '$1@<a href="http://twitter.com/$2">$2</a>','$1<a href="http://twitter.com/#search?q=%23$2">#$2</a>');
$text = preg_replace($search, $replace, $text);
return($text);
}
init();
?>
</body>
</html>