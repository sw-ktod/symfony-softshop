<?php

namespace ShopBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Component\Config\Definition\Exception\Exception;

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
     * @var int
     * @ORM\Column(name="user_id", type="integer")
     */
    private $user_id;
    /**
     * @var User
     * @OneToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="balance", type="decimal", precision=10, scale=0)
     */
    private $balance;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param string $balance
     * @return $this
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function addCash($amount) {
        $this->balance += $amount;

        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function takeCash($amount) {

        if ($this->balance - $amount < 0) {
            throw new Exception('Insufficient amount');
        }

        $this->balance -= $amount;

        return $this;
    }
}

