<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\Category;
use ShopBundle\Entity\Product;
use ShopBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/product/add", name="product_create")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();
            $product->setCategory(
                $this->getDoctrine()
                    ->getRepository(Category::class)
                    ->find($product->getCategoryId())
            );
            $product->setVisitedCount(0);

            $mgr = $this->getDoctrine()->getManager();
            $mgr->persist($product);
            $mgr->flush();

            return $this->redirectToRoute('product_list');
        }

        return [
            'form' => $form->createView()
        ];
    }
    /**
     * @Route("/product/{id}/edit", name="product_edit")
     * @Template()
     * @param Request $request
     */
    public function editAction(Request $request) {

    }
    /**
     * @Route("/product/{id}", name="product_get")
     * @Template()
     * @param Request $request
     */
    public function getAction(Request $request) {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($request->attributes->get('id'));

        return [
            'product'=>$product
        ];
    }
    /**
     * @Route("/product", name="product_list")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function listAction(Request $request) {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return [
            'products'=>$products
        ];
    }
}
