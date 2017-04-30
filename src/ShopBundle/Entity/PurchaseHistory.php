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
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\CustomerAccount")
     * @ORM\JoinColumn(name="customer_account_id", referencedColumnName="id")
     */
    private $customer_account;

    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer")
     */
    private $product_id;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     * @ORM\Column(name="spent", type="decimal", precision=10, scale=0)
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
     * @return string
     */
    public function getSpent()
    {
        return $this->spent;
    }

    /**
     * @param string $spent
     * @return $this
     */
    public function setSpent($spent)
    {
        $this->spent = $spent;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }
}

