<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Config\Event;

enum Type: string
{
    case Cleanup = 'Cleanup';
    case Meeting = 'Meeting';
    case Other = 'Other';
    case Pickup = 'Pickup';
    case Sale = 'Sale';
    case Wrenching = 'Wrenching';
}