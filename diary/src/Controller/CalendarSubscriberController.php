<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CalendarSubscriberController extends AbstractController
{
    /**
     * @Route("/calendar/subscriber", name="calendar_subscriber")
     */
    public function index()
    {
        return $this->render('calendar_subscriber/index.html.twig', [
            'controller_name' => 'CalendarSubscriberController',
        ]);
    }
}
