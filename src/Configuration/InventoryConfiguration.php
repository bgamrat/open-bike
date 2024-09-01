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

class InventoryConfiguration implements ConfigurationInterface {

    public function getConfigTreeBuilder(): TreeBuilder {
        $treeBuilder = new TreeBuilder('inventory');

        $treeBuilder->getRootNode()->children()
                ->arrayNode('inventory')
                ->children()
                ->integerNode('reserve')
                ->info('Number of bikes held in reserve')
                ->min(0)
                ->isRequired()
                ->defaultValue(10)
                ->end()
                ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
