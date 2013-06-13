<?php

namespace Maith\Common\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Maith\Common\AdminBundle\Model\Encrypt;
use Maith\Common\AdminBundle\Entity\mFile;

class AlbumsController extends Controller
{
    public function indexAction()
    {
        return $this->render('MaithCommonAdminBundle:Default:index.html.twig');
    }
    
    public function retrieveAlbumsDataAction()
    {
        /*
        $uploadForm = $this->createFormBuilder()
            ->add('download', 'genemu_jqueryfile', array('mapped' => false, 'configs' => array('script' => 'loopita_metalizadora_test_upload' ,'objectClass' => "myClase", 'objectId' => 1, 'debug'    => true)))
        ->getForm();
        */
        return $this->render('MaithCommonAdminBundle:Albums:showAlbums.html.twig');
        exit(0);
    }
    
    public function albumsDataAction($id, $objectclass)
    {
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("select a from MaithCommonAdminBundle:mAlbum a where a.object_id = :id and a.object_class = :object_class")->setParameters(array('id' => $id, 'object_class' => $objectclass));
      $albums = $query->getResult();
      return $this->render('MaithCommonAdminBundle:Albums:showAlbums.html.twig', array('albums' => $albums));
    }
    
    public function uploadFormAction($id)
    {
      $token = $this->container->getParameter('maith_common_admin.upload_token');
      $encrypt = new Encrypt($token);
      
      return $this->render('MaithCommonAdminBundle:Albums:upload.html.twig', array('albumId' => $id, 'dataSession' => urldecode($encrypt->encrypt(session_id()))));
    }
    
    
    public function doFormUploadAction()
    {
      
      $albumId = $this->getRequest()->get('albumId');
      $fileName = $this->getRequest()->get('name', 0);
      $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
      $sf_targetDir = "upload". DIRECTORY_SEPARATOR."album-".$albumId;
      $targetDir = $this->get('kernel')->getRootDir().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web'. DIRECTORY_SEPARATOR.$sf_targetDir;
      if (!file_exists($targetDir))
        @mkdir($targetDir);
      $fileUploaded = $this->container->get('request')->files->get('file');
      $name = uniqid() . '.' . $fileUploaded->guessExtension();
      $movedFile = $fileUploaded->move($targetDir, $name);
      //var_dump($fileUploaded->isValid());
      //var_dump($fileUploaded->getError());
      if ($movedFile) 
      {
        $em = $this->getDoctrine()->getManager();
        $myFile = new mFile();
        $myFile->setAlbum($em->getRepository("MaithCommonAdminBundle:mAlbum")->find($albumId));
        $myFile->setName($name);
        $myFile->setPath($targetDir);
        $myFile->setType($movedFile->getMimeType());
        $myFile->setSfPath($sf_targetDir);
        $em->persist($myFile);
        $em->flush();
        return new Response(json_encode(array("jsonrpc" => '2.0', 'result' => null, 'id' => $albumId)));
      }
      else
      {
        return new Response(json_encode(array("jsonrpc" => '2.0', 'error' => array('code' => 100, 'message' => "Failed to open temp directory."), 'id' => $albumId)));
      }
      die;
    }
    
}
