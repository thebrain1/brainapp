<?php

namespace Brainapp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends BaseController
{
	/**
	 * Setzt neues Template für Registrierung
	 *
	 * @Route("/register", name="register")
	 * @Template()
	 */
	public function registerAction(Request $request)
	{
		parent::registerAction($request);
	}
}
