<?php

namespace RSantellan\SitioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use RSantellan\SitioBundle\Entity\Category;

/**
 * Description of LoadUserFixture
 *
 * @author Rodrigo Santellan
 */
class LoadCategoryFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function getOrder() {
        return 2;
    }

    public function load(ObjectManager $manager) {
        $websites = new Category();
        $websites->setName("Sitios web");
        $websites->setTranslatableLocale('es');
        $manager->persist($websites);
        
        $scripting = new Category();
        $scripting->setName("Scripting");
        $scripting->setTranslatableLocale('es');
        $manager->persist($scripting);
        
        $wordpress = new Category();
        $wordpress->setName("Wordpress");
        $wordpress->setTranslatableLocale('es');
        $manager->persist($wordpress);
        
        $manager->flush();
        $this->addReference('category-web', $websites);
        $this->addReference('category-scripting', $scripting);
        $this->addReference('category-wordpress', $wordpress);
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


