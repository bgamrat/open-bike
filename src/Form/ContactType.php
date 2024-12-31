<?php

namespace App\Form;

use App\Entity\Contact;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $commonOptions = ['trim' => true, 'required' => true, 'sanitize_html' => true
        ];
        $builder
                ->add('name', TextType::class, $commonOptions)
                ->add('email', EmailType::class)
                ->add('phone', TextType::class, ['trim' => true, 'sanitize_html' => true,
                    'required' => false
                ])
                ->add('message', TextareaType::class, $commonOptions)
                ->add('captcha', Recaptcha3Type::class, [
                    'action_name' => 'social',
                    'constraints' => new Recaptcha3([
                        'message' => 'karser_recaptcha3.message',
                        'messageMissingValue' => 'karser_recaptcha3.message_missing_value',
                    ])])
                ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
