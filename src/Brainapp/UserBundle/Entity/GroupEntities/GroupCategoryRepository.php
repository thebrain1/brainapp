<?php

namespace Brainapp\UserBundle\Entity\GroupEntities;

use Doctrine\ORM\EntityRepository;

/**
 * GroupCategoryRepository
 * 
 * @author Chris Schneider
 */
class GroupCategoryRepository extends EntityRepository
{
	//TODO: Auslagern
	public function storeCategoryIfNotExists(GroupCategory $category)
	{
	
		$result = $this->createQueryBuilder('c')
		                ->select("COUNT(c.categoryId)")
		                //->where("c.type='group'")
		                ->andWhere("c.categoryName='" . $category->getCategoryName() . "'")
		                ->andWhere("c.ownerId=" . $category->getOwnerId())
		                ->getQuery()
		                ->getSingleScalarResult();
	
		$em = $this->getEntityManager();
		$em->persist($category);
		$result = $em->flush();
	}
}
