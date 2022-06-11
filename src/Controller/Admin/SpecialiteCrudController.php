<?php

namespace App\Controller\Admin;

use App\Entity\Specialite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SpecialiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Specialite::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
