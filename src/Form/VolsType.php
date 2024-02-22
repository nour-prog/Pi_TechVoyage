<?php

namespace App\Form;

use App\Entity\Vols;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree')
            ->add('datedepart')
            ->add('datearrive')
            ->add('nbrescale')
            ->add('nbrplace')
            ->add('classe')
            ->add('destination')
            ->add('pointdepart')
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vols::class,
        ]);
    }
}
