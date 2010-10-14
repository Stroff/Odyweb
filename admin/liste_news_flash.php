<?php
$secure_lvl=2;
include '../secure.php';
$xml = simplexml_load_file('news_list.xml', 'SimpleXMLElement', LIBXML_NOCDATA);		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<style type="text/css" title="currentStyle">
	@import "css/demo_page.css";
	@import "css/demo_table.css";

</style>
<title>Liste des news du flash</title>
</head>
<body>
<?php include "navbar.php"; ?>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
		<tr>
			<th>Titre de la news</th>
			<th>Contenu</th>
			<th>Image</th>
			<th>url</th>
			<th>Action</th>
		</tr>
	<?php
	include 'config/config.php';
	$i=1;
	foreach ($xml->children() as $une_news) { 
		echo '<tr class="gradeA">';
		echo '<td><a href="detail_news_flash.php?id='.$i.'">'.$une_news['title'].'</a></td>';
		echo '<td>'.$une_news[0].'</td>';
		echo '<td>'.$une_news['img'].'</td>';
		echo '<td>'.$une_news['lnk'].'</td>';
		echo '<td><a href="delete_news_flash.php?id='.$i.'">Suppression</a></td>';

		echo '</tr>';
		$i++;
	}
	?>
	</table>
	<a href="ajout_news_flash.php">Ajout d'une news</a>
</body>
</html>
