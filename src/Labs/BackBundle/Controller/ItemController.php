<?php

namespace Labs\BackBundle\Controller;

use Labs\BackBundle\Entity\Item;
use Labs\BackBundle\Form\ItemType;
use Labs\BackBundle\Form\ItemEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Items controller.
 *
 * @Route("/items")
 */
class ItemController extends Controller
{
    /**
     * @Route("/", name="item_list")
     */
    public function  getListItemAction()
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('LabsBackBundle:Item')->findAll();
        return $this->render('LabsBackBundle:Items:list_item.html.twig', array(
            'items' => $items
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     * @Route("/create", name="item_create")
     * @Method({"GET", "POST"})
     */
    public function CreateItemsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $items = new Item();
        $form = $this->createForm(ItemType::class, $items);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->persist($items);
            $em->flush();
            return $this->redirectToRoute('item_list');
        }
        return $this->render('LabsBackBundle:Items:create_item.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Item $item
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     * @Route("/edit/{id}", name="item_edit")
     * @Method({"GET", "POST"})
     */
    public function editItemAction(Item $item, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // On recupere l'id du item
        $items = $em->getRepository('LabsBackBundle:Item')->findOne($item);
        if(null === $items){
            throw new NotFoundHttpException("L'element d'id ".$items." n'existe pas");
        }
        $form = $this->createForm(ItemEditType::class, $items);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('item_list');
        }
        return $this->render('LabsBackBundle:Items:edit_item.html.twig',array(
            'form' => $form->createView(),
            'id'   => $items->getId()
        ));
    }

    /**
     * @param Item $item
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws NotFoundHttpException
     * @Route("/delete/{id}", name="item_delete")
     * @Method("GET")
     */
    public function deleteItemAction(Item $item)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('LabsBackBundle:Item')->find($item);
        if( null === $items)
            throw new NotFoundHttpException('equipe '.$items.' n\'existe pas');
        else
            $em->remove($items);
        $em->flush();
        return $this->redirectToRoute('item_list');
    }

}
