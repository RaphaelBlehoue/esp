<?php

namespace Labs\MemberBundle\Controller;

use Labs\BackBundle\Entity\Document;
use Labs\BackBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MemberController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="member_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()){
            $result = [];
            $media = $this->uploadMedia($request);
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
        return $this->render('LabsMemberBundle:Member:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Users $users
     * @Route("/files/list", name="member_file_list")
     */
    public function fileAction()
    {
        $users = $this->get('security.token_storage')->getToken()->getUser();
        $files = $this->get('doctrine.orm.entity_manager')
            ->getRepository('LabsBackBundle:Document')
            ->findUserDoc($users);
        return $this->render('LabsMemberBundle:Member:file_list.html.twig',[
            'files' => $files
        ]);
    }

    /**
     * @Route("/file/{filename}/download", name="file_show")
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
     * @Route("file/edit/name/{id}", name="file_edit_name")
     * @param Document $document
     */
    public function fileEditAction(Document $document){}

    /**
     * @Route("file/delete/{id}", name="file_delete")
     * @param Document $document
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function fileDeleteAction(Document $document){

        $em = $this->getDoctrine()->getManager();
        $documents = $em->getRepository('LabsBackBundle:Document')->find($document);
        if( null === $documents)
            throw new NotFoundHttpException('Le document '.$documents.' n\'existe pas');
        else
            $em->remove($documents);
        $em->flush();
        return $this->redirectToRoute('member_file_list');
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function uploadMedia(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $doc = new Document();
        $users = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $request->files->get('file');
        $doc->setNameFile($file->getClientOriginalName());
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
            $this->getParameter('docfile_directory'),
            $fileName
        );
        $doc->setPath($fileName);
        $doc->setUser($users);
        $em->persist($doc);
        $em->flush();
        return $doc->getId();
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
