<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Jidelna je místo, kde se vydává jídlo.
 * 
 * @Entity
 * @Table(uniqueConstraints={@UniqueConstraint(name="jidelna_unique", columns={"nazev"})})
 * @author pavel
 */
class Jidelna {

	/** @Id @Column(type="integer") @GeneratedValue **/
	protected $id;

	/** @Column **/
	private $nazev;

	/** 
	 *  @ManyToOne(targetEntity="Zarizeni", inversedBy="jidelny")
	 *  @var Zarizeni
	 **/
	protected $zarizeni;

	/**
	 *  @OneToMany(targetEntity="Jidlo", mappedBy="jidelna") 
	 *  @OrderBy({"vydejOd" = "ASC"})
	 *  @var Jidlo[]
	 **/
	protected $jidla;
	
	/** 
	 * @OneToMany(targetEntity="Chod", mappedBy="jidelna")
	 * @var Chod[]
	 */
	protected $chody;

	
	public function __construct() {
		$this->jidla = new ArrayCollection();
		$this->chody = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}
		
	public function getNazev() {
		return $this->nazev;
	}
	
	public function setNazev($nazev) {
		$this->nazev = $nazev;
	}

	public function getZarizeni() {
		return $this->zarizeni;
	}
	
	public function setZarizeni($zarizeni) {
		$this->zarizeni = $zarizeni;
	}

	/**	@param Jidlo $jidlo **/
	public function addJidlo($jidlo) {
		$this->jidla->add($jidlo);
//		$jidlo->setJidelna($this);
	}

	public function getJidla() {
		return $this->jidla;
	}

	/**
	 * @param Chod $chod
	 */
	public function addChod($chod) {
		$this->chody->add($chod);
		$chod->setJidelna($this);
	}

	public function getChody() {
		return $this->chody;
	}
	
	/**
	 * 
	 * @param Jidlo[] $jidla
	 * @return Jidelna[]
	 */
	public static function getJidelnyZJidla($jidla) {
		/* @var Jidelna[] */
		$jidelny = [];
		foreach ($jidla as $keyJ => $jidlo) {

			/* @var Jidelna */
			$jidelnaJidla = null;
			/* @var $jidelna Jidelna */
			foreach ($jidelny as $keyJi => $jidelna) {
				if ($jidelna->getId() == $jidlo->getJidelna()->getId()) {
					$jidelnaJidla = $jidelna;
					break;
				}
			}
			if ($jidelnaJidla == null) {
				$jidelnaJidla = $jidlo->getJidelna();
				array_push($jidelny, $jidelnaJidla);
			}

		}
		return $jidelny;
	}
	
}
