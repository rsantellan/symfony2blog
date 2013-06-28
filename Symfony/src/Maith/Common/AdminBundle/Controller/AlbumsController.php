<?php

namespace Maith\Common\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Maith\Common\AdminBundle\Model\Encrypt;
use Maith\Common\AdminBundle\Model\GalleryFile;
use Maith\Common\AdminBundle\Entity\mFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Finder\Finder;


class AlbumsController extends Controller
{
    public function indexAction()
    {
        return $this->render('MaithCommonAdminBundle:Default:index.html.twig');
    }
    
    public function retrieveAlbumsDataAction()
    {
        return $this->render('MaithCommonAdminBundle:Albums:showAlbums.html.twig');
        exit(0);
    }
    
    public function albumsDataAction($id, $objectclass)
    {
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("select a from MaithCommonAdminBundle:mAlbum a where a.object_id = :id and a.object_class = :object_class")->setParameters(array('id' => $id, 'object_class' => $objectclass));
      $albums = $query->getResult();
      //$imageManager = $this->get('maith_common_image.image.mimage');
      //$imageManager->doResize();
      return $this->render('MaithCommonAdminBundle:Albums:showAlbums.html.twig', array('albums' => $albums));
    }
    
    
    public function refreshAlbumAction()
    {
      
      $albumId = $this->getRequest()->get("id");
      $em = $this->getDoctrine()->getManager();
      $album = $em->getRepository("MaithCommonAdminBundle:mAlbum")->find($albumId);
      
      $response = new JsonResponse();
      $response->setData(array('status'=> 'OK', 'options' => array('html' => $this->renderView('MaithCommonAdminBundle:Albums:showAlbumFiles.html.twig', array('files' => $album->getFiles())) )));
      return $response;
    }
    
    public function sortAlbumAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $album = $em->getRepository("MaithCommonAdminBundle:mAlbum")->find($id);
      return $this->render('MaithCommonAdminBundle:Albums:fileSortable.html.twig', array('album' => $album));
    }
    
    public function doSortAlbumAction()
    {
      $albumId = $this->getRequest()->get("album_id");
      $items = $this->getRequest()->get("listItem");
      $em = $this->getDoctrine()->getManager();
      $album = $em->getRepository("MaithCommonAdminBundle:mAlbum")->find($albumId);
      $files = $album->getFiles();
      $counter = 0;
      while($counter < count($items))
      {
        $finish = false;
        $index = 0;
        $number = (int) $items[$counter];
        while(!$finish && $index < $files->count())
        {
          $file = $files->get($index);
          if(!$file)
          {
            $finish = true;
          }
          else
          {
            if($number == $file->getId())
            {
              $file->setOrden($counter);
              $em->persist($file);
              $em->flush();
              $finish = true;
            }
          }
          $index++;
        }
        $counter++;
      }
      
      $response = new JsonResponse();
      $response->setData(array('output' => true));
      return $response;
    }
    
    public function removeFileAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $file = $em->getRepository("MaithCommonAdminBundle:mFile")->find($id);
      $response = new JsonResponse();
      $status = "OK";
      if (!$file) 
      {
        $status = "ERROR";
      }
      else
      {
        $file->removeAllFiles($this->get('kernel')->getCacheDir());
        $em->remove($file);
        $em->flush();
      }
      $response->setData(array('status' => $status));
      return $response;
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
    
    
    /***
     * 
     * Galleries
     * 
     ***/
	
	public function showGalleriesAction()
    {
	  $sf_targetDir = "upload". DIRECTORY_SEPARATOR."galleries";
      $targetDir = $this->get('kernel')->getRootDir().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web'. DIRECTORY_SEPARATOR.$sf_targetDir;
	  $finder = new Finder();
	  $galleries = array();
	  foreach($finder->in($targetDir)->directories()->sortByName() as $dir)
	  {
		$galleries[$dir->getFilename()] = array();
		$file_finder = new Finder();
		foreach($file_finder->in($dir->getRealpath())->files()->sortByModifiedTime() as $file)
		{
          $obj = new GalleryFile();
          $obj->setFilename($file->getFilename());
          $obj->setFullpath($file->getRealpath());
          //$obj->fullPath = $file->getRealpath();
          //$obj->fileName = $file->getFilename();
		  $galleries[$dir->getFilename()][] = $obj;//$file->getRealpath();
		  
		}
	  }
	  //var_dump($galleries);
      return $this->render('MaithCommonAdminBundle:Albums:folders.html.twig', array('galleries' => $galleries));
    }
    
    public function uploadGalleryFormAction($gallery)
    {
      $token = $this->container->getParameter('maith_common_admin.upload_token');
      $encrypt = new Encrypt($token);
      
      return $this->render('MaithCommonAdminBundle:Albums:uploadGallery.html.twig', array('gallery' => $gallery, 'dataSession' => urldecode($encrypt->encrypt(session_id()))));
    }
    
    public function doGalleryFormUploadAction()
    {
      
      $gallery = $this->getRequest()->get('gallery');
      $fileName = $this->getRequest()->get('name', 0);
      $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
      $sf_targetDir = "upload". DIRECTORY_SEPARATOR."galleries".DIRECTORY_SEPARATOR.$gallery;
      $targetDir = $this->get('kernel')->getRootDir().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web'. DIRECTORY_SEPARATOR.$sf_targetDir;
      if (!file_exists($targetDir))
      {
        return new Response(json_encode(array("jsonrpc" => '2.0', 'error' => array('code' => 100, 'message' => "Failed to open temp directory."), 'id' => $gallery)));
      }
        
      $fileUploaded = $this->container->get('request')->files->get('file');
      //$name = uniqid() . '.' . $fileUploaded->guessExtension();
      $movedFile = $fileUploaded->move($targetDir, $fileName);
      if ($movedFile) 
      {
        return new Response(json_encode(array("jsonrpc" => '2.0', 'result' => null, 'id' => $gallery)));
      }
      else
      {
        return new Response(json_encode(array("jsonrpc" => '2.0', 'error' => array('code' => 100, 'message' => "Failed to open temp directory."), 'id' => $albumId)));
      }
      die;
    }
    
    public function removeGalleryFileAction($gallery, $file)
    {
      //$fileName = preg_replace('/[^\w\._]+/', '_', $file);
      $sf_targetDir = "upload". DIRECTORY_SEPARATOR."galleries".DIRECTORY_SEPARATOR.$gallery.DIRECTORY_SEPARATOR.$file;
      $targetDir = $this->get('kernel')->getRootDir().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web'. DIRECTORY_SEPARATOR.$sf_targetDir;
      $response = new JsonResponse();
      $status = "OK";
      if(file_exists($targetDir))
      {
        $cache_dir = $this->get('kernel')->getCacheDir().DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR;
        GalleryFile::removeAllCacheOfFile($cache_dir, $gallery, $file);
        @unlink($targetDir);
      }
      else
      {
        $status = "ERROR";
      }
      $response->setData(array('status' => $status));
      return $response;
      die;
    }
    
}
