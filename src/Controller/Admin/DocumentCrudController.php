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

use App\Admin\Field\FileField;
use App\Entity\Document;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\Image;

class DocumentCrudController extends AbstractCrudController {

    public function __construct(
            private string $projectDir,
            private string $crudUploadDir,
            private string $basePath,
            private FileUploader $fileUploader,

            ) {

    }

    public static function getEntityFqcn(): string {
        return Document::class;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('name'),
            TextField::new('description')->hideOnIndex(),
            FileField::new('file')->hideOnIndex()
                    ->setUploadDir($this->crudUploadDir)
                    ->setBasePath($this->basePath)
                    ->setFileConstraints(new Image(maxSize: '1M'))
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void {

        $filename = $entityInstance->getFile();

        // check if an image exists
        if (!empty($filename)) {

            // create a File reference to the image
            $file = new File($this->projectDir . $this->crudUploadDir . '/' . $filename);

            // (try to) move the uploaded image to the document images directory
            $uploadedFilename = $this->fileUploader->uploadImageField($this->basePath, $file, $entityInstance->getId());

            // update the path in the entity
            $entityInstance->setFile($uploadedFilename);
        }
        parent::updateEntity($entityManager, $entityInstance);
    }


}
