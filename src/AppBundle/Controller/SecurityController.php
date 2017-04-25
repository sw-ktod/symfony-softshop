<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
