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
  
  public function editCategoryAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->getRepository("MyBlogBlogBundle:Category")->find($id);
    if(!$category)
    {
      throw $this->createNotFoundException("No category with id: ".$id);
    }
    $form = $this->createForm(new CategoryType(), $category);
    
    $form->handleRequest($request);
    if($form->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($form->getData());
      $em->flush();
      $this->get("session")->getFlashBag()->add("notice", "Categoria guardada");
    }
    
    return $this->render('MyBlogBlogBundle:Admin:editCategoryForm.html.twig', array('form' => $form->createView()));
  }
  
  public function listAction()
  {
    $em = $this->getDoctrine()->getManager();
    
    $paginator = $this->get("knp_paginator");
    $pagination = $paginator->paginate(
            $em->getRepository("MyBlogBlogBundle:Category")->retrievePagerDqlQuery(),
            $this->get('request')->query->get('page', 1)/*page number*/,
             10/*limit per page*/
            );
    return $this->render('MyBlogBlogBundle:Admin:categoriesList.html.twig', array('pagination' => $pagination));
  }
}

