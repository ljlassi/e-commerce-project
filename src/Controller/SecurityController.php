<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

/**
 * For now controls login and logout.
 *
 * Class SecurityController
 * @package App\Controller
 */

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils, Environment $twig)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($request->request->get('X-Auth-Token')) {
            return new Response('You have already logged in.');
        }
        else if ($request->request->get('username') && $request->request->get('password')) {
            $user = new User();
            return $this->json([
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
            ]);
        }
        else {
            return new Response($twig->render('security/login.html.twig', ['error' => $error, 'last_username' => $lastUsername]));
        }
    }

    /**
     * Log out user, as said in throw LogicException, can be left blank and logout still works.
     *
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        
    }
}
