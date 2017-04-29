<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ShopBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $c1 = new Category();
        $c1->setName('Windows');
        $manager->persist($c1);

        $c1 = new Category();
        $c1->setName('Linux');
        $manager->persist($c1);

        $c1 = new Category();
        $c1->setName('Mac OS');
        $manager->persist($c1);

        $c1 = new Category();
        $c1->setName('MS DOS');
        $manager->persist($c1);

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}

