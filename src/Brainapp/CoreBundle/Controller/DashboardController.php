<?php

namespace Brainapp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Brainapp\UserBundle\Entity\User;
use Brainapp\UserBundle\Entity\Group;

/**
 * DashboardController
 * 
 * @author Michael Müller <development@reu-network.de>
 * @Route("/home")
 */
class DashboardController extends Controller
{
	/**
	 * Läd Dashboard
	 *
	 * @Route("/", name="dashboard_home")
	 * @Template("BrainappCoreBundle:Dashboard:overview.html.twig")
	 */
    public function overviewAction()
    {
		$em = $this->getDoctrine()->getManager();
		
        return array(
        );
    }
}
