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

use App\Config\Bike\Color;
use App\Config\Bike\Size;
use App\Config\Bike\Status;
use App\Config\Bike\Type;
use App\Config\BikeRequest\Status as BikeRequestStatus;
use App\Entity\Bike;
use App\Entity\BikeRequest;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminCrud(routePath: '/bikes', routeName: 'bikes')]
class BikeCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Bike::class;
    }

    public function configureActions(Actions $actions): Actions {
        return $actions
                        ->add(Crud::PAGE_INDEX, Action::DETAIL)

        ;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('serialNumber'),
            TextField::new('brand'),
            TextField::new('model'),
            ChoiceField::new('size')->setChoices(Size::cases())->autocomplete(),
            IntegerField::new('speeds')->hideOnIndex(),
            NumberField::new('wheelSize')->hideOnIndex(),
            ChoiceField::new('color')->hideOnIndex()->setChoices(Color::cases())->autocomplete(),
            ChoiceField::new('type')->setChoices(Type::cases())->autocomplete(),
            ChoiceField::new('status')->setChoices(Status::cases())->autocomplete(),
            TextareaField::new('note')->hideOnIndex(),
            NumberField::new('value'),
                    AssociationField::new('recipient')->hideOnIndex()->setQueryBuilder(
                            fn(QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(BikeRequest::class)->findBy(['status' => BikeRequestStatus::Pending, 'bike' => null]))
                    ->autocomplete()
        ];
    }
}
