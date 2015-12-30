<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\CoreBundle\Entity\UserEntities\UserAccount;
use Brainapp\CoreBundle\Entity\UserEntities\BuchungEinnahme;

use Brainapp\CoreBundle\Form\AccountForm\CreateUserAccountFormType;
use Brainapp\CoreBundle\Form\AccountForm\EditUserAccountFormType;

use Symfony\Component\HttpFoundation\Request;

/**
 * 
 * @author Chris Schneider
 *
 */
class DashboardUserAccountController extends AbstractController
{
	public function showUserAccountsAction(Request $request)
	{
		$userAccRep = $this->getUserAccountRep();
	
		$userId=$this->getUserId();
		$userAccounts=$userAccRep->getUserAccountsByOwnerId($userId);
		
		$buchungRep = $this->getBuchungRep();
		
		foreach($userAccounts as $account)
		{
			//ERMITTLE KONTOSTAND AM HEUTIGEN TAG
			$heute = date("Y-m-d");
			$account->setAccountCurrentValue($buchungRep->getSumOfBuchungValuesByAccountAndDatePairs($account, array("<=", $heute)));
			
			//ERMITTLE KONTOSTAND AM MONATSENDE
			$monatsEnde = date("Y-m-31");			
			$accValueMonatsEnde = $buchungRep->getSumOfBuchungValuesByAccountAndDatePairs($account, array("<=", $monatsEnde));
			$account->setAccountValueMonatsEnde($accValueMonatsEnde);
			
			//ERMITTLE MONATSSALDO
			$monatsAnfang = date("Y-m-01");
			$accValueMonatsAnfang = $buchungRep->getSumOfBuchungValuesByAccountAndDatePairs($account, array("<", $monatsAnfang));
			$accValueMonatsEnde   = $buchungRep->getSumOfBuchungValuesByAccountAndDatePairs($account, array("<=", $monatsEnde));
			$saldo = $accValueMonatsEnde - $accValueMonatsAnfang;
			$account->setAccountMonatsSaldo($saldo);
		}
	
		return $this->render("BrainappCoreBundle:Dashboard/UserAccountViews:showUserAccounts.html.twig",
				$this->concatWithUserDataArray(array("userAccounts" => $userAccounts, "monatsAnfang" => date("01.m.Y"), "monatsEnde" => date("31.m.Y"))));
	}
	
	public function createUserAccountAction(Request $request)
	{
		
		$userAccount = new UserAccount();
		
		$form = $this->createForm(new CreateUserAccountFormType(), $userAccount);
		
		$form->handleRequest($request);
		
		if( $form->isValid() )
		{
			$userAccRep = $this->getUserAccountRep();	
			
			$userAccount->setOwnerId($this->getUserId());
			$userAccount->setAccountCurrentValue($userAccount->getAccountStartValue());
			
			$userAccRep->storeAccount($userAccount);
			$buchungRep = $this->getBuchungRep();
			
			//INITIALE BUCHUNG
			$startWertBuchung = new BuchungEinnahme();
			$startWertBuchung->setAccount($userAccount);
			$startWertBuchung->setTitle("Initiale Buchung");
			$startWertBuchung->setComment("Diese Buchung wurde vom System erstellt.");
			$startWertBuchung->setDate(new \DateTime(date("Y-m-d")));
			$startWertBuchung->setValue($userAccount->getAccountStartValue());
			
			$buchungRep->storeBuchung($startWertBuchung);
			
			return $this->redirectToRoute('show_user_accounts');
		}
		
		return $this->render("BrainappCoreBundle:Dashboard/UserAccountViews/SpecificViews:createUserAccount.html.twig",
				             array("mask_user_account" => $form->createView()));
	}
	

	/* #####################################################################
	 *
	 * Generisch (Edit und Delete)
	 *
	 * #####################################################################
	 */
	public function editUserAccountAction(Request $request)
	{
		$logger = $this->get('logger');
	
		$error = null;
	
		$editUserAccForm = new EditUserAccountFormType();
		
		$userAcc = new UserAccount();
		
		$form = $this->createForm($editUserAccForm, $userAcc);
	
		$form->handleRequest($request);
	
		if( $form->isValid() )
		{
			try
			{
				$this->getUserAccountRep()
				     ->editAccountUpdate($userAcc);
				
				return $this->redirectToRoute('show_user_accounts');
			}
			catch(UniqueConstraintViolationException $uniq_exep_accountName)
			{
				$logger->error($uniq_exep_accountName->getMessage());
	
				$error = "Dieser Kontoname wird bereits verwendet.";
			}
		}
	
		return $this->render("BrainappCoreBundle:Dashboard/UserAccountViews:editUserAccount.html.twig",
				array("mask_user_account" => $form->createView(),
					  "error" => $error));
	}
	
	public function deleteUserAccountAction(Request $request)
	{
		$accountId = $request->request->get('#ff_accountId');
		
		 
		$this->getUserAccountRep()
		     ->deleteUserAccountByAccountId($accountId);
	
		return $this->redirectToRoute('show_user_accounts');
	}
	
	/* #####################################################################
	 *
	 * helper functions
	 *
	 * #####################################################################
	 */
	private function getUserAccountRep()
	{
		$em = $this->getDoctrine()->getManager();
		return $em->getRepository('Brainapp\CoreBundle\Entity\UserEntities\UserAccount');
	}
	
	private function getBuchungRep()
	{
		$em = $this->getDoctrine()->getManager();
		return $em->getRepository('Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung');
	}	
}