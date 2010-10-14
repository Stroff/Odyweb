<?php
$secure_lvl=2;
include '../secure.php';
require "../lib/phpmailer/class.phpmailer.php";

	include 'config/config.php';
	$id_news = $_GET['id'];
	if (isset($_POST['submit'])) {
		$dom = new DomDocument();
		$dom->load('news_list.xml');
		$newsList  = $dom->documentElement;
		$i=1;
		foreach($newsList->getElementsByTagName('news') as $news) {
			if($i==$_GET['id']){
				$newsList->removeChild($news);
			}
			$i++;
			$dom->save('news_list.xml');
		}
		echo "suppression de la news Ok";
	} else {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" title="currentStyle">
	@import "css/demo_page.css";
	@import "css/demo_table.css";
	@import "css/style.css";
</style>

<title>Détails de la news</title>
</head>
<body>
<a href="liste_news_flash.php">Retour à la liste des news</a><br />
<form id="form" name="form" method="post" action="delete_news_flash.php?id=<?php echo $id_news; ?>">

	<br />
	<label> Id de la news : </label><?php echo $id_news ?> <br />
	<br />
<label>Voulez vous vraiment supprimer la news ?</label><br /><br />
<input name="submit" id="new_valid" type="submit" value="Oui" /><br />
</form>


</body>
</html>

	
	<?php }?>