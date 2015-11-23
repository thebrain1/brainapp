<?php

namespace Brainapp\UserBundle\Entity\GroupEntities;

use Brainapp\UserBundle\Entity\AbstractEntities\AbstractCategory;
use Doctrine\ORM\Mapping as ORM;

/**
 * GroupCategory Entity
 *
 * @ORM\Entity(repositoryClass="Brainapp\UserBundle\Entity\GroupCategoryRepository")
 */
class GroupCategory extends AbstractCategory
{
	
	/**
	 * @ORM\ManyToOne(targetEntity="Brainapp\UserBundle\Entity\Group")
	 * @ORM\Column(name="ownerId", type="integer")
	 * @ORM\JoinColumn={referencedColumnName="id")}
	 */
	protected $ownerId;
	
	public function __construct($categoryId, $categoryName, array $ownerId, $parentCategoryId=null)
	{
		parent::__construct($categoryId,$categoryName,$parentCategoryId);
		
		$this->ownerId = $ownerId;
	}
	
	public function getOwnerId()
	{
		return $this->ownerId;
	}
		
	
	//Aufheben. Irgenwann mal nützlich
	
// 	public function getOwnerAsString()
// 	{
// 		$numberOfOwner = sizeof($this->ownerId);
// 		$ownerString = "";
		
// 		for($c = 0; $c < $numberOfOwner; $c++)
// 		{
// 			$ownerString = $ownerString . $this->ownerId[$c];
			
// 			if($c < ($numberOfOwner - 1))
// 			{
// 				$ownerString = $ownerString . ", ";
// 			}
// 		}
		
// 		return $ownerString;
// 	}
	
    
}
