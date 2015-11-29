<?php

namespace Brainapp\UserBundle\Entity\UserEntities;

use Doctrine\ORM\EntityRepository;
use Brainapp\UserBundle\Entity\UserEntities\UserCategory;

/**
 * UserCategoryRepository
 * 
 * @author Chris Schneider
 */
class UserCategoryRepository extends EntityRepository
{
	//TODO: Auslagern
	public function storeCategoryIfNotExists(UserCategory $category)
	{
		
		$result = $this->createQueryBuilder('c')
		               ->select("COUNT(c.categoryId)")
		               //->where("c.type='user'")
		               ->andWhere("c.categoryName='" . $category->getCategoryName() . "'")
		               ->andWhere("c.ownerId=" . $category->getOwnerId())
		               ->getQuery()
		               ->getSingleScalarResult();
		
		$em = $this->getEntityManager();
		$em->persist($category);
		$result = $em->flush();
	}
	public function getUserCategoriesByOwnerId($ownerId)
	{
		//$sql = "SELECT * FROM tbl_category WHERE ownerId = " . $userId;
		//$result = $this->findAll();
		
		return $this->findBy(array('ownerId' => $ownerId));
	}
	
	public function getUserCategoryByCategoryName($categoryName)
	{
		return $this->findByCategoryName($categoryName);
	}
	
	public function getUserCategoryByCategoryId($categoryId)
	{
		return $this->findOneByCategoryId($categoryId);
	}
}
