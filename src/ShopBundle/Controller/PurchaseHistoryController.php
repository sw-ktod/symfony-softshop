<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\PurchaceHistory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PurchaseHistoryController extends Controller
{
    /**
     * @Route("/purchaseHistory/{id}", name="purchase_history_get")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function getAction(Request $request)
    {
        $id = $request->attributes->get('id');

        $purchase_history = $this->getDoctrine()->getRepository(PurchaceHistory::class)->find($id);

        return [
            'purchase_history' => $purchase_history
        ];
    }

    /**
     * @Route("/purchaseHistory", name="purchase_history_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction()
    {
        $purchase_history = $this->getDoctrine()->getRepository(PurchaceHistory::class)->findAll();

        return [
            'purchase_history' => $purchase_history
        ];
    }

}
