<?php

namespace Acme\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $session = $this->getRequest()->getSession();
        $session->set("foo", "bar");
        return $this->render('AcmeHelloBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function helloAction()
    {
      $response = $this->forward('AcmeHelloBundle:Default:index', array('name' => 'pepe'));
      return $response;
      //return new Response("Hola mundo!");
    }
}
