<?php
namespace Brainapp\UserBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    protected $router;
    protected $security;
    protected $userManager;
    protected $service_container;

    public function __construct(RouterInterface $router, SecurityContext $security, $userManager, $service_container)
    {
        $this->router = $router;
        $this->security = $security;
        $this->userManager = $userManager;
        $this->service_container = $service_container;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($request->isXmlHttpRequest())
        {
            $result = array(
                'success' => true
            );
            return new JsonResponse($result, 200);
            ;
        }
        else
        {
            // Create a flash message with the authentication error message
            $request->getSession()
                ->getFlashBag()
                ->set('error', $exception->getMessage());
            $url = $this->router->generate('fos_user_security_login');
            
            return new RedirectResponse($url);
        }
        return new RedirectResponse($this->router->generate('brainapp_core_homepage'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $result = array(
            'success' => false,
            'function' => 'onAuthenticationFailure',
            'error' => true,
            'message' => $exception->getMessage()
        );
        
        return new JsonResponse($result);
    }
}