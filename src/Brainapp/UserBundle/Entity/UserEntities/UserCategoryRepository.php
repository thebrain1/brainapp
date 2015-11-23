<?php

namespace Brainapp\UserBundle\Entity\UserEntities;

use Doctrine\ORM\EntityRepository;

/**
 * UserCategoryRepository
 */
class UserCategoryRepository extends EntityRepository
{
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
}
