<?php

class Den implements JsonSerializable {
	private static $ceskeDny = array('Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota', 'Neděle');
	private $datum = "";
	private $nazevDne = "";
	private $budeSpecialita;
	private $jidla = array();

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

	public function offersSpeciality() {
		foreach ($this->jidla as $key => $j) {
			if ($this->jidla[$key]->getTypJidla() == 'Specialita 1'){
				$this->budeSpecialita = TRUE;
				return;
			}
		}
		$this->budeSpecialita = FALSE;
	}

	public function jsonSerialize() {
		$this->offersSpeciality();
		return get_object_vars($this);
	}

}