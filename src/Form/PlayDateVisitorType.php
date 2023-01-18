<?php

namespace App\Form;

use App\Entity\Visitor;
use App\Entity\PlayDateVisitor;
use App\Repository\VisitorRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('type', ChoiceType::class, [
                'label' => 'Tipo de visitante',
                'required' => true,
                'mapped' => false,
                'choices'  => [                    
                    Visitor::ADULT => Visitor::TYPE_ADULT,
                    Visitor::INFANT => Visitor::TYPE_INFANT
                ],
                'attr' => ['class' => 'visitorTypeSelect'],
                //'row_attr' => [ 'class' => 'col-md-4' ]
            ])            
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'mapped' => false,
                'attr' => ['required' => 'true', 'class' => 'visitorMobilePhone'],
                //'row_attr' => [ 'class' => 'col-md-4' ]
            ])
            ->add('mobilePhone', TelType::class, [
                'label' => 'Celular',
                'required' => true,
                'mapped' => false,
                'attr' => ['required' => 'true', 'class' => 'visitorMobilePhone'],
                //'row_attr' => [ 'class' => 'col-md-4' ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Nombre(s)',
                'required' => true,
                'mapped' => false,
                'attr' => ['required' => 'true', 'class' => 'visitorFirstName'],
                //'row_attr' => [ 'class' => 'col-md-4' ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Apellido(s)',
                'required' => true,
                'mapped' => false,
                'attr' => ['required' => 'true', 'class' => 'visitorLastName'],
                //'row_attr' => [ 'class' => 'col-md-4' ]
            ])            
            ->add('birthday', DateType::class, [
                'label' => 'Fecha de nacimiento',
                'required' => true,
                'empty_data' => '',
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día',
                ],
                'widget' => 'single_text',
                'attr' => ['required' => 'true'],
                'mapped' => false,
                //'row_attr' => [ 'class' => 'col-md-6' ],                
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Género',
                'required' => true,
                'mapped' => false,
                'choices'  => [
                    Visitor::UNDEFINED => Visitor::GENDER_UNDEFINED,
                    Visitor::FEMALE => Visitor::GENDER_FEMALE,
                    Visitor::MALE => Visitor::GENDER_MALE
                ],
                //'row_attr' => [ 'class' => 'col-md-4' ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayDateVisitor::class,
        ]);
    }
}
