<?php

namespace App\Form;

use App\Entity\ReclamationCommentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Service\BadWordsChecker;


class CommentaireType extends AbstractType
{
    private $badWordsChecker;

    public function __construct(BadWordsChecker $badWordsChecker)
    {
        $this->badWordsChecker = $badWordsChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('contenu', TextareaType::class, [
            'label' => 'Description',
            'constraints' => [
                new Assert\Callback([$this, 'validateBadWords']),
            ],
        ])
        ->add('Submit',SubmitType::class)

        ;
    }
    public function validateBadWords($value, ExecutionContextInterface $context)
{
    if ($value === null) {
        return;
    }

    if ($this->badWordsChecker->containsBadWords($value)) {
        $context->buildViolation('Le texte contient des mots inappropriés.')
            ->addViolation();
    }
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReclamationCommentaire::class,
        ]);
    }
}
