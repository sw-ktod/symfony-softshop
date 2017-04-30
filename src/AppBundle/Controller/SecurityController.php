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
            $user->setIsBanned(false);

            $em = $this->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction();
            try {
                $em->persist($user);

                $customerAccount = new CustomerAccount();
                $customerAccount
                    ->setUserId($user->getId())
                    ->setUser($user)
                    ->setBalance(1000);
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

    public function changePasswordAction() {

    }

    /**
     * @Route("/user/{id}/edit", name="user_edit")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function editAction(Request $request)
    {
        $user_id = $request->attributes->get('id');

        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setId($user_id)
                ->setIsBanned(false);
            $encrypt = $this->get('security.password_encoder');
            $user->setPassword(
                $encrypt->encodePassword($user, $user->getPasswordRaw())
            );

            $em = $this
                ->getDoctrine()
                ->getManager();

            $em->merge($user);
            $em->flush();
        } else {
            $user_data = $this
                ->getDoctrine()
                ->getRepository(User::class)
                ->find($user_id);

            $form->setData($user_data);
        }

        return [
            'form' => $form->createView()
        ];
    }


    /**
     * @Route("/user/{id}/ban", name="user_ban")
     * @param Request $request
     */
    public function banAction(Request $request)
    {
        $user_id = $request->attributes->get('id');

        $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);
        $user->setIsBanned(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }

}
