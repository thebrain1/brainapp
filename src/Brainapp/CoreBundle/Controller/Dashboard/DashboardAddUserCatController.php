<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\UserBundle\Entity\UserEntities\UserCategory;
use Brainapp\CoreBundle\Form\UserCategoryForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * 
 * @author Chris Schneider
 *
 */
class DashboardAddUserCatController extends AbstractController
{	
	public function addUserMainCategoryAction(Request $request)
    {
		
    	$logger = $this->get('logger');
    	$error = null;
      	$userCat = new UserCategory();

      	$form = $this->createForm(new UserCategoryForm(), $userCat);
    	
		$form->handleRequest($request);
		
		$this->requestLogging($form, $request, $logger, $userCat);
		
		if( $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$userCatRep = $em->getRepository('Brainapp\UserBundle\Entity\UserEntities\UserCategory');
			 
			try
			{
				$userCat->setOwnerId($this->getUserId());
				$query = $userCatRep->storeCategoryIfNotExists($userCat);
				return $this->redirectToRoute('show_user_categories');
			}
			catch(UniqueConstraintViolationException $uniq_exep_categoryName)
			{
				$logger->error($uniq_exep_categoryName->getMessage());
				
				$error = "Dieser Kategorie-Name wird bereits verwendet.";
			}
		}
		
		return $this->render("BrainappCoreBundle:Dashboard:addUserMainCategory.html.twig",
				             array("c_mask_user_cat" => $form->createView(),
			                       "error" => $error));
    }
    
    public function editUserMainCategoryAction(Request $request)
    {
    
    	$logger = $this->get('logger');
    	$error = null;
    	$userCat = new UserCategory();
    
    	$form = $this->createForm(new UserCategoryForm(), $userCat);
    	 
    	$form->handleRequest($request);
    
    	$this->requestLogging($form, $request, $logger, $userCat);
    
    	if( $form->isValid() )
    	{
    		$em = $this->getDoctrine()->getManager();
    		$userCatRep = $em->getRepository('Brainapp\UserBundle\Entity\UserEntities\UserCategory');
    
    		try
    		{
    			$userCat->setOwnerId($this->getUserId());
    			$query = $userCatRep->storeCategoryIfNotExists($userCat);
    			return $this->redirectToRoute('show_user_categories');
    		}
    		catch(UniqueConstraintViolationException $uniq_exep_categoryName)
    		{
    			$logger->error($uniq_exep_categoryName->getMessage());
    
    			$error = "Dieser Kategorie-Name wird bereits verwendet.";
    		}
    	}
    
    	return $this->render("BrainappCoreBundle:Dashboard/Widgets:form_create_mainCategory.html.twig",
    			array("c_mask_user_cat" => $form->createView(),
    					"error" => $error));
    }
    
    private function requestLogging($form, $request, $logger, $userCat)
    {
    	date_default_timezone_set("UTC");
    	
    	
    	if($request->getMethod() == "POST")
    	{
    		$logger->info("REQUEST_TYPE: Request is POST.");
    		$logger->info("REQUEST_QUERY: " . $_SERVER['QUERY_STRING']);
    	}
    	else
    	{
    		$logger->info("REQUEST_TYPE: Request is not POST.");
    	}
    	
    	
    	
    	
    	if($request->getMethod() == "GET")
    	{
    		$logger->info("REQUEST_TYPE: Request is GET.");
    		$logger->info("REQUEST_QUERY: " . $_SERVER['QUERY_STRING']);
    	}
    	else
    	{
    		$logger->info("REQUEST_TYPE: is not GET.");
    	}
    		
    	
    	
    	
    	if($form->isSubmitted())
    	{
    		$logger->info("FORM_SUBMITTED: is submitted.");
    	}
    	else
    	{
    		$logger->info("FORM_SUBMITTED: is not submitted.");
    	}
    	
    	
    	
    	if($form->isValid())
    	{
    		$logger->info("DATA_VALID: is valid.");
    	}
    	else
    	{
    		$logger->info("DATA_VALID: is not valid.");
    	}
    	
    	$logger->info("CAT_NAME: " . $userCat->getCategoryName());
    }
}
