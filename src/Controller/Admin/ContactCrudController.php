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

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Contact::class;
    }

    public function configureActions(Actions $actions): Actions {
        return $actions
                        ->remove(Crud::PAGE_INDEX, Action::NEW)

        ;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('dt')->setDisabled(true),
            TextField::new('name')->setDisabled(true),
            EmailField::new('email')->setDisabled(true),
            TextField::new('phone')->setDisabled(true),
            TextareaField::new('message')->setDisabled(true),
            TextareaField::new('note'),
        ];
    }
}
