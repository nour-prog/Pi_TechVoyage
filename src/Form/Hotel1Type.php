<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class Hotel1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le nom ne peut contenir que des lettres.',
                    ]),
                ],
                // Autres options si nécessaire
            ])

                ->add('nbretoile')
            ->add('emplacement')
            ->add('avis', TextType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^(?i)(?!.*\b(gros|gros_mot2|gros_mot3)\b).*/',
                        'message' => 'Des termes offensants ont été détectés dans l\'avis.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?i)(?!.*\b(autre_mot1|autre_mot2)\b).*/',
                        'message' => 'D\'autres termes offensants ont été détectés dans l\'avis.',
                    ]),
                    // Ajoutez plus de contraintes Regex pour d'autres termes offensants
                ],
                // Autres options si nécessaire
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
