<?php

/**
 * @Entity
 */
class Fotka {

    /**
	 * @Id
	 * @GeneratedValue
	 * @Column(type="integer")
	 */
    protected $id;
	
	/**
	 * @Column
	 */
	protected $nazev;

	/**
	 * @ManyToOne(targetEntity="Recept", inversedBy="fotky")
	 * @var Recept 
	 */
	protected $recept;

	/**
	 * @ManyToOne(targetEntity="Jidlo", inversedBy="fotky")
	 * @var Jidlo 
	 */
	protected $jidlo;
	
	public function getId() {
		return $this->id;
	}

	public function getNazev() {
		return $this->nazev;
	}

	public function getRecept() {
		return $this->recept;
	}

	public function getJidlo() {
		return $this->jidlo;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setNazev($nazev) {
		$this->nazev = $nazev;
	}

	public function setRecept(Recept $recept) {
		$this->recept = $recept;
	}

	public function setJidlo(Jidlo $jidlo) {
		$this->jidlo = $jidlo;
	}

}