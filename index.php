<?php
/*
	Jujidlo si klade za cíl přinést víc user-friendly jídelníček
*/

spl_autoload_register(function ($class_name) {
	include "classes/".$class_name.".php";
});
require __DIR__ . '/vendor/autoload.php';

mb_internal_encoding("UTF-8");
//setlocale(LC_TIME, 'cs_CZ.utf8');

function validateDate($date)
{
		$d = DateTime::createFromFormat('j.n.Y', $date);
		return $d && $d->format('j.n.Y') == $date;
}
//$studentska = file_get_contents("jidelnicky/15-10-29.html");

function parse($url = "http://menza.jcu.cz/Studentska.html"){
		$jidelnicek = file_get_contents($url);
		$jidelnicek = str_replace('&nbsp;', '', iconv('WINDOWS-1250', 'UTF-8', $jidelnicek));
		$doc = phpQuery::newDocumentHTML($jidelnicek);
		$rows = $doc["table  tr"];
		$radekDne = 0;
		$datumDne = "";
		$den = NULL;
		//echo $rows;
		foreach(pq($rows) as $row)
		{
			global $jidelna, $dny;


				$tr = pq($row);
				$datum = $tr['td:nth-child(1)']->text();

				// tady začínají jídla dne - datumem
				if(validateDate($datum)){
					$radekDne = 1;
					$datumDne = $datum;
					$uzExistuje = $dny->getDen($datum);
					if(!$uzExistuje){
						$den = new Den($datum);
						$dny->ulozit($den);
					}else{
						$den = $uzExistuje;
					}

				}elseif($radekDne>0){
					$radekDne++;
				}
				if($radekDne>0){
					$typJidla = $tr['td:nth-child(2)']->text();
					$alergeny = explode(', ',$tr['td:nth-child(3)']->text());
					$nazev = $tr['td:nth-child(4)']->text();
					if($nazev != ""){
						$j = new Jidlo($typJidla, $alergeny, $nazev);
						$den->addJidlo($j);
					}
		//      var_dump($jidelna->getJidla());
				}

		//    $prvni =pq($row)->text();
		}
	}
//      echo ucfirst(strftime('%A',DateTime::createFromFormat('j.n.Y', $tdDatum)->format('U')));
$jidelna = "";//new Jidelna();
$dny = new Dny();
parse();
parse("http://menza.jcu.cz/Minutkova.html");
//parse("jidelnicky/Studentskajsonjson.html");
//parse("jidelnicky/Minutkova.html");

if (isset($_GET['json'])) {
	echo json_encode($dny, JSON_PRETTY_PRINT);
	die();
} else {
	$latte = new Latte\Engine;
//	$latte->setTempDirectory('/temp'); // caching don't working offline
	$parameters['tydny'] = array($dny->getTydenRelative(-1), $dny->getTydenRelative(0), $dny->getTydenRelative(1));
	$parameters['dny'] = $dny->getDny();
	$parameters['pizzaList'] = Jidlo::getPizza();
	$parameters['datumDnes'] = date('j.n.Y');
	$dt = new DateTime();
	$parameters['tydenDnes'] = (int) $dt->format('W');
	$parameters['datumZitra'] = date('j.n.Y', strtotime("+1 day"));

	$latte->render('templates/homepage.latte', $parameters);
	die();
}