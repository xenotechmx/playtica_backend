<?php

namespace App\Form;

use App\Entity\PlayDateProduct;
use App\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class PlayDateProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', null, [
                'label' => 'Producto',
                "query_builder" => fn(ProductRepository $repo) => $repo
					->createQueryBuilder("p")
					->where("p.active = :true")
					->setParameter("true", true),
            ])            
            ->add('quantity', null, [
                'label' => 'Cantidad'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayDateProduct::class,
        ]);
    }
}
