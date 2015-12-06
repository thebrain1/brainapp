<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\UserBundle\Entity\UserEntities\UserCategory;

use Brainapp\CoreBundle\Form\UserCategoryForm\EditUserCategoryForm;
use Brainapp\CoreBundle\Form\UserCategoryForm\CreateUserMainCategoryForm;
use Brainapp\CoreBundle\Form\UserCategoryForm\CreateUserSubCategoryForm;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * 
 * @author Chris Schneider
 *
 */
class DashboardUserCatController extends AbstractController
{	
	
	/* #####################################################################
	 * 
	 * MainCategory
	 * 
	 * #####################################################################
	 */
	public function showUserMainCategoriesAction(Request $request)
	{
		$userCatRep = $this->getUserCategoryRep();
		
		$userId=$this->getUserId();
		$userCategories=$userCatRep->getUserMainCategoriesByOwnerId($userId);
		
		return $this->render("BrainappCoreBundle:Dashboard/UserCategoryViews:showUserMainCategories.html.twig",
				             $this->concatWithUserDataArray(array("userCategories" => $userCategories)));
	}
	
	public function createUserMainCategoryAction(Request $request)
    {
		
    	$logger = $this->get('logger');
    	$error = null;
      	$userMainCat = new UserCategory();

      	$form = $this->createForm(new CreateUserMainCategoryForm(), $userMainCat);
    	
		$form->handleRequest($request);
		
		if( $form->isValid() )
		{
			$userCatRep = $this->getUserCategoryRep();
			 
			try
			{
				$userMainCat->setOwnerId($this->getUserId());
				$userCatRep->storeCategory($userMainCat);
				return $this->redirectToRoute('show_user_main_categories');
			}
			catch(UniqueConstraintViolationException $uniq_exep_categoryName)
			{
				$logger->error($uniq_exep_categoryName->getMessage());
				
				$error = "Dieser Kategorie-Name wird bereits verwendet.";
			}
		}
		
		return $this->render("BrainappCoreBundle:Dashboard/UserCategoryViews/SpecificViews:createUserMainCategory.html.twig",
				             array("mask_user_cat" => $form->createView(),
			                       "error" => $error));
    }  
    
    /* #####################################################################
     *
     * SubCategorie
     *
     * #####################################################################
     */
    public function showUserSubCategoriesAction(Request $request)
    {
    	$userCatRep = $this->getUserCategoryRep();
    
    	$parentCatId = $request->get('parentCatId');
    	
    	$parentCategory = $userCatRep->getUserCategoryByCategoryId($parentCatId);
    	$userSubCategories = $userCatRep->getUserSubCategoriesByParentCategoryId($parentCatId);
    
    	return $this->render("BrainappCoreBundle:Dashboard/UserCategoryViews:showUserSubCategories.html.twig",
    			$this->concatWithUserDataArray(array("userSubCategories" => $userSubCategories,
    					                             "parentCategory" => $parentCategory))
    			                              );
    }
    
    public function createUserSubCategoryAction(Request $request)
    {
    	$logger = $this->get('logger');
    	
    	$originUrl = $request->headers->get('referer');
    	
    	$error = null;
    	
    	$userCatRep = $this->getUserCategoryRep();
    	$createUserSubCatForm = new CreateUserSubCategoryForm();
    	$userSubCat = new UserCategory();
		
    	$form = $this->createForm($createUserSubCatForm, $userSubCat);
    	$form->handleRequest($request);
    	
    	if( $form->isValid() )
    	{    		
    		$categoryName = $request->request->get($createUserSubCatForm->getName() .  '[categoryName]', null, true);
    		$parentCategoryId = $request->request->get($createUserSubCatForm->getName() . '[parentCategoryId]', null, true);
    		
    		$parentCategory = $userCatRep->getUserCategoryByCategoryId($parentCategoryId);
    		
    		$userSubCat->setCategoryName($categoryName);
    		$userSubCat->setParentCategory($parentCategory);
    		$userSubCat->setOwnerId($this->getUserId());
    		
    		try
    		{
				$userCatRep->storeCategory($userSubCat);
				return $this->redirect($originUrl);
    		}
    		catch(UniqueConstraintViolationException $uniq_exep_categoryName)
    		{
    			$logger->error($uniq_exep_categoryName->getMessage());
    			 
    			$error = "Dieser Kategorie-Name wird bereits verwendet.";
    		}
    	}
    	
    	return $this->render("BrainappCoreBundle:Dashboard/UserCategoryViews/SpecificViews:createUserSubCategory.html.twig",
    			array("mask_user_cat" => $form->createView(),
    				  "error" => $error));
    }

    /* #####################################################################
     *
     * Generische Funktionen, die für MainCategories und Subcategories
     * funktionieren
     *
     * #####################################################################
     */
    public function editUserCategoryAction(Request $request)
    {
    	$logger = $this->get('logger');
    
    	$originUrl = $request->headers->get('referer');
    
    	$error = null;
    	 
    	$editUserCatForm = new EditUserCategoryForm();
    	 
    	$categoryId = $request->request->get($editUserCatForm->getName() . '[categoryId]', null, true);
    	$categoryName = $request->request->get($editUserCatForm->getName() .  '[categoryName]', null, true);
    	 
    	$userCat = new UserCategory();
    	$userCat->setCategoryId($categoryId);
    	$userCat->setCategoryName($categoryName);
    
    	$form = $this->createForm($editUserCatForm, $userCat);
    
    	$form->handleRequest($request);
    
    	if( $form->isValid() )
    	{
    		$userCatRep = $this->getUserCategoryRep();
    
    		try
    		{
    			$userCatRep->updateCategory($userCat);
    			return $this->redirect($originUrl);
    		}
    		catch(UniqueConstraintViolationException $uniq_exep_categoryName)
    		{
    			$logger->error($uniq_exep_categoryName->getMessage());
    			 
    			$error = "Dieser Kategorie-Name wird bereits verwendet.";
    		}
    	}
    	 
    	return $this->render("BrainappCoreBundle:Dashboard/UserCategoryViews:editUserCategory.html.twig",
    			array("mask_user_cat" => $form->createView(),
    					"error" => $error));
    }
    
    public function deleteUserMainCategoryAction(Request $request)
    {
    	$categoryId = $request->request->get('#ff_categoryId');
    	
    	$originUrl = $request->headers->get('referer');
    	
    	$this->getUserCategoryRep()
    	     ->deleteUserCategoryById($categoryId);
    
    	return $this->redirect($originUrl);
    }
    
    /* #####################################################################
     *
     * helper functions
     *
     * #####################################################################
     */
    private function getUserCategoryRep()
    {
    	$em = $this->getDoctrine()->getManager();
    	return $em->getRepository('Brainapp\UserBundle\Entity\UserEntities\UserCategory');
    }
}
