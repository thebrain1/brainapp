<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlage;
use Brainapp\CoreBundle\Entity\UserEntities\UserBudget;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * 
 * @author Chris Schneider
 *
 */
class DashboardBudgetController extends AbstractController
{
	const DATE_FORMAT_BUCHUNG_SELECT = "Y-m-d";
	
	public function showBudgetsAction(Request $request)
	{
		$GERMAN_MONTH_NAMES = array("Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");
		
		$currentYear = date("Y");
		$currentMonth = date("n");
		
		$month = $request->request->get('selectedBudgetTimeframeMonth');
		$year = $request->request->get('selectedBudgetTimeframeYear');
		
		if(is_null($month) || is_null($year))
		{
			$month = $currentMonth;
			$year = $currentYear;
		}
		
		$monthLabel = $GERMAN_MONTH_NAMES[$month - 1];
		
		$budgets=$this->getBudgetsForYearAndMonth($year, $month);
		
		foreach($budgets as &$userBudgetInstance)
		{
			$this->setBudgtVerbrauchtForBudgetInstanceWithZeitraumSetted($userBudgetInstance);
		}
		
		return $this->render("BrainappCoreBundle:Dashboard/UserBudgetViews:showUserBudets.html.twig",
				             $this->concatWithUserDataArray(array('year' => $year,
				             		                              'month' => $month,
				             		                              'monthLabel' => $monthLabel,
				             		                              'budgets' => $budgets,
				             )));
	}
	
	/* #####################################################################
	 *
	 * helper functions
	 *
	 * #####################################################################
	 */
	private function getBudgetsForYearAndMonth($year, $month)
	{
		$MONTHS = array("January","February","March","April","May","June","July","August","September","October","November","December");


		$userBudVorlageRep = $this->getUserBudgetVorlageRep();
		$buchungRep = $this->getBuchungRep();
		
		$userId=$this->getUserId();
		$userBudgetVorlagen=$userBudVorlageRep->getUserBudgetVorlagenByOwnerId($userId);
		
		$userBudgets = array();
		
		foreach($userBudgetVorlagen as &$budgetVorlage)
		{
			if($budgetVorlage->getResetPeriod() == "WEEKLY")
			{
				$specificDatesForTriggerDateInMonth =  $this->getDatesForSpecificWochentagBetweenDatesWeeklyPeriod("1 " . $MONTHS[$month-1] ." " . $year, //Anfang des Monats
						                                                                                           date("Y-m-t", strtotime($year . "-" . $month ."-23")), //Ende des Monats
						                                                                                           $budgetVorlage->getResetTriggerDate()); //Nummer des gewünschten Wochentags
				
				foreach($specificDatesForTriggerDateInMonth as $wochentag)
				{
					$zeitpunktVon = strtotime("+1 day", $wochentag);
					$zeitpunktBis = strtotime("+1 week", $wochentag);
					
 					$budgetInstance = $budgetVorlage->getBudgetInstance($zeitpunktVon, $zeitpunktBis);
					
					array_push($userBudgets, $budgetInstance);
				}
			}
			else if($budgetVorlage->getResetPeriod() == "MONTHLY")
			{
				$localResetTriggerDate = $budgetVorlage->getResetTriggerDate();
				$anzahlTageDesMonats = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				
				//WENN DAS AUSGEWÄHLTE TRIGGER DATUM (z.B. 31) GAR KEIN TAG DES BETREFFENDEN MONATS IST (den 31. gibt es nicht in jedem Monat)
				if($localResetTriggerDate > $anzahlTageDesMonats)
				{
					$localResetTriggerDate = $anzahlTageDesMonats;
				}
				
				$TRIGGER_DATUM = strtotime($localResetTriggerDate . " " . $MONTHS[$month-1] . " " . $year);
				
// 				<Workaround, Anfang>
				if(date('j', $TRIGGER_DATUM) == 1)
				{
					$localVorherigerMonat="";
					$localJahr = $year;
					
					//Beachte Jahreswechsel...
					if($month == 1)
					{
						$localVorherigerMonat = $MONTHS[11]; //Wenn aktueller Monat == Januar, dann vorheriger Monat=Dezember
						$localJahr = $year - 1;
					}
					else
					{
						$localVorherigerMonat = $MONTHS[$month-2];
					}
					
					//vom 02.11.2015 bis 01.12.2015
					$zeitraumVonBeforeTriggerDate = strtotime("2" . $localVorherigerMonat . " " . $localJahr);
					$zeitraumBisBeforeTriggerDate = strtotime("1" . $MONTHS[$month-1] . " " . $year);
					$budgetInstanceBeforeTriggerDate = $budgetVorlage->getBudgetInstance($zeitraumVonBeforeTriggerDate, $zeitraumBisBeforeTriggerDate);
					
					$localNaechsterMonat = "";
					
					//<Chris Schneider, Bugfix vom 02.01.2016>
					
					//Der Monat vor dem Januar ist Dezember (12 - 1)...
					if($month == 12)
					{
						$localNaechsterMonat = $MONTHS[0]; //Wenn aktueller Monat == Dezember, dann nächster Monat=Januar
						$localJahrAfterTriggerDate = $year + 1;
					}
					else
					{
						$localNaechsterMonat = $MONTHS[$month];
						$localJahrAfterTriggerDate = $year;
					}
					
					//vom 02.12.2016 bis 01.02.2016
					$zeitraumVonAfterTriggerDate = strtotime("2" . $MONTHS[$month-1] . " " . $year);
					$zeitraumBisAfterTriggerDate = strtotime("1" . $localNaechsterMonat . " " . $localJahrAfterTriggerDate);
					$budgetInstanceAfterTriggerDate = $budgetVorlage->getBudgetInstance($zeitraumVonAfterTriggerDate, $zeitraumBisAfterTriggerDate);
					//</Chris Schneider, Bugfix vom 02.01.2016>
					
					array_push($userBudgets, $budgetInstanceBeforeTriggerDate);
					array_push($userBudgets, $budgetInstanceAfterTriggerDate);
				}
				else if(date('j', $TRIGGER_DATUM) == $anzahlTageDesMonats)
				{
					//Beispiel: 01.12.2015 BIS 31.12.2016
					$zeitraumVon = strtotime("1" . $MONTHS[$month-1] . " " . $year);
					$zeitraumBis = strtotime($anzahlTageDesMonats . $MONTHS[$month-1] . " " . $year);
					$budgetInstance = $budgetVorlage->getBudgetInstance($zeitraumVon, $zeitraumBis);
					
					array_push($userBudgets, $budgetInstance);
				}
//				<Workaround, Ende>
				else
				{			
					//Beispiel: 16.11.2015 BIS 15.12.2015
					$zeitraumVonBeforeTriggerDate = strtotime("-1 month +1 day", $TRIGGER_DATUM);
					$zeitraumBisBeforeTriggerDate = $TRIGGER_DATUM;
					$budgetInstanceBeforeTriggerDate = $budgetVorlage->getBudgetInstance($zeitraumVonBeforeTriggerDate, $zeitraumBisBeforeTriggerDate);
					
					//Beispiel: 16.12.2015 BIS 15.01.2016
					$zeitraumVonAfterTriggerDate = strtotime("+1 day", $TRIGGER_DATUM);
					$zeitraumBisAfterTriggerDate = strtotime("+1 month", $TRIGGER_DATUM);
					$budgetInstanceAfterTriggerDate = $budgetVorlage->getBudgetInstance($zeitraumVonAfterTriggerDate, $zeitraumBisAfterTriggerDate);
					
					array_push($userBudgets, $budgetInstanceBeforeTriggerDate);
					array_push($userBudgets, $budgetInstanceAfterTriggerDate);
				}
			}
		}
		
		return $userBudgets;
	}
	
