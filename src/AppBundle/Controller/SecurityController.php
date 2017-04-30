<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ShopBundle\Entity\CustomerAccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        $form = $this->createForm(UserType::class, null, ['action' => 'register']);
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
        $user_data = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($user_id);

        $username = $user_data->getUsername();
        $password = $user_data->getPassword();
        $email = $user_data->getEmail();

        $form = $this->createForm(UserType::class, $user_data, [
            'action' => 'edit'
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setId($user_data->getId())
                ->setUsername($username)
                ->setEmail($email)
                ->setIsBanned(false);
            $encrypt = $this->get('security.password_encoder');
            if(!$user->getPasswordRaw()) {
                $user->setPassword($password);
            } else {
                $user->setPassword(
                    $encrypt->encodePassword($user, $user->getPasswordRaw())
                );
            }

            $em = $this
                ->getDoctrine()
                ->getManager();

            $em->merge($user);
            $em->flush();

            return $this->redirectToRoute('user_get', ['id' => $user->getId()]);
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

    /**
     * @Route("/self_edit", name="user_self_edit")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public function selfEditAction(Request $request) {
        $user_data = $this->getUser();
        $username = $user_data->getUsername();
        $old_password = $user_data->getPassword();
        $email = $user_data->getEmail();

        $form = $this->createForm(UserType::class, $user_data, [
            'action' => 'self_edit'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $encrypt = $this->get('security.password_encoder');

            $password = $old_password;
            if($user->getPasswordRaw()) {
                $password = $encrypt->encodePassword($user, $user->getPasswordRaw());
            }

            $current_password = $encrypt->encodePassword($user, $user->getPasswordCurrent());

            if($old_password !== $current_password) {
                throw new Exception('Invalid password');
            }

            $user->setId($user_data->getId())
                ->setUsername($username)
                ->setPassword($password)
                ->setEmail($email)
                ->setIsBanned(false);

            $em = $this
                ->getDoctrine()
                ->getManager();

            $em->merge($user);
            $em->flush();

            return $this->redirectToRoute('user_get', ['id' => $user->getId()]);
        }

        return [
            'form' => $form->createView()
        ];
    }

}
