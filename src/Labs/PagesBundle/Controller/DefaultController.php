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
        $limit = 7;
        $speakers = $this->getTeamContent($limit);
        return $this->render('LabsPagesBundle:Default:index.html.twig',[
            'speakers' => $speakers
        ]);
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
        $speakers = $this->getTeamContent();
        return $this->render('LabsPagesBundle:Default:participant.html.twig',[
            'speakers' => $speakers
        ]);
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
     * @Route("/forum/programmes", name="programme")
     */
    public function ProgrammeTypePageBundle()
    {
        $programs = $this->getProgramsContent();
        return $this->render('LabsPagesBundle:Default:programme.html.twig',[
            'programs' => $programs
        ]);
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

    /**
     * @return array|\Labs\BackBundle\Entity\Team[]
     * Retourne un tabeau de tout les SPEAKERS enregistrez dans la base de donnée
     */
    private function getTeamContent($num = null)
    {
        if (!empty($num)){
            $em = $this->getDoctrine()->getManager();
            $team = $em->getRepository('LabsBackBundle:Team')->findLimit(7);
        }else{
            $em = $this->getDoctrine()->getManager();
            $team = $em->getRepository('LabsBackBundle:Team')->findAll();
        }
        return $team;
    }

    /**
     * @return array|\Labs\BackBundle\Entity\Programs[]
     */
    private function getProgramsContent()
    {
        $em = $this->getDoctrine()->getManager();
        $program = $em->getRepository('LabsBackBundle:Programs')->findAll();
        return $program;
    }

}
