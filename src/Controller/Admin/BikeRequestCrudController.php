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

use App\Config\BikeRequest\Height;
use App\Config\BikeRequest\Status;
use App\Entity\BikeRequest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BikeRequestCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return BikeRequest::class;
    }

    public function configureActions(Actions $actions): Actions {
        return $actions
                        ->add(Crud::PAGE_INDEX, Action::DETAIL)

        ;
    }

    public function configureCrud(Crud $crud): Crud {
        return $crud
                        ->setDefaultSort(['date' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable {
        $heightChoices = [];
        foreach (Height::cases() as $k => $h) {
            $heightChoices[$h->str()] = $h->str();
        }
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('clientName'),
            TextField::new('contact'),
            ChoiceField::new('height')->setChoices($heightChoices)->autocomplete(),
            TextareaField::new('specialRequests'),
            DateField::new('date'),
            AssociationField::new('referrer')->hideOnIndex(),
            ChoiceField::new('status')->setChoices(Status::cases())->autocomplete(),
            AssociationField::new('bike')->hideOnIndex(),
        ];
    }
}
