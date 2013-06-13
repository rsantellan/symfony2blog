<?php

namespace Maith\Common\ImageBundle\Twig;

/**
 * Description of mImageExtension
 *
 * @author rodrigo
 */
class mImageExtension extends \Twig_Extension
{
  
  public function getFilters() {
    return array(
        new \Twig_SimpleFilter('mImage', array($this, 'mImageFilter'))
    );
  }
  
  public function mImageFilter($image)
  {
    
    return "hello: ".$image. " nana";
  }

  public function getName() {
    return "maith_m_image";
  }
}

