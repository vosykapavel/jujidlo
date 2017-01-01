<?php

class Den implements JsonSerializable {
	private static $ceskeDny = ['Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota', 'Neděle'];
	/* @var DateTime */
	private $datum;
	private $tyden;
	private $nazevDne;
	private $jidla = [];

	public function __construct($datum) {
		$this->datum = $datum;
		$this->tyden = (int) $this->datum->format('W');
		$this->nazevDne = self::$ceskeDny[$datum->format('N')-1];
	}

	public function addJidlo($jidlo) {
		if (!$this->hasJidlo($jidlo)) {
			array_push($this->jidla, $jidlo);
		}
	}

	public function getJidla(){
		return $this->jidla;
	}

	public function hasJidlo($jidlo) {
		foreach ($this->jidla as $key => $j) {
			if ($this->jidla[$key] == $jidlo) {
				return true;
			}
		}
		return false;
	}
	public function getJidlaTypu($typJidla, $cislaJidla = []){
		$pole = array();
		foreach ($this->jidla as $key => $j) {
			$typ = $this->jidla[$key]->getTypJidla();
			if ($typ[0] == $typJidla && (!empty($cislaJidla) && in_array($typ[1], $cislaJidla))) {
			}
		}
		return false;
	}

	public function getSerazenaJidla($skupiny) {
		$jidla = [];
		foreach ($skupiny as $s) {
			$jidla = array_merge($jidla, $this->getJidlaZeSkupiny($s));
		}

		return $jidla;
	}

	public function getJidlaZeSkupiny($skupina){
		$jidla = array();
		foreach ($this->jidla as $key => $j) {
			$skupiny = $this->jidla[$key]->getSkupiny();
			foreach ($skupiny as $keyS => $s) {
				if ($s == $skupina) {
					array_push($jidla, $this->jidla[$key]);
				}
			}
		}
		return $jidla;
	}

	public function getDatum(){
		return $this->datum;
	}

	public function getNazevDne(){
		return $this->nazevDne;
	}

	public function getTyden(){
		return $this->tyden;
	}

	public function jsonSerialize() {
		return [
			"datum" => $this->getDatum()->format(DateTime::ATOM),
			"nazevDne" => $this->getNazevDne(),
			"tyden" => $this->getTyden(),
			"jidla" => $this->getJidla(),
		];
	}
	
	/**
	 * 
	 * @param Jidla[] $jidla
	 */
	public static function getDnyZJidel($jidla) {
		$dny = [];
		/* @var $jidlo Jidlo */
		foreach ($jidla as $keyJ => $jidlo) {
			/* @var Den */	
			$den = null; 
			/* @var $d Den */
			foreach ($dny as $keyD => $d) {
				if ($d->getDatum()->format("Y-m-d") == $jidlo->getDatum()->format("Y-m-d")) {
					$den = $d;
					break;
				}
			}
			if (!($den instanceof Den)) {
				$den = new Den($jidlo->getDatum());
				array_push($dny, $den);
			}
			$den->addJidlo($jidlo);
		}
		return $dny;
	}
}
