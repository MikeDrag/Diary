<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Entity\Event;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="category", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {
	    $category_name = $request->query->get('name');
		$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
		$event = $this->getDoctrine()->getRepository(Event::class)->findOneByCategory(['category' => $category_name]);

	    if ($category_name === "all")
		    return  new Response($this->container->get('serializer')->serialize($categories, 'json'));

	    $category_by_name = $this->getDoctrine()->getRepository(Category::class)->findOneByName($category_name);
	    // Return the specified category
	         return  new Response($this->container->get('serializer')->serialize(['data' => $event], 'json'));

    }
}
