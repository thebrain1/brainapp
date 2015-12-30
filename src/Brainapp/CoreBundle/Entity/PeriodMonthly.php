<?php

namespace Brainapp\CoreBundle\Entity;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractPeriod;
use Brainapp\CoreBundle\Entity\DayOfMonth;

class PeriodMonthly extends AbstractPeriod
{
	const PERIOD_NAME_MONTHLY = "MONTHLY";
	const PERIOD_DESCRIPTION_MONTHLY = "jeder Monat";

	public function getDaysOfPeriod()
	{
		$days = null;
		
		for($i = 1; $i <= DayOfMonth::NUMBER_OF_DAYS; $i++)
		{
			$days[$i] = DayOfMonth::getInstance($i);
		}
		
		return $days;
	}
	
	
	static function getInstance($triggerDay)
	{
		return new PeriodMonthly(PeriodMonthly::PERIOD_NAME_MONTHLY, PeriodMonthly::PERIOD_DESCRIPTION_MONTHLY, $triggerDay);
	}
	
	function getLogPrefix()
	{
		return "PeriodMonthly::";
	}
	
	function getTriggerDay()
	{
		return DayOfMonth::getInstance($this->triggerDay);
	}
}