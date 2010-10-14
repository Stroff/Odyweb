<?php
include '../config/config.php';
include '../lib/pChart/pData.class';
include '../lib/pChart/pChart.class';
$connexion = mysql_connect($host_wow, $user_wow , $pass_wow);
mysql_select_db($wow_characters ,$connexion);
//total des joueurs
$sql = mysql_query("SELECT class,race,level FROM characters.characters");
//liste des classes
$classe_id = array (
	1 => 'Guerrier',
	2 => 'Paladin',
	3 => 'Chasseur',
	4 => 'Voleur',
	5 => 'Prêtre',
	6 => 'Chevalier de la Mort',
	7 => 'Chaman',
	8 => 'Mage',
	9 => 'Démoniste', 
	11 => 'Druide',
);
$classe['Guerrier'] = 0;
$classe['Paladin'] = 0;
$classe['Chasseur'] = 0;
$classe['Voleur'] = 0;
$classe['Prêtre'] = 0;
$classe['Chevalier de la Mort'] = 0;
$classe['Chaman'] = 0;
$classe['Mage'] = 0;
$classe['Démoniste'] = 0;
$classe['Druide'] = 0;

$classe_lvl80['Guerrier'] = 0;
$classe_lvl80['Paladin'] = 0;
$classe_lvl80['Chasseur'] = 0;
$classe_lvl80['Voleur'] = 0;
$classe_lvl80['Prêtre'] = 0;
$classe_lvl80['Chevalier de la Mort'] = 0;
$classe_lvl80['Chaman'] = 0;
$classe_lvl80['Mage'] = 0;
$classe_lvl80['Démoniste'] = 0;
$classe_lvl80['Druide'] = 0;

// liste des factions
$race = array (
	1 => 'Humain',
	2 => 'Orc',
	3 => 'Nain',
	4 => 'Elfe de la nuit',
	5 => 'Mort vivant',
	6 => 'Tauren',
	7 => 'Gnome',
	8 => 'Troll',
	9 => 'Gnome', 
	10 => 'Elfe de sang',
	11 => 'Draenei',
);
$race_ally = array (1, 3, 4, 7, 9, 11 );
$faction['Alliance']=0;
$faction['Horde']=0;

$faction_lvl80['Alliance']=0;
$faction_lvl80['Horde']=0;

// boucle pour les persos
while($un_perso = mysql_fetch_array($sql)) {
	if (in_array ( $un_perso ['race'], $race_ally )) {
		$faction['Alliance'] = $faction['Alliance']+1;
		if($un_perso['level']==80) {
			$faction_lvl80['Alliance']=$faction_80['Alliance']+1;
		}
	} else {
		$faction['Horde']=$faction['Horde']+1;
		if($un_perso['level']==80) {
			$faction_lvl80['Horde']=$faction_80['Horde']+1;
		}
	}
	foreach ($classe_id as $id => $nom_classe) { 
		if ($id == $un_perso['class']) {
			$classe[$nom_classe]= $classe[$nom_classe]+1;
			if($un_perso['level']==80) {
				$classe_lvl80[$nom_classe]= $classe_lvl80[$nom_classe]+1;
			}
		}
	}
}

// Dataset definition   
 $DataSet = new pData;
 $DataSet->AddPoint(array($classe_lvl80['Guerrier'],$classe_lvl80['Paladin'],$classe_lvl80['Chasseur'],$classe_lvl80['Voleur'],$classe_lvl80['Prêtre'],$classe_lvl80['Chevalier de la Mort'],$classe_lvl80['Chaman'],$classe_lvl80['Mage'],$classe_lvl80['Démoniste'],$classe_lvl80['Druide']),"Serie1");  
 $DataSet->AddPoint(array("Guerrier","Paladin","Chasseur","Voleur","Prêtre","Chevalier de la Mort","Chaman","Mage","Démoniste","Druide"),"Serie2");  
 $DataSet->AddAllSeries(); 
 $DataSet->SetAbsciseLabelSerie("Serie2");  
  
 // Initialise the graph  
 $Test = new pChart(500,200);  
 $Test->loadColorPalette("../lib/pChart/couleurs_classes.txt");
 $Test->drawFilledRectangle(7,7,400,193,150,150,150,FALSE);  
  
 // Draw the pie chart  
 $Test->setFontProperties("../lib/Fonts/tahoma.ttf",8);  
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5); 
 $Test->drawPieLegend(290,15,$DataSet->GetData(),$DataSet->GetDataDescription(),160,160,160,-1,-1,-1,0,0,0,FALSE);  
 $Test->Render("../statistiques/classes_80.png");
	
