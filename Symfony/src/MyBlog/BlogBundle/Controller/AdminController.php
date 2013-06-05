<?php

namespace MyBlog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MyBlog\BlogBundle\Entity\Category;
use MyBlog\BlogBundle\Form\CategoryType;

/**
 * Description of AdminController
 *
 * @author rodrigo
 */
class AdminController extends Controller
{

  public function newCategoryAction(Request $request)
  {
    $category = new Category();
    $form = $this->createForm(new CategoryType(), $category);
    
    $form->handleRequest($request);
    if($form->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($form->getData());
      $em->flush();
      $this->get("session")->getFlashBag()->add("notice", "Categoria guardada");
    }
    
    return $this->render('MyBlogBlogBundle:Admin:newCategoryForm.html.twig', array('form' => $form->createView()));
  }
  
  public function listAction()
  {
    
    return $this->render('MyBlogBlogBundle:Admin:categoriesList.html.twig');
  }
}

