<?php

namespace Maith\Common\TranslatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $admin = $this->getRequest()->get('admin');
        
        $list = $this->container->getParameter('translation_bundles');
        if(!is_null($admin))
        {
          var_dump($this->container->getParameter('admin_translation_bundles'));
        }
        
        $path = $this->get('kernel')->getBundle('LoopitaMetalizadoraBundle')->getPath();
        return $this->render('MaithCommonTranslatorBundle:Default:index.html.twig', array('name' => 'hello'));
    }
}
