<?php
/**
 * Created by IntelliJ IDEA.
 * User: raphael
 * Date: 11/11/2017
 * Time: 12:06
 */

namespace Labs\BackBundle\EventListener;


use FOS\UserBundle\Model\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router, ContainerInterface $container)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($this->isUserLogged() && $event->isMasterRequest()) {
            $currentRoute = $event->getRequest()->attributes->get('_route');
            if ($this->isAuthenticatedUserOnAnonymousPage($currentRoute)) {
                $response = new RedirectResponse($this->router->generate('homepage'));
                $event->setResponse($response);
            }
        }
    }

    private function isUserLogged(){
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The security is not registered in your controller');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
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