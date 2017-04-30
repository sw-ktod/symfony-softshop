<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\CustomerAccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/user/{id}", name="user_get")
     * @Method("GET")
     * @Template()
     */
    public function getAction(Request $request)
    {
        $user_id = $request->attributes->get('id');
        $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);
        $customer_account = $this->getDoctrine()->getRepository(CustomerAccount::class)->findBy(['user_id' => $user->getId()])[0];

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
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return [
            'users' => $users
        ];
    }

}
