<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
            'label' => 'Supplier Name',
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Name cannot be empty.',
                ]),
                new Assert\Type([
                    'type' => 'string',
                    'message' => 'Name must be a string.',
                ]),
                new Assert\Length([
                    'max' => 50,
                    'maxMessage' => 'Name cannot exceed {{ limit }} characters.',
                ]),
                new Assert\Regex([
                    'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ\s\-]+$/',
                    'message' => 'Name can only contain letters, spaces, or hyphens.',
                ]),
            ],
        ])

        ->add('email', null, [
            'label' => 'Email Address',
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Email cannot be empty.',
                ]),
                new Assert\Email([
                    'message' => 'The email address "{{ value }}" is not valid.',
                ]),
                new Assert\Length([
                    'max' => 100,
                    'maxMessage' => 'Email cannot exceed {{ limit }} characters.',
                ]),
            ],
        ])

        ->add('phone', null, [
            'label' => 'Phone Number',
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Phone number is required.',
                ]),
                new Assert\Regex([
                    // Accepts 8 digits, with or without +216
                    'pattern' => '/^(\+216)?\s?[0-9]{8}$/',
                    'message' => 'Phone number must contain 8 digits (e.g., 22123456 or +21622123456).',
                ]),
            ],
        ])

        ->add('address', null, [
            'label' => 'Address',
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Address cannot be empty.',
                ]),
                new Assert\Length([
                    'max' => 150,
                    'maxMessage' => 'Address cannot exceed {{ limit }} characters.',
                ]),
            ],
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
