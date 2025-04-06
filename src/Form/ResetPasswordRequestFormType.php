<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'autocomplete' => 'email',
                    'class' => 'text-white bg-[#21213B] placeholder:text-[12px] placeholder:md:text-[16px] placeholder:lg:text-[18px] text-center rounded-full border-1 border-[#FF1B1C] md:w-96 lg:w-[400px] py-2 px-4 mx-auto',
                    'placeholder' => 'Email',
                    'aria-label' => 'Adresse e-mail pour réinitialisation de mot de passe',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un email',
                    ])
                ],
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
