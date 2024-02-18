<?php

namespace App\Form;

use App\Entity\ReclamationCommentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;


class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('contenu', null, [
            'constraints' => [
                new NotBlank(['message' => 'Le contenu ne peut pas être vide']),
                new Length([
                    'min' => 3,
                    'max' => 255,
                    'minMessage' => 'Le contenu doit comporter au moins {{ limit }} caractères',
                    'maxMessage' => 'Le contenu ne peut pas dépasser {{ limit }} caractères',
                ]),
            ],
        ])
            ->add('dateCreation')

            ->add('Reclamation', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez choisir la réclamation.']),
                ],
            ])           
             ->add('Submit',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReclamationCommentaire::class,
        ]);
    }
}
