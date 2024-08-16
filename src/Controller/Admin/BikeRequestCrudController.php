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

use App\Config\BikeRequest\Status;
use App\Entity\BikeRequest;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BikeRequestCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return BikeRequest::class;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('clientName'),
            TextField::new('contact'),
            TextField::new('height'),
            DateField::new('date'),
            AssociationField::new('referrer'),
            ChoiceField::new('status')->setChoices(Status::cases())->autocomplete(),
        ];
    }
}
