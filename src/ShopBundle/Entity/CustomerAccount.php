<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerAccount
 *
 * @ORM\Table(name="customer_account")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\CustomerAccountRepository")
 */
class CustomerAccount
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

