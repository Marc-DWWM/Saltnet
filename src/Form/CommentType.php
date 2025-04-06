<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('comment', TextareaType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => "écrire un commentaire",
                'class' => 'w-full p-4 bg-[#21213B] text-white text-[14px] sm:text-[16px] md:text-[18px] placeholder:text-[14px] sm:placeholder:text-[16px] md:placeholder:text-[18px] rounded-t-xl rounded-b-xl resize-none focus:outline-none focus:ring-2 focus:ring-[#FF1B1C]',
            ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}