<?php

/**
 * TODO seznam chodů tam nacpat manuálně, podobně to bude nějak i s ceníkem,
 * pokud ho teda vůbec řešit. Možná bych tam natvrdo narval studentskou cenu,
 * protože to nikdo jinej nebude používat a když tak co viď, cenu zná... 
 * aspoň tedy prozatím.
 *
 * @author pavel
 */
class JuConnector {

	/** @var EntityManager */
    private $entityManager;

	/** @var JidloRepository */
	private $jidloRepository;

	private $zarizeniNazev = "Menzy Jihočeské univerzity";

	private $konfigurace = [
			[
				"nazev" => "Studentská",
				"url" => "http://menza.jcu.cz/Studentska.html",
				"chody" => [
					["Snídaně 1", "19", "06:30", "08:00"],
					["Snídaně 2", "19", "06:30", "08:00"],

					["Polévka 1", "8", "11:00", "14:30"],

					["Oběd 1", "21", "11:00", "14:30"],
					["Oběd 2", "26", "11:00", "14:30"],
					["Oběd 3", "31", "11:00", "14:30"],
					["Oběd 4", "21", "11:00", "14:30"],
					["Oběd 5", "26", "11:00", "14:30"],
					["Oběd 6", "31", "11:00", "14:30"],
					["Oběd 7", "31", "11:00", "14:30"],
					["Oběd 8", "26", "11:00", "14:30"],

					["Specialita 1", "48", "11:15", "13:00"],

					["Dieta 1", "31", "11:00", "14:30"],
					["Dieta 2", "31", "11:00", "14:30"],
					["Dieta 3", "31", "11:00", "14:30"],
					["Dieta 4", "31", "11:00", "14:30"],

					["Večeře 1", "26", "17:30", "19:00"],
					["Večeře 2", "26", "17:30", "19:00"],
				]
			],
			[
				"nazev" => "Minutková",
				"url" => "http://menza.jcu.cz/Minutkova.html",
				"chody" => [
					["Pizza 1", "42", "09:30", "13:30"],
					["Pizza 2", "49", "09:30", "13:30"],

					["Minutka 1", "38", "11:00", "13:30"],
					["Minutka 2", "38", "11:00", "13:30"],

					["Polévka 1", "8", "11:00", "13:00"],
					["Oběd 5", "26", "11:00", "13:00"],
					["Oběd 6", "31", "11:00", "13:00"],
				]
			],
//			[
//				"nazev" => "OfflineStudentská",
//				"url" => "offline/Studentska-2016-11-30.html", // there is 132 unique Jidlo
//				"chody" => [
//					["Snídaně 1", "19", "06:30", "08:00"],
//					["Snídaně 2", "19", "06:30", "08:00"],
//
//					["Polévka 1", "8", "11:00", "14:30"],
//
//					["Oběd 1", "21", "11:00", "14:30"],
//					["Oběd 2", "26", "11:00", "14:30"],
//					["Oběd 3", "31", "11:00", "14:30"],
//					["Oběd 4", "21", "11:00", "14:30"],
//					["Oběd 5", "26", "11:00", "14:30"],
//					["Oběd 6", "31", "11:00", "14:30"],
//					["Oběd 7", "31", "11:00", "14:30"],
//					["Oběd 8", "26", "11:00", "14:30"],
//
//					["Specialita 1", "48", "11:15", "13:00"],
//
//					["Dieta 1", "31", "11:00", "14:30"],
//					["Dieta 2", "31", "11:00", "14:30"],
//					["Dieta 3", "31", "11:00", "14:30"],
//					["Dieta 4", "31", "11:00", "14:30"],
//
//					["Večeře 1", "26", "17:30", "19:00"],
//					["Večeře 2", "26", "17:30", "19:00"],
//				]
//			],
		];
	
	private $recepty;
	private $jidla;
	private $chody;
	
	public function __construct($entityManager) {
		$this->entityManager = $entityManager;
		$this->jidloRepository = new JidloRepository($entityManager);
	}
	
	public function run() {
		$this->recepty = $this->entityManager->getRepository("Recept")->findAll();
		$this->jidla = $this->entityManager->getRepository("Jidlo")->findAll();
		$this->chody = $this->entityManager->getRepository("Chod")->findAll();

		$zarizeni = $this->insertZarizeni($this->zarizeniNazev);
		foreach ($this->konfigurace as $keyJ => $j) {
			$jidelna = $this->insertJidelna($j["nazev"]);
			$zarizeni->addJidelna($jidelna);
			foreach ($j["chody"] as $keyCh => $ch) {
				/** @var Chod */
				$chodZKonfigurace = new Chod();
				$chodZKonfigurace->setNazev($ch[0]);
				$chodZKonfigurace->setCena($ch[1]);
				$format = 'Y-m-d H:i:s';

				/** @var DateTime */
				$od = DateTime::createFromFormat($format, '1000-01-01 ' . $ch[2] . ':00');
				$chodZKonfigurace->setDenniVydejOd($od);

				/** @var DateTime */
				$do = DateTime::createFromFormat($format, '1000-01-01 ' . $ch[3] . ':00');
				$chodZKonfigurace->setDenniVydejDo($do);

				$chodZKonfigurace->setJidelna($jidelna);
				$chod = $this->insertChod($chodZKonfigurace);

				$jidelna->addChod($chod);
			}
			$this->parseJidla($jidelna, $j["url"]);
		}
		$this->entityManager->flush();
	}
	
