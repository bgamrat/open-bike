<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Agency;
use App\Entity\BikeRequest;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BikeRequestType extends AbstractType {

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => BikeRequest::class,
            'action' => 'bike-request',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $commonOptions = ['trim' => true, 'required' => true, 'sanitize_html' => true
        ];
        $builder
                ->add('clientName', TextType::class, $commonOptions)
                ->add('contact', TextType::class, ['trim' => true, 'required' => true])
                ->add('date', DateType::class, ['required' => true,
                    'attr' => [
                        //'readonly' => true,
                        'value' => \date('Y-m-d', \strtotime('next monday')),
                        'min' => \date('Y-m-d', \strtotime('next monday')), 'max' => \date('Y-m-d', \strtotime("+1 month")), 'step' => 7]
                ])
                ->add('height', TextType::class, $commonOptions)
                ->add('referrer', EntityType::class, [
                    'required' => true,
                    'class' => Agency::class,
                    'choice_label' => 'name',
                ])
                ->add('captcha', Recaptcha3Type::class, [
                    'action_name' => 'social',
                    'constraints' => new Recaptcha3([
                        'message' => 'karser_recaptcha3.message',
                        'messageMissingValue' => 'karser_recaptcha3.message_missing_value',
                    ])])
                ->add('save', SubmitType::class)
        ;
    }
}
