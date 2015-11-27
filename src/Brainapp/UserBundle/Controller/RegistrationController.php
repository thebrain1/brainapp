<?php

namespace Brainapp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Brainapp\UserBundle\Form\RegistrationFormType;

class RegistrationController extends BaseController
{
	/**
	 * Setzt neues Template für Registrierung
	 *
	 * @Route("/register", name="registration_register")
	 * @Template("BrainappUserBundle:Registration:register_form.html.twig")
	 */
	public function registerAction(Request $request)
	{
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
		
		return array('form' => $form->createView());
		
		
// 		parent::registerAction($request);
		/** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->get('fos_user.registration.form.factory');
		/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
		$userManager = $this->get('fos_user.user_manager');
		/** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
		$dispatcher = $this->get('event_dispatcher');
		
		$user = $userManager->createUser();
		$user->setEnabled(true);
		$event = new GetResponseUserEvent($user, $request);
		$dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);
		
		if (null !== $event->getResponse()) {
			return $event->getResponse();
		}
		
		$form = $formFactory->createForm();
		$form->setData($user);
		
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$event = new FormEvent($form, $request);
			$dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
		
			$userManager->updateUser($user);
		
			if (null === $response = $event->getResponse()) {
				$url = $this->generateUrl('fos_user_registration_confirmed');
				$response = new RedirectResponse($url);
			}
		
			$dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
		
			return $response;
		}
		
		return array(
				'form' => $form->createView(),
		);
	}
}
