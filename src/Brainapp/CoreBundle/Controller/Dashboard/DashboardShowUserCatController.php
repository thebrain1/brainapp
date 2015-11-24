<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\UserBundle\Entity\UserEntities\UserCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * DashboardShowUserCatController
 * 
 * @author Chris Schneider
 * 
 * @Route("/home/usercategories")
 */
class DashboardShowUserCatController extends AbstractController
{
	/**
	 * Test Chris
	 *
	 * @Route("/", name="show_user_categories")
	 * @Template("BrainappCoreBundle:Dashboard:usercategories.html.twig")
	 */
    public function showMyCategories()
    {
		$em = $this->getDoctrine()->getManager();
    	
		$userId=$this->getUserId();
    	
    	$logger = $this->get('logger');
    	$logger->info('DashboardUserCategoriesController:: Selecting userCategories of user with ID=' . $userId);
    	
    	$userCatRep = $em->getRepository('Brainapp\UserBundle\Entity\UserEntities\UserCategory');
		
    	$userCategories=$userCatRep->getUserCategoriesByOwnerId($userId);
    	$logger->info('NewTestController:: size of result=' . sizeof($userCategories));
    		
    	return $this->concatWithUserDataArray( array("userCategories" => $userCategories) );
    }
}
