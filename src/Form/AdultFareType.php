<?php

namespace App\Form;

use App\Entity\AdultFare;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdultFareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adults', ChoiceType::class, [
                'label' => 'Adultos',
                'choices' => AdultFare::ADULTS_TYPE,
                'row_attr' => [
                    'class' => 'row-fare'
                ]
            ])
            ->add('days', ChoiceType::class, [
                'label' => 'Días',
                'choices' => AdultFare::DAYS,
                'row_attr' => [
					'class' => 'row-fare'
				]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Precio',
                'currency' => 'MXN',
                'row_attr' => [
					'class' => 'row-fare'
				]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdultFare::class,
        ]);
    }
}
