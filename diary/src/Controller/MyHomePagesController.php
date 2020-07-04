<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MyHomePagesController extends AbstractController
{
    /**
     * @Route("/homepages", name="homepages")
     */
    public function index()
    {
        return $this->render('homepages/index.html.twig', [
            'controller_name' => 'MyHomePagesController',
        ]);
    }
}
