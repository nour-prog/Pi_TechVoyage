<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReclamationFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('estTraite', ChoiceType::class, [
                'label' => 'État de la réclamation',
                'choices' => [
                    'Toutes' => null,
                    'Traitée' => true,
                    'Non traitée' => false,
                ],
                'required' => false,
            ])
            ->add('Filtrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configurez vos options ici
        ]);
    }
}
