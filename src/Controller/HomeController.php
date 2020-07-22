<?php

/**
 * Controller for home page.
 */

namespace App\Controller;


use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     *
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function homePage(Environment $twig) : Response {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findFeatured();
        return new Response($twig->render('/home/home.html.twig', ['products' => $products]));
    }

}
