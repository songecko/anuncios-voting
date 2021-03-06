<?php

namespace Anuncios\AnuncioBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
	public function hasVotingByCategory($campaign, $category, $user)
	{
		$anualSql = '';
		if($campaign->isAnual() && $user)
		{
			$finalistType = $user->getIsJurado()?Anuncio::FINALIST_TYPE_JURADO:Anuncio::FINALIST_TYPE_USUARIO;
			$anualSql .= " AND (a.finalistType = '".$finalistType."' OR a.finalistType IS NULL)";
		}
		
		return $this->getEntityManager()
		->createQuery(
				'SELECT count(u) 
				FROM AnunciosAnuncioBundle:User u 
				INNER JOIN AnunciosAnuncioBundle:Voting v WITH u.id = v.user
				INNER JOIN AnunciosAnuncioBundle:Anuncio a WITH a.id = v.anuncio 
				WHERE a.campaign = :campaign AND a.category = :category'.$anualSql.' AND u.id = :user_id'
		)->setParameters(array(
			'campaign' => $campaign,
			'category' => $category,
			'user_id'     => $user->getId()
		))
		->getSingleScalarResult();
	}
	
	public function isCompleteVoting($campaign, $category, $user)
	{
		if($user && $this->hasVotingByCategory($campaign, $category, $user) >= 3)
		{
			return true;
		}
		
		return false;
	}
}
