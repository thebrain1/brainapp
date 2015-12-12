<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\CoreBundle\Entity\UserEntities\UserAccount;

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
	
		return $this->render("BrainappCoreBundle:Dashboard/UserAccountViews:showUserAccounts.html.twig",
				$this->concatWithUserDataArray(array("userAccounts" => $userAccounts)));
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
	
		$originUrl = $request->headers->get('referer');
	
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
				
				return $this->redirect($originUrl);
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
		 
		$originUrl = $request->headers->get('referer');
		 
		$this->getUserAccountRep()
		     ->deleteUserAccountByAccountId($accountId);
	
		return $this->redirect($originUrl);
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
}