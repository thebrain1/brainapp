<?php

namespace Brainapp\CoreBundle\Entity;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractPeriod;
use Brainapp\CoreBundle\Entity\DayOfWeek;

class PeriodWeekly extends AbstractPeriod
{
	const PERIOD_NAME_WEEKLY = "WEEKLY";
	const PERIOD_DESCRIPTION_WEEKLY = "jede Woche";

	public function getDaysOfPeriod()
	{
		$days = null;
		
		for($i = 1; $i <= DayOfWeek::NUMBER_OF_DAYS; $i++)
		{
			$days[$i] = DayOfWeek::getInstance($i);
		}
		
		return $days;
	}
	
	
	static function getInstance($triggerDay)
	{
		return new PeriodWeekly(PeriodWeekly::PERIOD_NAME_WEEKLY, PeriodWeekly::PERIOD_DESCRIPTION_WEEKLY, $triggerDay);
	}
	
	function getLogPrefix()
	{
		return "PeriodWeekly::";
	}
	
	function getTriggerDay()
	{
		return DayOfWeek::getInstance($this->triggerDay);
	}
}