<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Entity\Volunteer;
use App\Service\FileUploader;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use function dd;

class EasyAdminSubscriber implements EventSubscriberInterface {

    public function __construct(
            private FileUploader $fileUploader
    ) {
        
    }

    public static function getSubscribedEvents() {
        return [
  //          BeforeEntityPersistedEvent::class => ['beforePersist'],
    //        BeforeEntityUpdatedEvent::class => ['beforeUpdate'],
        ];
    }

    public function beforePersist(BeforeEntityPersistedEvent $event) {
        dd('here');
        $entity = $event->getEntityInstance();
        dd($entity);
        if (!($entity instanceof Volunteer)) {
            return;
        }
        $this->uploadFile($entity);
    }

    public function beforeUpdate(BeforeEntityUpdatedEvent $event) {
        dd('here');
        $entity = $event->getEntityInstance();
        dd($entity);
        if (!($entity instanceof Volunteer)) {
            return;
        }
        $this->uploadFile($entity);
    }

    private function uploadFile($entity) {
        $imageFile = $entity->getImage()->getData();
        dd($imageFile);
        if ($imageFile) {
            $imageFileName = $this->fileUploader->upload(FileUploader::IMAGE, $imageFile);
            $entity->setImage($imageFileName);
        }
    }
}
