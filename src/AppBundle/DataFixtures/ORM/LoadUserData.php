<?php
namespace AppBundle\DataFixtures\ORM;

    use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use ShopBundle\Entity\CustomerAccount;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
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
        $admin_role = $manager
            ->getRepository('AppBundle:Role')
            ->findOneBy(['name'=>'ROLE_ADMIN']);

        $userSuperAdmin = new User();

        $userSuperAdmin
            ->setUsername('sa')
            ->setEmail('sa@sa.sa')
            ->setAddress('test address')
            ->setDateOfBirth(date_create())
            ->setIsBanned(false)
            ->setName('super')
            ->setSurname('admin')
            ->setIsBanned(false)
            ->addRole($admin_role);

        $encrypt = $this->container->get('security.password_encoder');
        $userSuperAdmin->setPassword($encrypt->encodePassword($userSuperAdmin, '123'));

        $manager->persist($userSuperAdmin);

        $customerAccount1 = new CustomerAccount();
        $customerAccount1
            ->setUser($userSuperAdmin)
            ->setUserId($userSuperAdmin->getId())
            ->setBalance(1000);

        $manager->persist($customerAccount1);
        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 20;
    }
}
