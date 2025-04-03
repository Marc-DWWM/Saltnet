<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Rechercher",
                    'class' => 'text-white bg-[#21213B] placeholder:text-[12px] text-center rounded-full border-1 border-[#FF1B1C]',

                ]
            ])
            ->add('Rechercher', SubmitType::class, [
                'attr' => [
                    "class" => "mt-2 w-20 bg-[#FF1B1C] opacity-75 hover:opacity-100 text-white text-[12px] text-center py-1 rounded-full"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