	private function setBudgtVerbrauchtForBudgetInstanceWithZeitraumSetted(UserBudget $budgetInstance)
	{
		$logPrefix = "DashboardBudgetController::setBudgtVerbrauchtForBudgetInstanceWithZeitraumSetted(budgetInstance)::";
		$buchungRep = $this->getBuchungRep();
		$budgetVorlage = $budgetInstance->getBudgetVorlage();
		
		if(is_null($budgetInstance))
		{
			throw new HttpException(400, $logPrefix . "Parameter 'budgetInstance' is null!");
		}
		
		$zeitpunktVon = $budgetInstance->getBudgetZeitraumVon();
		$zeitpunktBis = $budgetInstance->getBudgetZeitraumBis();
		
		if(is_null($zeitpunktVon))
		{
			throw new HttpException(400, $logPrefix . "Property 'budgetZeitraumVon' of parameter 'budgetInstance' is not setted!");
		}
		else if(is_null($zeitpunktBis))
		{
			throw new HttpException(400, $logPrefix . "Property 'budgetZeitraumBis' of parameter 'budgetInstance' is not setted!");
		}
		else
		{
			$zeitpunktVon = strtotime($zeitpunktVon);
			$zeitpunktBis = strtotime($zeitpunktBis);
			
			$budgetInstance->setBudgetVerbraucht($buchungRep->getSumOfBuchungValuesByCategoryAndDatePairs($budgetVorlage->getCategory(),
					array(">=", date(DashboardBudgetController::DATE_FORMAT_BUCHUNG_SELECT, $zeitpunktVon)),
					array("<=", date(DashboardBudgetController::DATE_FORMAT_BUCHUNG_SELECT, $zeitpunktBis))));
			
			return $budgetInstance;
		}
	}
	
	private function getUserBudgetVorlageRep()
	{
		$em = $this->getDoctrine()->getManager();
		return $em->getRepository('Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlage');
	}
	
	private function getBuchungRep()
	{
		$em = $this->getDoctrine()->getManager();
		return $em->getRepository('Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung');
	}
	
	private function getDatesForSpecificWochentagBetweenDatesWeeklyPeriod($startDate,$endDate,$wochenTagNummer)
	{
		$wochentage=array('1'=>'Monday','2' => 'Tuesday','3' => 'Wednesday','4'=>'Thursday','5' =>'Friday','6' => 'Saturday','7'=>'Sunday');
		$count = 0;
		
		$date_array = array();
		
		//Beispiel: Gib mir alle Dienstage im Zeitraum von $startDate bis $endDate, etc.
		for($i = strtotime($wochentage[$wochenTagNummer], strtotime($startDate)); $i <= strtotime($endDate); $i = strtotime('+1 week', $i))
		{
			$count = $count + 1;
			array_push($date_array,$i);
		}
		
		return $date_array;
	}
}