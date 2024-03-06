<?php

namespace App\Form;

use App\Entity\LocationVoiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateLocationVoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix', NumberType::class,[
                'empty_data' => '0',
                'label' => 'Prix Par Jour ($)',
                'constraints' => [
                    new NotBlank([
                        'message' => "veuillez entrer un prix",
                    ]),
                ]
            ])
            ->add('type', ChoiceType::class,[
                'empty_data' => 'null',
                'choices' => [
                    'Sports' => 'Sports',
                    'Famille' => 'Famille',
                    'Minivan' => 'Minivan',
                    'Luxe' => 'Luxe',
                ],
                'placeholder' => "choisir le type du voiture",
                'constraints' => [
                    new NotBlank([
                        'message' => "veuillez entrer un type",
                    ]),
                ]
            ])
            ->add('status', ChoiceType::class, [
                'empty_data' => 'null',
                'choices' => [
                    'disponible' => 'disponible',
                    'réservé' => 'réservé',
                ],
                'placeholder' => "choisir le status du voiture",
                'constraints' => [
                    new NotBlank([
                        'message' => "veuillez entrer un status",
                    ]),
                ]
            ])
            ->add('Submit',SubmitType::class,[
                "label"=> "modifier"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LocationVoiture::class,
        ]);
    }
}
