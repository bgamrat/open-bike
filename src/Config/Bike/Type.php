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

enum Type: string
{
    case MTB = 'MTB';
    case Hybrid = 'Hybrid';
    case Road = 'Road';
    case Youth = 'Youth';
    case Kids = 'Kids';
    case Cruiser = 'Cruiser';
    case Folding = 'Folding';
    case Fixie = 'Fixie';
    case Trike = 'Trike';
    case Vintage = 'Vintage';
    case Other = 'Other';
}