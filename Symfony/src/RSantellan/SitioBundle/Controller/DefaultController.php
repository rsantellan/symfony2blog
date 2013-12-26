<?php

namespace RSantellan\SitioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RSantellan\SitioBundle\Form\ContactType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("select p from RSantellanSitioBundle:Project p order by p.id desc")->setMaxResults(5);
        //var_dump($query->getQueryCacheDriver());
        
        $projects = $query->useResultCache(true, 360)->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
        $response =  $this->render('RSantellanSitioBundle:Default:index.html.twig', array('activemenu' => 'home', 'projects' => $projects));
        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }
    
    public function projectsAction()
    {
      $em = $this->getDoctrine()->getManager();
      $queryCategories = $em->createQuery("select c from RSantellanSitioBundle:Category c order by c.orden");
      $categories = $queryCategories->useResultCache(true, 360)->getResult();
      $queryProjects = $em->createQuery("select p from RSantellanSitioBundle:Project p order by p.id desc");
      $projects = $queryProjects->useResultCache(true, 360)->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
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
      $projects = $queryProjects->useResultCache(true, 360)->getResult();//$em->getRepository('RSantellanSitioBundle:Project')->findAll();
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
      $categories = $queryCategories->useResultCache(true, 360)->getResult();
      $response = $this->render('RSantellanSitioBundle:Default:menuCategories.html.twig', array('categories' => $categories));
      $response->setPublic();
      $response->setSharedMaxAge("3600");
      return $response;
    }
    
    public function adminAction()
    {
        return $this->render('RSantellanSitioBundle:Admin:index.html.twig');
    }
    
    public function aboutMeAction()
    {
        $response = $this->render('RSantellanSitioBundle:Default:aboutme.html.twig');
        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }
    
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($form->get('subject')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo('rsantellan@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'RSantellanSitioBundle:Default:contactMessage.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'name' => $form->get('name')->getData(),
                                'message' => $form->get('message')->getData()
                            )
                        )
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');

                //return $this->redirect($this->generateUrl('rsantellan_sitio_contact'));
            }
        }
        return $this->render('RSantellanSitioBundle:Default:contact.html.twig', array('form' => $form->createView()));
    }
}
