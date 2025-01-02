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

use App\Entity\Image as AppImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Image;

class ImageCrudController extends AbstractCrudController {

    public function __construct(
            private string $crudUploadDir,
            private string $basePath
    ) {

    }

    public static function getEntityFqcn(): string {
        return AppImage::class;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('title'),
            TextField::new('description')->hideOnIndex(),
            TextareaField::new('altText')->hideOnIndex(),
                    ImageField::new('file')
                    ->setUploadDir($this->crudUploadDir)
                    ->setBasePath($this->basePath)
                    ->setFileConstraints(new Image(maxSize: '1M'))
        ];
    }
}
