<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogTestController extends AbstractController
{
    /**
     * @Route("/blog/test", name="blog_test")
     */
    public function index()
    {
        return $this->render('socialLogins/sociallogin.html.twig');
    }
}
