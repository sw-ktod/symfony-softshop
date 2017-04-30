<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\CustomerAccount;
use ShopBundle\Entity\PurchaseHistory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PurchaseHistoryController extends Controller
{
    /**
     * @Route("/purchaseHistory/own", name="own_purchase_history_list")
     * @Method("GET")
     * @Template
     */
    public function listOwnAction() {
        $user_id = $this
            ->getUser()
            ->getId();
        $customer_account_id = $this
            ->getDoctrine()
            ->getRepository(CustomerAccount::class)
            ->findOneBy(['user_id' => $user_id])
            ->getId();

        $purchase_history = $this
            ->getDoctrine()
            ->getRepository(PurchaseHistory::class)
            ->findBy(['customer_account_id' => $customer_account_id]);
        return [
            'purchase_history' => $purchase_history
        ];
    }

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

        $purchase_history = $this
            ->getDoctrine()
            ->getRepository(PurchaseHistory::class)
            ->find($id);

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
        $purchase_history = $this
            ->getDoctrine()
            ->getRepository(PurchaseHistory::class)
            ->findAll();

        $total_amount = 0;

        foreach($purchase_history as $item) {
            $total_amount += ($item->getAmount() * $item->getQuantity());
        }

        return [
            'purchase_history' => $purchase_history,
            'total_amount' => $total_amount
        ];
    }

    /**
     * @Route("/purchaseHistory/customer/{customer_account_id}", name="customer_purchase_history_list")
     * @Method("GET")
     * @Template
     * @param Request $request
     * @return array
     */
    public function listByCustomerAction(Request $request) {
        $customer_account_id = $request->attributes->get('customer_account_id');

        $purchase_history = $this
            ->getDoctrine()
            ->getRepository(PurchaseHistory::class)
            ->findBy(['customer_account_id' => $customer_account_id]);

        $total_amount = 0;

        foreach($purchase_history as $item) {
            $total_amount += ($item->getAmount() * $item->getQuantity());
        }

        return [
            'purchase_history' => $purchase_history,
            'total_amount' => $total_amount
        ];
    }
}