// Dataset definition   
 $DataSet = new pData;
 $DataSet->AddPoint(array($classe['Guerrier'],$classe['Paladin'],$classe['Chasseur'],$classe['Voleur'],$classe['Prêtre'],$classe['Chevalier de la Mort'],$classe['Chaman'],$classe['Mage'],$classe['Démoniste'],$classe['Druide']),"Serie1");  
 $DataSet->AddPoint(array("Guerrier","Paladin","Chasseur","Voleur","Prêtre","Chevalier de la Mort","Chaman","Mage","Démoniste","Druide"),"Serie2");  
 $DataSet->AddAllSeries(); 
 $DataSet->SetAbsciseLabelSerie("Serie2");  

 // Initialise the graph  
 $Test = new pChart(500,200);  
 $Test->loadColorPalette("../lib/pChart/couleurs_classes.txt");
 $Test->drawFilledRectangle(7,7,400,193,150,150,150,FALSE); 

 // Draw the pie chart  
 $Test->setFontProperties("../lib/Fonts/tahoma.ttf",8);  
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5); 
 $Test->drawPieLegend(290,15,$DataSet->GetData(),$DataSet->GetDataDescription(),160,160,160,-1,-1,-1,0,0,0,FALSE);  
 $Test->Render("../statistiques/classes.png");

	// Dataset definition   
	 $DataSet = new pData;  
	 $DataSet->AddPoint(array($faction_lvl80['Alliance'],$faction_lvl80['Horde']),"Serie1");  
	 $DataSet->AddPoint(array("Alliance","Horde"),"Serie2");  
	 $DataSet->AddAllSeries();  
	 $DataSet->SetAbsciseLabelSerie("Serie2");  

	 // Initialise the graph  
	 $Test = new pChart(400,200);  
	 $Test->setColorPalette(0,17,87,168);  
	 $Test->setColorPalette(1,216,51,51);  
	 $Test->drawFilledRectangle(7,7,400,193,150,150,150,FALSE); 
	 //$Test->drawRoundedRectangle(5,5,295,195,5,0,0,0);  

	 // Draw the pie chart  
	 $Test->setFontProperties("../lib/Fonts/tahoma.ttf",8);  
//	$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1","Alliance","Alliance !", 150, 150, 150);
	 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5); 
	 $Test->drawPieLegend(290,15,$DataSet->GetData(),$DataSet->GetDataDescription(),160,160,160,-1,-1,-1,0,0,0,FALSE);  

	 $Test->Render("../statistiques/faction_80.png");
	
	
// Dataset definition   
 $DataSet = new pData;  
 $DataSet->AddPoint(array($faction['Alliance'],$faction['Horde']),"Serie1");  
 $DataSet->AddPoint(array("Alliance","Horde"),"Serie2");  
 $DataSet->AddAllSeries();  
 $DataSet->SetAbsciseLabelSerie("Serie2");  

 // Initialise the graph  
 $Test = new pChart(400,200);  
 $Test->setColorPalette(0,17,87,168);  
 $Test->setColorPalette(1,216,51,51);  
 $Test->drawFilledRectangle(7,7,400,193,150,150,150,FALSE); 
// $Test->drawRoundedRectangle(5,5,295,195,5,0,0,0);  

 // Draw the pie chart  
 $Test->setFontProperties("../lib/Fonts/tahoma.ttf",8);  
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5); 
 $Test->drawPieLegend(290,15,$DataSet->GetData(),$DataSet->GetDataDescription(),160,160,160,-1,-1,-1,0,0,0,FALSE);  

 $Test->Render("../statistiques/faction.png");
?>
