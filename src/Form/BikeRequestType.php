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

use App\Config\BikeRequest\Height;
use App\Entity\Agency;
use App\Entity\BikeRequest;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $heightChoices = [];
        foreach (Height::cases() as $k => $h) {
            $heightChoices[$h->str()] = $h->str();
        }
        $commonOptions = ['trim' => true, 'required' => true];
        $builder
                ->add('clientName', TextType::class, $commonOptions + ['attr' => ['placeholder' => 'Your name', 'sanitize_html' => true
                    ]])
                ->add('contact', TextType::class, ['trim' => true,
                    'required' => true,
                    'help' => 'Please provide an email address or phone number or other way we can contact you'])
                ->add('date', DateType::class, ['required' => true,
                    'help' => 'appointment_instructions',
                    'attr' => [
                        //'readonly' => true,
                        'value' => \date('Y-m-d', \strtotime('next monday')),
                        'min' => \date('Y-m-d', \strtotime('next monday')), 'max' => \date('Y-m-d', \strtotime("+1 month")), 'step' => 7]
                ])
                ->add('height', ChoiceType::class,
                        $commonOptions +
                        ['help' => 'Please enter your height so we know what size bike you need',
                            'choices' => $heightChoices])
                ->add('specialRequests', TextareaType::class, $commonOptions +
                        ['sanitize_html' => true,
                            'help' => 'Requests such as step through bike, trike, rack or basket'])
                ->add('referrer', EntityType::class, [
                    'required' => true,
                    'class' => Agency::class,
                    'choice_label' => 'name',
                    'help' => 'Please let us know which agency referred you'
                ])
                ->add('captcha', Recaptcha3Type::class, [
                    'action_name' => 'social',
                    'constraints' => new Recaptcha3([
                        'message' => 'karser_recaptcha3.message',
                        'messageMissingValue' => 'karser_recaptcha3.message_missing_value',
                    ])])
                ->add('submit', SubmitType::class)
        ;
    }
}
