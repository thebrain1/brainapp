<?php

namespace Brainapp\UserBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginListener 
{
	private $securityContext;
	private $router;
	private $dispatcher;
	private $pathname;
	
	public function __construct(SecurityContext $securityContext, Router $router, EventDispatcherInterface $dispatcher, $redirectPathname) 
	{
		$this->securityContext = $securityContext;
		$this->router = $router;
		$this->dispatcher = $dispatcher;
		$this->pathname = $redirectPathname;
	}
	
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) 
	{
		if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) 
		{
			$user = $event->getAuthenticationToken()->getUser();
	
			if ($user->getLastLogin() === null) 
			{
				$this->dispatcher->addListener(
						KernelEvents::RESPONSE, array ($this,'onKernelResponse')
				);
			}
		}
	}
	
	public function onKernelResponse(FilterResponseEvent $event) 
	{
		$response = new RedirectResponse($this->router->generate($this->pathname));
		$event->setResponse($response);
	}
}