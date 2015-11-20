<?php

namespace Brainapp\UserBundle\Entity\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractCategory
{
    
	protected $categoryId;
	protected $parentCategoryId;
	protected $categoryName;
	
	public function __construct($categoryId,$categoryName, $parentCategoryId=null)
	{
		$this->categoryId = $categoryId;
		$this->categoryName = $categoryName;
		
		if(!(null==$parentCategoryId))
		{
			$this->parentCategoryId=$parentCategoryId;
		}		
	}
	
	public function getCategoryId()
	{
		return $this->categoryId;
	}
	public function getParentCategoryId() {
		return $this->parentCategoryId;
	}
	public function setParentCategoryId($parentCategoryId)
	{
		$this->parentCategoryId = $parentCategoryId;
		return $this;
	}
	public function getCategoryName()
	{
		return $this->categoryName;
	}
	public function setCategoryName($categoryName)
	{
		$this->categoryName = $categoryName;
		return $this;
	}
	
    
}
