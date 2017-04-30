<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchaceHistory
 *
 * @ORM\Table(name="purchase_history")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\PurchaseHistoryRepository")
 */
class PurchaseHistory
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
     *
     * @ORM\Column(name="customer_account_id", type="integer")
     */
    private $customer_account_id;

    /**
     * @var CustomerAccount
     * @ORM\OneToOne(targetEntity="ShopBundle\Entity\CustomerAccount")
     */
    private $customer_account;

    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer")
     */
    private $product_id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var int
     * @ORM\Column(name="spent", type="integer")
     */
    private $spent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;


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
     * Set customerId
     *
     * @param $customer_account_id
     * @return PurchaseHistory
     * @internal param int $customerId
     *
     */
    public function setCustomerId($customer_account_id)
    {
        $this->customer_account_id = $customer_account_id;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_account_id;
    }

    /**
     * Set productId
     *
     * @param $product_id
     * @return PurchaseHistory
     * @internal param int $productId
     *
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get productId
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return PurchaseHistory
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return PurchaseHistory
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return CustomerAccount
     */
    public function getCustomerAccount()
    {
        return $this->customer_account;
    }

    /**
     * @param CustomerAccount $customer_account
     * @return $this
     */
    public function setCustomerAccount(CustomerAccount $customer_account)
    {
        $this->customer_account = $customer_account;

        return $this;
    }

    /**
     * @return int
     */
    public function getSpent()
    {
        return $this->spent;
    }

    /**
     * @param int $spent
     * @return $this
     */
    public function setSpent($spent)
    {
        $this->spent = $spent;

        return $this;
    }
}

