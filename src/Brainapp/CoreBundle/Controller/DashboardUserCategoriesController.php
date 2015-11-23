<?php

namespace Brainapp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Brainapp\UserBundle\Entity\UserEntities\UserCategory;
use Brainapp\UserBundle\Entity\GroupEntities\GroupCategory;

/**
 * DashboardUserCategoriesController
 * 
 * @author Chris Schneider
 * @Route("/home/categories")
 */
class DashboardUserCategoriesController extends AbstractController
{
	/**
	 * Test Chris
	 *
	 * @Route("/", name="show_user_categories")
	 * @Template("BrainappCoreBundle:Dashboard:usercategories.html.twig")
	 */
    public function showMyCategories()
    {
		
    	$user = $this->getUser();
    	
    	$userId = $user->getId();
    	$username = $user->getUsername();
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	
    	$logger = $this->get('logger');
    	$logger->info('NewTestController:: Selecting userCategories of user with ID=' . $userId);
    	
    	$groupCat = new GroupCategory(1,"ErsteGruppenKat",array(23,45,4345),5);
    	$userCat = new UserCategory(1,"ErsteHauptKategorie",$userId);
    	
     	//$em->persist($userCat);
     	//$em->flush();
    	
    	$test = $em->getRepository('Brainapp\UserBundle\Entity\UserEntities\UserCategory')->getUserCategoriesByOwnerId($userId);
    	$logger->info('NewTestController:: size of result=' . sizeof($test));
    	//$test = array($groupCat,$userCat);
 
    	
    		
    		
    		if(null == $user)
    		{
    			throw new Exception("User not found.");
    		}
    		
    		return $this->concatWithUserDataArray( array("test" => $test) );
    }
}
