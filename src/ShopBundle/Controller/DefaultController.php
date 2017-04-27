<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="shop")
     */
    public function indexAction()
    {
        return $this->render('ShopBundle:Default:index.html.twig');
    }
}
