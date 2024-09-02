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

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Description of ConfigFormCreator
 *
 * @author bgamrat
 */
class ConfigurationFormService {

    public function __construct(private FormFactoryInterface $formFactory) {
        
    }

    public function form(string $name, ConfigurationInterface $configuration, mixed $yaml): Form {
        $formBuilder = $this->formFactory->createNamedBuilder($name);
        $formBuilder->setMethod('post');

        $configs = [$yaml];
        $processor = new Processor();
        $processedConfiguration = $processor->processConfiguration(
                $configuration, $configs
        );

        $this->traverse($formBuilder, $name, $processedConfiguration);
        $formBuilder->add('save', SubmitType::class);

        return $formBuilder->getForm();
    }

    private function traverse(FormBuilder $formBuilder, string $name, mixed $value) {
        foreach ($value as $name => $v) {
            if (is_array($v)) {
                $this->traverse($formBuilder, $name, $v);
            } else {
                $type = is_int($v) ? IntegerType::class : TextType::class;
                $formBuilder->add($name, $type, ['data' => $v]);
            }
        }
    }

}
