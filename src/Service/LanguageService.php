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

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Yaml\Yaml;

class LanguageService {

    public function __construct(#[Autowire('%kernel.project_dir%')] private string $dir) {

    }

    public function getLanguage(string $language, string $type): mixed {
        $yamlFilename = $this->getYamlFilename($language, $type);
        $yaml = is_file($yamlFilename) ? Yaml::parse(\file_get_contents($yamlFilename)) : [];
        return $yaml;
    }

    public function updateLanguage(string $language, string $type, $messages) {
        file_put_contents($this->getYamlFilename($language, $type), Yaml::dump($messages));
    }

    private function getYamlFilename(string $language, string $type): string {
        return $this->dir . '/translations/' . $type . '.' . $language . '.yml';
    }
}
