<?php


/**
 * Description of Color
 *
 * @author bgamrat
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