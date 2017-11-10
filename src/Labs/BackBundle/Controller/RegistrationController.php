<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 21/03/2017
 * Time: 22:02
 */

namespace Labs\BackBundle\Controller;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        /** @var  $formFactory  FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');

        /** @var  $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        /** @var  $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if( null !== $event->getResponse()){
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            dump($form->getData()); die;

            if ($form->isValid()) {
                // Saving when have no error

                $user->setRoles(['ROLE_MEMBER']);
                $userManager->updateUser($user);
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
                if (null !== $response = $event->getResponse()) {
                    return $response;
                }
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('LabsBackBundle:Registration:register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}