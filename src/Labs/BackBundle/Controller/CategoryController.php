<?php

namespace Labs\BackBundle\Controller;

use Labs\BackBundle\Entity\Category;
use Labs\BackBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoryController
 * @package Labs\BackBundle\Controller
 * @Route("/catgory")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="category_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('LabsBackBundle:Category')->findAll();
        return $this->render('LabsBackBundle:Category:index.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/create", name="category_create")
     */
    public function CreateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = new Category();
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);

            if($form->isValid()){
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('success', 'L\'enregistrement  a été fait avec succès');
                return $this->redirectToRoute('category_index', array(), 302);
            }
        return $this->render('LabsBackBundle:Category:create.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Category $category, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('LabsBackBundle:Category')->getOneCategory($category);
        if(null === $categorie)
        {
            throw new NotFoundHttpException('Page Introuvable',null, 404);
        }
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);

        if($form->isValid()){
            $em->flush();
            $this->addFlash('success', 'La modification a été fait avec succès');
            return $this->redirectToRoute('category_index', array(), 302);
        }
        return $this->render('LabsBackBundle:Category:edit.html.twig',array(
            'form' => $form->createView(),
            'category' => $categorie
        ));
    }

    /**
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/delete", name="category_delete")
     * @Method("GET")
     */
    public function deleteAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('LabsBackBundle:Category')->find($category);
        if(null === $categorie)
            throw new NotFoundHttpException('Page Introuvable',null, 404);
        else
            $em->remove($categorie);
            $em->flush();
            $this->addFlash('success', 'La suppression a été fait avec succès');
            return $this->redirectToRoute('category_index', array(), 302);
    }
}
