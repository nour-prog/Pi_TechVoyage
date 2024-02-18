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

use App\Repository\VoitureRepository;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddLocationVoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix', NumberType::class,[
                'label' => 'Prix Par Jour ($)',
                'constraints' => [
                    new NotBlank([
                        'message' => "veuillez entrer un prix",
                    ]),
                ]
            ])
            ->add('type', ChoiceType::class,[
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
            ->add('voiture', null, [
                'query_builder' => function (VoitureRepository $repo) {
                    return $repo->createQueryBuilder('voiture')
                        ->leftJoin('voiture.locationVoiture', 'loc')
                        ->where('loc.id IS NULL');
                },
                'constraints' => [
                    new NotBlank([
                        'message' => "veuillez choisir une voiture",
                    ]),
                ]
            ])
            ->add('Submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LocationVoiture::class,
        ]);
    }
}
