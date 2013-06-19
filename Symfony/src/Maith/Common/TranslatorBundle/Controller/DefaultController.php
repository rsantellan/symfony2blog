<?php

namespace Maith\Common\TranslatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MaithCommonTranslatorBundle:Default:index.html.twig', array('name' => $name));
    }
}
