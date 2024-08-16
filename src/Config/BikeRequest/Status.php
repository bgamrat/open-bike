<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Config\BikeRequest;

enum Status: string
{
    case Received = 'Received';
    case Delivered = 'Delivered';
    case PickedUp = 'Picked up';
    case NoVoucher = 'No voucher';
    case NoShow = 'No show';
    case Refused = 'Refused';
    case Other = 'Other';
}