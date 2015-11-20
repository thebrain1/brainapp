<?php

namespace Brainapp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Brainapp\UserBundle\Entity\UserEntities\UserCategory;
use Brainapp\UserBundle\Entity\GroupEntities\GroupCategory;

/**
 * NewTestController
 * 
 * @author Chris Schneider
 * @Route("/test")
 */
class NewTestController extends Controller
{
	/**
	 * Test Chris
	 *
	 * @Route("/", name="test_home")
	 * @Template("BrainappCoreBundle:Test:test.html.twig")
	 */
    public function overviewAction()
    {

    	$groupCat = new GroupCategory(1,"ErsteGruppenKat",2);
    	
    	$userCat = new UserCategory(1,"ErsteHauptKategorie",3);
    	
//     		$user = $this->getUser();
    		
//     		if(null == $user)
//     		{
//     			throw new Exception("User not found.");
//     		}
    		
// //      	$em = $this->getDoctrine()->getManager();
// //      	$user = $em->getRepository('BrainappUserBundle:User')->getUserByUsername('schneiderc');
     	
     	return array(
     			'groupCat' => $groupCat,
     			'userCat' => $userCat
     	);
    }
}
