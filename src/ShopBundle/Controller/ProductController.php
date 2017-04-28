<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
                    ->find($product->getCategory()->getId())
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
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function getAction(Request $request)
    {
        $product_id = $request->attributes->get('id');
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($product_id);

        $product->setVisitedCount($product->getVisitedCount() + 1);

        $trace = $this->get('session')->get('trace');

        if(!isset($trace) || !is_array($trace)) {
            $trace = [];
        }

        if(!in_array('product/'.$product_id, $trace, true)) {
            $mgr = $this->getDoctrine()
                ->getManager();
            $mgr->persist($product);
            $mgr->flush();

            $trace[] = 'product/'.$product_id;
            $this->get('session')->set('trace', $trace);
        }

        return [
            'product' => $product
        ];
    }

    /**
     * @Route("/product", name="product_list")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function listAction(Request $request)
    {
        $query = $request->query;
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        if (!$query->count()) {
            return [
                'products' => $productRepository->findAll()
            ];
        }

        $queryParams = [
            'category_id' => $query->get('category_id')
        ];

        return [
            'products' => $productRepository->findBy($queryParams)
        ];
    }
}
