<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('name', TextType::class);
        $builder->add('price', TextType::class);
        $builder->add('add', SubmitType::class);
    }

}
