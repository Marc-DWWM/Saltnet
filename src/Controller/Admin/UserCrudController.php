<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
           
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            ArrayField::new('roles'),
            TextField::new('username', 'Nom d\'utilisateur'),
            DateTimeField::new('created_at', 'Créé le')
                ->setFormat('dd/MM/yyyy HH:mm'),
        ];
    }
}
