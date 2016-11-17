<?php

namespace Labs\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function HomePageBundle()
    {
        return $this->render('LabsPagesBundle:Default:index.html.twig');
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/presentation/initiative", name="initiative")
     */
    public function InitiativePageBundle()
    {
        return $this->render('LabsPagesBundle:Default:initiative.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/presentation/organisateurs", name="organisateur")
     */
    public function OrganisateurPageBundle()
    {
        return $this->render('LabsPagesBundle:Default:Organisateur.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/presentation/partenaires", name="partners")
     */
    public function PartnerPageBundle()
    {
        return $this->render('LabsPagesBundle:Default:partners.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/forum/participants", name="participant")
     */
    public function ParticipantPageBundle()
    {
        return $this->render('LabsPagesBundle:Default:participant.html.twig');
    }
}
