<?php

namespace Brainapp\CoreBundle\Entity\AbstractEntities;

abstract class AbstractDayOfPeriod {

	protected $period;
	protected $value;
	
	public function getPeriod()
	{
		return $this->period;
	}
	
	public function getValue()
	{
		return $this->value;
	}
	
	protected function __construct($period, $value)
	{
		$this->period = $period;
		
		$this->value = $value;
		
	}
}