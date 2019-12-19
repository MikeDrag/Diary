<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EventType;
use App\Entity\Event;


class EventController extends AbstractController
{
    /**
     * @Route("/event", name="create_event")
     */
    public function index(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush($event);

            $msg = $this->addFlash(['success' => 'Uploaded']);
        }
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController', 'form' => $form->createView()]);
    }
}
