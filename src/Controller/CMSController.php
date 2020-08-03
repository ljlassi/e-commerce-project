<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CMSController extends AbstractController
{

    /**
     * @Route("/admin/cms/banner", name="cms_change_banner")
     *
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function changeBannerView(Environment $twig) : Response {
        return new Response($twig->render('admin/cms/change_banner.html.twig', []));
    }

}