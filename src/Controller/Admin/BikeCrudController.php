<?php

namespace App\Controller\Admin;

use App\Config\Color;
use App\Entity\Bike;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BikeCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Bike::class;
    }
    
    public function configureFields(string $pageName): iterable {
        
        return [
            IdField::new('id')->hideWhenCreating(),
            TextField::new('serialNumber'),
            TextField::new('brand'),
            TextField::new('model'),
            IntegerField::new('speeds'),
            NumberField::new('wheelSize'),
            ChoiceField::new('color')->setChoices(Color::cases())->autocomplete(),
            TextEditorField::new('note')
      ];
    }
}
