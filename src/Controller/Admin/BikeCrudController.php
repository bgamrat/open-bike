<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Config\Bike\Status;
use App\Config\Bike\Type;
use App\Config\Bike\Color;
use App\Entity\Bike;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BikeCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Bike::class;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('serialNumber'),
            TextField::new('brand'),
            TextField::new('model'),
            IntegerField::new('speeds'),
            NumberField::new('wheelSize'),
            ChoiceField::new('color')->setChoices(Color::cases())->autocomplete(),
            ChoiceField::new('type')->setChoices(Type::cases())->autocomplete(),
            ChoiceField::new('status')->setChoices(Status::cases())->autocomplete(),
            TextareaField::new('note')
        ];
    }
}
