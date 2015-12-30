<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlage;
use Symfony\Component\HttpFoundation\Request;
use Brainapp\CoreBundle\Form\UserBudgetForm\CreateUserBudgetFormType;
use Brainapp\CoreBundle\Form\UserBudgetForm\EditUserBudgetFormType;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * 
 * @author Chris Schneider
 *
 */
class DashboardUserBudgetVorlageController extends AbstractController
{
	public function showUserBudgetVorlagenAction(Request $request)
	{
		$userBudVorlageRep = $this->getUserBudgetVorlageRep();
		
		$userId=$this->getUserId();
		$userBudgetVorlagen=$userBudVorlageRep->getUserBudgetVorlagenByOwnerId($userId);
		
		return $this->render("BrainappCoreBundle:Dashboard/UserBudgetViews:showUserBudetVorlagen.html.twig",
	                         $this->concatWithUserDataArray(array("userBudgetVorlagen" => $userBudgetVorlagen)));
	}
	
	public function createUserBudgetVorlageAction(Request $request)
	{
		$userBudgetVorlage = new UserBudgetVorlage();
		
		$form = $this->createForm(new CreateUserBudgetFormType(), $userBudgetVorlage, array( "attr" => array("ownerId" => $this->getUserId() ) ) );
		
		$form->handleRequest($request);
		
		if( $form->isValid() )
		{
			$userBudVorlageRep = $this->getUserBudgetVorlageRep();
			$userBudVorlageRep->storeBudgetVorlage($userBudgetVorlage);
			
			return $this->redirectToRoute('show_user_budget_vorlagen');
 		}
		
		return $this->render("BrainappCoreBundle:Dashboard/UserBudgetViews:createUserBudgetVorlage.html.twig",
				             array("mask_user_budget_vorlage" => $form->createView()));
	}
	
	public function editUserBudgetVorlageAction(Request $request)
	{
		$editUserBudgetForm = new EditUserBudgetFormType();
				
		$userBudgetVorlage = new UserBudgetVorlage();
		
		$form = $this->createForm($editUserBudgetForm, $userBudgetVorlage, array( "attr" => array("ownerId" => $this->getUserId() ) ) );
		
		$form->handleRequest($request);
		
		if( $form->isValid() )
		{
			$this->getUserBudgetVorlageRep()
			     ->updateUserBudgetVorlage($userBudgetVorlage);
				
			return $this->redirectToRoute('show_user_budget_vorlagen');
		}
		
		return $this->render("BrainappCoreBundle:Dashboard/UserBudgetViews:editUserBudgetVorlage.html.twig",
		                     array("mask_user_budget_vorlage" => $form->createView()));
	}
	
	public function getUserBudgetDataAsJsonAction(Request $request)
	{
		$budgetVorlageId = $request->get('budgetVorlageId');
		$userBudVorlageRep = $this->getUserBudgetVorlageRep();
		
		$instance = $userBudVorlageRep->getUserBudgetVorlageById($budgetVorlageId);
		
		if(is_null($instance))
		{
			throw new HttpException(400,"Die Budget-Vorlage mit der ID=" . $budgetVorlageId . " existiert nicht!");
		}
		
		$data = array('budgetName' => $instance->getBudgetName(),
                      'resetPeriod' => $instance->getResetPeriod(),
	                  'resetTriggerDate' => $instance->getResetTriggerDate(),
		              'category' => $instance->getCategory()->getCategoryId(),
		              'account' => $instance->getAccount()->getAccountId(),
		              'budgetComment' => $instance->getBudgetComment(),
		              'budgetValue' => $instance->getBudgetValue(),
		);
		
		$instanceAsJson = json_encode($data);
		
		return new Response($instanceAsJson);
	}
	
	public function deleteUserBudgetVorlageAction(Request $request)
	{
		$id = $request->request->get('#ff_budgetVorlageId');
		
		$this->getUserBudgetVorlageRep()
		     ->deleteUserBudgetVorlageById($id);
		
		return $this->redirectToRoute('show_user_budget_vorlagen');
	}
	
	/* #####################################################################
	 *
	 * helper functions
	 *
	 * #####################################################################
	 */
	private function getUserBudgetVorlageRep()
	{
		$em = $this->getDoctrine()->getManager();
		return $em->getRepository('Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlage');
	}
}