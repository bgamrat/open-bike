<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Config\Bike;

enum Status: string
{
    case Received = 'Received';
    case InProgress = 'In progress';
    case ReadyForClient = 'Ready for client';
    case ReadyForSale = 'Ready for sale';
    case GivenToClient = 'Given to client';
    case Sold = 'Sold';
    case Hold = 'Hold';
    case ClientRepair = 'Client repair';
    case Dumpster = 'Dumpster';
    case Traded = 'Traded';
    case Other = 'Other';
}