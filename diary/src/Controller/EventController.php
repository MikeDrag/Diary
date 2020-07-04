<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EventType;
use App\Entity\Event;
use Symfony\Component\Validator\Constraints\Date;   


class EventController extends AbstractController
{
    /**
     * @Route("/event", name="create_event")
     */
    public function index(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $request = Request::createFromGlobals();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $event->setDate(date('m/d/Y h:i:s a', time()));
                $em->persist($event);
                $em->flush($event);
                $this->addFlash('event_added', 'Event Added');
             }
        }
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController', 'form' => $form->createView()]);
    }

//	/**
//	 * @Route('/event{id}', name="single_event")
//	 */
//    private function singleEvent()
//    {
//
//    }
}
