<?php

namespace App\Controller\Admin;

use App\Entity\Repost;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class RepostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Repost::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('originalPost'),
            AssociationField::new('userRepost')
                ->setFormTypeOptions(['choice_label' => 'username']),
            DateTimeField::new('createdAt')
                ->setFormTypeOption('disabled', true),
        ];
    }
}

