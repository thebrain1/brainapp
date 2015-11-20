<?php

namespace Brainapp\UserBundle\Entity\GroupEntities;

use Brainapp\UserBundle\Entity\AbstractEntities\AbstractCategory;

class GroupCategory extends AbstractCategory
{
    
	protected $groupId;
	
	public function __construct($categoryId, $categoryName, $groupId, $parentCategoryId=null)
	{
		parent::__construct($categoryId,$categoryName,$parentCategoryId);
		
		$this->groupId = $groupId;
	}
	
	public function getGroupId()
	{
		return $this->groupId;
	}
	
    
}
