<?php

namespace Brainapp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Controller\ResettingController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Michael Müller <development@reu-network.de>
 * 
 * @Route("/resetting")
 */
class ResettingController extends BaseController
{
	/**
	 * Request reset user password: show form
	 * @Route("/request", name="resetting_request")
	 * @Template("BrainappUserBundle:Resetting:request.html.twig")
	 */
	public function requestAction()
	{
		return array();
	}
	
	/**
	 * Overrides FOSUser sendEmailAction
	 * @Route("/send-email", name="resetting_send_email")
	 */
	public function sendEmailAction(Request $request)
	{
	    $username = $request->request->get('username');
	    $email = $request->request->get('email');
	    
	    /** @var $user UserInterface */
	    $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);
	
	    // Kein Benutzer gefunden
	    if (null === $user) 
	    {
	        return new JsonResponse(array(
	            'error' => true,
	            'message' => "Der Benutzername oder die E-Mail-Adresse $username existiert nicht."), 200);
	    }
	    // falsche E-Mail
	    elseif($email !== $user->getEmail())
	    {
	        return new JsonResponse(array(
	            'error' => true,
	            'message' => "Der Benutzername und die E-Mail-Adresse können einander nicht zugeordnet werden."), 200);
	    }
	    // Passwortruecksetzung bereits beantragt
	    elseif ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) 
	    {
	        return new JsonResponse(array(
	            'error' => true,
	            'message' => "Für diesen Benutzer wurde in den vergangenen 24 Stunden bereits ein neues Passwort beantragt."), 200);
	    }
	    if (null === $user->getConfirmationToken()) 
	    {
	        /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
	        $tokenGenerator = $this->get('fos_user.util.token_generator');
	        $user->setConfirmationToken($tokenGenerator->generateToken());
	    }
	
	    $this->get('fos_user.mailer')->sendResettingEmailMessage($user);
	    $user->setPasswordRequestedAt(new \DateTime());
	    $this->get('fos_user.user_manager')->updateUser($user);
	    
	    $email =  $this->getObfuscatedEmail($user);
	    return new JsonResponse(array(
	        'success' => true, 
	        'message' => "Eine E-Mail wurde an $email gesendet. Sie enthält einen Link, den Sie anklicken müssen, um Ihr Passwort zurückzusetzen."), 200);
	}
}
