<?php

namespace MyBlog\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of BlogRepository
 *
 * @author rodrigo
 */
class BlogRepository extends EntityRepository{

  public function findAllOrderedByName()
  {
    return null;
    return $this->getEntityManager()->createQueryBuilder('b')
            ->select("b.*")
            ->from("MyBlogBlogBundle:Blog", "b")
            //->orderBy("b.name", "asc")
            ->getQuery()
            ->getResult();
  }
  
  public function findAllOrderByNameDql()
  {
    $dql = "select b from MyBlogBlogBundle:Blog b order by b.name ASC";
    return $this->getEntityManager()->createQuery($dql)->getResult();
  }
}

