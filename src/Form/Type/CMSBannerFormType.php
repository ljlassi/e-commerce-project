<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class CMSBannerFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('imageUrl', FileType::class, [
            'label' => 'Banner image',
            'mapped' => false,
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '2024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PNG or JPEG image.',
                ])
            ]
        ]);
        $builder->add('alt', TextType::class);
        $builder->add("role", HiddenType::class, [ "data" => "frontpage"]);
        $builder->add('submit', SubmitType::class);
    }

}