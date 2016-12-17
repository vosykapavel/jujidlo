<?php
/*
	Jujidlo si klade za cíl přinést víc user-friendly jídelníček
*/
require __DIR__ . '/vendor/autoload.php';


//	$jidelna = "";//new Jidelna();
//	$dny = new Dny();
//	parse();
//	parse("http://menza.jcu.cz/Minutkova.html");



// ROUTER


if (isset($_GET['json'])) {
	echo json_encode($dny, JSON_PRETTY_PRINT);
	die();
} else if (isset($_GET['juc'])) {
	require_once "bootstrap.php";
	$juConnector = new JuConnector($entityManager);
	$juConnector->run();
	
} else if (isset($_GET['show'])) {
	require_once "bootstrap.php";

	$zarizeni = $entityManager->getRepository("Zarizeni")->findAll();

	/* @var $z Zarizeni */
	foreach ($zarizeni as $keyZ => $z) {
		echo "Zařízení: " . $z->getNazev();
		
		echo "jidelny: \n";
		/* @var $jidelna Jidelna*/
		foreach ($z->getJidelny() as $keyJa => $jidelna) {
			echo $jidelna->getNazev() . "\n";

			foreach ($jidelna->getJidla() as $keyJo => $jidlo) {
				echo $jidlo->getDatum()->format('Y-m-d') . ": " . $jidlo->getChod()->getNazev() . " - " . $jidlo->getRecept()->getNazev() . "\n";
			}

		}
	}
} else if (isset($_GET['mock'])) {
	require_once "bootstrap.php";
	/* @var $recept Recept */
	$recept = new Recept;
	$entityManager->persist($recept);
	$recept->setNazev("Bramoboráček namockovanej 9");

	/* @var $jidlo Jidlo */
	$jidlo = new Jidlo;
	$entityManager->persist($jidlo);
	$jidlo->setDatum(new DateTime('NOW'));
	$jidlo->setRecept($recept);

	/* @var $jidelna Jidelna */
	$jidelna = new Jidelna;
	$entityManager->persist($jidelna);
	$jidelna->setNazev("Mockjídelna");
	$jidelna->addJidlo($jidlo);

	/* @var Zarizeni */
	$zarizeni = new Zarizeni;
	$entityManager->persist($zarizeni);
	$zarizeni->setNazev("Jihočeká mockuinverzita");
	$zarizeni->addJidelna($jidelna);
	
	$entityManager->flush();
	
} else if (isset($_GET['parse'])) {
	require_once "bootstrap.php";

	
	
	$recepty = $entityManager->getRepository("Recept")->findAll();
	$jidla = $entityManager->getRepository("Jidlo")->findAll();

		/* @var $jidlo Jidlo */
		foreach ($jidla as $keyJ => $jidlo) {
			$duplicitni = FALSE;
			foreach ($recepty as $keyR => $ulozenyRecept) {
				if ($ulozenyRecept->getNazev() == $jidlo->getNazev()) {
					$duplicitni = TRUE;
					break;
				}
			}
			if (!$duplicitni) {
				$recept = new Recept($jidlo->getNazev());
				$entityManager->persist($recept);
				array_push($recepty, $recept);
				echo "New recept \n";
			}
			$duplicitni = FALSE;
		}
	$entityManager->flush();	
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