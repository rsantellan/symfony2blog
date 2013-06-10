<?php

namespace Maith\Common\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AlbumsController extends Controller
{
    public function indexAction()
    {
        return $this->render('MaithCommonAdminBundle:Default:index.html.twig');
    }
    
    public function retrieveAlbumsData($id, $objectClass)
    {
      
    }
}
