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
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

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

            $file = $product->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );
            $product->setImageUrl($fileName);

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
     * @return array
     */
    public function editAction(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $product_id = $request->attributes->get('id');
        $product_data = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->find($product_id);

        $form = $this->createForm(ProductType::class);
        $form->setData($product_data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();
            $product->setId($product_id);
            $product->setCategory(
                $this->getDoctrine()
                    ->getRepository(Category::class)
                    ->find($product->getCategory()->getId()));
            $product->setVisitedCount($product_data->getVisitedCount());

            $mgr = $this->getDoctrine()->getManager();
            $mgr->merge($product);
            $mgr->flush();

            return $this->redirectToRoute('product_get', ['id' => $product->getId()]);
        }
        return [
            'form' => $form->createView()
        ];
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

        $trace = $this->get('session')->get('trace');

        if(!isset($trace) || !is_array($trace)) {
            $trace = [];
        }

        if(!in_array('product/'.$product_id, $trace, true)) {
            $product->setVisitedCount($product->getVisitedCount() + 1);

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
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        if (!$query->count()) {
            return [
                'products' => $productRepository->findAll(),
                'categories' => $categoryRepository->findAll(),
                'active_id' => null
            ];
        }

        $queryParams = [
            'category_id' => $query->get('category_id'),
        ];

        return [
            'products' => $productRepository->findBy($queryParams),
            'categories' => $categoryRepository->findAll(),
            'active_id' => $query->get('category_id')
        ];
    }
}
