<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractAccount;
use Brainapp\CoreBundle\Entity\UserEntities\UserAccountRepository;
use Brainapp\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserAccount Entity
 *
 * @author Chris Schneider
 *
 * @ORM\Entity(repositoryClass="Brainapp\CoreBundle\Entity\UserEntities\UserAccountRepository")
 */
class UserAccount extends AbstractAccount
{
	
	/**
	 * @ORM\ManyToOne(targetEntity="Brainapp\UserBundle\Entity\User")
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
