<?php

namespace Brainapp\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    /**
     * Setzt neuer Template für Login
     * 
     * @Route("/login", name="login")
     * @Template()
     */
	public function loginAction(Request $request)
	{
		return parent::loginAction($request);
	}
}
