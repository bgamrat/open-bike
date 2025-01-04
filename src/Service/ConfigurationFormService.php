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

use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\BooleanNode;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\FloatNode;
use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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

        $tree = $configuration->getConfigTreeBuilder();
        $root = $tree->buildTree()->getChildren()[$name];
        $this->buildForm($root, $formBuilder, $processedConfiguration[$name]);

        $formBuilder->add('save', SubmitType::class);

        return $formBuilder->getForm();
    }

    private function buildForm(mixed $node, FormBuilder $formBuilder, array $values) {
        if ($node instanceof ArrayNode) {
            $children = $node->getChildren();
            foreach ($children as $c) {
                $name = $node->getName();
                $this->buildForm($c, $formBuilder, $values);
            }
        } else {

            $name = $node->getName();
            $value = trim($values[$name]);
            $help = ['help' => $node->getInfo()];
            if ($node instanceof IntegerNode) {
                $formBuilder->add($name, IntegerType::class, $help);
            } elseif ($node instanceof FloatNode) {
                $formBuilder->add($name, NumberType::class, $help);
            } /*             * ** Don't bother - doesn't work
              elseif ($node instanceof BooleanNode) {
              $formBuilder->add($name, CheckboxType::class, $help, ['checked' => $value, 'empty_data' => false ]);
              } */ else {
                $formBuilder->add($name, TextareaType::class,
                        ['sanitize_html' => true, 'trim' => true] + $help);
            }
            $formBuilder->get($name)->setData($value);
        }
    }
}
