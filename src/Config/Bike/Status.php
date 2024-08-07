<?php


/**
 * Description of Disposition
 *
 * @author bgamrat
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