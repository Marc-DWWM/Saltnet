<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'text-white bg-[#21213B] placeholder:text-[12px] placeholder:md:text-[16px] placeholder:lg:text-[18px] text-center rounded-full border-1 border-[#FF1B1C] md:w-96 lg:w-[400px] py-2 px-4',
                    'placeholder' => 'Email',
                ],
                'label' => false,
            ])
            //Ajout de username pour que l'utilisateur puisse choisir un nom personalisée pour naviguer sur le réseau social.
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'text-white bg-[#21213B] placeholder:text-[12px] placeholder:md:text-[16px] placeholder:lg:text-[18px] text-center rounded-full border-1 border-[#FF1B1C] md:w-96 lg:w-[400px] py-2 px-4',
                    'placeholder' => 'Nom d\'utilisateur',
                ],
                'label' => false,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])


            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'text-white bg-[#21213B] placeholder:text-[12px] placeholder:md:text-[16px] placeholder:lg:text-[18px] text-center rounded-full border-1 border-[#FF1B1C] md:w-96 lg:w-[400px] py-2 px-4',
                        'placeholder' => 'Mot de passe',
                        'autocomplete' => 'new-password',
                    ],
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'text-white bg-[#21213B] placeholder:text-[12px] placeholder:md:text-[16px] placeholder:lg:text-[18px] text-center rounded-full border-1 border-[#FF1B1C] md:w-96 lg:w-[400px] py-2 px-4',
                        'placeholder' => 'Confirmez le mot de passe',
                        'autocomplete' => 'new-password',
                    ],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
