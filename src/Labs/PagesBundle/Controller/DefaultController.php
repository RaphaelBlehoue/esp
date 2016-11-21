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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/forum/engagements", name="engagement")
     */
    public function EngagementPageBundle()
    {
        return $this->render('LabsPagesBundle:Default:engagement.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/forum/les_donnees_de_la_croissance", name="croissance")
     */
    public function CroissancePageBundle()
    {
        return $this->render('LabsPagesBundle:Default:croissance.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/medias/communiques_de_presse", name="blog")
     */
    public function BlogPageBundle()
    {
        return $this->render('LabsPagesBundle:Default:blog.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contactez_nous", name="contact")
     */
    public function ContactPageBundle()
    {
        return $this->render('LabsPagesBundle:Default:contact.html.twig');
    }

}
