<?php

namespace RSantellan\SitioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Maith\Common\UsersBundle\Entity\Role;
use Maith\Common\UsersBundle\Entity\GroupRole;

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

        $roleAdmin = new Role();
        $roleAdmin->setName("ROLE_ADMIN");
        $roleAdmin->setDescription("Permiso del administrador");
        $manager->persist($roleAdmin);

        $manager->flush();
        
        $adminGroup = new GroupRole();
        $adminGroup->setName("Permisos del admin");
        $adminGroup->addGroupRole($roleAdmin);
        $manager->persist($adminGroup);

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setEmail('user@domain.com');
        $user->setPlainPassword('1234');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);
        $user->setFullName("Rodrigo Santellan");
        $user->fixtureAddUserGroup($adminGroup);
        $manager->persist($user);
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


