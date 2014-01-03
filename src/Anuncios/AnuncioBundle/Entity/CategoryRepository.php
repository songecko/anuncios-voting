<?php

namespace Anuncios\AnuncioBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
	public function getAllCategories()
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT c FROM AnunciosAnuncioBundle:Category c'
		)
		->getResult();
	}
	
	public function getCategoryById($id)
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT c FROM AnunciosAnuncioBundle:Category c WHERE c.id = :id'
		)->setParameter('id', $id)
		->getResult();
	}
}
