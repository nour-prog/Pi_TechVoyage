<?php

namespace App\Form;

use App\Entity\Offres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class OffresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "attr" => [
                    "class" =>"form-control"
                ]
            ])
            ->add('description', TextareaType::class, [
                "attr" => [
                    "class" =>"from-control"
                ]
            ])
            ->add('locationVoiture', null, [
                "placeholder" => "Choisir Une Location Voiture"
            ])
            ->add('vol',null, [
                "placeholder" => "Choisir Un Vol"
            ])
            ->add('image',  FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])

            ->add('prix', NumberType::class, [ 
                "attr" => [
                    "class" =>"from-control"
                ]
            ])
            ->add('lieu', TextType::class, [
                "attr" => [
                    "class" =>"form-control"
                ]
            ]);

        $builder->get('image')->addModelTransformer(new StringToFileTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offres::class,
        ]);
    }
}
class StringToFileTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        
        if (is_string($value)) {
            return new File($value);
        }

        return null;
    }

    public function reverseTransform($value)
    {
        
        if ($value instanceof File) {
            return $value->getPathname();
        }

        throw new TransformationFailedException('Expected a string value or an instance of "Symfony\Component\HttpFoundation\File\File".');
    }
}