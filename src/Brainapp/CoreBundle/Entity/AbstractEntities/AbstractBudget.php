<?php

namespace Brainapp\CoreBundle\Entity\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @author Chris Schneider
 */
abstract class AbstractBudget
{

    /**
     * @ORM\Column(name="budgetComment", type="string", nullable = true)
     */
    protected $budgetComment;
    /**
     * @ORM\Column(name="budgetValue", type="float", options={"default" = 0.0})
     */
    protected $budgetValue;
    
    
	public function getBudgetComment() {
		return $this->budgetComment;
	}
	public function setBudgetComment($budgetComment) {
		$this->budgetComment = $budgetComment;
		return $this;
	}
	
	
	
	public function getBudgetValue() {
		return $this->budgetValue;
	}
	public function setBudgetValue($budgetValue) {
		$this->budgetValue = round($budgetValue,2);
		return $this;
	}
}
