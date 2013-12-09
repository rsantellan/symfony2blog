<?php

namespace RSantellan\SitioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("select p from RSantellanSitioBundle:Project p order by p.id desc")->setMaxResults(5);
        $projects = $query->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
        $response =  $this->render('RSantellanSitioBundle:Default:index.html.twig', array('activemenu' => 'home', 'projects' => $projects));
        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }
    
    public function projectsAction()
    {
      $em = $this->getDoctrine()->getManager();
      $queryCategories = $em->createQuery("select c from RSantellanSitioBundle:Category c order by c.orden");
      $categories = $queryCategories->getResult();
      $queryProjects = $em->createQuery("select p from RSantellanSitioBundle:Project p order by p.id desc");
      $projects = $queryProjects->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
      $response =  $this->render('RSantellanSitioBundle:Default:projectsThreeColumns.html.twig', array('activemenu' => 'projects', 'projects' => $projects, 'categories' => $categories));
      $response->setPublic();
      $response->setSharedMaxAge("3600");
      return $response;
    }
    
    public function projectsCategoryAction($slug)
    {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository("RSantellanSitioBundle:Category")->findOneBySlug($slug);
      $queryProjects = $em->createQuery("select p from RSantellanSitioBundle:Project p where p.category = :category order by p.id desc")->setParameter('category', $category->getId());
      $projects = $queryProjects->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
      $response = $this->render('RSantellanSitioBundle:Default:projectsThreeColumns.html.twig', array('activemenu' => 'projects', 'page_title' => $category->getName(), 'projects' => $projects, 'categories' => array()));
      $response->setPublic();
      $response->setSharedMaxAge("3600");
      return $response;
    }
    
    public function projectsShowAction($slug)
    {
      $em = $this->getDoctrine()->getManager();
      $project = $em->getRepository("RSantellanSitioBundle:Project")->findOneBySlug($slug);
      
      $imagesAlbum = $em->getRepository("MaithCommonAdminBundle:mAlbum")->findOneBy(array('object_id' => $project->getId(), 'object_class' => $project->getFullClassName(), 'name' => 'images'));
      $mainAlbum = $em->getRepository("MaithCommonAdminBundle:mAlbum")->findOneBy(array('object_id' => $project->getId(), 'object_class' => $project->getFullClassName(), 'name' => 'main'));

      $response = $this->render('RSantellanSitioBundle:Default:projectShow.html.twig', array('activemenu' => 'projects', 'project' => $project, 'imagesAlbum' => $imagesAlbum, 'mainAlbums' => $mainAlbum));
      $response->setPublic();
      $response->setSharedMaxAge("3600");
      return $response;
    }
    
    public function menuCategoriesAction()
    {
      $em = $this->getDoctrine()->getManager();
      $queryCategories = $em->createQuery("select c from RSantellanSitioBundle:Category c order by c.orden");
      $categories = $queryCategories->getResult();
      $response = $this->render('RSantellanSitioBundle:Default:menuCategories.html.twig', array('categories' => $categories));
      $response->setPublic();
      $response->setSharedMaxAge("3600");
      return $response;
    }
    
    public function adminAction()
    {
        return $this->render('RSantellanSitioBundle:Admin:index.html.twig');
    }
}
