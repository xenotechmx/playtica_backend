<?php

namespace App\Form;

use App\Entity\Visitor;
use App\Entity\PlayDateVisitor;
use App\Repository\VisitorRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;


class PlayDateVisitorType extends AbstractType
{

    private $visitorRespository;

    public function __construct(VisitorRepository $visitorRespository)
    {
        $this->visitorRespository = $visitorRespository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('visitor', EntityType::class, [
                'label' => 'Visitante',
                'class' => Visitor::class,
                'choices' => $this->visitorRespository->findAll(),
                'row_attr' => [
					'class' => 'col-md-6'
				]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Cobro',
                'currency' => 'MXN',
                'row_attr' => [
					'class' => 'col-md-6'
				]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayDateVisitor::class,
        ]);
    }
}
