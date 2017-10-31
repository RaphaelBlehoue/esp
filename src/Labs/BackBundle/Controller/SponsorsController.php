<?php

namespace Labs\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Labs\BackBundle\Entity\Sponsors;
use Labs\BackBundle\Form\SponsorsType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Sponsors controller.
 *
 * @Route("/sponsors")
 */
class SponsorsController extends Controller
{
    /**
     * @Route("/", name="sponsors_list")
     */
    public function  getListSponsorsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $partners = $em->getRepository('LabsBackBundle:Sponsors')->findAll();
        return $this->render('LabsBackBundle:Sponsors:list_partner.html.twig', array(
            'partners' => $partners
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     * @Route("/create", name="sponsors_create")
     * @Method({"GET", "POST"})
     */
    public function CreateSponsorsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $partner = new Sponsors();
        $form = $this->createForm(SponsorsType::class, $partner);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->persist($partner);
            $em->flush();
            return $this->redirectToRoute('sponsors_list');
        }
        return $this->render('LabsBackBundle:Sponsors:create_partner.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Sponsors $sponsors
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     * @Route("/edit/{id}", name="sponsors_edit")
     * @Method({"GET", "POST"})
     */
    public function editPartnerAction(Sponsors $sponsors ,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $partners = $em->getRepository('LabsBackBundle:Sponsors')->findOne($sponsors);
        if(null === $partners){
            throw new NotFoundHttpException("L'element n'existe pas");
        }
        $form = $this->createForm(SponsorsType::class, $partners);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('sponsors_list');
        }
        return $this->render('LabsBackBundle:Sponsors:edit_partner.html.twig',array(
            'form' => $form->createView(),
            'sponsors'   => $partners
        ));
    }

    /**
     * @param Sponsors $sponsors
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws NotFoundHttpException
     * @Route("/delete/{id}", name="sponsors_delete")
     * @Method("GET")
     */
    public function deletePartnerAction(Sponsors $sponsors)
    {
        $em = $this->getDoctrine()->getManager();
        $partners = $em->getRepository('LabsBackBundle:Sponsors')->find($sponsors);
        if( null === $partners)
            throw new NotFoundHttpException('Le sponsors n\'existe pas');
        else
            $em->remove($partners);
        $em->flush();
        return $this->redirectToRoute('sponsors_list');
    }

}
