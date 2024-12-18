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

use App\Config\Event\Type;
use App\Entity\Event;
use App\Entity\Recurrence;
use App\Entity\Volunteer;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('type')->setChoices(Type::cases())->autocomplete(),
            TextField::new('name'),
            DateTimeField::new('start'),
            DateTimeField::new('end'),
            TextareaField::new('note'),
            AssociationField::new('host')->setQueryBuilder(
                           fn(QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(Volunteer::class)->findAll())
                  ->autocomplete(),
            CollectionField::new('recurrences')->useEntryCrudForm()->allowAdd(true)->allowDelete(true)->setEntryIsComplex()
        ];
    }

    public function addRecurrence(Recurrence $recurrence): void {
        $recurrence->setEvent($this);

        if (!$this->recurrences->contains($recurrence)) {
            $this->recurrences->add($recurrence);
        }
    }

    public function removeRecurrence(Recurrence $recurrence): void {
        $this->recurrences->removeElement($recurrence);
    }
}
