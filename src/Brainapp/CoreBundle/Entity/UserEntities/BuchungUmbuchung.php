<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung;
use Brainapp\CoreBundle\Entity\UserEntities\BuchungEinnahme;
use Doctrine\ORM\Mapping as ORM;

/**
 * BuchungUmbuchung Entity
 *
 * @author Chris Schneider
 *
 * @ORM\Entity(repositoryClass="Brainapp\CoreBundle\Entity\UserEntities\BuchungRepository")
 */
class BuchungUmbuchung extends AbstractBuchung
{
	/**
	 * @ORM\ManyToOne(targetEntity="Brainapp\CoreBundle\Entity\AbstractEntities\AbstractAccount")
	 * @ORM\JoinColumn(name="targetAccount", referencedColumnName="accountId", nullable=true, onDelete="SET NULL")
	 */
	protected $targetAccount;
	
	/**
	 * @ORM\OneToOne(targetEntity="Brainapp\CoreBundle\Entity\UserEntities\BuchungEinnahme")
	 * @ORM\JoinColumn(name="einnahme", referencedColumnName="id", nullable=true, onDelete="CASCADE");
	 */
	protected $einnahme;
	
	public function getTargetAccount() {
		return $this->targetAccount;
	}
	public function setTargetAccount($targetAccount) {
		$this->targetAccount = $targetAccount;
		return $this;
	}
	
	public function getEinnahme()
	{
		if(is_null($this->einnahme))
		{
			$einnahme = new BuchungEinnahme();
			
			$einnahme->setTitle($this->getTitle());
			$einnahme->setComment("Einnahme aus Umbuchung" . $this->getId());
			$einnahme->setDate($this->getDate());
			$einnahme->setValue($this->getValue());
			$einnahme->setCategory($this->getCategory());
			$einnahme->setAccount($this->getTargetAccount());
			
			$this->einnahme = $einnahme;
		}
		
		return $this->einnahme;
	}
	public function setEinnahme($einnahme)
	{
		$this->einnahme = $einnahme;
		return $this;
	}
	
	public function setValue($value)
	{
		parent::setValue($value);
		
		$localValue = $this->value;
		
		if($value > 0)
		{
			$localValue = $localValue * (-1);
		}
		
		$this->value = $localValue;
		return $this;
	}
}