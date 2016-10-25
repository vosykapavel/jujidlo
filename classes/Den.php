<?php

class Den implements JsonSerializable {
	private static $ceskeDny = array('Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota', 'Neděle');
	private $datum = "";
	private $nazevDne = "";
	private $jidla = array();
	private $pizza = array(
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


	public function __construct($datum){
		$this->datum = $datum;
		$this->nazevDne = self::$ceskeDny[DateTime::createFromFormat('j.n.Y', $datum)->format('N')-1];

	}

	public function addJidlo($jidlo){
		if(!$this->hasJidlo($jidlo)){
			array_push($this->jidla, $jidlo);
		}
	}
	public function getJidla(){
		return $this->jidla;
	}

	public function getPizza() {
		return $this->pizza;
	}

	public function hasJidlo($jidlo) {
		foreach ($this->jidla as $key => $j) {
			if($this->jidla[$key] == $jidlo){
				return true;
			}
		}
		return false;
	}
	public function getJidlaTypu($typJidla, $cislaJidla = array()){
		$pole = array();
		foreach ($this->jidla as $key => $j) {
			$typ = $this->jidla[$key]->getTypJidla();
			if($typ[0] == $typJidla && (!empty($cislaJidla) && in_array($typ[1],$cislaJidla))){
			}
		}
		return false;
	}
	public function getDatum(){
		return $this->datum;
	}
	public function getNazevDne(){
		return $this->nazevDne;
	}
	public function jsonSerialize() {
		return get_object_vars($this);
	}

}
