<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

/**
 * Builds edit product form.
 *
 * Class EditProductFormType
 * @package App\Form\Type
 */

class EditProductFormType extends AbstractType
{

    /**
     * Build form for editing product.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->setAction("./");
        $builder->add('name', TextType::class);
        $builder->add('price', TextType::class);
        $builder->add('image', FileType::class, [
            'label' => 'Product image',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '2024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PNG or JPEG image.',
                ])
            ],
        ])
            // ...
        ;
        $builder->add('submit', SubmitType::class);
    }

}