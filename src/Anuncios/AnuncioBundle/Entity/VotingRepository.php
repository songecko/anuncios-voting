<?php

namespace Anuncios\AnuncioBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * VotingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VotingRepository extends EntityRepository
{
	public function votesOnYear($year)
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT v
			FROM AnunciosAnuncioBundle:Voting v
			LEFT JOIN AnunciosAnuncioBundle:Anuncio a WITH a.id = v.anuncio
			LEFT JOIN AnunciosAnuncioBundle:Campaign c WITH c.id = a.campaign
			WHERE c.year = :year'
		)->setParameters(array(
			'year' => $year
		))
		->getResult();
	}
	
	public function hasVoting($user, $anuncio)
	{
		return $this->getEntityManager()
		->createQuery(
			'SELECT v 
			FROM AnunciosAnuncioBundle:Voting v 
			WHERE v.user = :user AND v.anuncio = :anuncio'
		)->setParameters(array(
    		'user'     => $user,
    		'anuncio'  => $anuncio
		))	
		->getResult();
	}
}
