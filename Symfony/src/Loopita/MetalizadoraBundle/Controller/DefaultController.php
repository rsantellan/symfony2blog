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
      var_dump($slug);
      die('aca');
    }
}
