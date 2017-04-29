<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use ShopBundle\Entity\CustomerAccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
    * @Route("/login", name="user_login")
    * @Template()
    */
    public function loginAction() {
        $auth = $this->get('security.authentication_utils');

        $error = $auth->getLastAuthenticationError();
        $last_username = $auth->getLastUsername();

        return [
            'error' => $error,
            'last_username' => $last_username
        ];
    }

    /**
     * @Route("/login_check", name="user_check")
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function checkAction()
    {
        return $this->redirectToRoute('user_login');
    }

    /**
     * @Route("/register", name="user_register")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function registerAction(Request $request) {
        $error = null;
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $enchanter = $this->get('security.password_encoder');
            $user->setPassword(
                $enchanter->encodePassword($user, $user->getPasswordRaw())
            );

            $em = $this->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction();
            try {
                $em->persist($user);
                $em->flush();

                $user_id = $user->getId();
                $customerAccount = new CustomerAccount($user_id, 1000);

                $em->persist($customerAccount);
                $em->flush();

                $em->getConnection()->commit();

                return $this->redirectToRoute('user_login');
            } catch(\Exception $e) {
                $em->getConnection()->rollback();
                $error = ['messageKey'=>0, 'messageData'=>[$e->getMessage()]];
            }
        }

        return [
            'form' => $form->createView(),
            'error' => $error
        ];
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction() {
    }

}
