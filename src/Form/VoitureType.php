<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('couleur', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'veuillez entrer une couleur',
                    ]),
                ]
            ])
            ->add('marque', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'veuillez entrer une marque',
                    ]),
                ]
            ])
            ->add('model', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'veuillez entrer un modèle',
                    ]),
                ]
            ])
            ->add('energy', ChoiceType::class, [
                'empty_data' => "null",
                'choices' => [
                    'Gasoline' => 'Gasoline',
                    'Diesel' => 'Diesel',
                    'Electricity' => 'Electricity',
                ],
                'placeholder' => "choisir le type d'énergie",
                'constraints' => [
                    new NotBlank([
                        'message' => "veuillez entrer un type d'énergie",
                    ]),
                ]
            ])
            ->add('capacite', IntegerType::class, [
                'empty_data' => "0",
                'constraints' => [
                    new NotBlank([
                        'message' => 'veuillez entrer une capacité',
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 1,
                        'message' => 'la capacité doit être au moins 1.',
                    ]),
                ],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/bmp',
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir une image valide',
                    ])
                ],
            ])
            ->add('Submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
