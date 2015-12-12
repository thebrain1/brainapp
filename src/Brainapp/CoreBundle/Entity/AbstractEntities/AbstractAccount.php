<?php

namespace Brainapp\CoreBundle\Entity\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diese Klasse repräsentiert eine Konto, entweder das einer Gruppe oder eines Users.
 * 
 * @author Chris Schneider
 * 
 * @ORM\Entity
 * @ORM\Table(name="tbl_account")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap( {"user" = "Brainapp\CoreBundle\Entity\UserEntities\UserAccount", "group" = "Brainapp\CoreBundle\Entity\GroupEntities\GroupAccount"} )
 */
abstract class AbstractAccount
{
    
	//Variablen
	/**
	 * @ORM\Id
	 * @ORM\Column(name="accountId", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $accountId;
	
	/**
	 * @ORM\Column(name="accountName", type="string")
	 */
	protected $accountName;
	
	/**
	 * @ORM\Column(name="accountCurrentValue", type="float", options={"default" = 0.0})
	 */
	protected $accountCurrentValue;
	
	/**
	 * @ORM\Column(name="accountStartValue", type="float", options={"default" = 0.0})
	 */
	protected $accountStartValue;
	
	/**
	 * @ORM\Column(name="accountIsDefaultAccount", type="boolean", options={"default" = false})
	 */
	protected $accountIsDefaultAccount;
	
	protected $ownerId;
	
	public function getAccountId() {
		return $this->accountId;
	}
	public function setAccountId($accountId) {
		$this->accountId = $accountId;
		return $this;
	}
	
	public function getAccountName() {
		return $this->accountName;
	}
	public function setAccountName($accountName) {
		$this->accountName = $accountName;
		return $this;
	}
	
	public function getAccountCurrentValue() {
		return $this->accountCurrentValue;
	}
	public function setAccountCurrentValue($accountCurrentValue) {
		$this->accountCurrentValue = $accountCurrentValue;
		return $this;
	}
	
	public function getAccountStartValue() {
		return $this->accountStartValue;
	}
	public function setAccountStartValue($accountStartValue) {
		$this->accountStartValue = $accountStartValue;
		return $this;
	}
	
	public function getAccountIsDefaultAccount()
	{
		return $this->accountIsDefaultAccount;
	}
	public function setAccountIsDefaultAccount($accountIsDefaultAccount)
	{
		$this->accountIsDefaultAccount = $accountIsDefaultAccount;
		return $this->accountIsDefaultAccount;
	}
	
// 	public function getOwnerId() {
// 		return $this->ownerId;
// 	}
// 	public function setOwnerId($ownerId) {
// 		$this->ownerId = $ownerId;
// 		return $this;
// 	}
	
	
	
	
}
