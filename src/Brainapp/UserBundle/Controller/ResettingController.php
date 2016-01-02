<?php

namespace Brainapp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Controller\ResettingController as BaseController;

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
}
