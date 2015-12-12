<?php

namespace Brainapp\CoreBundle\Entity\GroupEntities;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractAccount;
use Brainapp\CoreBundle\Entity\GroupEntities\GroupAccountRepository;
use Brainapp\UserBundle\Entity\Group;
use Doctrine\ORM\Mapping as ORM;

/**
 * GroupAccount Entity
 *
 * @author Chris Schneider
 *
 * @ORM\Entity(repositoryClass="Brainapp\CoreBundle\Entity\GroupEntities\GroupAccountRepository")
 */
class GroupAccount extends AbstractAccount
{
	
	/**
	 * @ORM\ManyToOne(targetEntity="Brainapp\UserBundle\Entity\Group")
	 * @ORM\Column(name="ownerId", type="integer")
	 * @ORM\JoinColumn={referencedColumnName="id")}
	 */
	protected $ownerId;
	
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
