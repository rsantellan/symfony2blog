<?php

namespace RSantellan\SitioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FOS\UserBundle\Model\User;

/**
 * Description of LoadUserFixture
 *
 * @author Rodrigo Santellan
 */
class LoadUserFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function getOrder() {
        return 1;
    }

    public function load(ObjectManager $manager) {
        $userManager = $this->container->get('fos_user.user_manager');
        var_dump(get_class($userManager));
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


