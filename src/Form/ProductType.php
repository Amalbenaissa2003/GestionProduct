<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Fournisseur;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Product Name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Product name is required.',
                    ]),
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'The name must be a string.',
                    ]),
                    new Assert\Length([
                        'max' => 50,
                        'maxMessage' => 'The name cannot exceed {{ limit }} characters.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\-]+$/',
                        'message' => 'The name can only contain letters, numbers, spaces, and hyphens.',
                    ]),
                ],
            ])

            ->add('description', null, [
                'label' => 'Description',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Description is required.',
                    ]),
                    new Assert\Length([
                        'max' => 500,
                        'maxMessage' => 'Description cannot exceed {{ limit }} characters.',
                    ]),
                ],
            ])

            ->add('price', null, [
                'label' => 'Price (DT)',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Price is required.',
                    ]),
                    new Assert\Positive([
                        'message' => 'Price must be a positive number.',
                    ]),
                    new Assert\LessThan([
                        'value' => 10000,
                        'message' => 'Price cannot exceed 10,000 DT.',
                    ]),
                ],
            ])

            ->add('image', null, [
                'label' => 'Image (URL or path)',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Product image is required.',
                    ]),
                    new Assert\Url([
                        'message' => 'The image must be a valid URL (e.g., https://example.com/image.jpg).',
                    ]),
                ],
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Category',
                'placeholder' => 'Select a category',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please select a category.',
                    ]),
                ],
            ])

            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'name',
                'label' => 'Supplier',
                'placeholder' => 'Select a supplier',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please select a supplier.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
