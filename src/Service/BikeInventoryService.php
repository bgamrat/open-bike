<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Config\Bike\Status as BikeStatus;
use App\Config\BikeRequest\Status as BikeRequestStatus;
use App\Repository\BikeRepository;
use App\Repository\BikeRequestRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Yaml\Yaml;

class BikeInventoryService {

    public function __construct(#[Autowire('%kernel.project_dir%')] private $dir, private BikeRepository $bikeRepository, private BikeRequestRepository $bikeRequestRepository) {
        
    }

    public function bikes_available(): bool {
        $inventoryConfig = Yaml::parse(
                        \file_get_contents($this->dir . '/config/app/inventory.yml')
        );
        $inventoryReserve = $inventoryConfig['inventory']['reserve'];
        return $this->bikeRepository->countByStatus(BikeStatus::ReadyForClient) - $inventoryReserve >
                $this->bikeRequestRepository->count(['status' => BikeRequestStatus::Pending, 'bike' => null]);
    }
}