	/** @return Zarizeni **/
	private function insertZarizeni($nazev) {
			$zarizeni = $this->entityManager->createQueryBuilder()
				->select('z')
				->from('Zarizeni', 'z')
				->where('z.nazev = ?1')
				->getQuery()
				->setParameter(1, $nazev)
				->getResult()[0];

			if (!($zarizeni instanceof Zarizeni)) {
				$zarizeni = new Zarizeni;
				$zarizeni->setNazev($nazev);
				$this->entityManager->persist($zarizeni);
			}
		return $zarizeni;
	}

	/** @return Jidelna **/
	private function insertJidelna($nazev) {
		$jidelna = $this->entityManager->createQueryBuilder()
			->select('j')
			->from('Jidelna', 'j')
			->where('j.nazev = ?1')
			->getQuery()
			->setParameter(1, $nazev)
			->getResult()[0];

		if (!($jidelna instanceof Jidelna)) {
				$jidelna = new Jidelna();
			$jidelna->setNazev($nazev);
			$this->entityManager->persist($jidelna);
		}
		return $jidelna;
	}

		/** @return Chod **/
	private function insertChod(Chod $chod) {
		/* @var $ulozenyChod Chod */
		foreach ($this->chody as $keyCh => $ulozenyChod) {
			if ($ulozenyChod->getNazev() == $chod->getNazev() &&
					$ulozenyChod->getJidelna() == $chod->getJidelna()
					) {
				$ulozenyChod->setDenniVydejOd($chod->getDenniVydejOd());
				$ulozenyChod->setDenniVydejDo($chod->getDenniVydejDo());
				$ulozenyChod->setCena($chod->getCena());
				return $ulozenyChod;
			}
		}
		$this->entityManager->persist($chod);
		array_push($this->chody, $chod);
		return $chod;
	}


	private function validateDate($date)
	{
		$d = DateTime::createFromFormat('j.n.Y', $date);
		return $d && $d->format('j.n.Y') == $date;
	}
	
	private function insertRecept($nazev) {
		
		/* @var $ulozenyRecept Recept */
		foreach ($this->recepty as $keyR => $ulozenyRecept) {
			if ($ulozenyRecept->getNazev() == $nazev) {
				return $ulozenyRecept;
			}
		}
		$recept = new Recept;
		$recept->setNazev($nazev);
		$this->entityManager->persist($recept);
		array_push($this->recepty, $recept);
		return $recept;
	}
	
	public function insertJidlo(Jidlo $jidlo , Jidelna $jidelna) {
		/* @var $ulozeneJidlo Jidlo */
		foreach ($this->jidla as $keyJ => $ulozeneJidlo) {
			if ($ulozeneJidlo->getRecept() == $jidlo->getRecept() &&
					$ulozeneJidlo->getDatum()->format("Y-m-d") == $jidlo->getDatum()->format("Y-m-d") &&
					$ulozeneJidlo->getJidelna() == $jidelna &&
					$ulozeneJidlo->getChod() == $jidlo->getChod()) {
				return $ulozeneJidlo;
			}
		}
		$jidelna->addJidlo($jidlo);
		$this->entityManager->persist($jidlo);
		array_push($this->jidla, $jidlo);
		return $jidlo;
	}

	public function parseJidla(Jidelna $jidelna, $url) {
		$jidelnicek = str_replace('&nbsp;', '', iconv('WINDOWS-1250', 'UTF-8', file_get_contents($url)));
//		$jidelnicek = str_replace('&nbsp;', '', file_get_contents($url)); // for offline in ut8
		$doc = phpQuery::newDocumentHTML($jidelnicek);
		$rows = $doc["table  tr"];
		$dateTemp = "";
		$datum = null;
		foreach (pq($rows) as $row) {
			$tr = pq($row);
			$dateTemp = $tr['td:nth-child(1)']->text();

			if ($this->validateDate($dateTemp)) {
				$datum = DateTime::createFromFormat('j.n.Y', $dateTemp);
			}
	
			if ($datum != null && $tr['td:nth-child(4)']->text() != "") {
				$nazevChodu = $tr['td:nth-child(2)']->text();
				$alergeny = explode(', ', $tr['td:nth-child(3)']->text());
				$nazev = $tr['td:nth-child(4)']->text();
				
				$j = new Jidlo();

				/* @var $ch Chod */
				foreach ($this->chody as $keyCh => $ch) {
					if ($ch->getJidelna() === $jidelna &&
							$ch->getNazev() == $nazevChodu) {
						$j->setChod($ch);
						break;
					}
				}

				/** @var Recept */
				$recept = $this->insertRecept($nazev);
				$j->setRecept($recept);
				$j->setDatum($datum);
				$j->setCena($j->getChod()->getCena());

				$od = new DateTime($j->getDatum()->format('Y-m-d'));
				$od->setTime($j->getChod()->getDenniVydejOd()->format('H'), $j->getChod()->getDenniVydejOd()->format('i'), 0);
				$j->setVydejOd($od);

				$do = new DateTime($j->getDatum()->format('Y-m-d'));
				$do->setTime($j->getChod()->getDenniVydejDo()->format('H'), $j->getChod()->getDenniVydejDo()->format('i'), 0);
					$j->setVydejDo($do);

				$this->insertJidlo($j, $jidelna);
			}
		}
	}
}
