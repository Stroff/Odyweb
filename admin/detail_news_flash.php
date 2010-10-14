<?php
$secure_lvl=2;
include '../secure.php';
require "../lib/phpmailer/class.phpmailer.php";

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
<?php include "navbar.php"; ?>
<a href="liste_news_flash.php">Retour à la liste des news</a><br />
	<?php
	include 'config/config.php';
	$id_news = $_GET['id'];
	
	if (isset($_POST['submit'])) {
		/*$xml = simplexml_load_file('news_list.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
		$i=1;
		foreach ($xml->children() as $une_news) { 
			if($i==$id_news){
				$une_news['title']=utf8_encode($_POST['title']);
				$une_news['img']=utf8_encode($_POST['img']);
				$une_news['lnk']=utf8_encode($_POST['lnk']);
				$une_news[0]=html_entity_decode("<![CDATA]".$_POST['contenu']."]]>");
			}
			$i++;
		}
		$xml->asXML('news_list.xml');
		echo $xml->asXML();
		echo 'modifié';*/
		$dom = new DomDocument();
		$dom->load('news_list.xml');
		$newsList  = $dom->documentElement;
		$i=1;
		foreach($newsList->getElementsByTagName('news') as $news) {
			if($i==$id_news){
				$nouveau = $dom->createElement('news');
				
				// create attribute node
				$title = $dom->createAttribute("title");
				$nouveau->appendChild($title);
				// create attribute value node
				$titleValue = $dom->createTextNode($_POST['title']);
				$title->appendChild($titleValue);

				// create attribute node
				$img = $dom->createAttribute("img");
				$nouveau->appendChild($img);
				// create attribute value node
				$imgValue = $dom->createTextNode($_POST['img']);
				$img->appendChild($imgValue);
				
				// create attribute node
				$lnk = $dom->createAttribute("lnk");
				$nouveau->appendChild($lnk);
				// create attribute value node
				$lnkValue = $dom->createTextNode($_POST['lnk']);
				$lnk->appendChild($lnkValue);
				
				// create CDATA section
				$cdata = $dom->createCDATASection($_POST['contenu']);
				$nouveau->appendChild($cdata);
				
				
				$newsList->replaceChild($nouveau,$news);
			}
			$i++;
			$dom->save('news_list.xml');
		}
	}
	
	$i=1;
	$xml = simplexml_load_file('news_list.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
	foreach ($xml->children() as $une_news) { 
		if($i==$id_news){
			$la_news['title']=$une_news['title'];
			$la_news['img']=$une_news['img'];
			$la_news['lnk']=$une_news['lnk'];
			$la_news['contenu']=$une_news[0];
			break;	
		}
		$i++;
	}

	?>
<form id="form" name="form" method="post" action="detail_news_flash.php?id=<?php echo $id_news; ?>">

	<br />
	<label> Id de la news : </label><?php echo $id_news ?> <br />

	<br />
	<label> Titre : </label><input name="title" type="text" id="title" size="20" value="<?php echo $la_news['title']; ?>"/> <br />
	<br />

	
	<label> Contenu: </label>
	<input name="contenu" type="text" id="contenu" size="20" value="<?php echo $la_news['contenu']; ?>"/> <br />
	<br />
	
	<label> Image: </label>
	<input name="img" type="text" id="img" size="20" value="<?php echo $la_news['img']; ?>"/> <br />
	<br />
	
	<label> Url: </label>
	<input name="lnk" type="text" id="lnk" size="20" value="<?php echo $la_news['lnk']; ?>"/> <br />
	<br />
<input name="submit" id="new_valid" type="submit" value="Valider" /><br />
</form>


</body>
</html>

