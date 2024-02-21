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
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Expression;

class ReserveLocationVoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentDate = new \DateTime();

        $builder
            ->add('dateDebut', DateTimeType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "veuillez entrer un date",
                    ]),
                    new GreaterThan([
                        'value' => $currentDate,
                        'message' => 'La date doit être ultérieure à la date actuelle.',
                    ]),
                ]
            ])
            ->add('datefin', DateTimeType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "veuillez entrer un date",
                    ]),
                    new GreaterThan([
                        'value' => $currentDate,
                        'message' => 'La date doit être ultérieure à la date actuelle.',
                    ]),
                    new GreaterThan([
                        'propertyPath' => 'parent.all[dateDebut].data',
                        'message' => 'La date fin doit être ultérieure à la date debut.',
                    ]),
                ]
            ])
            ->add('Submit',SubmitType::class,[
                "label"=> "Reserver"
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
