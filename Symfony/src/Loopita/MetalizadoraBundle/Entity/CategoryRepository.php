<?php

namespace Loopita\MetalizadoraBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of CategoryRepository
 *
 * @author rodrigo
 */
class CategoryRepository extends EntityRepository{
  
  public function retrievePagerDqlQuery(){
    $dql = "select c from LoopitaMetalizadoraBundle:Category c";
    return $this->getEntityManager()->createQuery($dql);
  }
}

