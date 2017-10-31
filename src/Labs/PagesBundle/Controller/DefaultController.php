<?php

namespace Labs\PagesBundle\Controller;

use Labs\BackBundle\Entity\Gallery;
use Labs\BackBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @return Response
     * @Route("/", name="intro")
     */
    /*public function IntroPageAction()
    {
        return $this->render('LabsPagesBundle:Intro:index.html.twig');
    }*/

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function HomePageBundle()
    {
        $organisateurs = $this->getAllOrganisateur();
        $intervenant = $this->getTeamContent();
        return $this->render('LabsPagesBundle:Default:index.html.twig',[
                'organisateurs' => $organisateurs,
                'intervenants'   => $intervenant
            ]
        );
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
        $intervenant = $this->getTeamContent();
        return $this->render('LabsPagesBundle:Default:participant.html.twig',[
            'intervenants' => $intervenant
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
     * @Route("/forum/{team}/speakers", name="viewspeaker")
     */
    public function renderArticleAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('LabsBackBundle:Post')->findBy(
            ['status' => 1], ['created' => 'Desc'], ['limit' => 3]
        );
        return $this->render('LabsPagesBundle:includes:footer.html.twig',[
            'articles' => $articles
        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/medias/communiques_de_presse", name="blog")
     */
    public function BlogPageBundle()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('LabsBackBundle:Post')->findBy([
            'status' => 1
        ]);
        return $this->render('LabsPagesBundle:Default:blog.html.twig',[
            'posts' => $posts
        ]);
    }

    /**
     * @param Post $post
     * @param $slug
     * @Route("/actualite/new_{id}/{slug}", name="single_blog")
     * @Route("GET")
     * @return Response
     */
    public function getSingleBlogAction(Post $post, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('LabsBackBundle:Post')->findOneBy([
            'id' => $post,
            'slug' => $slug
        ]);
        return $this->render('LabsPagesBundle:Default:blog_single.html.twig',[
            'post' => $post
        ]);
    }

    /**
     * @return Response
     * @Route("/portfolio", name="portfolio")
     */
    public function portfolioAction()
    {
        $albums = $this->getDoctrine()->getRepository('LabsBackBundle:Gallery')->getAllGalleryWithMediaActived();
        return $this->render('LabsPagesBundle:Default:portfolio.html.twig',[
            'albums' => $albums
        ]);
    }

    /**
     * @param $slug
     * @return Response
     * @Route("/portfolio/{slug}", name="single_portfolio")
     */
    public function portfolioSingleAction($slug)
    {
        $albums = $this->getDoctrine()->getRepository('LabsBackBundle:Gallery')->getOneGalleryBySlug($slug);
        return $this->render('LabsPagesBundle:Default:portfolio_single.html.twig',[
            'albums' => $albums
        ]);
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
        $docs = $this->getAllDoc();
        return $this->render('LabsPagesBundle:Default:document.html.twig',[
            'docs' => $docs
        ]);
    }

    /**
     * @param $filename
     * @return Response
     * @Route("/document/{filename}/download", name="document_download")
     */
    public function downloadreportfileAction($filename)
    {
        $doc = $this->getOneDocs($filename);
        $files = $doc->getAssertPathDoc();
        $content = file_get_contents($files);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$files);
        $response->setContent($content);
        return $response;
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
            $team = $em->getRepository('LabsBackBundle:Team')->findAllName();
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

    /**
     * @return array|\Labs\BackBundle\Entity\Document[]
     */
    private function getAllDoc()
    {
        $em = $this->getDoctrine()->getManager();
        $docs = $em->getRepository('LabsBackBundle:Document')->findAll();
        return $docs;
    }

    /**
     * @param $docName
     * @return mixed
     */
    private function getOneDocs($docName)
    {
        $em = $this->getDoctrine()->getManager();
        $docs = $em->getRepository('LabsBackBundle:Post')->findOneBy([
            'documentName' => $docName
        ]);
        return $docs;
    }

}
