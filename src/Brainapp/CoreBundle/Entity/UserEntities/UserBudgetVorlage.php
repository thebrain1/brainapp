<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractAccount;
use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBudget;
use Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlageRepository;
use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractCategory;
use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractPeriod;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * UserBudgetVorlage Entity
 *
 * @author Chris Schneider
 *
 * @ORM\Table(name="tbl_userBudgetVorlage", options={"comment":"Tabelle Budgetvorlagen"})
 * @ORM\Entity(repositoryClass="Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlageRepository")
 */
class UserBudgetVorlage extends AbstractBudget
{
	/**
	 * @ORM\Id
	 * @ORM\Column(name="budgetVorlageId", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
    /**
     * @ORM\Column(name="budgetVorlageResetPeriod", type="string")
     */
    protected $resetPeriod;
    /**
     * @ORM\Column(name="resetTriggerDate", type="integer")
     */
    protected $resetTriggerDate;
    /**
     * @ORM\ManyToOne(targetEntity="Brainapp\CoreBundle\Entity\AbstractEntities\AbstractCategory")
     * @ORM\JoinColumn(name="category", referencedColumnName="categoryId", nullable=true, onDelete="SET NULL")
     */
    protected $category;
    /**
     * @ORM\ManyToOne(targetEntity="Brainapp\CoreBundle\Entity\AbstractEntities\AbstractAccount")
     * @ORM\JoinColumn(name="account", referencedColumnName="accountId", nullable=false, onDelete="CASCADE")
     */
    protected $account;
    /**
     * @ORM\Column(name="budgetName", type="string", nullable=false)
     */
    protected $budgetName;
    
    
    public function getId() {
    	return $this->id;
    }
    public function setId($id) {
    	$this->id = $id;
    	return $this;
    }
	
    
    
    public function getResetPeriod()
    {
    	return $this->resetPeriod;;
    }
    public function setResetPeriod($resetPeriod) {
    	$this->resetPeriod = $resetPeriod;
    	return $this;
    }
    
    
    
    public function getResetTriggerDate() {
    	return $this->resetTriggerDate;
    }
    public function setResetTriggerDate($resetTriggerDate) {
    	$this->resetTriggerDate = $resetTriggerDate;
    	return $this;
    }
    
    
    
    public function getCategory() {
    	return $this->category;
    }
    public function setCategory($category)
    {
    	$this->category = $category;
    	return $this;
    }
    
    
    
    public function getAccount() {
    	return $this->account;
    }
    public function setAccount($account) {
    	$this->account = $account;
    	return $this;
    }
    
    
    
    public function getBudgetName() {
    	return $this->budgetName;
    }
    public function setBudgetName($budgetName) {
    	$this->budgetName = $budgetName;
    	return $this;
    }
    
	public function getResetPeriodObject() {
		$period = $this->resetPeriod;
		
		$periodInstance = AbstractPeriod::getInstanceByPeriodNameAndTriggerDay($period, $this->resetTriggerDate);
		
		return $periodInstance;
	}
	
	public function jsonSerialize()
	{
		return $this;
	}
	
	public function changingScope($changingScope = null)
	{
		//TODO changingScope (Umfang der Änderung einer BudgetVorlage implementieren)
	}
	
	
	const DATE_FORMAT = "d.m.Y";
	
	public function getBudgetInstance($zeitraumVon, $zeitraumBis)
	{
		$budgetInstance = new UserBudget();
		
		$budgetInstance->setBudgetVorlage($this);
		$budgetInstance->setBudgetZeitraumVon(date(UserBudgetVorlage::DATE_FORMAT, $zeitraumVon));
		$budgetInstance->setBudgetZeitraumBis(date(UserBudgetVorlage::DATE_FORMAT, $zeitraumBis));
		
		return $budgetInstance;
	}
}
