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
     * @return RedirectResponse
     * @internal param Request $request
     *
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

            $encrypt = $this->get('security.password_encoder');
            $user->setPassword(
                $encrypt->encodePassword($user, $user->getPasswordRaw())
            );

            $em = $this->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction();
            try {
                $em->persist($user);
                $em->flush();

                $customerAccount = new CustomerAccount();
                $customerAccount
                    ->setUserId($user->getId())
                    ->setUser($user)
                    ->setCashAmount(1000);
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
