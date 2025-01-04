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

interface Str {

    public function str(): string;
}

enum Height: string implements Str {

    case UnderFive = 'Under 5 ft / 152 cm';
    case FiveToFiveSix = '5 ft to 5 ft 6 in / 153-168 cm';
    case FiveSixToSix = '5 ft 6 in to 6 ft / 169-182 cm';
    case OverSix = 'Over 6 ft / 183cm';

    // Fulfills the interface contract.
    public function str(): string {
        return match ($this) {
            Height::UnderFive => 'Under 5 ft / 152 cm',
            Height::FiveToFiveSix => '5 ft to 5 ft 6 in / 153-168 cm',
            Height::FiveSixToSix => '5 ft 6 in to 6 ft / 169-182 cm',
            Height::OverSix => 'Over 6 ft / 183cm'
        };
    }
}
