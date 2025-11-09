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
                'label' => 'Nom du produit',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le nom du produit est obligatoire.',
                    ]),
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'Le nom doit être une chaîne de caractères.',
                    ]),
                    new Assert\Length([
                        'max' => 50,
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\-]+$/',
                        'message' => 'Le nom peut contenir uniquement des lettres, chiffres, espaces et tirets.',
                    ]),
                ],
            ])

            ->add('description', null, [
                'label' => 'Description',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La description est obligatoire.',
                    ]),
                    new Assert\Length([
                        'max' => 500,
                        'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])

            ->add('price', null, [
                'label' => 'Prix (DT)',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le prix est obligatoire.',
                    ]),
                    new Assert\Positive([
                        'message' => 'Le prix doit être un nombre positif.',
                    ]),
                    new Assert\LessThan([
                        'value' => 10000,
                        'message' => 'Le prix ne doit pas dépasser 10 000 DT.',
                    ]),
                ],
            ])

            ->add('image', null, [
                'label' => 'Image (URL ou chemin)',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L’image du produit est obligatoire.',
                    ]),
                    new Assert\Url([
                        'message' => 'L’image doit être une URL valide (ex: https://exemple.com/image.jpg).',
                    ]),
                ],
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'placeholder' => 'Choisir une catégorie',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez choisir une catégorie.',
                    ]),
                ],
            ])

            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'name',
                'label' => 'Fournisseur',
                'placeholder' => 'Choisir un fournisseur',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez choisir un fournisseur.',
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
