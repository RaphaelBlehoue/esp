<?php

namespace Labs\BackBundle\Controller;

use Labs\BackBundle\Entity\Parts;
use Labs\BackBundle\Form\PartsEditType;
use Labs\BackBundle\Form\PartsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Parts controller.
 *
 * @Route("/parts")
 */
class PartsController extends Controller
{
    /**
     * @Route("/", name="part_list")
     */
    public function  getListItemAction()
    {
        $em = $this->getDoctrine()->getManager();
        $parts = $em->getRepository('LabsBackBundle:Parts')->findAll();
        return $this->render('LabsBackBundle:Parts:list_part.html.twig', array(
            'parts' => $parts
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     * @Route("/create", name="part_create")
     * @Method({"GET", "POST"})
     */
    public function CreateItemsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $parts = new Parts();
        $form = $this->createForm(PartsType::class, $parts);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->persist($parts);
            $em->flush();
            return $this->redirectToRoute('part_list');
        }
        return $this->render('LabsBackBundle:Parts:create_part.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Parts $part
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     * @Route("/edit/{id}", name="part_edit")
     * @Method({"GET", "POST"})
     */
    public function editItemAction(Parts $part, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // On recupere l'id du item
        $parts = $em->getRepository('LabsBackBundle:Parts')->findOne($part);
        if(null === $parts){
            throw new NotFoundHttpException("L'element d'id ".$parts." n'existe pas");
        }
        $form = $this->createForm(PartsEditType::class, $parts);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('part_list');
        }
        return $this->render('LabsBackBundle:Parts:edit_part.html.twig',array(
            'form' => $form->createView(),
            'id'   => $parts->getId()
        ));
    }

    /**
     * @param Parts $part
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws NotFoundHttpException
     * @Route("/delete/{id}", name="part_delete")
     * @Method("GET")
     */
    public function deleteItemAction(Parts $part)
    {
        $em = $this->getDoctrine()->getManager();
        $parts = $em->getRepository('LabsBackBundle:Parts')->find($part);
        if( null === $parts)
            throw new NotFoundHttpException('equipe '.$parts.' n\'existe pas');
        else
            $em->remove($parts);
        $em->flush();
        return $this->redirectToRoute('part_list');
    }

}
