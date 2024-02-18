<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class , [
                'constraints' => [
                    new NotBlank([
                        'message' => 'veuillez entrer une adresse mail',
                    ]),
                    new Email([
                        'message' => 'l e-mail {{ value }} n est pas une adresse e-mail valide',
                    ])
                ]
            ])
            ->add('nom',TextType::class , [
                'constraints' => [
                    new NotBlank([
                        'message' => 'veuillez entrer le nom',
                    ])
                ]
            ])
            ->add('prenom',TextType::class , [
                 'constraints' => [
                    new NotBlank([
                         'message' => 'veuillez entrer le prenom',
                    ])
                ]
            ])
            ->add('num_tel', null , [
                 'constraints' => [
                     new NotBlank([
                        'message' => 'veuillez entrer le prenom',
                     ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre numéro de téléphone doit comporter au moins {{ limit }} caractères',
                        'max' => 13,
                    ]),
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('Submit',SubmitType::class) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
