<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recept
 *
 * @author pavel
 * @Entity
 */
class Recept {

    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

	/** @Column **/
	protected $nazev;
	
	/**
	 * @OneToMany(targetEntity="Fotka", mappedBy="recept")
	 * @var Fotka[]
	 */
	protected $fotky;
	
	public function __construct() {
		$this->fotky = new ArrayCollection();
	}

	public function getNazev() {
		return $this->nazev;
	}

	public function setNazev($nazev) {
		$this->nazev = $nazev;
	}
	
	/**	@param Fotka $fotka **/
	public function addFotka($fotka) {
		$this->fotky->add($fotka);
		$fotka->setRecept($this);
	}

	public function getFotky() {
		return $this->fotky;
	}
	
}
// @Table(name="recept", uniqueConstraints={@UniqueConstraint(name="nazev_unique", columns={"nazev"})})