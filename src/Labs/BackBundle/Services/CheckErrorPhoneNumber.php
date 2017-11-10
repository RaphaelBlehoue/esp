<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 18/02/2017
 * Time: 10:52
 */

namespace Labs\BackBundle\Services;


use Doctrine\ORM\EntityManagerInterface;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CheckErrorPhoneNumber
{

    private $session;
    private $em;
    private $numberUtil;

    public function __construct(SessionInterface $session, EntityManagerInterface $em, PhoneNumberUtil $numberUtil)
    {
        $this->session = $session;
        $this->em = $em;
        $this->numberUtil = $numberUtil;
    }

    public function checkError($data)
    {
        //$phoneNumber = $this->container->get('libphonenumber.phone_number_util');
        $isValid = $this->numberUtil->isValidNumber($data);
        $isExisted = $this->checkErrorInDataBase($data);
        if(false === $isValid)
        {
            $this->session->set('Error.code', 1);
            $this->session->set('Error.message', 'Le format du Numéro de téléphone est incorrect');
            $result = false;
            return $result;

        }elseif (false === $isExisted){

            $this->session->set('Error.code', 1);
            $this->session->set('Error.message', 'Ce Numéro de téléphone est déjà utilisé');
            $result = false;
            return $result;

        }else{
            if($this->session->has('Error.code')){
                $this->session->remove('Error.code');
                $this->session->remove('Error.message');
                unset($this->session);
            }
            $result = true;
            return $result;
        }
    }

    /**
     * @param $data
     * @return bool|void
     */
    private function checkErrorInDataBase($data)
    {
        $isExist = $this->em->getRepository('LabsAuthBundle:User')->findOneBy(
            ['phone' => $data]
        );
        if ( null === $isExist) {
            return true;
        }
        return false;
    }

}