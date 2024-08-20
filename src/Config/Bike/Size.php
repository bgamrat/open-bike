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

enum Size: string
{
    case ExtraSmall = 'Extra small (kid)';
    case Small = 'Small (youth/small adult)';
    case Medium = 'Medium (adult)';
    case Large = 'Large (tall adult)';
    case ExtraLarge = 'Extra large (very tall adult)';
    case Other = 'Other';
}