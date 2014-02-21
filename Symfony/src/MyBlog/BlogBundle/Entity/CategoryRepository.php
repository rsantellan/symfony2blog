<?php

namespace MyBlog\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of CategoryRepository
 *
 * @author rodrigo
 */
class CategoryRepository extends EntityRepository{
  
  public function retrievePagerDqlQuery(){
    $dql = "select c from MyBlogBlogBundle:Category c";
    return $this->getEntityManager()->createQuery($dql);
  }
}

