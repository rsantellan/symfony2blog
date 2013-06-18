<?php

namespace Maith\Common\AdminBundle\Twig;

use Doctrine\ORM\EntityManager;

/**
 * Description of mImageExtension
 *
 * @author rodrigo
 */
class mAvatarExtension extends \Twig_Extension
{
  
  private $em;
  private $conn;
  private $rootDir;
  
  function __construct(EntityManager $em, $rootDir) {
    $this->em = $em;
    $this->conn = $em->getConnection();
    $this->rootDir = $rootDir;
  }

  
  public function getFilters() {
    return array(
        new \Twig_SimpleFilter('mAvatar', array($this, 'mAvatarFilter'))
    );
  }
  
  public function mAvatarFilter($objectId, $objectClass, $albumName = "Default")
  {
    $query = $this->em->createQuery("select a from MaithCommonAdminBundle:mAlbum a where a.object_id = :id and a.object_class = :object_class and a.name = :name ")->setParameters(array('id' => $objectId, 'object_class' => $objectClass, 'name' => $albumName));
    $album = $query->getOneOrNullResult();
    $files = $album->getFiles();
    $file = null;
    if($files->count() > 0)
    {
      $file = $files->get(0);
      return $file->getFullPath();
    }
    else
    {
      return $this->rootDir."/../web/bundles/maithcommonimage/images/noimage.png";
    }
  }

  public function getName() {
    return "maith_m_avatar";
  }
}

