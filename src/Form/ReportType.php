<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\File;
use App\Entity\Message;
use App\Entity\Post;
use App\Entity\Report;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('reason_reporting', TextareaType::class, [
            'label' => false,
            'required' => true,
            'attr' => [
                'placeholder' => "écrire la raison du signalement(haine...)",
                'class' => 'p-4 bg-[#21213B] text-white text-[12px] placeholder:text-[12px] rounded-t-xl rounded-b-xl',
            ]
        ])
        ->add('user_report', EntityType::class, [
            'class' => User::class,
            'label' => false,
            'required' => true,
            'attr' => [
                'class' => 'p-4 bg-[#21213B] text-white text-[12px] placeholder:text-[12px] rounded-t-xl rounded-b-xl',
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Report::class,
        ]);
    }
}
