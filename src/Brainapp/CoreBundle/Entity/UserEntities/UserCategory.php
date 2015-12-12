<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractCategory;
use Brainapp\CoreBundle\Entity\UserEntities\UserCategoryRepository;
use Brainapp\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserCategory Entity
 *
 * @author Chris Schneider
 *
 * @ORM\Entity(repositoryClass="Brainapp\CoreBundle\Entity\UserEntities\UserCategoryRepository")
 */
class UserCategory extends AbstractCategory
{
	
	/**
	 * @ORM\ManyToOne(targetEntity="Brainapp\UserBundle\Entity\User")
	 * @ORM\Column(name="ownerId", type="integer")
	 * @ORM\JoinColumn={referencedColumnName="id")}
	 */
	protected $ownerId;
	
	public function __construct($categoryName=null, $ownerId=null, $parentCategory=null)
	{
		parent::__construct($categoryName, $parentCategory);
	
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
