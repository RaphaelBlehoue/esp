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
        $office = $this->getTeamContent();
        return $this->render('LabsPagesBundle:Default:index.html.twig',[
            'speakers' => $speakers,
            'office' => $office
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
        $organisateurs = $this->getAllOrganisateur();
        return $this->render('LabsPagesBundle:Default:Organisateur.html.twig',[
            'organisateurs' => $organisateurs
        ]);
    }

    /**
     * @param $org
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/presentation/{org}/organisateur", name="view_organisateur")
     */
    public function ViewOrganisateurPageBundle($org)
    {
        $orga = $this->getOneOrga($org);
        return $this->render('LabsPagesBundle:Default:view_orgl.html.twig',[
            'orga' => $orga
        ]);
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
     * @Route("/forum/officiels", name="officiel")
     */
    public function OfficielPageBundle()
    {
        $office = $this->getTeamContent();
        return $this->render('LabsPagesBundle:Default:officiel.html.twig',[
            'office' => $office
        ]);
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
     * @param $team
     * @return \Symfony\Component\HttpFoundation\Response
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/forum/{team}/officiel", name="viewofficiel")
     */
    public function OfficielViewAction($team)
    {
        $office = $this->getOneTeam($team);
        return $this->render('LabsPagesBundle:Default:view_officiel.html.twig',[
            'office' => $office
        ]);
    }


    /**
     * @param $team
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/forum/{team}/speakers", name="viewspeaker")
     */
    public function SpeakerViewAction($team)
    {
        $speaker = $this->getOneTeam($team);
        return $this->render('LabsPagesBundle:Default:view_speakers.html.twig',[
            'speaker' => $speaker
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
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/document", name="document")
     */
    public function DocumentPageBundle()
    {
        return $this->render('LabsPagesBundle:Default:document.html.twig');
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

    /**
     * @param $team
     * @return mixed
     */
    private function getOneTeam($team)
    {
        $em = $this->getDoctrine()->getManager();
        $program = $em->getRepository('LabsBackBundle:Team')->findOne($team);
        return $program; 
    }

    /**
     * @return array|\Labs\BackBundle\Entity\Partner[]
     */
    private function getAllOrganisateur()
    {
        $em = $this->getDoctrine()->getManager();
        $program = $em->getRepository('LabsBackBundle:Partner')->findAll();
        return $program;
    }

    /**
     * @param $org
     * @return mixed
     */
    private function getOneOrga($org)
    {
        $em = $this->getDoctrine()->getManager();
        $program = $em->getRepository('LabsBackBundle:Partner')->findOne($org);
        return $program;
    }

}
