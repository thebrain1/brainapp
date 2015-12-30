<?php

namespace Brainapp\CoreBundle\Entity;

use Symfony\Component\HttpKernel\Exception\HttpException;

class MonthRequest {
	
	const MONTHS = array("Januar","Februar","M&auml;rz","April","Mai","Juni","Juli","August","September","Oktoker","November","Dezember");
	
	private $month;
	
	public function __construct($paramMonth = null)
	{
		if(is_null($paramMonth))
		{
			$localCurrentMonth = date('n');
			
			$this->setMonth($localCurrentMonth - 1);
		}
		else
		{
			$this->month = $paramMonth;
		}
		
	}
	
	public function getMonth()
	{
		return $this->month;	
	}
	
	public function getRequestForNextMonth()
	{
		$index = array_search($this->month);
		
		$indexNextMonth = 0;
		
		if($index < ( sizeof(MonthRequest::MONTHS) - 1 ) )
		{
			$indexNextMonth = $index + 1;
		}
		
		return new MonthRequest(MonthRequest::MONTHS[$indexNextMonth]);
	}
	
	public function setMonth($month)
	{
		$logPrefix = MonthRequest::getLogPrefix() . "setMonth()::";
		
		if(is_null($month))
		{
			throw new HttpException(400, $logPrefix. "Parameter 'month' is null.");
		}
		
		if(in_array($month, MonthRequest::MONTHS))
		{
			$this->month = $month;
			return $this;
		}
		else if(is_numeric($month))
		{
			if($month < 0 || $month >= (sizeof(MonthRequest::MONTHS)))
			{
				throw new HttpException(400, $logPrefix. "Parameter 'month' is invalid. " . $month . " given.");
			}
			else
			{
				$this->month = MonthRequest::MONTHS[$month];
			}
		}
	}
	
	private static function getLogPrefix()
	{
		return "MonthRequest::";
	}
}