<?php
include '../config/config.php';
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
mysql_select_db($wow_characters ,$connexion);
mysql_query("SET NAMES 'utf8'");
$sql = mysql_query("SELECT mail.sender, 
	mail.id,
	mail_items.item_template, 
	mail.money, 
	characters.name AS perso_nom,
	characters.guid AS perso_id,
	realmd.account.username ,
	realmd.account.id AS account_id
FROM mail_items INNER JOIN mail ON mail_items.mail_id = mail.id
	 INNER JOIN characters ON mail.sender = characters.guid
	 INNER JOIN realmd.account ON realmd.account.id = characters.account WHERE mail.receiver=3");


while($un_mail = mysql_fetch_array($sql)) {
	$mail[$un_mail['id']]['item_template'] = $un_mail['item_template'];
	$mail[$un_mail['id']]['money']= $un_mail['money'];
	$mail[$un_mail['id']]['username'] = $un_mail['username'];
	$mail[$un_mail['id']]['id_compte'] = $un_mail['account_id'];
	$mail[$un_mail['id']]['perso_nom'] = $un_mail['perso_nom'];
	$mail[$un_mail['id']]['perso_id'] = $un_mail['perso_id'];
}
if(count($mail)>0){
	foreach ($mail as $clee => $valeurs) {
		mysql_query("DELETE FROM mail WHERE id = '".$clee."'");
		mysql_query("DELETE FROM mail_items WHERE mail_id = '".$clee."'");
	}
}
mysql_close();
$connexion = mysql_connect($host_site, $user_site , $pass_site);
mysql_select_db($site_database ,$connexion);
mysql_query("SET NAMES 'utf8'");
$sql_boutique = mysql_query("SELECT prix, id_objet_ig,id_objet FROM items_boutique");
while($un_item = mysql_fetch_array($sql_boutique)) {
		$item[$un_item['id_objet_ig']]['id'] = $un_item['id_objet_ig'];
		$item[$un_item['id_objet_ig']]['id_wowhead'] = $un_item['id_objet'];
		$item[$un_item['id_objet_ig']]['prix'] = $un_item['prix'];
}
if(count($mail)>0){
	foreach ($mail as $clee => $valeurs) {
		mysql_query("UPDATE accounts SET points=points+".$item[$valeurs['item_template']]['prix']." WHERE id = '".$valeurs['id_compte']."'");
		mysql_query("INSERT INTO logs_achat_boutique SET account_id='".$valeurs['id_compte']."',perso_id='".$valeurs['perso_id']."', perso_nom='".$valeurs['perso_nom']."', objet_id ='prix=".$item[$valeurs['item_template']]['prix'].";item=".$item[$valeurs['item_template']]['id_wowhead']."',date=NOW()");
	}
}

?>