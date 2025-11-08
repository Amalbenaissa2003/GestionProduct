<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du fournisseur',
                'attr' => ['required' => true, 'class' => 'form-control']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['required' => true, 'class' => 'form-control']
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => ['required' => true, 'pattern' => '[0-9]{8}', 'class' => 'form-control']
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['required' => true, 'class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
