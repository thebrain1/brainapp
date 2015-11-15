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
        return array();
    }
}
