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

class BikeInventory {
    
    public function __construct(private BikeRepository $bikeRepository, private BikeRequestRepository $bikeRequestRepository){
    }
    
    public function bikes_available():bool {
        return $this->bikeRepository->countByStatus(BikeStatus::ReadyForClient) >  
                $this->bikeRequestRepository->count(['status' => BikeRequestStatus::Pending, 'bike' => null]);
        }
}
