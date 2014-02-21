<?php

namespace Loopita\MetalizadoraBundle\Entity;

use Doctrine\ORM\EntityRepository;
// use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * Description of CategoryRepository
 *
 * @author rodrigo
 */
class CategoryRepository extends EntityRepository{
  
  public function retrievePagerDqlQuery(){
    $dql = "select c from LoopitaMetalizadoraBundle:Category c order by c.orden";
    return $this->getEntityManager()->createQuery($dql);
  }
}

