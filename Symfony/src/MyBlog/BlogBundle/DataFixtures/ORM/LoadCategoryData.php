<?php

namespace MyBlog\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MyBlog\BlogBundle\Entity\Category;

/**
 * Description of LoadCategoryData
 *
 * @author rodrigo
 */
class LoadCategoryData implements FixtureInterface{
  
  public function load(ObjectManager $manager) {
    $category = new Category();
    $category->setName("Bass lessons");
    $category2 = new Category();
    $category2->setName("Programming lessons");
    $manager->persist($category);
    $manager->persist($category2);
    $manager->flush();
    
  }
}
