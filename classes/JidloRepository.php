<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JidloRepository
 *
 * @author pavel
 */
class JidloRepository {
	
	/** @var EntityManager */
    private $entityManager;

	public function __construct($entityManager) {
		$this->entityManager = $entityManager;
	}

	public function getJidlaPodleData($datum) {
		return $this->entityManager->createQueryBuilder()
			->select('j')
			->from('Jidlo', 'j')
			->where('j.datum = ?1')
			->getQuery()
			->setParameter(1, $datum)
			->getResult();
	}
	
	public function getJidlaMeziDaty($datumA, $datumB) {
		return $this->entityManager->createQueryBuilder()
			->select('j')
			->from('Jidlo', 'j')
			->where('j.datum >= ?1 AND j.datum <= ?2')
			->getQuery()
			->setParameter(1, $datumA, \Doctrine\DBAL\Types\Type::DATETIME)
			->setParameter(2, $datumB, \Doctrine\DBAL\Types\Type::DATETIME)
			->getResult();
	}
	

}
