<?php

namespace Brainapp\CoreBundle\Entity;

use Brainapp\CoreBundle\Entity\Interfaces\iDayOfPeriod;
use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractDayOfPeriod;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DayOfMonth extends AbstractDayOfPeriod implements iDayOfPeriod{
	
	const NUMBER_OF_DAYS = 31;
	
	public static function getInstance($value)
	{
		$logPrefix = DayOfMonth::getLogPrefix() . "getInstance()::";
		
		if(!is_null($value))
		{
			if($value > 0 && $value <= DayOfMonth::NUMBER_OF_DAYS)
			{
				return new DayOfMonth("MONTHLY", $value);
			}
			else
			{
				throw new HttpException(400, $logPrefix . "The value of a day has to be in the intervall between 1 an 31, " . $value . " given.");
			}
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'value' is null");
		}

	}
	
	public function isEqualToDate($date)
	{
		if(date("j", $this->date) == date("j", $date))
		{
			return true;
		}
	
		return false;
	}
	
	protected function __construct($period, $value)
	{
		parent::__construct($period, $value);
		
		$this->date = mktime(null,null,null,null,$value);
	}
	
	public function getLabel()
	{
		return $this->value . ".";
	}
	
	public function getNextDay()
	{
		
	}
	
	private static function getLogPrefix()
	{
		return "DayOfMonth::";
	}
}