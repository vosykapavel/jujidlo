<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(uniqueConstraints={@UniqueConstraint(name="jidlo_unique", columns={"recept_id", "datum", "jidelna_id", "chod_id"})})
 */
class Jidlo {
    
	/** 
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue
	 */
	protected $id;

	/**
	 * @manyToOne(targetEntity="Chod") 
	 * @var Chod
	 */
	protected $chod;
	
	/**
	 * @manyToOne(targetEntity="Recept") 
	 * @var Recept
	 */
	protected $recept;
	
	/** @Column(type="date") **/
    protected $datum;

	/** 
	 *  @ManyToOne(targetEntity="Jidelna", inversedBy="jidla")
	 *  @var Jidelna
	 */
	protected $jidelna;

	/**
	 * @OneToMany(targetEntity="Fotka", mappedBy="jidlo")
	 * @var Fotka[]
	 */
	protected $fotky;
	
	public function __construct() {
		$this->fotky = new ArrayCollection();
	}
	
	public function getId() {
		return $this->id;
	}

	public function getRecept() {
		return $this->recept;
	}

	/**
	 * 
	 * @param Recept $recept
	 */
	public function setRecept($recept) {
		$this->recept = $recept;
	}

	public function getDatum() {
		return $this->datum;
	}

	public function setDatum($datum) {
		$this->datum = $datum;
	}

	public function getJidelna() {
		return $this->jidelna;
	}

	public function setJidelna($jidelna) {
		$this->jidelna = $jidelna;
	}
	
	/**	@param Fotka $fotka **/
	public function addFotka($fotka) {
		$this->fotky->add($fotka);
		$fotka->setJidlo($this);

		$this->recept->addFotka($fotka);
	}

	public function getFotky() {
		return $this->fotky;
	}
	
	public function getChod() {
		return $this->chod;
	}

	public function setChod(Chod $chod) {
		$this->chod = $chod;
	}

}