<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class DistributionConfiguration implements ConfigurationInterface {

    public function getConfigTreeBuilder(): TreeBuilder {
        $treeBuilder = new TreeBuilder('distribution');
        // TODO: placeholder for distribution configuration, for example - required number of volunteers
        $treeBuilder->getRootNode()->children()
                ->arrayNode('distribution')
                ->children()
                ->variableNode('open')
                ->info('True or 1 for open, false or 0 for closed')
                ->isRequired()
                ->defaultValue(true)
                ->end()
                ->variableNode('message')
                ->info('Status message - only displayed if closed')
                ->isRequired()
                ->defaultValue('Open')
                ->end()
                ->variableNode('location_days_and_times')
                ->info('Location bikes are distributed from')
                ->isRequired()
                ->defaultValue('Be sure to complete this - for example: 10 Sample Road, New Castle, MA')
                ->end()
                ->variableNode('policy')
                ->info('Policy with respect to receiving a bike')
                ->isRequired()
                ->defaultValue('Be sure to complete this - for example: Must have voucher, one bike per year')
                ->end()
                ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
