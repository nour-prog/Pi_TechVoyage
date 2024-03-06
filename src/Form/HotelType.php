<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\GreaterThan;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('nbretoile', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'constraints' => [
                    new GreaterThan([
                        'value'   => 0,
                        'message' => 'Le nombre de personnes ne peut pas être négatif.',
                    ]),
                ],
                // Autres options si nécessaire
            ])
            ->add('emplacement')
            ->add('avis')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
