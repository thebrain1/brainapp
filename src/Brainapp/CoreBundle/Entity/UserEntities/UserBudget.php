<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBudget;
use Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlage;

/**
 * UserBudget Entity
 *
 * @author Chris Schneider
 */
class UserBudget extends AbstractBudget
{
	

	protected $budgetId;
	
    protected $budgetZeitraumVon;
    
    protected $budgetZeitraumBis;
    
    protected $budgetVorlage;
    
    protected $budgetVerbraucht;
	
    public function getBudgetId() {
    	return $this->budgetId;
    }
    public function setBudgetId($budgetId) {
    	$this->budgetId = $budgetId;
    	return $this;
    }
	public function getBudgetZeitraumVon() {
		return $this->budgetZeitraumVon;
	}
	public function setBudgetZeitraumVon($budgetZeitraumVon) {
		$this->budgetZeitraumVon = $budgetZeitraumVon;
		return $this;
	}
	public function getBudgetZeitraumBis() {
		return $this->budgetZeitraumBis;
	}
	public function setBudgetZeitraumBis($budgetZeitraumBis) {
		$this->budgetZeitraumBis = $budgetZeitraumBis;
		return $this;
	}
	
	public function getBudgetVorlage()
	{
		return $this->budgetVorlage;
	}
	public function setBudgetVorlage(UserBudgetVorlage $budgetVorlage)
	{
		$this->budgetVorlage = $budgetVorlage;
		return $this;
	}
	
	public function getBudgetVerbraucht()
	{
		return $this->budgetVerbraucht;
	}
	public function setBudgetVerbraucht($budgetVerbraucht)
	{
		$this->budgetVerbraucht = round($budgetVerbraucht, 2);
		return $this;
	}
	public function getBudgetVerbrauchtForCanvasHover()
	{
		return $this->getBudgetVerbraucht() . " €";
	}
	
	public function getRestbetrag()
	{
		$localBudgetVorlageValue = $this->getBudgetVorlage()
		                                ->getBudgetValue();
		
		$localBudgetVerbraucht = $this->budgetVerbraucht;
		
		if(is_null($localBudgetVorlageValue))
		{
			return null;
		}
		else if(is_null($localBudgetVerbraucht))
		{
			return round($localBudgetVorlageValue, 2); 
		}
		else
		{
			//$localBudgetVerbraucht ist bereits negativ!
			return $localBudgetVorlageValue + $localBudgetVerbraucht;
		}
	}
}
