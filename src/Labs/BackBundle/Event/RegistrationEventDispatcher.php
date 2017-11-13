<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 21/03/2017
 * Time: 19:35
 */

namespace Labs\BackBundle\Event;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationEventDispatcher implements EventSubscriberInterface
{

    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => ['onRegisterSuccess']
        ];
    }

    public function onRegisterSuccess(FormEvent $event)
    {
        $url = $this->router->generate('member_index');
        $event->setResponse(new RedirectResponse($url));
    }

}