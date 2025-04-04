<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PictureProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'text-white bg-[#21213B] placeholder:text-[12px] text-center rounded-full border-1 border-[#FF1B1C]',
                ],
                'label' => false,
            ])

            ->add('picture', Filetype::class, [
                'label' => 'Photo de profil(webp file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '100K',
                        'mimeTypes' => [
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier webp valide',
                    ])
                ],
                'attr' => [
                    'class' => 'mt-4 mb-4 flex flex-col justify-center items-center',
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
