<?php

namespace Brainapp\CoreBundle\Entity;

use Brainapp\CoreBundle\Entity\Interfaces\iDayOfPeriod;
use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractDayOfPeriod;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DayOfWeek extends AbstractDayOfPeriod implements iDayOfPeriod{
	
	const NUMBER_OF_DAYS = 7;
	private static $days = array("Monday",
			                     "Tuesday",
			                     "Wednesday",
			                     "Thursday",
			                     "Friday",
			                     "Saturday",
			                     "Sunday");
	
	public static function getInstance($value)
	{
		$logPrefix = DayOfWeek::getLogPrefix() . "getInstance()::";

		if(!is_null($value))
		{
			if($value > 0 && $value <= DayOfWeek::NUMBER_OF_DAYS)
			{
				return new DayOfWeek("WEEKLY", $value);
			}
			else
			{
				throw new HttpException(400, $logPrefix . "The value of a day has to be in the intervall between 1 an 7, " . $value . " given.");
			}
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'value' is null");
		}
	}
	
	public function isEqualToDate($date)
	{
		if(date("l", $this->date) == date("l", $date))
		{
			return true;
		}
	
		return false;
	}
	
	public function translateDateName()
	{
		$dateName = DayOfWeek::$days[$this->value - 1];
		
		switch ($dateName) {
			case DayOfWeek::$days[0]:
				$result = "Montag";
				break;
			case DayOfWeek::$days[1]:
				$result = "Dienstag";
				break;
			case DayOfWeek::$days[2]:
				$result = "Mittwoch";
				break;
			case DayOfWeek::$days[3]:
				$result = "Donnerstrag";
				break;
			case DayOfWeek::$days[4]:
				$result = "Freitag";
				break;
			case DayOfWeek::$days[5]:
				$result = "Samstag";
				break;
			case DayOfWeek::$days[6]:
				$result = "Sonntag";
				break;
			default:
				$result = $dateName;
		}
	
		return $result;
	}
	
	protected function __construct($period, $value)
	{
		parent::__construct($period, $value);
	
		$this->date = strtotime($value);
	}
	
	public function getLabel()
	{
		return $this->translateDateName();
	}
	
	public function getNextDay()
	{
		$index = $this->value;
		
		$indexNextDay = 0;
		
		if($index < ( sizeof($this->days) - 1 ) )
		{
			$indexNextDay = $index + 1;
		}
		
		return new DayOfWeek($indexNextDay);
	}
	
	private static function getLogPrefix()
	{
		return "DayOfWeek::";
	}
}