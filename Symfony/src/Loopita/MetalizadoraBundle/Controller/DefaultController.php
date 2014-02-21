<?php

namespace Loopita\MetalizadoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LoopitaMetalizadoraBundle:Default:index.html.twig');
    }
    
    public function retrieveServiceMenuAction(){
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("select c from LoopitaMetalizadoraBundle:Category c order by c.orden desc");
      $categories = $query->getResult();
      return $this->render('LoopitaMetalizadoraBundle:Default:serviceMenu.html.twig', array('categories' => $categories));
    }
    
    public function serviciosAction($slug)
    {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository("LoopitaMetalizadoraBundle:Category")->findOneBy(array('slug' => $slug));
      $query = $em->createQuery("select c from LoopitaMetalizadoraBundle:Category c order by c.orden desc");
      $categories = $query->getResult();
      return $this->render('LoopitaMetalizadoraBundle:Default:servicios.html.twig', array('categories' => $categories, 'category' => $category));
      die('aca');
    }
}
