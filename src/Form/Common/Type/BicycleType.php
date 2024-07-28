<?php

/**
 * Description of BicycleType
 *
 * @author bgamrat
 */
namespace App\Form\Common\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BicycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, ['label' => false])
            ->add('serialNumber', TextType::class, ['label' => false])
            ->add('brand', TextType::class, ['label' => false])
            ->add('model', TextType::class, ['label' => false])
            ->add('save', SubmitType::class)
        ;
    }
}
