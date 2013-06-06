<?php

namespace Loopita\MetalizadoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('LoopitaMetalizadoraBundle:Admin:index.html.twig');
    }
}
