<?php

// TODO: fix this

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Gallery;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\File;

class GalleryCrudController extends AbstractCrudController {

    public function __construct(
            private string $projectDir,
            private string $crudUploadDir,
            private string $basePath,
            private FileUploader $fileUploader) {

    }

    public static function getEntityFqcn(): string {
        return Gallery::class;
    }

    public function configureFields(string $pageName): iterable {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('name'),
            CollectionField::new('pictures')->hideOnIndex()->useEntryCrudForm()->allowAdd(true)->allowDelete(true)
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void {

        $pictures = $entityInstance->getPictures();

        foreach ($pictures as $p) {
            $image = $p->getFile();

            // check if the image exists (arguably unnecessary)
            if (!empty($image)) {
//dd($this->projectDir . $this->crudUploadDir . '/' . $image);
                // create a File reference to the image
                $imageFile = new File($this->projectDir . $this->crudUploadDir . '/' . $image);

          //      dd($this->basePath,$imageFile);

                // (try to) move the uploaded image to the volunteer images directory
                $imageFilename = $this->fileUploader->uploadImageField($this->basePath, $imageFile, $p->getId());

                // update the path in the entity
                $p->setFile($imageFilename);
              //  dd($p);
            }
        }
        parent::updateEntity($entityManager, $entityInstance);
    }
}
