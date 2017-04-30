<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use ShopBundle\Entity\CustomerAccount;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userSuperAdmin = new User();
        $userSuperAdmin->setUsername('sa');
        $userSuperAdmin->setEmail('sa@sa.sa');
        $userSuperAdmin->setAddress('test address');
        $userSuperAdmin->setDateOfBirth(date_create());
        $userSuperAdmin->setIsBanned(false);
        $userSuperAdmin->setName('super');
        $userSuperAdmin->setSurname('admin');

        $encrypt = $this->container->get('security.password_encoder');
        $userSuperAdmin->setPassword($encrypt->encodePassword($userSuperAdmin, '123'));

        $manager->persist($userSuperAdmin);

        $customerAccount = new CustomerAccount();
        $customerAccount->setUser($userSuperAdmin);
        $customerAccount->setUserId($userSuperAdmin->getId());
        $customerAccount->setBalance(1000);

        $manager->persist($customerAccount);
        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}


