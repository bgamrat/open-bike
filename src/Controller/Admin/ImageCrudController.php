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

use App\Entity\Event;
use App\Entity\Recurrence;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class RecurrenceCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Recurrence::class;
    }

    public function configureFields(string $pageName): iterable {
        return [
            DateTimeField::new('datetime')
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $recurrence = new Recurrence();
        $recurrence->event($this->getEvent());

        return $recurrence;
    }

}
