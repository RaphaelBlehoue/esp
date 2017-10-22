<?php

namespace Labs\BackBundle\Controller;

use Labs\BackBundle\Form\DocumentEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Labs\BackBundle\Entity\Document;
use Labs\BackBundle\Form\DocumentType;
use Labs\BackBundle\Form\DocumentEditTypec;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Partner controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{
    /**
     * @Route("/", name="doc_list")
     */
    public function  getListDocAction()
    {
        $em = $this->getDoctrine()->getManager();
        $docs = $em->getRepository('LabsBackBundle:Document')->findAll();
        return $this->render('LabsBackBundle:Document:list_doc.html.twig', array(
            'docs' => $docs
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     * @Route("/create", name="doc_create")
     * @Method({"GET", "POST"})
     */
    public function CreatePartnerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->persist($document);
            $em->flush();
            return $this->redirectToRoute('doc_list');
        }
        return $this->render('LabsBackBundle:Document:create_doc.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Document $document
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     * @Route("/edit/{id}", name="doc_edit")
     * @Method({"GET", "POST"})
     */
    public function editPartnerAction(Document $document ,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $documents = $em->getRepository('LabsBackBundle:Document')->findOneId($document);
        if(null === $documents){
            throw new NotFoundHttpException("L'element d'id ".$documents." n'existe pas");
        }
        $form = $this->createForm(DocumentEditType::class, $documents);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('doc_list');
        }
        return $this->render('LabsBackBundle:Document:edit_doc.html.twig',array(
            'form' => $form->createView(),
            'id'   => $documents->getId()
        ));
    }

    /**
     * @param Document $document
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws NotFoundHttpException
     * @Route("/delete/{id}", name="doc_delete")
     * @Method("GET")
     */
    public function deletePartnerAction(Document $document)
    {
        $em = $this->getDoctrine()->getManager();
        $documents = $em->getRepository('LabsBackBundle:Document')->find($document);
        if( null === $documents)
            throw new NotFoundHttpException('Le document '.$documents.' n\'existe pas');
        else
            $em->remove($documents);
        $em->flush();
        return $this->redirectToRoute('doc_list');
    }

}
