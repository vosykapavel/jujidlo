<?php

class Jidlo
{

	function __construct($typJidla, $alergeny, $nazev)
	{
		$this->nazev = $nazev;
		$this->typJidla = $typJidla;
		$this->alergeny = $alergeny;
	}

	function getNazev(){
		return $this->nazev;
	}
	function getTypJidla(){
		return $this->typJidla;
	}
	function getAlergeny(){
		return $this->alergeny;
	}
	function listAlergens(){
		return implode(", ", $this->alergeny);
	}
}