<?php

namespace Loopita\MetalizadoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Loopita\MetalizadoraBundle\Entity\Category;
use Loopita\MetalizadoraBundle\Entity\Project;
use Loopita\MetalizadoraBundle\Form\CategoryType;
use Loopita\MetalizadoraBundle\Form\ProjectType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Maith\Common\AdminBundle\Entity\mAlbum;


use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Writer\TranslationWriter;
use Symfony\Component\Translation\Dumper\XliffFileDumper;
use Symfony\Component\Translation\MessageCatalogue;

class AdminController extends Controller
{

    public function saveTestUploadAction()
    {
      $translator = new Translator('es', new MessageSelector());
      $translator->addLoader("xlf", new XliffFileLoader());
      $file = __DIR__."/../Resources/translations/messages.es.xlf";
      $translator->addResource('xlf', $file, 'es');
      $writer = new TranslationWriter();
      $writer->addDumper('xlf', new XliffFileDumper());
      
      $catalog = new MessageCatalogue('es');
      //$catalog->addCatalogue()
      var_dump($catalog);
      var_dump($writer);
      var_dump('saveTestUploadAction');
      exit(0);
    }  
  
    public function indexAction()
    {
        return $this->render('LoopitaMetalizadoraBundle:Admin:index.html.twig');
    }
    
    public function listCategoriesAction()
    {
      $em = $this->getDoctrine()->getManager();
    
      $paginator = $this->get("knp_paginator");
      $query = $em->createQuery("select c from LoopitaMetalizadoraBundle:Category c order by c.orden desc");
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
    
    public function orderCategoryAction()
    {
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("select c from LoopitaMetalizadoraBundle:Category c order by c.orden desc");
      $categories = $query->getResult();
      
      $url = $this->generateUrl("loopita_metalizadora_category_order_save");
      return $this->render('MaithCommonAdminBundle:Sortable:layout.html.twig', array('sortableList' => $categories, 'url_sortable' => $url));
    }
    
    public function saveCategoriesOrderAction(Request $request)
    {
      $list = array_reverse($request->get("listItem"));
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery("select c from LoopitaMetalizadoraBundle:Category c order by c.orden desc");
      $categories = $query->getResult();
      $counter = count($list) - 1;
      while($counter >= 0)
      {
        $finish = false;
        $index = 0;
        $number = (int) $list[$counter];
        while(!$finish && $index < count($categories))
        {
          if(!isset($categories[$index]))
          {
            $finish = true;
          }
          else
          {
            $category = $categories[$index];
            if($number == $category->getId())
            {
              $category->setOrden($counter);
              $em->persist($category);
              $em->flush();
              $finish =true;
            }
          }
          $index++;
        }
        $counter--;
      }
      
      $response = new JsonResponse();
      $response->setData(array('output' => true));
      return $response;
      //die;
    }
    
    /**
     * 
     * Projects parts
     */
    
    public function listProjectsAction()
    {
      $em = $this->getDoctrine()->getManager();
    
      $paginator = $this->get("knp_paginator");
      $query = $em->createQuery("select p from LoopitaMetalizadoraBundle:Project p order by p.orden desc");
      $pagination = $paginator->paginate(
              $query ,
              $this->get('request')->query->get('page', 1)/*page number*/,
               10/*limit per page*/
              );
      return $this->render('LoopitaMetalizadoraBundle:Admin:projectsList.html.twig', array('pagination' => $pagination));
    }
    
    public function addProjectAction(Request $request)
    {
      
      //$test = $em->find("Loopita\MetalizadoraBundle\Entity\Project", 3);
      
      $project = new Project();
      $form = $this->createForm(new ProjectType(), $project);
      $form->handleRequest($request);
      if($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($form->getData());
        $em->flush();
        
        $mAlbum = new mAlbum();
        $mAlbum->setName("Default");
        $mAlbum->setObjectId($project->getId());
        $mAlbum->setObjectClass(get_class($project));
        $em->persist($mAlbum);
        $em->flush();
        $this->get("session")->getFlashBag()->add("notice", "Proyecto guardado");
        return $this->redirect($this->generateUrl('loopita_metalizadora_project_new'));
      }
      return $this->render('LoopitaMetalizadoraBundle:Admin:newProjectForm.html.twig', array('form' => $form->createView()));
    }
    
    public function editProjectAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $project = $em->getRepository("LoopitaMetalizadoraBundle:Project")->find($id);
      if(!$project)
      {
        throw $this->createNotFoundException("No hay proyecto con id: ".$id);
      }
      $form = $this->createForm(new ProjectType(), $project);

      $form->handleRequest($request);
      if($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($form->getData());
        $em->flush();
        $this->get("session")->getFlashBag()->add("notice", "Proyecto guardado");
      }
      return $this->render('LoopitaMetalizadoraBundle:Admin:editProjectForm.html.twig', array('form' => $form->createView()));
    }
    
    public function deleteProjectAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $project = $em->getRepository("LoopitaMetalizadoraBundle:Project")->find($id);
      if(!$project)
      {
        throw $this->createNotFoundException("No hay proyecto con id: ".$id);
      }
      $em->remove($project);
      $em->flush();
      $this->get("session")->getFlashBag()->add("notice", "Proyecto eliminado");
      return $this->redirect($this->generateUrl('loopita_metalizadora_projects'));
    }
}
