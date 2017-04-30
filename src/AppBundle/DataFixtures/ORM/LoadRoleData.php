<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $role_user = new Role();
        $role_user->setName('ROLE_USER');
        $manager->persist($role_user);

        $role_admin = new Role();
        $role_admin->setName('ROLE_ADMIN');
        $manager->persist($role_admin);

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 200;
    }
}

