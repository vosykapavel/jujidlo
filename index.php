<?php
/**
 *	Jujidlo si klade za cíl přinést víc user-friendly jídelníček
 */
	require __DIR__ . '/vendor/autoload.php';
	require_once "bootstrap.php";

	/** @var JidloRepository */
	$jidloRepository = new JidloRepository($entityManager);

	/** @var JuConnector */
	$juConnector = new JuConnector($entityManager);

if (isset($_GET['json'])) {
	$jidla = $entityManager->getRepository("Jidlo")->findAll();
	$dny = Den::getDnyZJidel($jidla);
	$tydny = Tyden::getTydnyZeDnu($dny);
	echo json_encode($tydny, JSON_PRETTY_PRINT);
	die();
} else if (isset($_GET['jsonraw'])) {
	$jidla = $entityManager->getRepository("Jidlo")->findAll();
	echo json_encode($jidla, JSON_PRETTY_PRINT);
	die();
} else if (isset($_GET['juc'])) {
	$juConnector->run();
} else if (isset($_GET['image'])) {
	$server = League\Glide\ServerFactory::create([
		'source' => 'www/photos',
		'cache' => 'www/cache/photos',
	]);
	$server->outputImage($_GET['image'], $_GET);
} else if (isset($_GET['upload'])) {
	$uploader = new Uploader("fotka");
	if ($uploader->getStatus()) {

		$jidlo = $entityManager->getRepository("Jidlo")->find($_POST['id']);
		
		$fotka = new Fotka();
		$fotka->setJidlo($jidlo);
		$fotka->setNazev($uploader->getFileName());
		$fotka->setRecept($jidlo->getRecept());

		$entityManager->persist($fotka);
		$entityManager->flush();
		$uploader->redirect("/");
	}
	echo $uploader->getMessage();
	
} else {
	$datumMinulePondeli = new DateTime('NOW');
	$datumMinulePondeli->modify('monday this week');
	$datumMinulePondeli->modify('-1 week');

	$datumPristiNedele = new DateTime('NOW');
	$datumPristiNedele->modify('sunday this week');
	$datumPristiNedele->modify('+1 week');

	$jidla = $jidloRepository->getJidlaMeziDaty($datumMinulePondeli, $datumPristiNedele);
	//$jidla = $entityManager->getRepository("Jidlo")->findAll();
	$dny = Den::getDnyZJidel($jidla);
	$tydny = Tyden::getTydnyZeDnu($dny);

	$latte = new Latte\Engine;
	$parameters['tydny'] = $tydny;
	$parameters['jidelny'] = Jidelna::getJidelnyZJidla($jidla);

	$parameters['datumDnes'] = new DateTime('today');
	$dt = new DateTime('');
	$parameters['tydenDnes'] = (int) $dt->format('W');
	$parameters['datumZitra'] = date('j.n.Y', strtotime("+1 day"));
	$latte->render('templates/homepage.latte', $parameters);
	die();
}