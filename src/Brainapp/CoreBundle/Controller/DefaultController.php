<?php

namespace Brainapp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * DefaultController
 * 
 * @author Michael Müller <development@reu-network.de>
 * @Route("/")
 */
class DefaultController extends Controller
{
	/**
	 * Läd Index
	 *
	 * @Route("/", name="brainapp_index")
	 * @Template("BrainappCoreBundle:Default:index.html.twig")
	 */
    public function indexAction()
    {
    	// Weiterleitung auf Dashboard, wenn Benutzer bereits angemeldet
    	$securityContext = $this->container->get('security.authorization_checker');
    	if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY'))
    		return $this->redirect($this->generateUrl('dashboard_home'));
    	
    	// sonst: erstelle Login
    	if ($this->has('security.csrf.token_manager')) 
    	{
    		$csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
    	} 
    	else 
    	{
    		// BC for SF < 2.4
    		$csrfToken = $this->has('form.csrf_provider') ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
    		: null;
    	}
    	
        return array(
        		'csrf_token' => $csrfToken
        );
    }
}
