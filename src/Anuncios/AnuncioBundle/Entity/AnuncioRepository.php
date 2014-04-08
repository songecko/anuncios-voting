<?php

namespace Anuncios\AnuncioBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AnuncioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnuncioRepository extends EntityRepository
{
	public function getAnunciosByCategory($campaign, $category, $user = false)
	{
		$anualSql = '';
		if($campaign->isAnual() && $user)
		{
			$finalistType = $user->getIsJurado()?Anuncio::FINALIST_TYPE_JURADO:Anuncio::FINALIST_TYPE_USUARIO;
			$anualSql .= " AND (a.finalistType = '".$finalistType."' OR a.finalistType IS NULL)";
		}
		
		return $this->getEntityManager()
		->createQuery(
				'SELECT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign = :campaign AND a.category = :category'.$anualSql.'
				ORDER BY a.votoJurado+a.votoUsuario DESC, a.name'
		)->setParameters(array(
			'campaign' => $campaign,
			'category' => $category
		))
		->getResult();
	}
	
	public function getAnunciosByCategoryAnual($category, $year)
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT DISTINCT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign IN (
					SELECT c.id FROM AnunciosAnuncioBundle:Campaign c WHERE c.year = :year
				) 
				AND a.category = :category
				ORDER BY a.votoJurado+a.votoUsuario DESC, a.name'
		)->setParameters(array(
				'category' => $category,
				'year'     => $year
		))
		->getResult();
	}
	
	public function getLeftAnunciosVoteByUser($campaign, $user, $category)
	{
		$anualSql = '';
		if($campaign->isAnual() && $user)
		{
			$finalistType = $user->getIsJurado()?Anuncio::FINALIST_TYPE_JURADO:Anuncio::FINALIST_TYPE_USUARIO;
			$anualSql .= " AND (a.finalistType = '".$finalistType."' OR a.finalistType IS NULL)";
		}
		
		return $this->getEntityManager()
		->createQuery(
				'SELECT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign = :campaign AND a.category = :category'.$anualSql.'
				AND a.id NOT IN (
					SELECT IDENTITY(v.anuncio) FROM AnunciosAnuncioBundle:Voting v WHERE v.user = :user
				)
				GROUP BY a.category
				ORDER BY a.name'
		)->setParameters(array(
				'campaign' => $campaign,
				'user' => $user,
				'category' => $category
		))->setMaxResults(1)
		->getOneOrNullResult();
	}
	
	public function getLastAnunciosVoteByUser($campaign, $user, $limit)
	{
		$anualSql = '';
		if($campaign->isAnual() && $user)
		{
			$finalistType = $user->getIsJurado()?Anuncio::FINALIST_TYPE_JURADO:Anuncio::FINALIST_TYPE_USUARIO;
			$anualSql .= " AND (a.finalistType = '".$finalistType."' OR a.finalistType IS NULL)"; 
		}
		
		return $this->getEntityManager()
		->createQuery(
				'SELECT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign = :campaign AND a.category IN (
					SELECT c.id FROM AnunciosAnuncioBundle:Category as c
				)
				AND a.id IN (
					SELECT IDENTITY(v.anuncio) FROM AnunciosAnuncioBundle:Voting v WHERE v.user = :user
				)'.$anualSql.'
				GROUP BY a.category
				ORDER BY a.name'
		)->setParameters(array(
				'campaign' => $campaign,
				'user' => $user
		))
		->setMaxResults($limit)
		->getResult();
	}
	
	public function getLastAnunciosVoteByCategory($campaign, $category, $limit)
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign = :campaign AND a.category = :category AND a.id IN (
					SELECT IDENTITY(v.anuncio) FROM AnunciosAnuncioBundle:Voting v
				)
				ORDER BY a.votoJurado+a.votoUsuario DESC, a.name'
		)->setParameters(array(
				'campaign' => $campaign,
				'category' => $category
		))
		->setMaxResults($limit)
		->getResult();
	}
	
	public function getAnunciosVoteByJurado($campaign, $category, $user = false)
	{
		$anualSql = '';
		if($campaign->isAnual() && $user)
		{
			$anualSql .= " AND (a.finalistType = '".Anuncio::FINALIST_TYPE_JURADO."' OR a.finalistType IS NULL)";
		}
		
		return $this->getEntityManager()
			->createQuery(
				'SELECT a 
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign = :campaign AND a.category = :category'.$anualSql.'
				ORDER BY a.votoJurado DESC'
		)->setParameters(array(
				'campaign' => $campaign,
				'category' => $category
		))->setMaxResults(1)
		->getOneOrNullResult();
	}
	
	public function getAnunciosVoteByUsuario($campaign, $category, $user = false)
	{
		$anualSql = '';
		if($campaign->isAnual() && $user)
		{
			$anualSql .= " AND (a.finalistType = '".Anuncio::FINALIST_TYPE_USUARIO."' OR a.finalistType IS NULL)";
		}
		
		return $this->getEntityManager()
			->createQuery(
				'SELECT a 
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign = :campaign AND a.category = :category'.$anualSql.'
				ORDER BY a.votoUsuario DESC'
		)->setParameters(array(
				'campaign' => $campaign,
				'category' => $category
		))->setMaxResults(1)
		->getOneOrNullResult();
	}
	
	public function getAllAnunciosVoteByJurado($campaign, $category, $user = false)
	{
		$anualSql = '';
		if($campaign->isAnual() && $user)
		{
			$anualSql .= " AND (a.finalistType = '".Anuncio::FINALIST_TYPE_JURADO."' OR a.finalistType IS NULL)";
		}
		
		return $this->getEntityManager()
		->createQuery(
				'SELECT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign = :campaign AND a.category = :category'.$anualSql.'
				ORDER BY a.votoJurado DESC'
		)->setParameters(array(
				'campaign' => $campaign,
				'category' => $category
		))
		->getResult();
	}
	
	public function getAllAnunciosVoteByUsuario($campaign, $category, $user = false)
	{
		$anualSql = '';
		if($campaign->isAnual() && $user)
		{
			$anualSql .= " AND (a.finalistType = '".Anuncio::FINALIST_TYPE_USUARIO."' OR a.finalistType IS NULL)";
		}
		
		return $this->getEntityManager()
		->createQuery(
				'SELECT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.campaign = :campaign AND a.category = :category'.$anualSql.'
				ORDER BY a.votoUsuario DESC'
		)->setParameters(array(
				'campaign' => $campaign,
				'category' => $category
		))
		->getResult();
	}
	
	public function getAnunciosFinalJuradoByCategory($category, $month, $year)
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.category = :category AND a.campaign IN (
					SELECT c.id FROM AnunciosAnuncioBundle:Campaign c WHERE c.month = :month AND
					c.year = :year
				)
				ORDER BY a.votoJurado DESC'
		)->setParameters(array(
				'category' => $category,
				'month'    => $month,
				'year'     => $year
		))->setMaxResults(1)
		->getOneOrNullResult();
	}
	
	public function getAnunciosFinalUsuarioByCategory($category, $month, $year)
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT a
				FROM AnunciosAnuncioBundle:Anuncio a
				WHERE a.category = :category AND a.campaign IN (
					SELECT c.id FROM AnunciosAnuncioBundle:Campaign c WHERE c.month = :month AND
					c.year = :year
				)
				ORDER BY a.votoUsuario DESC'
		)->setParameters(array(
				'category' => $category,
				'month'    => $month,
				'year'     => $year
		))->setMaxResults(1)
		->getOneOrNullResult();
	}
}
