<?php

namespace Loopita\MetalizadoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Loopita\MetalizadoraBundle\Entity\Category;
use Loopita\MetalizadoraBundle\Form\CategoryType;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('LoopitaMetalizadoraBundle:Admin:index.html.twig');
    }
    
    public function listCategoriesAction()
    {
      $em = $this->getDoctrine()->getManager();
    
      $paginator = $this->get("knp_paginator");
      $query = $em->createQuery("select c from LoopitaMetalizadoraBundle:Category c order by c.orden");
      // $em->getRepository("LoopitaMetalizadoraBundle:Category")->retrievePagerDqlQuery()
      $pagination = $paginator->paginate(
              $query ,
              $this->get('request')->query->get('page', 1)/*page number*/,
               10/*limit per page*/
              );
      return $this->render('LoopitaMetalizadoraBundle:Admin:categoriesList.html.twig', array('pagination' => $pagination));
    }
    
    public function addCategoryAction(Request $request)
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
        return $this->redirect($this->generateUrl('loopita_metalizadora_category_new'));
      }
      return $this->render('LoopitaMetalizadoraBundle:Admin:newCategoryForm.html.twig', array('form' => $form->createView()));
    }
    
    public function editCategoryAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository("LoopitaMetalizadoraBundle:Category")->find($id);
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

      return $this->render('LoopitaMetalizadoraBundle:Admin:editCategoryForm.html.twig', array('form' => $form->createView()));
    }
    
    public function deleteCategoryAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository("LoopitaMetalizadoraBundle:Category")->find($id);
      if(!$category)
      {
        throw $this->createNotFoundException("No category with id: ".$id);
      }
      $em->remove($category);
      $em->flush();
      $this->get("session")->getFlashBag()->add("notice", "Categoria eliminada");
      return $this->redirect($this->generateUrl('loopita_metalizadora_category'));
    }
}
