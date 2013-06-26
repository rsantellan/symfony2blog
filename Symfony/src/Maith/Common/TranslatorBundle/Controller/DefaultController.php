<?php

namespace Maith\Common\TranslatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Translation\MessageCatalogue;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $admin = $this->getRequest()->get('admin');
        
        $list = $this->container->getParameter('translation_bundles');
        if(!is_null($admin))
        {
          $list = array_merge($list, $this->container->getParameter('admin_translation_bundles'));
        }
        $lang_list = $this->container->getParameter('translation_languages');;
        //$path = $this->get('kernel')->getBundle('LoopitaMetalizadoraBundle')->getPath();
        return $this->render('MaithCommonTranslatorBundle:Default:index.html.twig', array('bundles' => $list, 'langs' => $lang_list));
    }
    
    public function getTranslationAction(){
        
        $bundle = $this->getRequest()->get("bundle");
        $lang = $this->getRequest()->get("lang");
        $path = $this->get('kernel')->getBundle($bundle)->getPath()."/Resources/translations";
        $loader = $this->get('translation.loader');
        $catalog = new MessageCatalogue($lang);
        $loader->loadMessages($path, $catalog);
        var_dump($catalog->all("messages"));
        die('aca');
    }
}
