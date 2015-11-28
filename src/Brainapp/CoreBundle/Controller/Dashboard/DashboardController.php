<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * DashboardController
 * 
 * @author Michael Müller <development@reu-network.de>
 * @Route("/home")
 */
class DashboardController extends AbstractController
{
	/**
	 * Läd Dashboard
	 *
	 * @Route("/", name="dashboard_home")
	 * @Template("BrainappCoreBundle:Dashboard:overview.html.twig")
	 */
    public function overviewAction()
    {
        $user = $this->getUser();
        if($user->getLastLogin() === null)
            return $this->redirect($this->generateUrl('dashboard_first_login'));
        
    	return $this->concatWithUserDataArray();
    }
    
	/**
	 * Erster Login nach Registrierung
	 *
	 * @Route("/first-login", name="dashboard_first_login")
	 * @Template("BrainappCoreBundle:Dashboard:firstLoginPage.html.twig")
	 */
    public function firstLoginAction()
    {
    	return $this->concatWithUserDataArray();
    }
}
