<?php

namespace Loopita\MetalizadoraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Loopita\MetalizadoraBundle\Entity\Category;

/**
 * Description of LoadCategoryData
 *
 * @author rodrigo
 */
class LoadCategoryData implements FixtureInterface{
  
  public function load(ObjectManager $manager) {
    $category = new Category();
    $category->setName("Área Industrial");
    $category->setOrden(2);
    $category2 = new Category();
    $category2->setName("Área Naval");
    $category2->setOrden(1);
    $category3 = new Category();
    $category3->setName("Área Edilicia y Poliuretano Expandido");
    $category3->setOrden(0);
    $manager->persist($category);
    $manager->persist($category2);
    $manager->persist($category3);
    $manager->flush();
    
  }
}
