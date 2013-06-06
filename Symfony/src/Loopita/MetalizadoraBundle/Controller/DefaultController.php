<?php

namespace Loopita\MetalizadoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LoopitaMetalizadoraBundle:Default:index.html.twig');
    }
}
