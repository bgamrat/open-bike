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
use App\Entity\Appointment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType {

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('clientName', TextType::class, ['required' => true,
                ])
                ->add('contact', TextType::class, ['required' => true,
                ])
                ->add('date', DateType::class, ['required' => true,
                    'attr' => [
                        'value' => \date('Y-m-d',\strtotime('next monday')),
                        'min' => \date('Y-m-d',\strtotime('next monday')), 'max' => \date('Y-m-d',\strtotime("+1 month")), 'step' => 7]
                ])
                ->add('height', TextType::class, ['required' => true,
                ])
                ->add('referrer', EntityType::class, [
                    'required' => true,
                    'class' => Agency::class,
                    'choice_label' => 'name',
                ])
                ->add('save', SubmitType::class)
        ;
    }
}
