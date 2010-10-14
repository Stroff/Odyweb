        	<div class="modtwit-haut">
            </div>
            <div class="modtwit-bas">
            <div class="modtwit-titre">
            	Derniers debugs  <br/>
            </div>
            <br/>
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
    curl_setopt($twitter,CURLOPT_URL,"feed://bug.odyssee-serveur.com/issues.atom?&project_id=odyssee-serveur&fields%5B%5D=status_id&operators%5Bstatus_id%5D=c&values%5Bstatus_id%5D%5B%5D=1&operators%5Btracker_id%5D=%3D&values%5Btracker_id%5D%5B%5D=3&operators%5Bpriority_id%5D=%3D&values%5Bpriority_id%5D%5B%5D=3&operators%5Bassigned_to_id%5D=%3D&values%5Bassigned_to_id%5D%5B%5D=1006&operators%5Bauthor_id%5D=%3D&values%5Bauthor_id%5D%5B%5D=1006&operators%5Bfixed_version_id%5D=%3D&values%5Bfixed_version_id%5D%5B%5D=1&operators%5Bsubject%5D=~&values%5Bsubject%5D%5B%5D=&operators%5Bcreated_on%5D=%3Et-&values%5Bcreated_on%5D%5B%5D=&operators%5Bupdated_on%5D=%3Et-&values%5Bupdated_on%5D%5B%5D=&operators%5Bstart_date%5D=%3Ct%2B&values%5Bstart_date%5D%5B%5D=&operators%5Bdue_date%5D=%3Ct%2B&values%5Bdue_date%5D%5B%5D=&operators%5Bestimated_hours%5D=%3D&values%5Bestimated_hours%5D%5B%5D=&operators%5Bdone_ratio%5D=%3D&values%5Bdone_ratio%5D%5B%5D=&query%5Bcolumn_names%5D%5B%5D=tracker&query%5Bcolumn_names%5D%5B%5D=status&query%5Bcolumn_names%5D%5B%5D=priority&query%5Bcolumn_names%5D%5B%5D=subject&query%5Bcolumn_names%5D%5B%5D=assigned_to&query%5Bcolumn_names%5D%5B%5D=updated_on&query%5Bcolumn_names%5D%5B%5D=done_ratio&query%5Bcolumn_names%5D%5B%5D=created_on&group_by=");
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
            echo "<br /> <br/>";
    }
}
function twitter($text)
{
$search = array('|(http://[^ ]+)|', '/(^|[^a-z0-9_])@([a-z0-9_]+)/i','/(^|[^a-z0-9_])#([a-z0-9_]+)/i');
$replace = array('<a href="$1" class="lienvrai">$1</a>', '$1@<a href="http://bug.odyssee-serveur.com/issues/$2">$2</a>','$1<a href="http://bug.odyssee-serveur.com/issues/$2">#$2</a>');
$text = preg_replace($search, $replace, $text);
$txt1 = str_replace( array("nonox","agmagor", "stroff"), array("<font color=red>Nonox</font>","<font color=red>Agmagor</font>", "<font color=red>Stroff</font>"), $text );
return($txt1);
}
init();
?>
<br/>
<div class="modtwit-lien">
<a href="#"> Acceder au bugtracker <img src="medias/images/fleche.gif" /></a>
</div>

            </div>