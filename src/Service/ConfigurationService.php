<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;
use Symfony\Component\Yaml\Yaml;

class ConfigurationService {

    public function __construct(#[Autowire('%kernel.project_dir%')] private string $dir) {
        
    }

    public function getConfiguration(string $type): mixed {
        $className = ucfirst($type) . 'Configuration';
        $fullClassName = 'App\\Configuration\\' . $className;
        if (\class_exists($fullClassName)) {
            return new $fullClassName();
        }
        throw new ClassNotFoundException($className);
    }

    public function getYamlConfiguration(string $type): mixed {
        $yamlFilename = $this->getYamlFilename($type);
        $yaml = is_file($yamlFilename) ? Yaml::parse(\file_get_contents($yamlFilename)) : [];
        return $yaml;
    }

    public function updateYamlConfiguration(string $type, $configuration, $updates) {
        $processor = new Processor();
        $processedConfiguration = $processor->processConfiguration(
                $configuration, $updates
        );
        $updatedYaml = Yaml::dump($processedConfiguration);
        file_put_contents($this->getYamlFilename($type), $updatedYaml);
    }

    private function getYamlFilename(string $type): string {
        return $this->dir . '/config/app/' . $type . '.yml';
    }
}
