<?php


namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
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
        $form = $this->createFormBuilder($user);
        $form->add('first_name', TextType::class);
        $form->add('last_name', TextType::class);
        $form->add('username', TextType::class);
        $form->add('email', TextType::class);
        $form->add('phone', TextType::class);
        $form->add('password', TextType::class);
        $form = $form->getForm();
        $form = $form->createView();

        return new Response($twig->render('user/register_user.html.twig', ['form' => $form]));
    }

}