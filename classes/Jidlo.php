<?php

class Jidlo
{

	private static $pizza = array(
			array('nazev' => 'Pizza šunková'),
			array('nazev' => 'Pizza šunková se žampiony'),
			array('nazev' => 'Pizza šunková s ananasem'),
			array('nazev' => 'Pizza šunková s brokolicí'),
			array('nazev' => 'Pizza salámová'),
			array('nazev' => 'Pizza zeleninová'),
			array('nazev' => 'Pizza sýrová'),
			array('nazev' => 'Pizza špenátová se zakysanou smetanou'),
			array('nazev' => 'Pizza špenátová se šunkou a smetannou'),
			array('nazev' => 'Pizza tuňáková'),
			array('nazev' => 'Pizza s česnekem a sýrem'),
	);


	public static function getPizza() {
		return self::$pizza;
	}

	function __construct($typJidla, $alergeny, $nazev) {
		$this->nazev = $nazev;
		$this->typJidla = $typJidla;
		$this->alergeny = $alergeny;
		$this->skupiny = [];
		$this->cena = ["student" => []];
		$this->setSkupiny();
	}

	function getNazev() {
		return $this->nazev;
	}

	function getTypJidla() {
		return $this->typJidla;
	}

	function getSkupiny() {
		return $this->skupiny;
	}

	function getCena($stravnik = "student") {
		return $this->cena[$stravnik];
	}

	function getAlergeny() {
		return $this->alergeny;
	}

	function listAlergens() {
		return implode(", ", $this->alergeny);
	}


	/* Ceník z http://kam.jcu.cz/stravovani/cenikm.html. Poslední aktualizace 7.11. 2016*/
	private function setSkupiny() {
		switch ($this->typJidla) {
			case ("Snídaně 1") :
				array_push($this->skupiny, "snidane");
				$this->cena["student"] = 19;
				break;

			case ("Snídaně 2") :
				array_push($this->skupiny, "snidane");
				$this->cena["student"] = 19;
				break;

			case ("Polévka 1") :
				array_push($this->skupiny, "obed", "polevka");
				$this->cena["student"] = 8;
				break;

			case ("Oběd 1") :
				array_push($this->skupiny, "obed");
				$this->cena["student"] = 21;
				break;

			case ("Oběd 2") :
				array_push($this->skupiny, "obed");
				$this->cena["student"] = 26;
				break;

			case ("Oběd 3") :
				array_push($this->skupiny, "obed");
				$this->cena["student"] = 31;
				break;

			case ("Oběd 1") :
				array_push($this->skupiny, "obed");
				$this->cena["student"] = 21;
				break;

			case ("Oběd 5") :
				array_push($this->skupiny, "obed", "bezobjednavkove");
				$this->cena["student"] = 26;
				break;

			case ("Oběd 6") :
				array_push($this->skupiny, "obed", "bezobjednavkove");
				$this->cena["student"] = 31;
				break;

			case ("Oběd 7") :
				array_push($this->skupiny, "obed", "bezobjednavkove");
				$this->cena["student"] = 31;
				break;

			case ("Oběd 8") :
				array_push($this->skupiny, "obed", "bezobjednavkove");
				$this->cena["student"] = 26;
				break;

			case ("Dieta 1") :
				array_push($this->skupiny, "obed", "dieta");
				$this->cena["student"] = 31;
				break;

			case ("Dieta 2") :
				array_push($this->skupiny, "obed", "dieta");
				$this->cena["student"] = 31;
				break;

			case ("Dieta 3") :
				array_push($this->skupiny, "obed", "dieta");
				$this->cena["student"] = 31;
				break;

			case ("Dieta 4") :
				array_push($this->skupiny, "obed", "dieta");
				$this->cena["student"] = 31;
				break;

			case ("Minutka 1") :
				array_push($this->skupiny, "obed", "bezobjednavkove");
				$this->cena["student"] = 38;
				break;

			case ("Minutka 2") :
				array_push($this->skupiny, "obed", "bezobjednavkove");
				$this->cena["student"] = 38;
				break;

			case ("Specialita 1") :
				array_push($this->skupiny, "obed", "specialita");
				$this->cena["student"] = 48;
				break;
			case ("Pizza 1") :
				array_push($this->skupiny, "obed", "pizza");
				$this->cena["student"] = 42;
				break;
			case ("Pizza 2") :
				array_push($this->skupiny, "obed", "pizza");
				$this->cena["student"] = 42 + 7;
				break;

			case ("Večeře 1") :
				array_push($this->skupiny, "vecere");
				$this->cena["student"] = 26;
				break;
			case ("Večeře 2") :
				array_push($this->skupiny, "vecere");
				$this->cena["student"] = 26;
				break;

			case ("Bageta 1") :
				array_push($this->skupiny, "bageta");
				$this->cena["student"] = 12;
				break;

			case ("Bageta 2") :
				array_push($this->skupiny, "bageta");
				$this->cena["student"] = 17;
				break;

			case ("Bageta 3") :
				array_push($this->skupiny, "bageta");
				$this->cena["student"] = 20;
				break;
			case ("Doplněk 1") :
				array_push($this->skupiny, "doplnek");
				$this->cena["student"] = 17;
				break;

			case ("Doplněk 2") :
				array_push($this->skupiny, "doplnek");
				$this->cena["student"] = 15;
				break;

			case ("Doplněk 3") :
				array_push($this->skupiny, "doplnek");
				$this->cena["student"] = 7;
				break;
			case ("Doplněk 4") :
				array_push($this->skupiny, "doplnek");
				$this->cena["student"] = 10;
				break;

			case ("Doplněk 5") :
				array_push($this->skupiny, "doplnek");
				$this->cena["student"] = 12;
				break;
		}
	}
}