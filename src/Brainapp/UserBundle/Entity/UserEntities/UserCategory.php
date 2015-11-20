<?php

namespace Brainapp\UserBundle\Entity\UserEntities;

use Brainapp\UserBundle\Entity\AbstractEntities\AbstractCategory;

class UserCategory extends AbstractCategory
{
	protected $userId;
	
	public function __construct($categoryId, $categoryName, $userId, $parentCategoryId=null)
	{
		parent::__construct($categoryId, $categoryName, $parentCategoryId);
	
		$this->userId = $userId;
	}
	
	public function getUserId()
	{
		return $this->userId;
	}
	
}
