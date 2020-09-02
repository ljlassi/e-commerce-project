<?php

/**
 * Controller for home page.
 */

namespace App\Controller;


use App\Entity\CMSBanner;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Controller for homepage.
 *
 * Class HomeController
 * @package App\Controller
 */

class HomeController extends AbstractController
{

    /**
     * Render homepage, get featured products and pass them to view.
     *
     * @Route("/", name="homepage")
     *
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function homePage(Environment $twig) : Response {
        return new Response($twig->render('/home/home.html.twig', []));
    }

}