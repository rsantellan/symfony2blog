<?php

namespace Maith\Common\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MaithCommonImageBundle:Default:index.html.twig', array('name' => $name));
    }
}
