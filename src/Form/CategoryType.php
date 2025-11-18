<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Category Name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Name cannot be empty.',
                    ]),
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'Name must be a string.',
                    ]),
                    new Assert\Length([
                        'max' => 30,
                        'maxMessage' => 'Name cannot exceed {{ limit }} characters.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/',
                        'message' => 'Name can only contain letters and spaces.',
                    ]),
                ],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Description cannot be empty.',
                    ]),
                    new Assert\Callback(function ($value, $context) {
                        if ($value) {
                            // Compter le nombre de phrases (basé sur les points, points d'exclamation ou d'interrogation)
                            $sentences = preg_split('/[.!?]+/', trim($value), -1, PREG_SPLIT_NO_EMPTY);
                            if (count($sentences) > 1) {
                                $context->buildViolation('Description must not exceed 4 sentences.')
                                    ->addViolation();
                            }
                        }
                    }),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
