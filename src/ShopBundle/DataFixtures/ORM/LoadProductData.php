<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ShopBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $categories = $manager->getRepository('ShopBundle:Category')->findAll();
        $p1 = new Product();
        $p1->setName('Linux Test Product 1')
            ->setVisitedCount(0)
            ->setCategory($categories[0])
            ->setCategoryId(1)
            ->setDescription('Linux Test Product1')
            ->setPrice('200');
        $manager->persist($p1);

        $p2 = new Product();
        $p2->setName('Linux Test Product 2')
            ->setVisitedCount(0)
            ->setCategory($categories[0])
            ->setCategoryId(1)
            ->setDescription('Linux Test Product 2')
            ->setPrice('350');
        $manager->persist($p2);

        $p3 = new Product();
        $p3->setName('Linux Test Product 3')
            ->setVisitedCount(0)
            ->setCategory($categories[0])
            ->setCategoryId(1)
            ->setDescription('Linux Test Product 3')
            ->setPrice('123');
        $manager->persist($p3);

        $p4 = new Product();
        $p4->setName('Windows Test Product 1')
            ->setVisitedCount(0)
            ->setCategory($categories[1])
            ->setCategoryId(2)
            ->setDescription('Linux Test Product 1')
            ->setPrice('322');
        $manager->persist($p4);

        $p5 = new Product();
        $p5->setName('Windows Test Product 2')
            ->setVisitedCount(0)
            ->setCategory($categories[1])
            ->setCategoryId(2)
            ->setDescription('Linux Test Product 2')
            ->setPrice('60');
        $manager->persist($p5);

        $p6 = new Product();
        $p6->setName('Windows Test Product 3')
            ->setVisitedCount(0)
            ->setCategory($categories[1])
            ->setCategoryId(2)
            ->setDescription('Linux Test Product 3')
            ->setPrice('60');
        $manager->persist($p6);

        $p7 = new Product();
        $p7->setName('Mac OS Test Product 1')
            ->setVisitedCount(0)
            ->setCategory($categories[2])
            ->setCategoryId(3)
            ->setDescription('Linux Test Product 1')
            ->setPrice('6000');
        $manager->persist($p7);

        $p8 = new Product();
        $p8->setName('Mac OS Test Product 2')
            ->setVisitedCount(0)
            ->setCategory($categories[2])
            ->setCategoryId(3)
            ->setDescription('Linux Test Product 2')
            ->setPrice('3500');
        $manager->persist($p8);

        $p9 = new Product();
        $p9->setName('Mac OS Test Product 3')
            ->setVisitedCount(0)
            ->setCategory($categories[2])
            ->setCategoryId(3)
            ->setDescription('Linux Test Product 3')
            ->setPrice('2000');
        $manager->persist($p9);

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}

