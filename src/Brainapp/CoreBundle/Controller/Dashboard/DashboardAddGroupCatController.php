<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\UserBundle\Entity\GroupEntities\GroupCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * DashboardAddGroupCatController
 * 
 * @author Chris Schneider
 */
class DashboardAddGroupCatController extends AbstractController
{
	/**
	 * Test Chris
	 * 
	 * @Template("BrainappCoreBundle:Dashboard:usercategories.html.twig")
	 */
	public function addGroupMainCategoryAction()
	{
		//<Test>
		 
		//public function __construct($categoryName=null, $ownerId=null, $parentCategoryId=null)
		$groupCat = new GroupCategory("GruppenKat1",1);
		$em = $this->getDoctrine()->getManager();
		$groupCatRep = $em->getRepository('Brainapp\UserBundle\Entity\GroupEntities\GroupCategory');
		
		$groupCatRep->storeCategoryIfNotExists($groupCat);
		
		//</Test>

		return $this->concatWithUserDataArray( array("userCategories" => null));
	}
}