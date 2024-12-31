<?php

namespace App\Controller\Admin;

use App\Entity\Shift;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ShiftCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Shift::class;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            AssociationField::new('Volunteer'),
            DateTimeField::new('startDateTime'),
            DateTimeField::new('endDateTime'),
            BooleanField::new('adjusted')
        ];
    }
}
