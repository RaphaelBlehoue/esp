<?php
/**
 * Created by IntelliJ IDEA.
 * User: raphael
 * Date: 11/11/2017
 * Time: 12:06
 */

namespace Labs\BackBundle\EventListener;


use FOS\UserBundle\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RedirectUserLoggedListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($this->isUserLogged() && $event->isMasterRequest()) {
            $currentRoute = $event->getRequest()->attributes->get('_route');
            if ($this->isAuthenticatedUserOnAnonymousPage($currentRoute)) {
                $referer = $event->getRequest()->headers->get('referer');
                if (null ==! $referer && !$this->isAuthenticatedUserOnAnonymousPage($referer)) {
                    $response = new RedirectResponse($this->router->generate($referer));
                    $event->setResponse($response);
                }
                $response = new RedirectResponse($this->router->generate('homepage'));
                $event->setResponse($response);
            }
        }
    }

    private function isUserLogged(){
        $user = $this->tokenStorage->getToken()->getUser();
        return $user instanceof User;
    }

    /**
     * @param $currentRoute
     * @return bool
     */
    private function isAuthenticatedUserOnAnonymousPage($currentRoute){
        return in_array(
            $currentRoute,
            ['fos_user_security_login', 'fos_user_resetting_request', 'fos_user_registration_register']
        );
    }
}