<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * For now renders the admin index view. Symfony Firewall only allows logged in users with admin privilidges
 * to /admin route.
 *
 * Class AdminController
 * @package App\Controller
 */

class AdminController extends AbstractController
{
    /**
     * Render admin index page
     *
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', []);
    }
}
