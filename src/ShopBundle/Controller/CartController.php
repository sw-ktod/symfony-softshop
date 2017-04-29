<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        return [
            'cart' => $cart,
            'total' => $total
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
        $refererRoute = $request->headers->get('referer');

        if ($quantity < 1) {
            return $this->redirect($refererRoute);
        }

        if(!isset($cart) || !is_array($cart)) {
            $cart = [];
        }

        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($request->request->get('product_id'));
        $quantity = $request->request->get('quantity');


        if(!$product || $product->getQuantity() < $quantity) {
            return $this->redirect($refererRoute);
        }

        $cart[$product->getId()] = [
            'product' => $product,
            'quantity' => $quantity
        ];

        $this->get('session')->set('cart', $cart);

        return $this->redirect($refererRoute);
    }

    /**
     * @Route("/cart/remove", name="cart_remove")
     * @Method("POST")
     */
    public function removeAction(Request $request)
    {
        $cart = $this->get('session')->get('cart');

        if(!isset($cart) || !is_array($cart)) {
            $cart = [];
        }

        unset($cart[$request->request->get('product_id')]);
        $this->get('session')->set('cart', $cart);

        $refererRoute = $request->headers->get('referer');

        return $this->redirect($refererRoute);
    }

    /**
     * @Route("/cart/reset", name="cart_reset")
     * @Method("POST")
     */
    public function resetAction()
    {
        $this->get('session')->set('cart', []);

//        $this->getRequest()->headers->get('referer');
    }

    /**
     * @Route("/cart/checkout", name="cart_checkout")
     * @Method("GET")
     * @Template()
     */
    public function checkoutAction()
    {
        return [];
    }

}
