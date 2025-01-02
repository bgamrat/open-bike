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

use App\Entity\Volunteer;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\Image;

class VolunteerCrudController extends AbstractCrudController {

    public function __construct(
            private string $projectDir,
            private string $crudUploadDir,
            private string $basePath,
            private FileUploader $fileUploader) {

    }

    public static function getEntityFqcn(): string {
        return Volunteer::class;
    }

    public function configureActions(Actions $actions): Actions {
        return $actions
                        ->add(Crud::PAGE_INDEX, Action::DETAIL)

        ;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('firstName'),
            TextField::new('lastName'),
            EmailField::new('email')->setHtmlAttributes(['placeholder' => 'superseded_by_user_account_email']),
            TelephoneField::new('phone'),
                    ImageField::new('image')->hideOnIndex()
                    ->setUploadDir($this->crudUploadDir)
                    ->setBasePath($this->basePath)
                    ->setFileConstraints(new Image(maxSize: '1M'))
                    ->setUploadedFileNamePattern('[contenthash].[extension]'),
            IntegerField::new('tagId')->hideOnIndex(),
            AssociationField::new('user'),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void {

        $image = $entityInstance->getImage();

        // check if an image exists
        if (!empty($image)) {

            // create a File reference to the image
            $imageFile = new File($this->projectDir . $this->crudUploadDir . '/' . $image);

            // (try to) move the uploaded image to the volunteer images directory
            $imageFilename = $this->fileUploader->uploadImageField($this->basePath, $imageFile, $entityInstance->getId());

            // update the path in the entity
            $entityInstance->setImage($imageFilename);
        }
        parent::updateEntity($entityManager, $entityInstance);
    }
}