<?php

namespace Brainapp\UserBundle\Entity\UserEntities;

use Brainapp\UserBundle\Entity\AbstractEntities\AbstractCategory;
use Brainapp\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserCategory Entity
 *
 * @author Chris Schneider
 *
 * @ORM\Entity(repositoryClass="Brainapp\UserBundle\Entity\UserEntities\UserCategoryRepository")
 */
class UserCategory extends AbstractCategory
{
	
	/**
	 * @ORM\ManyToOne(targetEntity="Brainapp\UserBundle\Entity\User")
	 * @ORM\Column(name="ownerId", type="integer")
	 * @ORM\JoinColumn={referencedColumnName="id")}
	 */
	protected $ownerId;
	
	public function __construct($categoryName=null, $ownerId=null, $parentCategoryId=null)
	{
		parent::__construct($categoryName, $parentCategoryId);
	
		$this->ownerId = $ownerId;
	}
		
	public function getOwnerId()
	{
		return $this->ownerId;
	}
	
	public function setOwnerId($ownerId)
	{
		$this->ownerId = $ownerId;
		return $this;
	}
}
