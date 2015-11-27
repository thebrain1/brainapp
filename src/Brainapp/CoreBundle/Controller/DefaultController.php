<?php

namespace Brainapp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Brainapp\UserBundle\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction(Request $request)
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
    	
    	// Register form
    	/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
    	$userManager = $this->get('fos_user.user_manager');
    	
    	$user = $userManager->createUser();
    	$user->setEnabled(true);
    	
    	$form = $this->createForm(new RegistrationFormType(), $user);
    	$form->handleRequest($request);
    	
    	if($form->isValid())
    	{
    		$userManager->updateUser($user);
    	}
    	
        return array(
        		'form_registration' => $form->createView(),
        		'csrf_token' => $csrfToken
        );
    }
}
