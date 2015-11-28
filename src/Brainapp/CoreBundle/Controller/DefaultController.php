<?php

namespace Brainapp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Brainapp\UserBundle\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
    		$token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
    		$this->get('security.context')->setToken($token);
    		$this->get('session')->set('_security_main',serialize($token));
    		return $this->redirect($this->generateUrl('dashboard_home'));
    	}
    	
    	// LOGIN
    	$session = $request->getSession();
    	
    	if (class_exists('\Symfony\Component\Security\Core\Security')) {
    		$authErrorKey = Security::AUTHENTICATION_ERROR;
    		$lastUsernameKey = Security::LAST_USERNAME;
    	} else {
    		// BC for SF < 2.6
    		$authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
    		$lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
    	}
    	
    	// get the error if any (works with forward and redirect -- see below)
    	if ($request->attributes->has($authErrorKey)) {
    		$error = $request->attributes->get($authErrorKey);
    	} elseif (null !== $session && $session->has($authErrorKey)) {
    		$error = $session->get($authErrorKey);
    		$session->remove($authErrorKey);
    	} else {
    		$error = null;
    	}
    	
    	if (!$error instanceof AuthenticationException) {
    		$error = null; // The value does not come from the security component.
    	}
    	
    	// last username entered by the user
    	$lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);
    	
    	if ($this->has('security.csrf.token_manager')) {
    		$csrfTokenLogin = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
    	} else {
    		// BC for SF < 2.4
    		$csrfTokenLogin = $this->has('form.csrf_provider')
    		? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
    		: null;
    	}
    	
    	return array(
    			'last_username' => $lastUsername,
    			'error' => $error,
    			'csrf_token_login' => $csrfTokenLogin,
        		'form_registration' => $form->createView(),
        		'csrf_token_registration' => $csrfToken
        );
    }
}
