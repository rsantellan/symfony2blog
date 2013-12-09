<?php

namespace RSantellan\SitioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("select p from RSantellanSitioBundle:Project p order by p.id desc");
        $projects = $query->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
        return $this->render('RSantellanSitioBundle:Default:index.html.twig', array('activemenu' => 'home', 'projects' => $projects));
    }
    
    public function projectsAction()
    {
      $em = $this->getDoctrine()->getManager();
      $queryCategories = $em->createQuery("select c from RSantellanSitioBundle:Category c order by c.orden");
      $categories = $queryCategories->getResult();
      $queryProjects = $em->createQuery("select p from RSantellanSitioBundle:Project p order by p.id desc");
      $projects = $queryProjects->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
      return $this->render('RSantellanSitioBundle:Default:projectsThreeColumns.html.twig', array('activemenu' => 'projects', 'projects' => $projects, 'categories' => $categories));
    }
    
    public function projectsCategoryAction($slug)
    {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository("RSantellanSitioBundle:Category")->findOneBySlug($slug);
      $queryProjects = $em->createQuery("select p from RSantellanSitioBundle:Project p where p.category = :category order by p.id desc")->setParameter('category', $category->getId());
      $projects = $queryProjects->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
      return $this->render('RSantellanSitioBundle:Default:projectsThreeColumns.html.twig', array('activemenu' => 'projects', 'page_title' => $category->getName(), 'projects' => $projects, 'categories' => array()));
    }
    
    public function projectsShowAction($slug)
    {
      $em = $this->getDoctrine()->getManager();
      $project = $em->getRepository("RSantellanSitioBundle:Project")->findOneBySlug($slug);
      
      $imagesAlbum = $em->getRepository("MaithCommonAdminBundle:mAlbum")->findOneBy(array('object_id' => $project->getId(), 'object_class' => $project->getFullClassName(), 'name' => 'images'));
      $mainAlbum = $em->getRepository("MaithCommonAdminBundle:mAlbum")->findOneBy(array('object_id' => $project->getId(), 'object_class' => $project->getFullClassName(), 'name' => 'main'));
      
      //$album = $em->createQuery("select a from MaithCommonAdminBundle:mAlbum a where a.object_id = :object_id and a.object_class = :object_class and a.name = :name")->setParameters(array('name' => 'images', 'object_id'=>$project->getId(), 'object_class' => $project->getFullClassName()))->getResult();
      //$albums = $em->createQuery("select a from MaithCommonAdminBundle:mAlbum a where a.object_id = :object_id and a.object_class = :object_class")->setParameters(array('object_id'=>$project->getId(), 'object_class' => $project->getFullClassName()))->getResult();
      //var_dump($albums);die;
      /*
      if(count($album) > 0)
      {
        $album = $album[0];
      }
      $albumsData = array();
      foreach($albums as $albumKey => $albumValue){
        $albumsData[$albumValue->getName()] = $albumValue;
      }
      */
      return $this->render('RSantellanSitioBundle:Default:projectShow.html.twig', array('activemenu' => 'projects', 'project' => $project, 'imagesAlbum' => $imagesAlbum, 'mainAlbums' => $mainAlbum));
      die($project->getId());
      
    }
    
    public function menuCategoriesAction()
    {
      $em = $this->getDoctrine()->getManager();
      $queryCategories = $em->createQuery("select c from RSantellanSitioBundle:Category c order by c.orden");
      $categories = $queryCategories->getResult();
      return $this->render('RSantellanSitioBundle:Default:menuCategories.html.twig', array('categories' => $categories));
    }
    
    public function adminAction()
    {
        return $this->render('RSantellanSitioBundle:Admin:index.html.twig');
    }
}
