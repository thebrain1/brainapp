<?php
namespace Brainapp\CoreBundle\Entity\Interfaces;

interface iDayOfPeriod
{
	public static function getInstance($value);
	public function isEqualToDate($date);
	public function getLabel();
	public function getNextDay();
}