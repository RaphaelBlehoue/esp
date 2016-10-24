<?php

namespace Labs\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('LabsPagesBundle:Default:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/page_one", name="page_one")
     */
    public function PageOneBundle()
    {
        return $this->render('LabsPagesBundle:Default:page_one.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/page_two", name="page_two")
     */
    public function PageTwoBundle()
    {
        return $this->render('LabsPagesBundle:Default:page_two.html.twig');
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/page_three", name="page_three")
     */
    public function PageThreeBundle()
    {
        return $this->render('LabsPagesBundle:Default:page_three.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/page_forth", name="page_forth")
     */
    public function PageForthBundle()
    {
        return $this->render('LabsPagesBundle:Default:page_forth.html.twig');
    }
}
