<?php

namespace App\Form;

use App\Entity\Fare;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', MoneyType::class, [
                'label' => 'Precio',
                'currency' => 'MXN',
                'row_attr' => [
					'class' => 'col-md-4'
				]
            ])
            ->add('days', ChoiceType::class, [
                'label' => 'Días',
                'choices' => Fare::DAYS,
                'row_attr' => [
					'class' => 'col-md-4'
				]
            ])
            ->add('time', ChoiceType::class, [
                'label' => 'Tipo',
                'choices' => Fare::TIMES,
                'row_attr' => [
					'class' => 'col-md-4'
				]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fare::class,
        ]);
    }
}
