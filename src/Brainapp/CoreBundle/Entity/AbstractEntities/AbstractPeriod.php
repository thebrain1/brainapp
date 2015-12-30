<?php

namespace Brainapp\CoreBundle\Entity\AbstractEntities;

use Brainapp\CoreBundle\Entity\PeriodMonthly;
use Brainapp\CoreBundle\Entity\PeriodWeekly;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractPeriod
{
	protected $periodName;
	protected $periodDescription;
	protected $triggerDay;
	
	abstract public function getDaysOfPeriod();
	abstract public function getTriggerDay();
	abstract protected function getLogPrefix();
	
	public function getPeriodName()
	{
		return $this->periodName;
	}
	
	public function getPeriodDescription()
	{
		return $this->periodDescription;
	}
	
	protected function __construct($periodName, $periodDescription, $triggerDay)
	{
		$logPrefix = $this->getLogPrefix() . "__construct::";
		
		if($periodName == null)
		{
			throw new HttpException( 400, $logPrefix . "Parameter 'name' is null" );
		}
		
		if($periodDescription == null)
		{
			throw new HttpException( 400, $logPrefix . "Parameter 'periodDescription' is null" );
		}
		
		if(is_null($triggerDay))
		{
			throw new HttpException( 400, $logPrefix . "Parameter 'triggerDay' is null" );
		}
		
		$this->periodName = $periodName;
		$this->periodDescription = $periodDescription;
		$this->triggerDay = $triggerDay;
	}
	
	public static function getInstanceByPeriodNameAndTriggerDay($periodName, $triggerDay)
	{
		if($periodName == "MONTHLY")
		{
			return PeriodMonthly::getInstance($triggerDay);
		}
		else if($periodName == "WEEKLY")
		{
			return PeriodWeekly::getInstance($triggerDay);
		}
	}
}