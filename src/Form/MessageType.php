<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "écrire un message",
                    'class' => 'w-full p-4 bg-[#21213B] text-white text-[14px] placeholder:text-[14px] rounded-t-xl rounded-b-xl resize-none',
                    'rows' => 2,
                ]
            ])

            ->add('receiver', EntityType::class, [
                'class' => User::class,
                'label' => false,
                'attr' => [
                    "hidden" => "hidden"
                ]
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    "class" => "mt-2 w-20 bg-[#FF1B1C] opacity-75 hover:opacity-100 text-white text-[12px] text-center py-1 rounded-full"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
