<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\CustomerAccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /**
     * @Route("/user/{id}/addCash", name="user_add_cash")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addCashAction(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $customer_account = $this
            ->getDoctrine()
            ->getRepository(CustomerAccount::class)
            ->findOneBy(['user_id' => $request->attributes->get('id')]);

        $customer_account
            ->addCash($request->request->get('amount'));

        $em = $this
            ->getDoctrine()
            ->getManager();

        $em->merge($customer_account);
        $em->flush();

        $referrerRoute = $request->headers->get('referer');

        return $this->redirect($referrerRoute);
    }
    /**
     * @Route("/user/{id}", name="user_get")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function getAction(Request $request)
    {
        $user_id = $request->attributes->get('id');
        if ($this->getUser()->getId() !== $user_id) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        }

        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($user_id);

        $customer_account = $this
            ->getDoctrine()
            ->getRepository(CustomerAccount::class)
            ->findOneBy(['user_id' => $user->getId()]);

        return [
            'user' => $user,
            'customer_account' => $customer_account
        ];
    }

    /**
     * @Route("/user", name="user_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        foreach($users as $user) {
            $user->setCustomerAccountId(
                $this->getDoctrine()
                    ->getRepository(CustomerAccount::class)
                    ->findOneBy(['user_id'=> $user->getId()])
                    ->getId()
            );
        }

        return [
            'users' => $users
        ];
    }
}
