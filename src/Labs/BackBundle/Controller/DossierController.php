<?php

namespace Labs\BackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DossierController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/dossiers", name="list_dossier")
     */
    public function getFileUsersAction(){

        $em = $this->get('doctrine.orm.entity_manager');
        //$usersfiles = $em->getRepository('LabsBackBundle:Document')->findUserDoc($users);
        $usersfiles = $em->getRepository('LabsBackBundle:Users')->findByRole('ROLE_MEMBER');
        return $this->render('LabsBackBundle:Dossier:index.html.twig',
            ['userfiles' => $usersfiles]
        );

    }

    /**
     * @param Request $request
     * @Route("/dossiers/create", name="dossier_create")
     */
    public function createDossierAction(Request $request){}


    /**
     * @param $user_id
     * @Route("/dossiers/users/{user_id}", name="dossier_show_file")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showUserFileAction($user_id){
        $em = $this->get('doctrine.orm.entity_manager');
        $userfiles = $em->getRepository('LabsBackBundle:Users')->findUserDocment($user_id);
        return $this->render('LabsBackBundle:Dossier:show.html.twig', [
            'userfiles' => $userfiles
        ]);
    }


    /**
     * @Route("/dossiers/{filename}/download", name="document_show")
     * @param $filename
     * @return Response
     * @internal param Document $document
     */
    public function fileShowAction($filename){
        $doc = $this->getOneDocs($filename);
        $files = $doc->getAssertPath();
        $content = file_get_contents($files);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContent($content);
        return $response;
    }

    /**
     * @param $docName
     * @return mixed
     */
    private function getOneDocs($docName)
    {
        $em = $this->getDoctrine()->getManager();
        $docs = $em->getRepository('LabsBackBundle:Document')->findOneBy([
            'path' => $docName
        ]);
        return $docs;
    }
}
