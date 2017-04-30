<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\CustomerAccount;
use ShopBundle\Entity\Product;
use ShopBundle\Entity\PurchaseHistory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * @Route("/cart", name="cart_get")
     * @Method("GET")
     * @Template()
     */
    public function getAction()
    {
        $cart = $this->get('session')->get('cart');

        if(!isset($cart) || !is_array($cart)) {
            $cart = [];
        }

        $total = 0;

        foreach($cart as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        $user_id = $this
            ->getUser()
            ->getId();
        $customer_account = $this
            ->getDoctrine()
            ->getRepository(CustomerAccount::class)
            ->findOneBy(['user_id' => $user_id]);

        return [
            'cart' => $cart,
            'total' => $total,
            'available_balance' => $customer_account->getBalance()
        ];
    }

    /**
     * @Route("/cart/add", name="cart_add")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $cart = $this->get('session')->get('cart');
        $quantity = $request->request->get('quantity');

        if ($quantity < 1) {
            throw new Exception('Invalid quantity');
        }

        if(!isset($cart) || !is_array($cart)) {
            $cart = [];
        }

        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($request->request->get('product_id'));
        $quantity = $request->request->get('quantity');

        if(!$product || $product->getQuantity() < $quantity) {
            throw new Exception('Insufficient quantity');
        }

        $product_id = $product->getId();

        if(isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            $cart[$product_id] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }


        $this->get('session')->set('cart', $cart);

        return $this->redirectToRoute('cart_get');
    }

    /**
     * @Route("/cart/remove", name="cart_remove")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Request $request)
    {
        $cart = $this->get('session')->get('cart');

        if(!isset($cart) || !is_array($cart)) {
            $cart = [];
        }

        unset($cart[$request->request->get('product_id')]);
        $this->get('session')->set('cart', $cart);

        $referrerRoute = $request->headers->get('referer');

        return $this->redirect($referrerRoute);
    }

    /**
     * @Route("/cart/reset", name="cart_reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        $this->get('session')->set('cart', []);

        return $this->redirectToRoute('cart_get');
    }

    /**
     * @Route("/cart/checkout", name="cart_checkout")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function checkoutAction(Request $request)
    {
        $cart = $this->get('session')->get('cart');

        if(!isset($cart) || !is_array($cart)) {
            throw new Exception('Cart is empty');
        }
        $total = 0;
        foreach($cart as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        $user_id = $this->getUser()->getId();
        $customer_account = $this
            ->getDoctrine()
            ->getRepository(CustomerAccount::class)
            ->findOneBy(['user_id' => $user_id]);

        $available_balance = $customer_account->getBalance();

        if($total > $available_balance) {
            throw new Exception('Insufficient amount');
        }

        $em = $this
            ->getDoctrine()
            ->getManager();
        $product_repository = $this
            ->getDoctrine()
            ->getRepository(Product::class);

        $em->getConnection()->beginTransaction();
        try {
            $purchase_date = date_create();
            foreach($cart as $item) {
                $product = $product_repository
                    ->findOneBy(['id' => $item['product']->getId()]);

                if ($product->getQuantity() < $item['quantity']) {
                    throw new Exception('Insufficient product quantity');
                }

                $product->setQuantity($product->getQuantity() - $item['quantity']);
                $em->merge($product);

                $purchase_history = new PurchaseHistory();
                $purchase_history
                    ->setQuantity($item['quantity'])
                    ->setCustomerAccount($customer_account)
                    ->setCustomerId($customer_account->getId())
                    ->setProductId($product->getId())
                    ->setProduct($product)
                    ->setDateCreated($purchase_date)
                    ->setAmount($product->getPrice());
                $em->persist($purchase_history);
            }
            $customer_account->takeCash($total);

            $em->merge($customer_account);
            $em->flush();

            $this->get('session')->set('cart', []);

            $em->getConnection()->commit();
        } catch(Exception $e) {
            $em->getConnection()->rollback();
        }


        $referrerRoute = $request->headers->get('referer');

        return $this->redirect($referrerRoute);
    }
}
