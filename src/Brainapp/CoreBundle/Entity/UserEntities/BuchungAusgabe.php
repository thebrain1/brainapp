<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung;
use Doctrine\ORM\Mapping as ORM;

/**
 * BuchungAusgabe Entity
 *
 * @author Chris Schneider
 *
 * @ORM\Entity(repositoryClass="Brainapp\CoreBundle\Entity\UserEntities\BuchungRepository")
 */
class BuchungAusgabe extends AbstractBuchung
{
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