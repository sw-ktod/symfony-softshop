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
        $c1->setName('Test category 1');
        $manager->persist($c1);

        $c2 = new Category();
        $c2->setName('Test category 2');
        $manager->persist($c2);

        $c3 = new Category();
        $c3->setName('Test category 3');
        $manager->persist($c3);

        $c4 = new Category();
        $c4->setName('Test category 4');
        $manager->persist($c4);

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 30;
    }
}

