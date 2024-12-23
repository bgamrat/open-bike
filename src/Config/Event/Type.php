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

interface Iconed {

    public function icon(): string;
}

interface Colored {

    public function color(): string;
}

enum Type: string implements Iconed, Colored {

    case Cleanup = 'Cleanup';
    case Meeting = 'Meeting';
    case Other = 'Other';
    case Pickup = 'Pickup';
    case Sale = 'Sale';
    case Wrenching = 'Wrenching';

    public function icon(): string {
        return match ($this) {
            Type::Cleanup => "bi bi-bucket",
            Type::Meeting => "bi bi-clipboard",
            Type::Other => "bi bi-motherboard",
            Type::Pickup => "bi bi-truck",
            Type::Sale => "bi bi-tags",
            Type::Wrenching => "bi bi-tools"
        };
    }

    public function color(): string {
        return match ($this) {
            Type::Cleanup => "text-dark",
            Type::Meeting => "text-info",
            Type::Other => "text-muted",
            Type::Pickup => "text-warning",
            Type::Sale => "text-success",
            Type::Wrenching => "text-primary"
        };
    }
}
