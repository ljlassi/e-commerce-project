<?php


namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Form\Type\UserFormType;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserController extends AbstractController
{
    /**
     * @Route("/user/register", name="register_user")
     *
     * @param Environment $twig
     */

    public function registerUserPage(Environment $twig, Request $request) : Response {
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);
        $form = $form->createView();

        return new Response($twig->render('user/register_user.html.twig', ['form' => $form]));
    }

}