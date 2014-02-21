<?php

namespace MyBlog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MyBlog\BlogBundle\Entity\Blog;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MyBlogBlogBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function addTestAction()
    {
      $blog = new Blog();
      $blog->setName("Primer blog");
      $blog->setBody("Jajajaja estoy testeando un blog!");
      $blog->setAuthor("RS");
      
      $em = $this->getDoctrine()->getManager();
      $em->persist($blog);
      $em->flush();
      return $this->render('MyBlogBlogBundle:Default:blog.html.twig', array('blog' => $blog));
      
    }
    
    public function showTestAction($id)
    {
      $em = $this->getDoctrine();
      $blog = $em->getRepository("MyBlogBlogBundle:Blog")->find($id);
      if(!$blog)
      {
        throw $this->createNotFoundException("No blog with id: ".$id);
      }
      $em->getRepository("MyBlogBlogBundle:Blog")->findAllOrderedByName();
      $em->getRepository("MyBlogBlogBundle:Blog")->findAllOrderByNameDql();
      
      return $this->render('MyBlogBlogBundle:Default:blog.html.twig', array('blog' => $blog));
    }
}
