<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\UserEntities\UserCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * UserCategoryRepository
 * 
 * @author Chris Schneider
 */
class UserCategoryRepository extends EntityRepository
{
	
	private function getClassLogPrefix()
	{
		return "UserCategoryRepository::";
	}
	
	public function storeCategory(UserCategory $category)
	{
		$logPrefix = $this->getClassLogPrefix() . "storeCategory::";
		
		if($category != null)
		{
			$em = $this->getEntityManager();
			$em->persist($category);
			$result = $em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'category' is null");
		}
		
	}
	
	
	
	public function getUserMainCategoriesByOwnerId($ownerId)
	{
		$logPrefix = $this->getClassLogPrefix() . "getUserMainCategoriesByOwnerId::";
		
		if($ownerId != null)
		{
			$queryBuilder = $this->createQueryBuilder('c');
			$expr = $queryBuilder->expr();
			
			$query = $queryBuilder->add('where', $expr->andX($expr->eq('c.ownerId', $ownerId),
					                                         $expr->isNull('c.parentCategory')))
					              ->orderBy('c.categoryName');
			
			return $query->getQuery()->getResult();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'ownerId' is null");
		}
		
		
	}
	
	public function getUserSubCategoriesByParentCategoryId($parentCategoryId)
	{
		$logPrefix = $this->getClassLogPrefix() . "getUserSubCategoriesByParentCategoryId::";
	
		if($parentCategoryId != null)
		{
			$queryBuilder = $this->createQueryBuilder('c');
			$expr = $queryBuilder->expr();
			 
			$query = $queryBuilder->add('where', $expr->eq('c.parentCategory', $parentCategoryId))
			                      ->orderBy('c.categoryName');
			 
			return $query->getQuery()->getResult();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'parentCategoryId' is null");
		}	
	}
	
	public function getUserCategoryByCategoryId($categoryId)
	{
		$logPrefix = $this->getClassLogPrefix() . "getUserCategoryByCategoryId::";
		
		if($categoryId != null)
		{
			return $this->findOneByCategoryId($categoryId);
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'categoryId' is null"); 
		}
	}
	
	public function deleteUserCategoryById($categoryId)
	{
		$logPrefix = $this->getClassLogPrefix() . "deleteUserCategoryById::";
		
	    if($categoryId != null)
    	{
    		$userCat = $this->getUserCategoryByCategoryId($categoryId);
    		
    		if($userCat != null)
    		{
    			$em = $this->getEntityManager();
    			$em->remove($userCat);
    			$em->flush();
    			
    			return true;
    		}
    	}
    	else
    	{
    		throw new HttpException(400, $logPrefix . "Parameter 'categoryId' is null");
    	}
    	
    	return false;
	}
	
	public function updateCategory(UserCategory $category)
	{
		
		$logPrefix = $this->getClassLogPrefix() . "updateCategory::";
		
		if($category != null)
		{
			$categoryId = $category->getCategoryId();
			
			$localUserCat = $this->getUserCategoryByCategoryId($categoryId);
			$localUserCat->setCategoryName($category->getCategoryName());
			
			$em = $this->getEntityManager();
			$em->merge($localUserCat);
			$em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'category' is null");
		}
	}
}
