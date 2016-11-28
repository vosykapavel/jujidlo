<?php
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * Description of JuConnector
 *
 * @author pavel
 */
class JuConnector {

	/** @var EntityManager */
    private $entityManager;
	
	private $zarizeniNazev = "Menzy Jihočeské univerzity";
	private $jidelny = [
			["nazev" => "Studentská", "url" => "http://menza.jcu.cz/Studentska.html"],
			["nazev" => "Minutková", "url" => "http://menza.jcu.cz/Minutkova.html"],
		];
	
	private $recepty;
	private $jidla;
	
	public function __construct($entityManager) {
		$this->entityManager = $entityManager;
	
	}
	
	public function run() {
		$this->recepty = $this->entityManager->getRepository("Recept")->findAll();
		$this->jidla = $this->entityManager->getRepository("Jidlo")->findAll();

		$zarizeni = $this->insertZarizeni($this->zarizeniNazev);
		foreach ($this->jidelny as $keyJ => $j) {
			$jidelna = $this->insertJidelna($j["nazev"]);
			$zarizeni->addJidelna($jidelna);
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


	private function validateDate($date)
	{
		$d = DateTime::createFromFormat('j.n.Y', $date);
		return $d && $d->format('j.n.Y') == $date;
	}
	
	// try save but return recept
	// dostane seznam jidel, které sice už mají nasetované recepty,
	// ale pokud se najde v DB již uložený, nasetuje se ten
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
		echo "New recept \n";
		return $recept;
	}
	
	public function insertJidlo(Jidlo $jidlo , Jidelna $jidelna) {
		/* @var $ulozeneJidlo Jidlo */
		foreach ($this->jidla as $keyJ => $ulozeneJidlo) {
			if ($ulozeneJidlo->getRecept() == $jidlo->getRecept() && 
					$ulozeneJidlo->getDatum() == $jidlo->getDatum() &&
						$ulozeneJidlo->getJidelna() == $jidelna) {

				return $ulozeneJidlo;
			}
		}

		$jidelna->addJidlo($jidlo);
		$this->entityManager->persist($jidlo);
		array_push($this->jidla, $jidlo);
		echo "New jidlo \n";
		return $jidlo;
	}

	public function parseJidla(Jidelna $jidelna, $url) {
		$jidelnicek = str_replace('&nbsp;', '', iconv('WINDOWS-1250', 'UTF-8', file_get_contents($url)));
		$doc = phpQuery::newDocumentHTML($jidelnicek);
		$rows = $doc["table  tr"];
		$dateTemp = "";
		$datum = null;
		foreach (pq($rows) as $row) {
			echo "Hej";
			$tr = pq($row);
			$dateTemp = $tr['td:nth-child(1)']->text();

			if ($this->validateDate($dateTemp)){
				$datum = DateTime::createFromFormat('j.n.Y', $dateTemp);
			}
	
			if ($datum != null) {
				$typJidla = $tr['td:nth-child(2)']->text();
				$alergeny = explode(', ', $tr['td:nth-child(3)']->text());
				$nazev = $tr['td:nth-child(4)']->text();
				if ($nazev != "") {
					$j = new Jidlo; //$typJidla, $alergeny, $nazev
					$recept = $this->insertRecept($nazev);
					$j->setRecept($recept);
					$j->setDatum($datum);
					$this->insertJidlo($j, $jidelna);
				}
			}
		}
	}
}
