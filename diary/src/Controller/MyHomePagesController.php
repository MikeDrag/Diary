<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MyHomePagesController extends AbstractController
{
    /**
     * @Route("/homepages", name="my_home_pages")
     */
    public function index()
    {
        return $this->render('my_home_pages/index.html.twig', [
            'controller_name' => 'MyHomePagesController',
        ]);
    }
}
