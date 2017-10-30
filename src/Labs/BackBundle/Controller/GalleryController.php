<?php

namespace Labs\BackBundle\Controller;

use Labs\BackBundle\Entity\Gallery;
use Labs\BackBundle\Entity\Media;
use Labs\BackBundle\Form\GalleryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Class FormatController
 * @package Labs\BackBundle\Controller;
 * @Route("/gallery")
 */
class GalleryController extends Controller
{
    /**
     * @Route("/", name="dossier_index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $dossiers = $this->getAllDossiers();
        return $this->render('LabsBackBundle:Gallery:index.html.twig',[
            'dossiers' => $dossiers
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/create", name="dossier_create")
     * @Method({"GET","POST"})
     */
    public function createAction()
    {
        $user = $this->getUser();
        $gallery = new Gallery();
        $draft = $this->get('draft_create')->DraftCreate($user, $gallery);
        return $this->redirectToRoute('dossier_draft', ['id' => $draft->getId(), 'user_id' => $user->getId()]);
    }


    /**
     * @param Request $request
     * @param Gallery $gallery
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @Route("/{id}/{user_id}/edit", name="dossier_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Gallery $gallery)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $datas = $em->getRepository('LabsBackBundle:Gallery')->getGallerysArticles($gallery, $user);
        if( null === $datas)
        {
            throw new AccessDeniedException("Vous n'êtes pas autorisé à modifier la galerie d'un utilisateur");
        }

        // Upload Medias
        if($request->isXmlHttpRequest()){
            $result = [];
            $media = $this->uploadMedia($request, $datas);
            if(null !== $media){
                $result = [
                    'results' => 'true',
                    'media'   => $media
                ];
                return new JsonResponse($result);
            }
            $result = ['results' => 'false'];
            return new JsonResponse($result);
        }

        $form = $this->createForm(GalleryType::class, $datas);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $datas->setDraft(1);
            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('dossier_index');
        }
        return $this->render('LabsBackBundle:Gallery:edit_page.html.twig', [
            'form' => $form->createView(),
            'dossier' => $datas
        ]);

    }

    /**
     * @Route("/{id}/{user_id}/draft", name="dossier_draft")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Gallery $gallery
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \OutOfBoundsException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function GalleryDraftAction(Request $request, Gallery $gallery)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $datas = $this->get('draft_create')->DraftCreate($user, $gallery);
        if( null === $datas)
        {
            throw new NotFoundHttpException('Dossier introuvable');
        }
        // Upload Medias
        if($request->isXmlHttpRequest()){
            $result = [];
            $media = $this->uploadMedia($request, $datas);
            if(null !== $media){
                $result = [
                    'results' => 'true',
                    'media'   => $media
                ];
                return new JsonResponse($result);
            }
            $result = ['results' => 'false'];
            return new JsonResponse($result);
        }

        $form = $this->createForm(GalleryType::class, $datas);
        $form->add('draft', SubmitType::class, array(
            'label' => 'Enregistrer comme brouillon',
            'attr'  => array('class' => 'btn btn-danger')
        ));

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){

            if ($form->get('draft')->isClicked()){
                $datas->setDraft(-1);
                $datas->setOnline(0);
            } else {
                $datas->setDraft(1);
            }

            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('dossier_index');
        }
        return $this->render('LabsBackBundle:Gallery:draft_page.html.twig', [
            'form' => $form->createView(),
            'dossier' => $datas
        ]);
    }

    /**
     * @param Gallery $gallery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{id}/delete", name="dossier_delete")
     * @Method({"GET","DELETE"})
     */
    public function deleteAction(Gallery $gallery)
    {
        $em = $this->getDoctrine()->getManager();
        $formats = $em->getRepository('LabsBackBundle:Gallery')->find($gallery);
        if( null === $formats)
            throw new NotFoundHttpException('element '.$formats.' n\'existe pas');
        else
            $em->remove($formats);
        $em->flush();
        return $this->redirectToRoute('dossier_index');
    }

    /**
     * @return array
     */
    private function getAllDossiers()
    {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('LabsBackBundle:Gallery')->getAll();
      if(null === $entity){
          throw new NotFoundHttpException('Entity introuvable');
      }
      return $entity;
    }


    /**
     * @param Request $request
     * @param Gallery $gallery
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function uploadMedia(Request $request, Gallery $gallery)
    {
        $em = $this->getDoctrine()->getManager();
        $media = new Media();
        $dossier = $em->getRepository('LabsBackBundle:Gallery')->getGallerys($gallery);
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $request->files->get('file');
        $fileName = $dossier->getSlug().'_'.md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
            $this->getParameter('gallery_directory'),
            $fileName
        );
        $media->setUrl($fileName);
        $media->setGallery($dossier);
        $em->persist($media);
        $em->flush($media);
        return $media->getId();
    }


}
