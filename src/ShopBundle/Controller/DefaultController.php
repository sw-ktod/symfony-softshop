<?php

namespace ShopBundle\Controller;

use Proxies\__CG__\ShopBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="shop")
     * @Template()
     */
    public function indexAction()
    {
        return [
          'user' => $this->getUser()
        ];
    }
}
