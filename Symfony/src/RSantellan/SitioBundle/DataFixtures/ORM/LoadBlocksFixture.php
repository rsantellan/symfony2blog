<?php

namespace RSantellan\SitioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use RSantellan\SitioBundle\Entity\Project;

/**
 * Description of LoadUserFixture
 *
 * @author Rodrigo Santellan
 */
class LoadBlocksFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function getOrder() {
        return 3;
    }

    public function load(ObjectManager $manager) {
        
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


