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

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PageCrudController extends AbstractCrudController {

    public function __construct(private string $defaultLocale, private string $supportedLocales) {
        
    }

    public static function getEntityFqcn(): string {
        return Page::class;
    }

    public function configureFields(string $pageName): iterable {
        $locales = explode('|', $this->supportedLocales);
        $localeChoices = array_combine($locales,$locales);
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            IntegerField::new('position'),
            TextField::new('name'),
            TextField::new('shortName')->hideOnIndex(),
            TextEditorField::new('content')->hideOnIndex()->setNumOfRows(25),
            // no hierarchy - much simpler
            //AssociationField::new('parent')->setRequired(false),
            ChoiceField::new('locale')->setChoices($localeChoices)->autocomplete()->setValue($this->defaultLocale),
            SlugField::new('slug')->setTargetFieldName('name')
        ];
    }

}
