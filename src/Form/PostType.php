<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('post', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "écrire un post",
                    'class' => 'w-full p-4 bg-[#21213B] text-white text-[14px] placeholder:text-[14px] rounded-t-xl rounded-b-xl resize-none',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
