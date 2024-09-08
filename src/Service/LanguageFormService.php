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
class LanguageFormService {

    public function __construct(private FormFactoryInterface $formFactory) {
        
    }

    public function form(string $name, mixed $yaml): Form {
        $formBuilder = $this->formFactory->createBuilder();
        $formBuilder->setMethod('post');

        $this->traverse($formBuilder, $name, $yaml);
        $formBuilder->add('save', SubmitType::class);

        return $formBuilder->getForm();
    }

    private function traverse(FormBuilder $formBuilder, string $name, mixed $value) {
        foreach ($value as $name => $v) {
            if (\is_array($v)) {
                $this->traverse($formBuilder, $name, $v);
            } else {
                $formBuilder->add($name, TextareaType::class,
                        ['data' => $v, 'sanitize_html' => true, 'trim' => true]);
            }
        }
    }
}
