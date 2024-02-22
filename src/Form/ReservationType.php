<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\GreaterThan;




class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDepart', DateType::class, [
                'label' => 'Date de départ',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value'   => new \DateTime('today'),
                        'message' => 'La date de départ doit être supérieure ou égale à la date actuelle.',
                    ]),
                ],
                // Autres options si nécessaire
            ])

            ->add('classe', ChoiceType::class, [
                'choices' => [
                    'First class' => 'First class',
                    'Second class' => 'Second class',
                    // Add as many options as needed
                ],
                'label' => 'la classe',
                // Other options if needed
            ])
            ->add('Destinationdepart', CountryType::class, [
                'label' => 'Destination de départ',
                // Autres options si nécessaire
            ])
            ->add('Destinationretour', CountryType::class, [
                'label' => 'Destination de départ',
                // Autres options si nécessaire
            ])
            ->add('Nbrdepersonne', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'constraints' => [
                    new GreaterThan([
                        'value'   => 0,
                        'message' => 'Le nombre de personnes ne peut pas être négatif.',
                    ]),
                ],
                // Autres options si nécessaire
            ])
            ->add('dateRetour', DateType::class, [
                'label' => 'Date de retour',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new GreaterThan([
                        'propertyPath' => 'parent.all[dateDepart].data',
                        'message' => 'La date fin doit être ultérieure à la date debut.',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
