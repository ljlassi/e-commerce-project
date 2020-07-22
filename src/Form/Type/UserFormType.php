<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('first_name', TextType::class);
        $builder->add('last_name', TextType::class);
        $builder->add('username', TextType::class);
        $builder->add('email', TextType::class);
        $builder->add('phone', TextType::class);
        $builder->add('password', TextType::class);
        $builder->add('register', SubmitType::class);
    }

}
