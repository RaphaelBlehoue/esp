<?php

namespace Labs\BackBundle\Controller;

use Labs\BackBundle\Entity\Programs;
use Labs\BackBundle\Form\ProgramsEditType;
use Labs\BackBundle\Form\ProgramsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Programmes controller.
 *
 * @Route("/programs")
 */
class ProgramsController extends Controller
{
    /**
     * @Route("/", name="programs_list")
     */
    public function  getListProgrammsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $programs = $em->getRepository('LabsBackBundle:Programs')->findAll();
        return $this->render('LabsBackBundle:Programs:list_program.html.twig', array(
            'programs' => $programs
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     * @Route("/create", name="programs_create")
     * @Method({"GET", "POST"})
     */
    public function CreateProgramAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $programs = new Programs();
        $form = $this->createForm(ProgramsType::class, $programs);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->persist($programs);
            $em->flush();
            return $this->redirectToRoute('programs_list');
        }
        return $this->render('LabsBackBundle:Programs:create_program.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Programs $programs
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     * @Route("/edit/{id}", name="programs_edit")
     * @Method({"GET", "POST"})
     */
    public function editProgramsAction(Programs $programs, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // On recupere l'id du market
        $program = $em->getRepository('LabsBackBundle:Programs')->findOne($programs);
        if(null === $program){
            throw new NotFoundHttpException("L'element d'id ".$program." n'existe pas");
        }
        $form = $this->createForm(ProgramsEditType::class, $program);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('programs_list');
        }
        return $this->render('LabsBackBundle:Programs:edit_program.html.twig',array(
            'form' => $form->createView(),
            'id'   => $program->getId()
        ));
    }

    /**
     * @param Programs $programs
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws NotFoundHttpException
     * @Route("/delete/{id}", name="programs_delete")
     * @Method("GET")
     */
    public function deleteProgramsAction(Programs $programs)
    {
        $em = $this->getDoctrine()->getManager();
        $program = $em->getRepository('LabsBackBundle:Team')->find($programs);
        if( null === $program)
            throw new NotFoundHttpException('equipe '.$program.' n\'existe pas');
        else
            $em->remove($program);
        $em->flush();
        return $this->redirectToRoute('programs_list');
    }

}
