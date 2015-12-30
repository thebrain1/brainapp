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
	protected $accountValueMonatsEnde;
	protected $accountMonatsSaldo;
	/**
	 * @ORM\Column(name="accountStartValue", type="float", options={"default" = 0.0})
	 */
	protected $accountStartValue;
	/**
	 * @ORM\Column(name="accountIsDefaultAccount", type="boolean", options={"default" = false})
	 */
	protected $accountIsDefaultAccount;
	/**
	 * @ORM\Column(name="ownerId", type="integer"))
	 */
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
		$this->accountCurrentValue = round($accountCurrentValue,2);
		return $this;
	}
	
	public function getAccountValueMonatsEnde() {
		return $this->accountValueMonatsEnde;
	}
	public function setAccountValueMonatsEnde($accountValueMonatsEnde) {
		$this->accountValueMonatsEnde = round($accountValueMonatsEnde,2);
		return $this;
	}
	
	public function getAccountMonatsSaldo() {
		return $this->accountMonatsSaldo;
	}
	public function setAccountMonatsSaldo($accountMonatsSaldo) {
		$this->accountMonatsSaldo = round($accountMonatsSaldo,2);
		return $this;
	}
	
	public function getAccountStartValue() {
		return $this->accountStartValue;
	}
	public function setAccountStartValue($accountStartValue) {
		$this->accountStartValue = round($accountStartValue,2);
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
}
